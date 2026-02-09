// URL base del Geoportal y URL del servicio WMS
const url = "https://geoportal.puebla.gob.mx/",
    urlGeoserver = `${url}geoserver/wms`;

// URL para OpenStreetMap
// const osmUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
// const osmAttrib = "© OpenStreetMap contributors";

// Variable para almacenar la capa seleccionada y el contenedor del mapa
let selectLayer = null;
const containerMap = document.getElementById("mapa");

// Inicializa el mapa con configuraciones específicas
const map = L.map("mapa", {
    zoom: 8,
    zoomSnap: 0.02,
    maxBounds: [
        [32.7183333333, -114.540833333], // Coordenadas de límite máximo
        [14.5408333333, -92.2166666667], // Coordenadas de límite mínimo
    ],
    minZoom: 8, // Nivel mínimo de zoom
}).setView([19.35, -97.8], 8); // Vista inicial del mapa

// Añade el mapa base de OpenStreetMap
// L.tileLayer(osmUrl, {
//     attribution: osmAttrib,
//     maxZoom: 18,
//     minZoom: 6,
// }).addTo(map);

// URL para obtener datos GeoJSON de las capas
const urlShapeGeo = `${url}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json&typeName=`;

// Carga y añade la capa de regiones al mapa
fetch(`${urlShapeGeo}Regiones_CEIGEP_2023`)
    .then((response) => response.json()) // Convierte la respuesta en JSON
    .then((data) => {
        // Añade la capa GeoJSON al mapa con estilos personalizados
        L.geoJSON(data, {
            style: {
                color: "#8C264B", // Color de borde
                weight: 2, // Grosor de borde
                opacity: 1, // Opacidad del borde
                fillColor: "#a2a2a2", // Color de relleno (opcional)
                fillOpacity: 1, // Opacidad del relleno (opcional)
            },
        }).addTo(map); // Añade la capa al mapa
    })
    .catch((error) => console.error("Error:", error)); // Manejo de errores

// Carga y añade la capa de municipios al mapa
fetch(`${urlShapeGeo}21mun`)
    .then((response) => response.json()) // Convierte la respuesta en JSON
    .then((data) => {
        // Añade la capa GeoJSON al mapa con estilos personalizados
        const geoJsonLayer = L.geoJSON(data, {
            style: {
                color: "#fa2a6c", // Color del borde
                weight: 0.6, // Grosor del borde
                opacity: 0.6, // Opacidad del borde
                fillColor: "#8C264B", // Color de relleno (opcional)
                fillOpacity: 0, // Opacidad del relleno (opcional)
            },
        }).addTo(map); // Añade la capa al mapa
    })
    .catch((error) => console.error("Error:", error)); // Manejo de errores

// old->1
let highlightLayer = L.layerGroup();

const regiones = L.tileLayer.wms(urlGeoserver, {
    layers: "Regiones_CEIGEP_2023",
    format: "image/png",
    transparent: true,
    opacity: 0.8,
    minZoom: 6,
    maxZoom: 18,
    zIndex: 998,
});

function getInfo(e) {
    let promises = [];

    // Limpiar la capa de resaltado para borrar geometrías anteriores
    highlightLayer.clearLayers();

    const layerName = "Regiones_CEIGEP_2023";
    const layer = regiones;
    const url =
        layer._url +
        "?service=WMS&version=1.1.1&request=GetFeatureInfo" +
        "&LAYERS=" +
        layerName +
        "&QUERY_LAYERS=" +
        layerName +
        "&INFO_FORMAT=application/json" +
        "&SRS=EPSG:4326&STYLES=" +
        "&BBOX=" +
        map.getBounds()._southWest.lng +
        "," +
        map.getBounds()._southWest.lat +
        "," +
        map.getBounds()._northEast.lng +
        "," +
        map.getBounds()._northEast.lat +
        "&WIDTH=" +
        map.getSize().x +
        "&HEIGHT=" +
        map.getSize().y +
        "&X=" +
        Math.round(map.layerPointToContainerPoint(e.layerPoint).x) +
        "&Y=" +
        Math.round(map.layerPointToContainerPoint(e.layerPoint).y);

    // Agregar la promesa de la solicitud GET a la lista de promesas
    promises.push(
        fetch(url)
            .then((response) => response.json())
            .then((data) => {
                let properties = data.features[0].properties;

                let filter = "new_reg_ra";
                let idRegion = properties.new_reg_ra;

                const layerGeoJSON = data.features.find(
                    (feature) => feature.properties[filter] == idRegion
                );

                // Remover la capa existente si ya existe
                if (selectLayer) {
                    map.removeLayer(selectLayer);
                }

                // Crear la capa de la consulta deseada
                // selectLayer = L.geoJSON(layerGeoJSON.geometry).addTo(map);
                selectLayer = L.geoJSON(layerGeoJSON.geometry, {
                    style: {
                        color: "#923254",
                        weight: 2,
                        opacity: 1,
                        fillColor: "#4a98ff",
                        fillOpacity: 0.6,
                    },
                }).addTo(map);

                // Ajusta los límites del mapa para mostrar la capa seleccionada
                map.fitBounds(selectLayer.getBounds(), {
                    animate: true,
                    duration: 1000,
                    easeLinearity: 0.5,
                });

                // Obtiene información de la región y muestra el pop-up
                getInfoRegion(idRegion).then((info) => {
                    if (info) {
                        // Genera la lista de municipios
                        let municipiosList =
                            "<li class='custom-popup-list-item'>No hay municipios disponibles</li>";

                        if (info.municipios && info.municipios.length > 0) {
                            municipiosList = info.municipios
                                .map(
                                    (municipio) =>
                                        `<li class='custom-popup-list-item'>
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span class="municipio-nombre">${municipio.nombre}</span>
                                                    </li>`
                                )
                                .join("");
                        }

                        // Contenido estilizado del pop-up
                        const popupContent = `
                                            <div class="custom-popup-container">
                                                <div class="custom-popup-header">
                                                    <h4 class="custom-popup-title">${info.nombre}</h4>
                                                </div>
                                                <div class="custom-popup-body">
                                                    <p class="custom-popup-description">${info.descripcion}</p>
                                                    <h5 class="custom-popup-subtitle">Municipios:</h5>
                                                    <ul class="custom-popup-list">${municipiosList}</ul>
                                                </div>
                                            </div>
                                        `;

                        // Muestra el pop-up en el mapa en el centro de la capa seleccionada
                        const boundsCenter = selectLayer
                            .getBounds()
                            .getCenter();
                        L.popup()
                            .setLatLng(boundsCenter)
                            .setContent(popupContent)
                            .openOn(map);
                    }
                });
                // return idRegion;
            })
            .catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: "Lo siento...",
                    text: `Error al obtener los atributos: Estás fuera de los límites del estado. ${error}`,
                });
                return ""; // En caso de error, devolver una cadena vacía
            })
    );

    // Esperar a que se completen todas las promesas antes de mostrar el popup
    Promise.all(promises).then((idRegion) => {});
}

// Función asíncrona para obtener información de una región por su ID
async function getInfoRegion(id_region) {
    try {
        const response = await fetch(`get_info_region/${id_region}`); // Realiza la solicitud
        const data = await response.json(); // Convierte la respuesta en JSON
        return data; // Devuelve los datos
    } catch (error) {
        // Muestra una alerta en caso de error
        Swal.fire({
            icon: "error",
            title: `${error}`,
        });
    }
}

// Añade un evento de clic a cada elemento de la región
const itemRegion = document.querySelectorAll(".item-region");
itemRegion.forEach((el) => {
    el.addEventListener("click", () => {
        let idRegion = el.dataset.id; // Obtiene el ID de la región desde el atributo de datos

        // URL para buscar la región seleccionada
        let urlSearch = `${urlShapeGeo}Regiones_CEIGEP_2023&CQL_FILTER=new_reg_ra=%27${idRegion}%27`;

        fetch(urlSearch) // Realiza la solicitud para obtener datos de la región
            .then((response) => response.json()) // Convierte la respuesta en JSON
            .then((data) => {
                // containerMap.classList.replace("col-md-8", "col-md-5");

                // Filtra los datos para obtener la región deseada
                // Filtrar los datos para obtener solo la consulta deseada
                const layerGeoJSON = data.features.find(
                    (feature) => feature.properties["new_reg_ra"] == idRegion
                );

                // Remueve la capa existente si ya existe
                if (selectLayer) {
                    map.removeLayer(selectLayer);
                }

                // Crea una nueva capa con la región seleccionada y la añade al mapa
                selectLayer = L.geoJSON(layerGeoJSON.geometry, {
                    style: {
                        color: "#ffffff", // Color del borde
                        weight: 2, // Grosor del borde
                        opacity: 1, // Opacidad del borde
                        fillColor: "#4a98ff", // Color de relleno
                        fillOpacity: 0.6, // Opacidad del relleno
                    },
                }).addTo(map); //Agrega la capa al mapa

                // Ajusta los límites del mapa para mostrar la capa seleccionada
                map.fitBounds(selectLayer.getBounds(), {
                    animate: true,
                    duration: 1000,
                    easeLinearity: 0.5,
                    // maxZoom: 9 // (opcional) Ajusta el nivel de zoom máximo
                });

                selectLayer.bringToBack(); // Envía la capa al fondo

                // Obtiene información de la región y muestra el pop-up
                getInfoRegion(idRegion).then((info) => {
                    if (info) {
                        // Genera la lista de municipios
                        // Verifica si hay municipios y genera la lista
                        let municipiosList =
                            "<li class='custom-popup-list-item'>No hay municipios disponibles</li>"; // Valor por defecto

                        if (info.municipios && info.municipios.length > 0) {
                            municipiosList = info.municipios
                                .map(
                                    (municipio) =>
                                        `<li class='custom-popup-list-item'>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span class="municipio-nombre">${municipio.nombre}</span>
                                        </li>`
                                )
                                .join("");
                        }

                        // Contenido estilizado del pop-up con clases personalizadas
                        const popupContent = `
                            <div class="custom-popup-container">
                                <div class="custom-popup-header">
                                    <h4 class="custom-popup-title">${info.nombre}</h4>
                                </div>
                                <div class="custom-popup-body">
                                    <p class="custom-popup-description">${info.descripcion}</p>
                                    <h5 class="custom-popup-subtitle">Municipios:</h5>
                                    <ul class="custom-popup-list">${municipiosList}</ul>
                                </div>
                            </div>
                        `;

                        // Muestra el pop-up en el mapa en el centro de la capa seleccionada
                        const boundsCenter = selectLayer
                            .getBounds()
                            .getCenter();
                        L.popup()
                            .setLatLng(boundsCenter)
                            .setContent(popupContent)
                            .openOn(map);
                    }
                });
            })
            .catch((error) => {
                // Muestra una alerta en caso de error
                Swal.fire({
                    icon: "error",
                    title: "Lo siento...",
                    text: `Error al cargar el archivo JSON: ${error}`,
                });
            });
    });
});
map.addEventListener("click", getInfo);
map.on("popupclose", function () {
    // Resetea la vista del mapa a la posición y nivel de zoom iniciales
    map.setView([19.35, -97.8], 8);

    // Remueve la capa seleccionada si existe
    if (selectLayer) {
        map.removeLayer(selectLayer);
        selectLayer = null;
    }
});
