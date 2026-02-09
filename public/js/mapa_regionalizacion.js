document.addEventListener("DOMContentLoaded", function () {
    // URLS y configuración general
    const url = "https://geoportal.puebla.gob.mx/",
        urlGeoserver = `${url}geoserver/wms`,
        urlShapeGeo = `${url}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json&typeName=`;

    const configCapas = {
        Microrregiones: { id_field: "id_micro", layer_name: "Microrregiones" },
        Macrorregiones: { id_field: "id_macro", layer_name: "Macrorregiones" },
    };

    // Declaración de variables que usaremos
    let selectLayer = null;
    let capaGeneral = null;
    let municipiosLayer = null;
    let capaActiva = "Macrorregiones";
    const geometriasMicro = new Map();
    const geometriasMacro = new Map();
    let hoverLayer = null; // La declaramos aquí, pero la inicializamos después del mapa

    // Inicialización del mapa
    const map = L.map("mapa", {
        zoom: 8,
        minZoom: 8,
    }).setView([19.35, -97.8], 8);

    // =========================================================================
    // SOLUCIÓN: Movemos la inicialización de la capa hover AQUÍ, después de crear el mapa
    hoverLayer = L.layerGroup().addTo(map);
    // Antes, esta línea estaba arriba y causaba el error porque 'map' no existía aún.
    // =========================================================================

    // Carga de la capa de municipios (siempre visible)
    fetch(`${urlShapeGeo}21mun`)
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
        })
        .catch((error) => console.error("Error cargando municipios:", error));

    // --- FUNCIONES ---

    /**
     * Pide todas las geometrías de una capa y las guarda en un Map para acceso rápido.
     */
    function precargarGeometrias(nombreCapa, mapaDeAlmacenamiento, idField) {
        fetch(`${urlShapeGeo}${nombreCapa}`)
            .then((response) => response.json())
            .then((data) => {
                data.features.forEach((feature) => {
                    const id = feature.properties[idField];
                    const geometria = feature.geometry;
                    if (id && geometria) {
                        mapaDeAlmacenamiento.set(String(id), geometria); // Guardamos ID como string por consistencia
                    }
                });
                console.log(`Geometrías para ${nombreCapa} precargadas.`);
            })
            .catch((error) =>
                console.error(
                    `Error precargando geometrías para ${nombreCapa}:`,
                    error
                )
            );
    }

    /**
     * Carga la capa principal gris de fondo (Micro o Macro)
     */
    function cargarCapaPrincipal(nombreCapa) {
        if (capaGeneral) {
            map.removeLayer(capaGeneral);
        }
        fetch(`${urlShapeGeo}${nombreCapa}`)
            .then((response) => response.json())
            .then((data) => {
                capaGeneral = L.geoJSON(data, {
                    style: {
                        color: "var(--color6)",
                        weight: 2,
                        opacity: 1,
                        fillColor: "#a2a2a2",
                        fillOpacity: 1,
                    },
                    interactive: false,
                }).addTo(map);

                if (municipiosLayer) {
                    municipiosLayer.bringToFront();
                }
            })
            .catch((error) =>
                console.error(`Error cargando capa ${nombreCapa}:`, error)
            );
    }

    /**
     * Resalta la región seleccionada al hacer clic y muestra el popup
     */
    function seleccionarRegion(idRegion, nombreCapa) {
        // Lógica de `seleccionarRegion` (sin cambios)
        const config = configCapas[nombreCapa];
        const urlSearch = `${urlShapeGeo}${config.layer_name}&CQL_FILTER=${config.id_field}=%27${idRegion}%27`;

        fetch(urlSearch)
            .then((response) => response.json())
            .then((data) => {
                if (!data.features || data.features.length === 0) {
                    Swal.fire(
                        "Error",
                        `No se encontró la geometría para la región ${idRegion}.`,
                        "error"
                    );
                    return;
                }
                const layerGeoJSON = data.features[0];

                if (selectLayer) {
                    map.removeLayer(selectLayer);
                }

                selectLayer = L.geoJSON(layerGeoJSON.geometry, {
                    style: {
                        color: "#ffffff",
                        weight: 2,
                        opacity: 1,
                        fillColor: "var(--color7)",
                        fillOpacity: 0.6,
                    },
                }).addTo(map);

                if (municipiosLayer) {
                    municipiosLayer.bringToFront();
                }

                map.fitBounds(selectLayer.getBounds(), {
                    animate: true,
                    duration: 1,
                });

                getInfoRegion(idRegion, nombreCapa).then((info) => {
                    if (info) {
                        const tituloPopup =
                            nombreCapa === "Microrregiones"
                                ? `Microrregión ${info.nombre}`
                                : `Macrorregión ${info.nombre}`;
                        let municipiosList =
                            "<li class='custom-popup-list-item'>No hay municipios disponibles</li>";
                        if (info.municipios && info.municipios.length > 0) {
                            municipiosList = info.municipios
                                .map(
                                    (m) =>
                                        `<li class='custom-popup-list-item'><i class="fas fa-map-marker-alt"></i><span class="municipio-nombre">${m.nombre_municipio}</span></li>`
                                )
                                .join("");
                        }
                        const popupContent = `<div class="custom-popup-container"><div class="custom-popup-header"><h4 class="custom-popup-title">${tituloPopup}</h4></div><div class="custom-popup-body"><h5 class="custom-popup-subtitle">Municipios:</h5><ul class="custom-popup-list">${municipiosList}</ul></div></div>`;
                        L.popup()
                            .setLatLng(selectLayer.getBounds().getCenter())
                            .setContent(popupContent)
                            .openOn(map);
                    }
                });
            })
            .catch((error) =>
                Swal.fire(
                    "Error",
                    `Error al cargar la región: ${error}`,
                    "error"
                )
            );
    }

    /**
     * Obtiene la info (nombre y municipios) de una región desde el backend
     */
    async function getInfoRegion(id_region, nombreCapa) {
        // Lógica de `getInfoRegion` (sin cambios)
        try {
            const response = await fetch(
                `get_info_region/${nombreCapa}/${id_region}`
            );
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error("Error en getInfoRegion:", error);
            Swal.fire(
                "Error",
                `No se pudo cargar la información de la región: ${error.message}`,
                "error"
            );
            return null;
        }
    }

    // --- LÓGICA DE EVENTOS ---

    // Eventos para los TABS
    document
        .querySelectorAll("#regionalizacionTab .nav-link")
        .forEach((tab) => {
            tab.addEventListener("click", function () {
                capaActiva = this.dataset.capa;
                cargarCapaPrincipal(capaActiva);
                if (selectLayer) {
                    map.removeLayer(selectLayer);
                    selectLayer = null;
                }
                map.setView([19.35, -97.8], 8);
            });
        });

    // Eventos para los ITEMS DE LA LISTA
    document.querySelectorAll(".item-region").forEach((el) => {
        // Evento de CLIC
        el.addEventListener("click", () => {
            const idRegion = el.dataset.id;
            const tipoCapa = el.dataset.capa;
            seleccionarRegion(idRegion, tipoCapa);
        });

        // Evento HOVER (mouseenter)
        el.addEventListener("mouseenter", () => {
            const idRegion = el.dataset.id;
            const tipoCapa = el.dataset.capa;
            const almacenGeometrias =
                tipoCapa === "Microrregiones"
                    ? geometriasMicro
                    : geometriasMacro;
            const geometria = almacenGeometrias.get(idRegion);

            if (geometria) {
                const highlight = L.geoJSON(geometria, {
                    style: {
                        color: "black",
                        weight: 2,
                        fillColor: "#F7DC6F",
                        fillOpacity: 0.5,
                    },
                    interactive: false,
                });
                hoverLayer.addLayer(highlight);
            }
        });

        // Evento HOVER (mouseleave)
        el.addEventListener("mouseleave", () => {
            hoverLayer.clearLayers();
        });
    });

    // Evento de click en el mapa
    map.on("click", function (e) {
        // Obtenemos la configuración de la capa activa (Micro o Macro)
        const config = configCapas[capaActiva];

        // Construimos la URL para la petición GetFeatureInfo
        const wmsUrl =
            `${urlGeoserver}?service=WMS&version=1.1.1&request=GetFeatureInfo` +
            `&LAYERS=${config.layer_name}` +
            `&QUERY_LAYERS=${config.layer_name}` +
            `&INFO_FORMAT=application/json` +
            `&SRS=EPSG:4326&STYLES=` +
            `&BBOX=${map.getBounds().toBBoxString()}` + // El área visible del mapa
            `&WIDTH=${map.getSize().x}` + // El ancho del mapa en píxeles
            `&HEIGHT=${map.getSize().y}` + // El alto del mapa en píxeles
            `&X=${Math.round(e.containerPoint.x)}` + // La coordenada X del clic
            `&Y=${Math.round(e.containerPoint.y)}`; // La coordenada Y del clic

        fetch(wmsUrl)
            .then((response) => response.json())
            .then((data) => {
                // Si el servidor encontró una región en ese punto...
                if (data.features && data.features.length > 0) {
                    const properties = data.features[0].properties;
                    // Obtenemos el ID de la región usando el nombre del campo correcto
                    const idRegion = properties[config.id_field];
                    if (idRegion) {
                        // Reutilizamos la función que ya teníamos para resaltar y mostrar el popup
                        seleccionarRegion(idRegion, capaActiva);
                    }
                }
            })
            .catch((error) => {
                console.log(
                    "Clic fuera de una región o error en GetFeatureInfo:",
                    error
                );
            });
    });

    // Evento al cerrar un popup
    map.on("popupclose", function () {
        if (selectLayer) {
            map.removeLayer(selectLayer);
            selectLayer = null;
        }
        map.setView([19.35, -97.8], 8);
    });

    // --- CARGA INICIAL ---

    cargarCapaPrincipal(capaActiva);
    precargarGeometrias("Microrregiones", geometriasMicro, "id_micro");
    precargarGeometrias("Macrorregiones", geometriasMacro, "id_macro");
});
