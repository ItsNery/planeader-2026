document.addEventListener("DOMContentLoaded", () => {
    const mapElement = document.getElementById("mapa");
    if (!mapElement) return;

    const configCapas = {
        Microrregiones: {
            idField: "id_micro",
            nameField: "nom_micro",
            url: mapElement.dataset.microrregionesUrl,
            queryValue: "micro",
            label: "Microrregión",
        },
        Macrorregiones: {
            idField: "id_macro",
            nameField: "nom_macro",
            url: mapElement.dataset.macrorregionesUrl,
            queryValue: "macro",
            label: "Macrorregión",
        },
    };
    const cacheTtl = 24 * 60 * 60 * 1000;
    const initialView = [19.35, -97.8];
    const loader = document.getElementById("loader-mapa");
    const loaderMessage = loader?.querySelector("[data-loader-message]");
    const retryButton = loader?.querySelector("[data-map-retry]");
    const details = document.getElementById("region-details");
    const layerData = {};
    const layerPromises = {};
    const geometryMaps = {
        Microrregiones: new Map(),
        Macrorregiones: new Map(),
    };
    let activeLayer = new URLSearchParams(window.location.search).get("tipo") === "micro"
        ? "Microrregiones"
        : "Macrorregiones";
    let generalLayer = null;
    let municipalitiesLayer = null;
    let selectedLayer = null;
    let hoverLayer = null;
    let miniMapBaseLayer = null;
    let detailsController = null;

    const map = L.map("mapa", { zoom: 8, minZoom: 8 }).setView(initialView, 8);
    hoverLayer = L.layerGroup().addTo(map);

    const miniMap = L.map("mi-minimapa-estatico", {
        zoomControl: false,
        attributionControl: false,
        dragging: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        touchZoom: false,
        keyboard: false,
    }).setView(initialView, 6);
    const miniMapHighlightLayer = L.layerGroup().addTo(miniMap);

    function normalizeText(value) {
        return String(value || "")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .trim();
    }

    function escapeHtml(value) {
        const element = document.createElement("div");
        element.textContent = String(value ?? "");
        return element.innerHTML;
    }

    function setMobileView(view) {
        const layout = document.querySelector("[data-map-layout]");
        if (!layout || window.innerWidth >= 768) return;
        layout.dataset.mobileView = view;
        document.querySelectorAll(".map-view-toggle [data-map-view]").forEach((button) => {
            button.classList.toggle("active", button.dataset.mapView === view);
        });
        if (view === "map") setTimeout(() => map.invalidateSize(), 50);
    }

    function showLoader(message = "Cargando mapa...") {
        if (!loader) return;
        loader.classList.add("d-flex");
        loader.style.display = "flex";
        loaderMessage.textContent = message;
        loader.querySelector(".spinner")?.classList.remove("d-none");
        retryButton?.classList.add("d-none");
    }

    function hideLoader() {
        if (!loader) return;
        loader.classList.remove("d-flex");
        loader.style.display = "none";
    }

    function showLoadError() {
        if (!loader) return;
        loader.classList.add("d-flex");
        loader.style.display = "flex";
        loaderMessage.textContent = "No fue posible cargar la información geográfica.";
        loader.querySelector(".spinner")?.classList.add("d-none");
        retryButton?.classList.remove("d-none");
    }

    async function fetchGeoJson(cacheKey, url, force = false) {
        if (!force) {
            const cached = await CacheManager.get(cacheKey, cacheTtl);
            if (cached) return cached;
        }

        const response = await fetch(url, { headers: { Accept: "application/geo+json, application/json" } });
        if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
        const data = await response.json();
        if (data.type !== "FeatureCollection" || !Array.isArray(data.features)) {
            throw new Error("El archivo no es una colección GeoJSON válida.");
        }
        await CacheManager.set(cacheKey, data);
        return data;
    }

    function loadLayerData(layerName, force = false) {
        if (!force && layerData[layerName]) return Promise.resolve(layerData[layerName]);
        if (!force && layerPromises[layerName]) return layerPromises[layerName];

        const config = configCapas[layerName];
        const promise = fetchGeoJson(`geo_regionalizacion_v3_${layerName}`, config.url, force)
            .then((data) => {
                layerData[layerName] = data;
                indexGeometries(layerName, data);
                return data;
            })
            .finally(() => delete layerPromises[layerName]);
        layerPromises[layerName] = promise;
        return promise;
    }

    function indexGeometries(layerName, data) {
        const config = configCapas[layerName];
        const geometryMap = geometryMaps[layerName];
        geometryMap.clear();
        data.features.forEach((feature) => {
            const id = String(Number(feature.properties?.[config.idField]));
            if (id !== "NaN") geometryMap.set(id, feature.geometry);
        });
    }

    function pointInRing([lng, lat], ring) {
        let inside = false;
        for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
            const [lngI, latI] = ring[i];
            const [lngJ, latJ] = ring[j];
            const intersects = latI > lat !== latJ > lat &&
                lng < ((lngJ - lngI) * (lat - latI)) / (latJ - latI) + lngI;
            if (intersects) inside = !inside;
        }
        return inside;
    }

    function pointInPolygon(point, coordinates) {
        return pointInRing(point, coordinates[0]) &&
            !coordinates.slice(1).some((ring) => pointInRing(point, ring));
    }

    function findRegion(latlng) {
        const point = [latlng.lng, latlng.lat];
        return layerData[activeLayer]?.features.find((feature) => {
            const geometry = feature.geometry;
            if (geometry.type === "Polygon") return pointInPolygon(point, geometry.coordinates);
            if (geometry.type === "MultiPolygon") {
                return geometry.coordinates.some((polygon) => pointInPolygon(point, polygon));
            }
            return false;
        });
    }

    function renderMunicipalities(data) {
        if (municipalitiesLayer) map.removeLayer(municipalitiesLayer);
        municipalitiesLayer = L.geoJSON(data, {
            style: { color: "#fa2a6c", weight: 0.6, opacity: 0.65, fillOpacity: 0 },
            onEachFeature: (feature, layer) => {
                layer.on("click", (event) => {
                    const region = findRegion(event.latlng);
                    if (!region) return;
                    const config = configCapas[activeLayer];
                    selectRegion(region.properties[config.idField], activeLayer, false, {
                        latlng: event.latlng,
                        municipality: feature.properties.nomgeo,
                    });
                });
            },
        }).addTo(map);
        municipalitiesLayer.bringToFront();
    }

    function renderMainLayer(data) {
        if (generalLayer) map.removeLayer(generalLayer);
        generalLayer = L.geoJSON(data, {
            style: {
                color: "var(--color6)",
                weight: 2,
                opacity: 1,
                fillColor: "#a2a2a2",
                fillOpacity: 1,
            },
            onEachFeature: (feature, layer) => {
                layer.on("click", () => {
                    const config = configCapas[activeLayer];
                    selectRegion(feature.properties[config.idField], activeLayer, false);
                });
            },
        }).addTo(map);
        municipalitiesLayer?.bringToFront();

        if (miniMapBaseLayer) miniMap.removeLayer(miniMapBaseLayer);
        miniMapBaseLayer = L.geoJSON(data, {
            style: { color: "#777", weight: 0.7, fillColor: "#e0e0e0", fillOpacity: 0.75 },
            interactive: false,
        }).addTo(miniMap);
        miniMap.fitBounds(miniMapBaseLayer.getBounds(), { padding: [4, 4] });
    }

    async function loadActiveLayer(force = false) {
        showLoader();
        try {
            const data = await loadLayerData(activeLayer, force);
            renderMainLayer(data);
            hideLoader();
            return data;
        } catch (error) {
            console.error("Error cargando regionalización:", error);
            showLoadError();
            throw error;
        }
    }

    function updateUrl(id = null, replace = false) {
        const url = new URL(window.location.href);
        url.searchParams.set("tipo", configCapas[activeLayer].queryValue);
        if (id) url.searchParams.set("id", String(id));
        else url.searchParams.delete("id");
        window.history[replace ? "replaceState" : "pushState"]({}, "", url);
    }

    function markSelectedItem(id, layerName) {
        document.querySelectorAll(".item-region").forEach((item) => {
            const selected = item.dataset.capa === layerName && String(item.dataset.id) === String(id);
            item.classList.toggle("is-selected", selected);
            item.setAttribute("aria-pressed", String(selected));
            if (selected) item.scrollIntoView({ block: "nearest" });
        });
    }

    function showRegionPopup(id, layerName, options) {
        if (!options?.latlng) return;
        const config = configCapas[layerName];
        const feature = layerData[layerName]?.features.find(
            (item) => String(Number(item.properties?.[config.idField])) === String(Number(id)),
        );
        const name = feature?.properties?.[config.nameField] || "Sin información";
        L.popup()
            .setLatLng(options.latlng)
            .setContent(`
                <div class="custom-popup-container">
                    <div class="custom-popup-header"><h4 class="custom-popup-title">${config.label} ${escapeHtml(id)} - ${escapeHtml(name)}</h4></div>
                    ${options.municipality ? `<div class="custom-popup-body">Municipio: <strong>${escapeHtml(options.municipality)}</strong></div>` : ""}
                </div>
            `)
            .openOn(map);
    }

    async function loadRegionDetails(id, layerName) {
        const config = configCapas[layerName];
        details.innerHTML = `<h2>${config.label} ${escapeHtml(id)}</h2><p>Cargando información...</p>`;
        detailsController?.abort();
        detailsController = new AbortController();

        try {
            const response = await fetch(
                `${mapElement.dataset.regionInfoUrl}/${encodeURIComponent(layerName)}/${encodeURIComponent(id)}`,
                { signal: detailsController.signal, headers: { Accept: "application/json" } },
            );
            if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
            const data = await response.json();
            const municipalities = data.municipios || [];
            details.innerHTML = `
                <div class="map-selection-heading">
                    <div><span>${config.label}</span><h2>${escapeHtml(id)} - ${escapeHtml(data.nombre)}</h2></div>
                    <strong>${municipalities.length} municipios</strong>
                </div>
                <ul class="map-detail-list">${municipalities.map((item) => `<li>${escapeHtml(item.nombre_municipio)}</li>`).join("")}</ul>
            `;
        } catch (error) {
            if (error.name === "AbortError") return;
            details.innerHTML = `<h2>${config.label} ${escapeHtml(id)}</h2><p>No fue posible cargar la lista de municipios.</p>`;
        }
    }

    function selectRegion(id, layerName = activeLayer, shouldZoom = true, popupOptions = null, updateHistory = true) {
        const geometry = geometryMaps[layerName].get(String(Number(id)));
        if (!geometry) return;

        if (selectedLayer) map.removeLayer(selectedLayer);
        selectedLayer = L.geoJSON(geometry, {
            style: { color: "#fff", weight: 2, fillColor: "var(--color7)", fillOpacity: 0.65 },
            interactive: false,
        }).addTo(map);
        municipalitiesLayer?.bringToFront();
        if (shouldZoom) map.fitBounds(selectedLayer.getBounds(), { animate: true, duration: 0.8 });

        miniMapHighlightLayer.clearLayers();
        L.geoJSON(geometry, {
            style: { color: "#fff", weight: 1, fillColor: "#d71920", fillOpacity: 1 },
            interactive: false,
        }).addTo(miniMapHighlightLayer);

        markSelectedItem(id, layerName);
        loadRegionDetails(id, layerName);
        showRegionPopup(id, layerName, popupOptions);
        if (updateHistory) updateUrl(id);
        setMobileView("map");
    }

    function resetSelection(updateHistory = true) {
        if (selectedLayer) map.removeLayer(selectedLayer);
        selectedLayer = null;
        hoverLayer.clearLayers();
        miniMapHighlightLayer.clearLayers();
        map.closePopup();
        map.setView(initialView, 8, { animate: true });
        markSelectedItem(null, activeLayer);
        details.innerHTML = "<h2>Explora las regiones</h2><p>Selecciona una región en la lista o un municipio en el mapa para consultar sus detalles.</p>";
        if (updateHistory) updateUrl();
    }

    async function changeLayer(layerName, selectedId = null, updateHistory = true) {
        activeLayer = layerName;
        resetSelection(false);
        await loadActiveLayer();
        if (selectedId) selectRegion(selectedId, layerName, true, null, updateHistory);
        else if (updateHistory) updateUrl();
    }

    function activateInitialTab() {
        document.querySelectorAll("#regionalizacionTab .nav-link").forEach((tab) => {
            const selected = tab.dataset.capa === activeLayer;
            tab.classList.toggle("active", selected);
            tab.setAttribute("aria-selected", String(selected));
            document.querySelector(tab.dataset.bsTarget)?.classList.toggle("show", selected);
            document.querySelector(tab.dataset.bsTarget)?.classList.toggle("active", selected);
        });
    }

    document.querySelectorAll("#regionalizacionTab .nav-link").forEach((tab) => {
        tab.addEventListener("shown.bs.tab", () => {
            changeLayer(tab.dataset.capa).catch(() => {});
        });
    });

    document.querySelectorAll(".item-region").forEach((item) => {
        const selectItem = () => selectRegion(item.dataset.id, item.dataset.capa);
        item.addEventListener("click", selectItem);
        item.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                selectItem();
            }
        });
        item.addEventListener("mouseenter", () => {
            const geometry = geometryMaps[item.dataset.capa].get(String(Number(item.dataset.id)));
            if (geometry) {
                hoverLayer.clearLayers();
                hoverLayer.addLayer(L.geoJSON(geometry, {
                    style: { color: "#111", weight: 2, fillColor: "#f7dc6f", fillOpacity: 0.5 },
                    interactive: false,
                }));
            }
        });
        item.addEventListener("mouseleave", () => hoverLayer.clearLayers());
    });

    document.querySelectorAll(".map-search").forEach((input) => {
        input.addEventListener("input", () => {
            const pane = document.querySelector(input.dataset.searchPane);
            const items = [...pane.querySelectorAll(".item-region")];
            const query = normalizeText(input.value);
            let visible = 0;
            items.forEach((item) => {
                const matches = normalizeText(item.textContent).includes(query);
                item.hidden = !matches;
                if (matches) visible += 1;
            });
            input.parentElement.querySelector(".map-search-status").textContent =
                visible ? `${visible} resultados` : "No se encontraron regiones";
        });
    });

    document.querySelectorAll(".map-view-toggle [data-map-view]").forEach((button) => {
        button.addEventListener("click", () => setMobileView(button.dataset.mapView));
    });

    document.getElementById("btnResetMap")?.addEventListener("click", () => resetSelection());
    document.getElementById("btnInfo")?.addEventListener("click", () => {
        Swal.fire({
            icon: "info",
            title: "Cómo explorar el mapa",
            html: "Selecciona una región de la lista o haz clic sobre un municipio. Puedes cambiar entre macro y microrregiones sin recargar la página.",
            confirmButtonText: "Cerrar",
        });
    });
    retryButton?.addEventListener("click", async () => {
        try {
            const [municipalities] = await Promise.all([
                fetchGeoJson("geo_regionalizacion_v3_municipios", mapElement.dataset.municipiosUrl, true),
                loadActiveLayer(true),
            ]);
            renderMunicipalities(municipalities);
            hideLoader();
        } catch (error) {
            showLoadError();
        }
    });
    window.addEventListener("popstate", async () => {
        const params = new URLSearchParams(window.location.search);
        const nextLayer = params.get("tipo") === "micro" ? "Microrregiones" : "Macrorregiones";
        activeLayer = nextLayer;
        activateInitialTab();
        await changeLayer(nextLayer, params.get("id"), false);
    });

    (async () => {
        activateInitialTab();
        showLoader();
        try {
            const [municipalities] = await Promise.all([
                fetchGeoJson("geo_regionalizacion_v3_municipios", mapElement.dataset.municipiosUrl),
                loadActiveLayer(),
            ]);
            renderMunicipalities(municipalities);
            const selectedId = new URLSearchParams(window.location.search).get("id");
            if (selectedId) selectRegion(selectedId, activeLayer, true, null, false);
            updateUrl(selectedId, true);
            hideLoader();
            const otherLayer = activeLayer === "Microrregiones" ? "Macrorregiones" : "Microrregiones";
            const preload = () => loadLayerData(otherLayer).catch(() => {});
            if ("requestIdleCallback" in window) window.requestIdleCallback(preload);
            else setTimeout(preload, 500);
        } catch (error) {
            showLoadError();
        }
    })();
});
