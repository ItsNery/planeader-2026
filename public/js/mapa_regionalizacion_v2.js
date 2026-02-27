document.addEventListener("DOMContentLoaded", function () {
    // =========================================================================
    // 1. CONFIGURACIÓN
    // =========================================================================
    const url = "https://geoportal.puebla.gob.mx/",
        urlGeoserver = `${url}geoserver/wms`;

    const baseUrlWFS = `${url}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json`;

    const configCapas = {
        Microrregiones: {
            id_field: "id_micro",
            layer_name: "Microrregiones_2026",
            name_field: "nom_micro",
        },
        Macrorregiones: {
            id_field: "id_macro",
            layer_name: "Macrorregiones_2026",
            name_field: "nom_macro",
        },
    };

    // Variables
    let selectLayer = null;
    let capaGeneral = null;
    let municipiosLayer = null;
    let capaActiva = "Macrorregiones";
    const geometriasMicro = new Map();
    const geometriasMacro = new Map();
    const cacheCapasPrincipales = {};
    let hoverLayer = null;
    let bloqueosDeEvento = false;
    const loader = document.getElementById("loader-mapa");

    let miniMapBaseLayer = null;
    let miniMapHighlightLayer = L.layerGroup();

    // =========================================================================
    // 2. MAPA PRINCIPAL
    // =========================================================================
    const map = L.map("mapa", {
        zoom: 8,
        minZoom: 8,
    }).setView([19.35, -97.8], 8);

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
    }).setView([19.0, -97.8], 6);

    L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png",
        {
            minZoom: 0,
            maxZoom: 20,
        },
    ).addTo(miniMap);

    miniMapHighlightLayer.addTo(miniMap);

    // =========================================================================
    // 2. CARGA DE MUNICIPIOS
    // =========================================================================
    const urlMuni = `${baseUrlWFS}&typeName=21mun`;
    fetch(urlMuni)
        .then((response) => response.json())
        .then((data) => {
            // Capa de municipios para el mapa principal
            municipiosLayer = L.geoJSON(data, {
                style: {
                    color: "#fa2a6c",
                    weight: 0.6,
                    opacity: 0.6,
                    fillOpacity: 0,
                },
                interactive: true,
                onEachFeature: function (feature, layer) {
                    layer.on("click", function (e) {
                        if (bloqueosDeEvento) return;

                        const nombreMun =
                            feature.properties.nomgeo || "Municipio";
                        const config = configCapas[capaActiva];
                        const wmsUrl =
                            `${urlGeoserver}?service=WMS&version=1.1.1&request=GetFeatureInfo` +
                            `&LAYERS=${config.layer_name}&QUERY_LAYERS=${config.layer_name}` +
                            `&INFO_FORMAT=application/json&SRS=EPSG:4326` +
                            `&BBOX=${map.getBounds().toBBoxString()}&WIDTH=${map.getSize().x}&HEIGHT=${map.getSize().y}` +
                            `&X=${Math.round(e.containerPoint.x)}&Y=${Math.round(e.containerPoint.y)}`;

                        fetch(wmsUrl)
                            .then((r) => r.json())
                            .then((d) => {
                                let regionId = null;
                                let regionNombre = "";
                                if (d.features?.length > 0) {
                                    const props = d.features[0].properties;
                                    regionId = props[config.id_field];
                                    regionNombre =
                                        props[config.name_field] || "";

                                    if (regionId) {
                                        highlightRegion(
                                            regionId,
                                            capaActiva,
                                            false,
                                        );
                                    }
                                }
                                let titulo =
                                    capaActiva === "Microrregiones"
                                        ? "Microrregión"
                                        : "Macrorregión";
                                if (regionId && regionNombre) {
                                    titulo += ` ${regionId} - ${regionNombre}`;
                                } else if (regionId) {
                                    titulo += ` ${regionId}`;
                                } else if (regionNombre) {
                                    titulo += ` ${regionNombre}`;
                                } else {
                                    titulo += " (sin información)";
                                }
                                const popupContent = `
                                    <div class="custom-popup-container">
                                        <div class="custom-popup-header">
                                            <h4 class="custom-popup-title">${titulo}</h4>
                                        </div>
                                        <div class="custom-popup-body">
                                            <ul class="custom-popup-list">
                                                <li class="custom-popup-list-item">Municipio: <strong>${nombreMun}</strong></li>
                                            </ul>
                                        </div>
                                    </div>
                                `;
                                L.popup()
                                    .setLatLng(e.latlng)
                                    .setContent(popupContent)
                                    .openOn(map);
                            })
                            .catch((err) =>
                                console.warn("Error obteniendo región:", err),
                            );
                    });
                },
            }).addTo(map);

            // Agregar la misma capa de municipios al minimapa (como fondo contextual)
            if (miniMap && miniMap._map) {
                L.geoJSON(data, {
                    style: {
                        color: "#999999",
                        weight: 0.4,
                        opacity: 0.5,
                        fillOpacity: 0,
                    },
                    interactive: false,
                }).addTo(miniMap._map);
            }
        })
        .catch((error) => console.error("Error municipios:", error));

    // =========================================================================
    // 3. PRECARGA (SOPORTE MULTI-GEOMETRÍA)
    // =========================================================================

    function precargarGeometrias(claveCapa, mapaDeAlmacenamiento) {
        const config = configCapas[claveCapa];
        const urlPrecarga = `${baseUrlWFS}&typeName=${config.layer_name}`;

        fetch(urlPrecarga)
            .then((response) => response.json())
            .then((data) => {
                if (data && data.features) {
                    let contadorFragmentos = 0;

                    data.features.forEach((feature) => {
                        const id = feature.properties[config.id_field];

                        if (id) {
                            const idStr = String(id);

                            if (mapaDeAlmacenamiento.has(idStr)) {
                                const geometriasExistentes =
                                    mapaDeAlmacenamiento.get(idStr);
                                geometriasExistentes.push(feature.geometry);
                                contadorFragmentos++;
                            } else {
                                mapaDeAlmacenamiento.set(idStr, [
                                    feature.geometry,
                                ]);
                            }
                        }
                    });
                }
            })
            .catch((error) =>
                console.warn(`Error precarga ${claveCapa}`, error),
            );
    }

    // =========================================================================
    // 4. FUNCIONES DEL MAPA
    // =========================================================================
    function cargarCapaPrincipal(claveCapa) {
        const config = configCapas[claveCapa];
        if (loader) loader.style.display = "flex";

        if (capaGeneral) {
            map.removeLayer(capaGeneral);
            capaGeneral = null;
        }

        if (cacheCapasPrincipales[claveCapa]) {
            renderizarCapa(cacheCapasPrincipales[claveCapa]);
            if (loader) loader.style.display = "none";
            return;
        }

        const urlFondo = `${baseUrlWFS}&typeName=${config.layer_name}`;
        fetch(urlFondo)
            .then((response) => response.json())
            .then((data) => {
                cacheCapasPrincipales[claveCapa] = data;
                renderizarCapa(data);
            })
            .catch((error) => console.error(error))
            .finally(() => {
                if (loader) loader.style.display = "none";
            });
    }

    function renderizarCapa(dataGeoJSON) {
        // 1. DIBUJAR EN EL MAPA PRINCIPAL
        capaGeneral = L.geoJSON(dataGeoJSON, {
            style: {
                color: "var(--color6)",
                weight: 2,
                opacity: 1,
                fillColor: "#a2a2a2",
                fillOpacity: 1,
            },
            interactive: false,
        }).addTo(map);
        if (municipiosLayer) municipiosLayer.bringToFront();

        // 2. DIBUJAR EN EL MINIMAPA (Contexto Gris)
        // Limpiamos la capa base anterior del minimapa
        if (miniMapBaseLayer) {
            miniMap.removeLayer(miniMapBaseLayer);
        }

        // Agregamos la nueva capa base (Macro o Micro)
        miniMapBaseLayer = L.geoJSON(dataGeoJSON, {
            style: {
                color: "#999", // Gris suave
                weight: 0.5,
                fillColor: "#e0e0e0", // Relleno gris muy claro
                fillOpacity: 0.5,
            },
            interactive: false,
        }).addTo(miniMap);

        // Importante: Ajustamos la vista del minimapa para que quepa toda la capa
        miniMap.fitBounds(miniMapBaseLayer.getBounds());
    }

    // Resalta una región y actualiza el minimapa
// Resalta una región y actualiza el minimapa
    function highlightRegion(idRegion, claveCapa, shouldZoom = true) {
        const config = configCapas[claveCapa];
        const idStr = String(idRegion);

        const mapaDeUso = claveCapa === "Microrregiones" ? geometriasMicro : geometriasMacro;
        const geometrias = mapaDeUso.get(idStr);

        if (!geometrias || geometrias.length === 0) {
            console.warn(`No hay geometrías para ${idStr} en ${claveCapa}`);
            return;
        }

        // --- MAPA PRINCIPAL (Sin cambios) ---
        if (selectLayer) {
            bloqueosDeEvento = true;
            map.removeLayer(selectLayer);
            selectLayer = null;
            bloqueosDeEvento = false;
        }

        const grupoGeometrias = L.featureGroup();
        L.geoJSON(geometrias, {
            style: {
                color: "#ffffff",
                weight: 2,
                opacity: 1,
                fillColor: "var(--color7)",
                fillOpacity: 0.6,
            },
        }).addTo(grupoGeometrias);
        
        selectLayer = grupoGeometrias.addTo(map);
        if (municipiosLayer) municipiosLayer.bringToFront();

        if (shouldZoom) {
            map.fitBounds(selectLayer.getBounds(), {
                animate: true,
                duration: 0.8,
            });
        }

        // --- MINIMAPA (CORREGIDO) ---
        // 1. Limpiamos cualquier selección previa en el minimapa
        if (miniMapHighlightLayer) {
            miniMapHighlightLayer.clearLayers();

            // 2. Agregamos la geometría y guardamos la referencia en 'layerMini'
            const layerMini = L.geoJSON(geometrias, {
                style: {
                    color: "#fff",
                    weight: 1,
                    fillColor: "#ff0000", 
                    fillOpacity: 1
                },
                interactive: false
            }).addTo(miniMapHighlightLayer);
            
            // 3. FIX: Aplicamos bringToFront() A LA CAPA, no al grupo contenedor
            if (layerMini.bringToFront) {
                layerMini.bringToFront();
            }
        }
    }
    // =========================================================================
    // 5. EVENTOS
    // =========================================================================

    // Bloquear propagación de eventos en el popup (para permitir scroll)
    map.on("popupopen", function (e) {
        const popupNode = e.popup.getElement();
        if (popupNode) {
            L.DomEvent.disableClickPropagation(popupNode);
            L.DomEvent.disableScrollPropagation(popupNode);
            const scrollContainer = popupNode.querySelector(
                ".custom-popup-container",
            );
            if (scrollContainer) {
                scrollContainer.addEventListener("wheel", (event) =>
                    event.stopPropagation(),
                );
                scrollContainer.addEventListener("touchmove", (event) =>
                    event.stopPropagation(),
                );
            }
        }
    });

    // Cambio de pestañas (Macro/Micro)
    document
        .querySelectorAll("#regionalizacionTab .nav-link")
        .forEach((tab) => {
            tab.addEventListener("click", function () {
                capaActiva = this.dataset.capa;

                // 1. Cargar la capa en mapa principal (esto a su vez actualiza el fondo del minimapa)
                cargarCapaPrincipal(capaActiva);

                // 2. Limpiar selecciones en mapa principal
                if (selectLayer) {
                    bloqueosDeEvento = true;
                    map.removeLayer(selectLayer);
                    selectLayer = null;
                    bloqueosDeEvento = false;
                }
                map.setView([19.35, -97.8], 8);

                // 3. Limpiar selección (roja) del minimapa
                miniMapHighlightLayer.clearLayers();
            });
        });

    // Clic en elemento de la lista de regiones
    document.querySelectorAll(".item-region").forEach((el) => {
        el.addEventListener("click", () => {
            highlightRegion(el.dataset.id, el.dataset.capa, true);
        });

        el.addEventListener("mouseenter", () => {
            const mapGeo =
                el.dataset.capa === "Microrregiones"
                    ? geometriasMicro
                    : geometriasMacro;
            const idHtml = String(el.dataset.id);
            const geometrias = mapGeo.get(idHtml);
            if (geometrias && geometrias.length > 0) {
                geometrias.forEach((geo) => {
                    const h = L.geoJSON(geo, {
                        style: {
                            color: "black",
                            weight: 2,
                            fillColor: "#F7DC6F",
                            fillOpacity: 0.5,
                        },
                        interactive: false,
                    });
                    hoverLayer.addLayer(h);
                });
            }
        });

        el.addEventListener("mouseleave", () => hoverLayer.clearLayers());
    });

    // Eliminamos el anterior manejador de clic en el mapa (ya no se usa)

    // Al cerrar el popup, ya no restablecemos la vista ni quitamos el resaltado
    map.on("popupclose", function () {
        // Solo evitamos acciones si hay bloqueo
        if (bloqueosDeEvento) return;
        // No hacemos nada más: ni reset de zoom ni eliminación de selectLayer
    });

    // =========================================================================
    // 6. BOTÓN PARA RESTABLECER VISTA Y BOTÓN DE INFO (con tooltip)
    // =========================================================================
    window.resetMapView = function () {
        map.setView([19.35, -97.8], 8, { animate: true });

        // Limpiar mapa principal
        if (selectLayer) {
            map.removeLayer(selectLayer);
            selectLayer = null;
        }

        // Limpiar selección del minimapa
        miniMapHighlightLayer.clearLayers();

        // Opcional: Centrar minimapa de nuevo en el estado completo
        if (miniMapBaseLayer) {
            miniMap.fitBounds(miniMapBaseLayer.getBounds());
        }
    };

    const btnReset = document.getElementById("btnResetMap");
    if (btnReset) {
        btnReset.addEventListener("click", resetMapView);
    }

    // ARRANQUE
    cargarCapaPrincipal(capaActiva);
    precargarGeometrias("Microrregiones", geometriasMicro);
    precargarGeometrias("Macrorregiones", geometriasMacro);
});
