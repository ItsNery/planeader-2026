document.addEventListener("DOMContentLoaded", function () {
    // URL base del Geoportal y URL del servicio WMS
    const url = "https://geoportal.puebla.gob.mx/",
        urlGeoserver = `${url}geoserver/wms`;

    // URL para obtener datos GeoJSON de las capas
    const urlShapeGeo = `${url}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json&typeName=`;

    let selectLayer = null;
    let capaGeneral = null; // Para la capa gris de fondo
    let capaActiva = "Microrregiones"; // Inicia con Microrregiones por defecto

    // Configuración para cada tipo de capa
    const configCapas = {
        Microrregiones: {
            id_field: "id_micro",
            layer_name: "Microrregiones",
        },
        Macrorregiones: {
            id_field: "id_macro",
            layer_name: "Macrorregiones", // Asegúrate de que este es el nombre de tu capa en Geoserver
        },
    };

    // Inicializa el mapa
    const map = L.map("mapa", {
        zoom: 8,
        minZoom: 8,
    }).setView([19.35, -97.8], 8);

    let municipiosLayer = null; // <-- AÑADE ESTA LÍNEA al inicio del script, junto a las otras variables.

    // Carga la capa de municipios (esta es estática y siempre visible)
    fetch(`${urlShapeGeo}21mun`)
        .then((response) => response.json())
        .then((data) => {
            municipiosLayer = L.geoJSON(data, {
                // <-- GUARDA LA CAPA AQUÍ
                style: {
                    color: "#fa2a6c",
                    weight: 0.6,
                    opacity: 0.6,
                    fillOpacity: 0,
                },
            }).addTo(map);
        })
        .catch((error) => console.error("Error cargando municipios:", error));

    // ---- FUNCIONES REUTILIZABLES ----

    // Función para cargar la capa principal (gris) según el tab
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
                }).addTo(map);

                // =============================================================
                //  SOLUCIÓN: Aseguramos que los municipios estén siempre al frente
                if (municipiosLayer) {
                    municipiosLayer.bringToFront();
                }
                // =============================================================
            })
            .catch((error) =>
                console.error(`Error cargando capa ${nombreCapa}:`, error)
            );
    }

    // Función para resaltar una región y mostrar su popup
    // Función para resaltar una región y mostrar su popup
    // Función para resaltar una región y mostrar su popup
    function seleccionarRegion(idRegion, nombreCapa) {
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
                        // ====================================================================
                        //  AQUÍ ESTÁ LA CORRECCIÓN: Creamos el título correctamente
                        const tituloPopup =
                            nombreCapa === "Microrregiones"
                                ? `Microrregión ${info.nombre}`
                                : `Macrorregión ${info.nombre}`;
                        // ====================================================================

                        let municipiosList =
                            "<li class='custom-popup-list-item'>No hay municipios disponibles</li>";
                        if (info.municipios && info.municipios.length > 0) {
                            municipiosList = info.municipios
                                .map(
                                    (m) =>
                                        `<li class='custom-popup-list-item'>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="municipio-nombre">${m.nombre_municipio}</span>
                            </li>`
                                )
                                .join("");
                        }
                        const popupContent = `
                        <div class="custom-popup-container">
                            <div class="custom-popup-header">
                                <h4 class="custom-popup-title">${tituloPopup}</h4>
                            </div>
                            <div class="custom-popup-body">
                                <h5 class="custom-popup-subtitle">Municipios:</h5>
                                <ul class="custom-popup-list">${municipiosList}</ul>
                            </div>
                        </div>`;
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

    // Tu función de getInfoRegion necesita saber de qué tipo de región pedir info
    async function getInfoRegion(id_region, nombreCapa) {
        try {
            // =========================================================================
            //  AQUÍ ESTÁ EL CAMBIO CLAVE: Añadimos el tipo de capa a la URL
            const response = await fetch(
                `get_info_region/${nombreCapa}/${id_region}`
            );
            //  La URL ahora será, por ejemplo: /get_info_region/Macrorregiones/5
            // =========================================================================

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

    // ---- LÓGICA DE EVENTOS ----

    // 1. Eventos para los TABS
    document
        .querySelectorAll("#regionalizacionTab .nav-link")
        .forEach((tab) => {
            tab.addEventListener("click", function () {
                capaActiva = this.dataset.capa;
                cargarCapaPrincipal(capaActiva);
                // Al cambiar de tab, reseteamos el mapa
                if (selectLayer) {
                    map.removeLayer(selectLayer);
                    selectLayer = null;
                }
                map.setView([19.35, -97.8], 8);
            });
        });

    // 2. Eventos para los ITEMS DE LA LISTA (para ambas listas)
    document.querySelectorAll(".item-region").forEach((el) => {
        el.addEventListener("click", () => {
            const idRegion = el.dataset.id;
            const tipoCapa = el.dataset.capa; // 'Microrregiones' o 'Macrorregiones'
            seleccionarRegion(idRegion, tipoCapa);
        });
    });

    // 3. Evento de click en el mapa (GetFeatureInfo)
    map.on("click", function (e) {
        const config = configCapas[capaActiva];
        const wmsUrl = `${urlGeoserver}?service=WMS&version=1.1.1&request=GetFeatureInfo&LAYERS=${
            config.layer_name
        }&QUERY_LAYERS=${
            config.layer_name
        }&INFO_FORMAT=application/json&SRS=EPSG:4326&STYLES=&BBOX=${map
            .getBounds()
            .toBBoxString()}&WIDTH=${map.getSize().x}&HEIGHT=${
            map.getSize().y
        }&X=${Math.round(e.containerPoint.x)}&Y=${Math.round(
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
                // No mostrar error si simplemente se hace clic fuera
                console.log(
                    "Clic fuera de una región o error en GetFeatureInfo:",
                    error
                );
            });
    });

    // 4. Evento al cerrar un popup
    map.on("popupclose", function () {
        if (selectLayer) {
            map.removeLayer(selectLayer);
            selectLayer = null;
        }
        map.setView([19.35, -97.8], 8);
    });

    // Carga inicial
    cargarCapaPrincipal(capaActiva);
});
