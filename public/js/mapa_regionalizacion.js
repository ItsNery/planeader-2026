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
        },
        Macrorregiones: {
            id_field: "id_macro",
            layer_name: "Macrorregiones_2026",
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

    const map = L.map("mapa", {
        zoom: 8,
        minZoom: 8,
    }).setView([19.35, -97.8], 8);

    hoverLayer = L.layerGroup().addTo(map);

    // =========================================================================
    // 2. CARGA DE MUNICIPIOS
    // =========================================================================
    const urlMuni = `${baseUrlWFS}&typeName=21mun&t=${Date.now()}`;

    // console.log("🔄 Descargando municipios...");
    fetch(urlMuni)
        .then((response) => response.json())
        .then((data) => {
            municipiosLayer = L.geoJSON(data, {
                style: {
                    color: "#fa2a6c",
                    weight: 0.6,
                    opacity: 0.6,
                    fillOpacity: 0,
                },
                interactive: false,
            }).addTo(map);
            // console.log("✅ Municipios cargados.");
        })
        .catch((error) => console.error("❌ Error municipios:", error));

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

                            // Guardamos un ARRAY de geometrías, no solo una
                            if (mapaDeAlmacenamiento.has(idStr)) {
                                // Si ya existe, agregamos este nuevo pedazo al array
                                const geometriasExistentes =
                                    mapaDeAlmacenamiento.get(idStr);
                                geometriasExistentes.push(feature.geometry);
                                contadorFragmentos++; // Contamos fragmentos extra
                            } else {
                                // Si es nuevo, iniciamos el array
                                mapaDeAlmacenamiento.set(idStr, [
                                    feature.geometry,
                                ]);
                            }
                        }
                    });
                    // console.log(
                    //     `✅ ${claveCapa}: Procesadas. Se encontraron ${contadorFragmentos} fragmentos adicionales (islas o duplicados).`,
                    // );
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

        const urlFondo = `${baseUrlWFS}&typeName=${config.layer_name}&t=${Date.now()}`;

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
    }

    function seleccionarRegion(idRegion, claveCapa) {
        const config = configCapas[claveCapa];
        const idStr = String(idRegion);

        // 1. Obtener las geometrías del caché que ya llenamos en precargarGeometrias
        const mapaDeUso =
            claveCapa === "Microrregiones" ? geometriasMicro : geometriasMacro;
        const geometrias = mapaDeUso.get(idStr);

        if (!geometrias || geometrias.length === 0) {
            // console.warn(
            //     `⚠️ No se encontró geometría en caché para el ID: ${idStr} en ${claveCapa}`,
            // );
            return;
        }

        // 2. Limpieza de capa previa
        if (selectLayer) {
            bloqueosDeEvento = true;
            map.removeLayer(selectLayer);
            selectLayer = null;
            bloqueosDeEvento = false;
        }

        // 3. Dibujar las geometrías desde el caché (Soporta multipartes/fragmentos)
        const grupoGeometrias = L.featureGroup();

        // L.geoJSON puede recibir un array de geometrías directamente
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

        // Ajustar vista y traer municipios al frente
        if (municipiosLayer) municipiosLayer.bringToFront();
        map.fitBounds(selectLayer.getBounds(), {
            animate: true,
            duration: 0.8,
        });

        // 4. Obtener la información (esto sí requiere fetch porque es info de BD)
        getInfoRegion(idRegion, claveCapa).then((info) => {
            if (info && selectLayer) {
                const titulo =
                    claveCapa === "Microrregiones"
                        ? `Microrregión ${info.nombre}`
                        : `Macrorregión ${info.nombre}`;

                let lista =
                    "<li class='custom-popup-list-item'>Sin municipios</li>";
                if (info.municipios?.length > 0) {
                    lista = info.municipios
                        .map(
                            (m) =>
                                `<li class='custom-popup-list-item '><i class="fas fa-map-marker-alt me-3"></i> ${m.nombre_municipio}</li>`,
                        )
                        .join("");
                }
                const content = `<div class="custom-popup-container">
                                <div class="custom-popup-header"><h4 class="custom-popup-title">${titulo}</h4></div>
                                <div class="custom-popup-body"><ul class="custom-popup-list">${lista}</ul></div>
                             </div>`;

                bloqueosDeEvento = true;
                selectLayer.bindPopup(content).openPopup();
                setTimeout(() => {
                    bloqueosDeEvento = false;
                }, 300);
            }
        });
        // 4. Obtener la información
    }

    async function getInfoRegion(id, claveCapa) {
        try {
            const res = await fetch(`get_info_region/${claveCapa}/${id}`);
            return await res.json();
        } catch (e) {
            return null;
        }
    }

    // =========================================================================
    // 5. EVENTOS (MODIFICADO PARA MULTI-GEOMETRÍA)
    // =========================================================================
// =========================================================================
    // BLOQUEO ABSOLUTO DE EVENTOS HACIA EL MAPA
    // =========================================================================
    map.on('popupopen', function(e) {
        const popupNode = e.popup.getElement(); 

        if (popupNode) {
            // Detiene clics y doble clics generales en el globo
            L.DomEvent.disableClickPropagation(popupNode);
            L.DomEvent.disableScrollPropagation(popupNode);

            // Busca específicamente tu contenedor con la lista
            const scrollContainer = popupNode.querySelector('.custom-popup-container');
            
            if (scrollContainer) {
                // Frenamos el evento de la rueda del ratón (scroll) puro
                scrollContainer.addEventListener('wheel', function(event) {
                    event.stopPropagation();
                });
                
                // Frenamos el evento táctil (para móviles)
                scrollContainer.addEventListener('touchmove', function(event) {
                    event.stopPropagation();
                });
            }
        }
    });
    document
        .querySelectorAll("#regionalizacionTab .nav-link")
        .forEach((tab) => {
            tab.addEventListener("click", function () {
                capaActiva = this.dataset.capa;
                cargarCapaPrincipal(capaActiva);
                if (selectLayer) {
                    bloqueosDeEvento = true;
                    map.removeLayer(selectLayer);
                    selectLayer = null;
                    bloqueosDeEvento = false;
                }
                map.setView([19.35, -97.8], 8);
            });
        });

    document.querySelectorAll(".item-region").forEach((el) => {
        el.addEventListener("click", () => {
            seleccionarRegion(el.dataset.id, el.dataset.capa);
        });

        el.addEventListener("mouseenter", () => {
            const mapGeo =
                el.dataset.capa === "Microrregiones"
                    ? geometriasMicro
                    : geometriasMacro;
            const idHtml = String(el.dataset.id);

            // Ahora obtenemos un ARRAY de geometrías
            const geometrias = mapGeo.get(idHtml);

            if (geometrias && geometrias.length > 0) {
                // console.log(
                //     `Highlighting ID: ${idHtml}. Fragments found: ${geometrias.length}`,
                // );
                // Recorremos el array y pintamos cada pedazo
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

    map.on("click", function (e) {
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
                if (d.features?.length > 0) {
                    const id = d.features[0].properties[config.id_field];
                    if (id) seleccionarRegion(id, capaActiva);
                }
            });
    });

    map.on("popupclose", function () {
        if (bloqueosDeEvento) return;
        if (selectLayer) {
            map.removeLayer(selectLayer);
            selectLayer = null;
        }
        map.setView([19.35, -97.8], 8);
    });

    // ARRANQUE
    cargarCapaPrincipal(capaActiva);
    precargarGeometrias("Microrregiones", geometriasMicro);
    precargarGeometrias("Macrorregiones", geometriasMacro);
});
