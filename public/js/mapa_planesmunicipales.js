document.addEventListener("DOMContentLoaded", () => {
    const mapElement = document.getElementById("mapa");
    if (!mapElement) return;

    const cacheKey = "geojson_21mun_data_v2";
    const cacheTtl = 24 * 60 * 60 * 1000;
    const initialView = [19.35, -97.8];
    const mapWrapper = document.querySelector(".mapa-wrapper");
    const mapLoader = document.getElementById("map-loader");
    const loaderMessage = mapLoader?.querySelector("[data-loader-message]");
    const retryButton = mapLoader?.querySelector("[data-map-retry]");
    const resultsContainer = document.getElementById("container-results");
    const sidebarItems = [...document.querySelectorAll(".map-item-list .leaderboard__profile")];
    const searchInput = document.getElementById("buscar-municipio");
    let allMunicipalities = null;
    let geoJsonLayer = null;
    let selectedLayer = null;
    let hoveredLayer = null;
    let selectedId = null;
    let plansController = null;

    const map = L.map("mapa", { zoom: 8, minZoom: 8 }).setView(initialView, 8);
    const baseStyle = {
        color: "var(--color1, #808080)",
        weight: 1,
        opacity: 0.55,
        fillColor: "#a2a2a2",
        fillOpacity: 0.12,
    };
    const selectedStyle = {
        color: "var(--color4, #d71920)",
        weight: 3,
        opacity: 1,
        fillColor: "var(--color4, #d71920)",
        fillOpacity: 0.3,
        dashArray: "5, 5",
    };

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

    function formatId(id) {
        return String(Number(id)).padStart(3, "0");
    }

    function getMunicipalityId(feature) {
        return formatId(feature.properties.cve_mun ?? feature.properties.cvemunc);
    }

    function showLoader(message = "Cargando mapa...") {
        if (!mapLoader) return;
        mapLoader.classList.add("d-flex");
        mapLoader.style.display = "flex";
        loaderMessage.textContent = message;
        mapLoader.querySelector(".spinner")?.classList.remove("d-none");
        retryButton?.classList.add("d-none");
    }

    function hideLoader() {
        if (!mapLoader) return;
        mapLoader.classList.remove("d-flex");
        mapLoader.style.display = "none";
    }

    function showLoadError() {
        if (!mapLoader) return;
        mapLoader.classList.add("d-flex");
        mapLoader.style.display = "flex";
        loaderMessage.textContent = "No fue posible cargar los límites municipales.";
        mapLoader.querySelector(".spinner")?.classList.add("d-none");
        retryButton?.classList.remove("d-none");
    }

    async function fetchMunicipalities(force = false) {
        if (!force) {
            const cached = await CacheManager.get(cacheKey, cacheTtl);
            if (cached) return cached;
        }

        const response = await fetch(mapElement.dataset.geojsonUrl, {
            headers: { Accept: "application/geo+json, application/json" },
        });
        if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
        const data = await response.json();
        if (data.type !== "FeatureCollection" || !Array.isArray(data.features)) {
            throw new Error("El archivo municipal no es una colección GeoJSON válida.");
        }
        await CacheManager.set(cacheKey, data);
        return data;
    }

    function getFeature(id) {
        const formattedId = formatId(id);
        return allMunicipalities?.features.find((feature) => getMunicipalityId(feature) === formattedId);
    }

    function removeHighlight(type) {
        const layer = type === "hover" ? hoveredLayer : selectedLayer;
        if (layer) map.removeLayer(layer);
        if (type === "hover") hoveredLayer = null;
        else selectedLayer = null;
    }

    function drawHighlight(id, type = "selected", shouldZoom = false) {
        const feature = getFeature(id);
        if (!feature) return;
        removeHighlight(type);
        const layer = L.geoJSON(feature.geometry, {
            style: selectedStyle,
            interactive: false,
        }).addTo(map);
        if (type === "hover") hoveredLayer = layer;
        else selectedLayer = layer;
        if (shouldZoom) map.fitBounds(layer.getBounds(), { animate: true, duration: 0.7 });
    }

    function updateUrl(id = null, replace = false) {
        const url = new URL(window.location.href);
        if (id) url.searchParams.set("municipio", String(Number(id)));
        else url.searchParams.delete("municipio");
        window.history[replace ? "replaceState" : "pushState"]({}, "", url);
    }

    function markSelected(id) {
        sidebarItems.forEach((item) => {
            const selected = id && Number(item.dataset.id) === Number(id);
            item.classList.toggle("is-selected", Boolean(selected));
            item.setAttribute("aria-pressed", String(Boolean(selected)));
            if (selected) item.scrollIntoView({ block: "nearest" });
        });
    }

    function openPopup(id) {
        const formattedId = formatId(id);
        geoJsonLayer?.eachLayer((layer) => {
            if (getMunicipalityId(layer.feature) !== formattedId) return;
            const name = escapeHtml(layer.feature.properties.nomgeo || "Municipio");
            layer.bindPopup(`
                <div class="custom-popup-container">
                    <div class="custom-popup-header"><h4 class="custom-popup-title">${name}</h4></div>
                </div>
            `).openPopup();
        });
    }

    function selectMunicipality(id, shouldZoom = true, updateHistory = true) {
        if (!getFeature(id)) return false;
        selectedId = String(Number(id));
        drawHighlight(selectedId, "selected", shouldZoom);
        markSelected(selectedId);
        openPopup(selectedId);
        if (updateHistory) updateUrl(selectedId);
        setMobileView("map");
        loadPlans(selectedId);
        return true;
    }

    async function loadPlans(id) {
        plansController?.abort();
        plansController = new AbortController();
        resultsContainer.innerHTML = `
            <div class="map-content-loading" role="status">
                <div class="spinner"></div><p>Cargando planes municipales...</p>
            </div>
        `;

        try {
            const response = await fetch(`${mapElement.dataset.planesUrl}/${Number(id)}`, {
                signal: plansController.signal,
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });
            if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
            resultsContainer.innerHTML = await response.text();
            mapWrapper.classList.add("d-none");
            resultsContainer.focus({ preventScroll: true });
            resultsContainer.scrollIntoView({ behavior: "smooth", block: "start" });
        } catch (error) {
            if (error.name === "AbortError") return;
            resultsContainer.innerHTML = `
                <div class="map-inline-error" role="alert">
                    <h2>No fue posible cargar los planes</h2>
                    <p>Verifica tu conexión e inténtalo nuevamente.</p>
                    <button type="button" class="map-retry-button" data-retry-plans="${Number(id)}">Reintentar</button>
                </div>
            `;
        }
    }

    function closeMunicipality(updateHistory = true) {
        plansController?.abort();
        resultsContainer.innerHTML = "";
        mapWrapper.classList.remove("d-none");
        map.invalidateSize();
        map.closePopup();
        selectedId = null;
        removeHighlight("selected");
        markSelected(null);
        if (updateHistory) updateUrl();
    }

    function renderMap(data) {
        allMunicipalities = data;
        if (geoJsonLayer) map.removeLayer(geoJsonLayer);
        geoJsonLayer = L.geoJSON(data, {
            style: baseStyle,
            onEachFeature: (feature, layer) => {
                const id = getMunicipalityId(feature);
                layer.on({
                    mouseover: () => {
                        if (Number(selectedId) !== Number(id)) drawHighlight(id, "hover");
                    },
                    mouseout: () => removeHighlight("hover"),
                    click: () => selectMunicipality(id),
                });
            },
        }).addTo(map);
    }

    async function initializeMap(force = false) {
        showLoader();
        try {
            renderMap(await fetchMunicipalities(force));
            hideLoader();
            const id = new URLSearchParams(window.location.search).get("municipio");
            const validId = id && selectMunicipality(id, true, false) ? id : null;
            updateUrl(validId, true);
        } catch (error) {
            console.error("Error cargando municipios:", error);
            showLoadError();
        }
    }

    sidebarItems.forEach((item) => {
        const selectItem = () => selectMunicipality(item.dataset.id);
        item.addEventListener("click", selectItem);
        item.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                selectItem();
            }
        });
        item.addEventListener("mouseenter", () => {
            if (Number(selectedId) !== Number(item.dataset.id)) drawHighlight(item.dataset.id, "hover");
        });
        item.addEventListener("mouseleave", () => removeHighlight("hover"));
    });

    searchInput?.addEventListener("input", () => {
        const query = normalizeText(searchInput.value);
        let visible = 0;
        sidebarItems.forEach((item) => {
            const matches = normalizeText(item.querySelector(".leaderboard__name")?.textContent).includes(query);
            item.hidden = !matches;
            if (matches) visible += 1;
        });
        searchInput.parentElement.querySelector(".map-search-status").textContent =
            visible ? `${visible} municipios` : "No se encontraron municipios";
    });

    resultsContainer.addEventListener("click", (event) => {
        if (event.target.closest("#btnCerrarMunicipio")) closeMunicipality();
        const retry = event.target.closest("[data-retry-plans]");
        if (retry) loadPlans(retry.dataset.retryPlans);
    });

    document.querySelectorAll(".map-view-toggle [data-map-view]").forEach((button) => {
        button.addEventListener("click", () => setMobileView(button.dataset.mapView));
    });

    document.getElementById("btnInfo")?.addEventListener("click", () => {
        Swal.fire({
            icon: "info",
            title: "Planes municipales",
            html: "Busca un municipio y selecciónalo en la lista o en el mapa para consultar sus documentos publicados.",
            confirmButtonText: "Cerrar",
        });
    });
    document.getElementById("btnResetMap")?.addEventListener("click", () => {
        closeMunicipality();
        map.setView(initialView, 8, { animate: true });
    });
    retryButton?.addEventListener("click", () => initializeMap(true));
    window.addEventListener("popstate", () => {
        const id = new URLSearchParams(window.location.search).get("municipio");
        if (id) selectMunicipality(id, true, false);
        else closeMunicipality(false);
    });

    initializeMap();
});
