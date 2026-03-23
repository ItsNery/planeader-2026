document.addEventListener("DOMContentLoaded", function () {
    //================================================================================
    // CONFIGURACIÓN Y VARIABLES INICIALES
    //================================================================================

    // URLS del servidor de mapas
    const url = "https://geoportal.puebla.gob.mx/",
        urlGeoserver = `${url}geoserver/wms`,
        urlShapeGeo = `${url}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json&typeName=`;

    // Configuración para cada tipo de capa
    const configCapas = {
        Microrregiones: { id_field: "id_micro", layer_name: "Microrregiones" },
        Macrorregiones: { id_field: "id_macro", layer_name: "Macrorregiones" },
    };

    // --- Declaración de variables de estado de la aplicación ---
    let selectLayer = null; // Capa para la región seleccionada (resaltado de clic)
    let capaGeneral = null; // Capa gris de fondo (Micro o Macro)
    let municipiosLayer = null; // Capa con los límites de los 217 municipios
    let hoverLayer = null; // Capa para el resaltado temporal del hover
    let capaActiva = "Macrorregiones"; // La capa que se muestra por defecto al cargar la página
    let isNavigating = false; // Bandera para controlar los eventos de zoom y popups

    // --- Almacenes para las geometrías precargadas ---
    const geometriasMicro = new Map();
    const geometriasMacro = new Map();

    // Inicialización del objeto Mapa de Leaflet
    const map = L.map("mapa", {
        zoom: 8,
        minZoom: 8,
    }).setView([19.35, -97.8], 8);

    // Se inicializa la capa de hover aquí, después de que 'map' ha sido creado
    hoverLayer = L.layerGroup().addTo(map);

    //================================================================================
    // CARGA DE CAPAS BASE
    //================================================================================

    // Carga la capa de municipios que siempre estará visible
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
                interactive: false, // Esta capa no necesita reaccionar a clics
            }).addTo(map);
        })
        .catch((error) => console.error("Error cargando municipios:", error));

    //================================================================================
    // DEFINICIÓN DE FUNCIONES PRINCIPALES
    //================================================================================

    /**
     * Pide a GeoServer todas las geometrías de una capa y las guarda en memoria
     * para un acceso instantáneo en funciones como el hover.
     */
    function precargarGeometrias(nombreCapa, mapaDeAlmacenamiento, idField) {
        fetch(`${urlShapeGeo}${nombreCapa}`)
            .then((response) => response.json())
            .then((data) => {
                data.features.forEach((feature) => {
                    const id = feature.properties[idField];
                    const geometria = feature.geometry;
                    if (id && geometria) {
                        mapaDeAlmacenamiento.set(String(id), geometria);
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
     * Carga y muestra la capa de fondo gris, ya sea de Micros o Macros.
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
     * Obtiene la información detallada (nombre, municipios) de una región desde el backend.
     */
    async function getInfoRegion(id_region, nombreCapa) {
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

    /**
     * Lógica principal que se activa al seleccionar una región (por clic en lista o mapa).
     * Se encarga de resaltar, hacer zoom y mostrar el popup con la información.
     */
    function seleccionarRegion(idRegion, nombreCapa) {
        // 1. APAGAMOS el listener de 'popupclose' para evitar conflictos de eventos.
        map.off("popupclose", onPopupClose);
        isNavigating = true; // Subimos la bandera de seguridad.

        const config = configCapas[nombreCapa];
        const urlSearch = `${urlShapeGeo}${config.layer_name}&CQL_FILTER=${config.id_field}=%27${idRegion}%27`;

        fetch(urlSearch)
            .then((response) => response.json())
            .then((data) => {
                if (!data.features || data.features.length === 0) {
                    Swal.fire("Error", `No se encontró la geometría para la región ${idRegion}.`, "error");
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

                // Devolvemos la promesa para encadenar el siguiente .then()
                return getInfoRegion(idRegion, nombreCapa);
            })
            .then((info) => {
                if (info) {
                    const tituloPopup =
                        nombreCapa === "Microrregiones"
                            ? `Microrregión ${info.nombre}`
                            : `Macrorregión ${info.nombre}`;
                    let municipiosList = "<li class='custom-popup-list-item'>No hay municipios disponibles</li>";
                    if (info.municipios && info.municipios.length > 0) {
                        municipiosList = info.municipios
                            .map(
                                (m) => `<li class='custom-popup-list-item'><i class="fas fa-map-marker-alt"></i><span class="municipio-nombre">${m.nombre_municipio}</span></li>`
                            )
                            .join("");
                    }
                    const popupContent = `<div class="custom-popup-container"><div class="custom-popup-header"><h4 class="custom-popup-title">${tituloPopup}</h4></div><div class="custom-popup-body"><h5 class="custom-popup-subtitle">Municipios:</h5><ul class="custom-popup-list">${municipiosList}</ul></div></div>`;

                    L.popup()
                        .setLatLng(selectLayer.getBounds().getCenter())
                        .setContent(popupContent)
                        .openOn(map);
                }
            })
            .catch((error) =>
                Swal.fire("Error", `Error al cargar la región: ${error}`, "error")
            )
            .finally(() => {
                // 3. CUANDO TODO TERMINA, volvemos a ENCENDER el listener.
                map.on("popupclose", onPopupClose);
                isNavigating = false; // Y bajamos la bandera.
            });
    }

    /**
     * Esta es la función que se ejecutará SOLO cuando un popup se cierre manualmente por el usuario.
     * Resetea el resaltado y el zoom del mapa.
     */
    function onPopupClose() {
        if (isNavigating) {
            return; // Doble chequeo de seguridad con la bandera
        }
        if (selectLayer) {
            map.removeLayer(selectLayer);
            selectLayer = null;
        }
        map.setView([19.35, -97.8], 8);
    }

    //================================================================================
    // ASIGNACIÓN DE EVENTOS (LISTENERS)
    //================================================================================

    // Eventos para los TABS que cambian entre Micro y Macro
    document.querySelectorAll("#regionalizacionTab .nav-link").forEach((tab) => {
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

    // Eventos para los ITEMS DE LA LISTA de regiones
    document.querySelectorAll(".item-region").forEach((el) => {
        // Evento de CLIC para seleccionar una región
        el.addEventListener("click", () => {
            seleccionarRegion(el.dataset.id, el.dataset.capa);
        });

        // Evento HOVER para previsualizar la región en el mapa
        el.addEventListener("mouseenter", () => {
            const almacenGeometrias =
                el.dataset.capa === "Microrregiones"
                    ? geometriasMicro
                    : geometriasMacro;
            const geometria = almacenGeometrias.get(el.dataset.id);

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

        // Evento para limpiar la previsualización del hover
        el.addEventListener("mouseleave", () => {
            hoverLayer.clearLayers();
        });
    });

    // Evento de CLIC DIRECTO EN EL MAPA para identificar una región
    map.on("click", function (e) {
        const config = configCapas[capaActiva];
        const wmsUrl =
            `${urlGeoserver}?service=WMS&version=1.1.1&request=GetFeatureInfo` +
            `&LAYERS=${config.layer_name}` +
            `&QUERY_LAYERS=${config.layer_name}` +
            `&INFO_FORMAT=application/json&SRS=EPSG:4326&STYLES=` +
            `&BBOX=${map.getBounds().toBBoxString()}` +
            `&WIDTH=${map.getSize().x}&HEIGHT=${map.getSize().y}` +
            `&X=${Math.round(e.containerPoint.x)}&Y=${Math.round(
                e.containerPoint.y
            )}`;

        fetch(wmsUrl)
            .then((response) => response.json())
            .then((data) => {
                if (data.features && data.features.length > 0) {
                    const properties = data.features[0].properties;
                    const idRegion = properties[config.id_field];
                    if (idRegion) {
                        seleccionarRegion(idRegion, capaActiva);
                    }
                }
            })
            .catch((error) => {
                console.log("Clic fuera de una región o error en GetFeatureInfo:", error);
            });
    });

    // Se activa el listener para el cierre de popups por primera vez
    map.on("popupclose", onPopupClose);

    //================================================================================
    // CARGA INICIAL DE DATOS
    //================================================================================

    // Carga la capa de fondo gris inicial
    cargarCapaPrincipal(capaActiva);

    // Precarga las geometrías de ambas capas para un hover rápido
    precargarGeometrias("Microrregiones", geometriasMicro, "id_micro");
    precargarGeometrias("Macrorregiones", geometriasMacro, "id_macro");
});