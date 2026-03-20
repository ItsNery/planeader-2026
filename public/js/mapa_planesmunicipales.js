// URL base del Geoportal y URL del servicio WMS
const url = "https://geoportal.puebla.gob.mx/",
    urlGeoserver = `${url}geoserver/wms`;

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

// URL para obtener datos GeoJSON de las capas
const urlShapeGeo = `${url}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json&typeName=`;

// Carga y añade la capa de municipios al mapa
fetch(`${urlShapeGeo}21mun`)
    .then((response) => response.json()) // Convierte la respuesta en JSON
    .then((data) => {
        // Añade la capa GeoJSON al mapa con estilos personalizados
        const geoJsonLayer = L.geoJSON(data, {
            style: {
                color: "var(--color1)", // Color del borde
                weight: 1, // Grosor del borde
                opacity: 0.3, // Opacidad del borde
                fillColor: "#A9A9A9", // Color de relleno (opcional)
                fillOpacity: 0, // Opacidad del relleno (opcional)
            },
        }).addTo(map); // Añade la capa al mapa
    })
    .catch((error) => console.error("Error:", error)); // Manejo de errores

// old->1

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
const itemRegion = document.querySelectorAll(".leaderboard__profile");
itemRegion.forEach((el) => {
    el.addEventListener("mouseenter", () => {
        let idMunicipio = el.dataset.id; // Obtiene el ID del municipio desde el atributo de datos

        // Convierte el ID en un número y aplica el formato deseado
        if (idMunicipio < 10) {
            idMunicipio = `00${idMunicipio}`; // Agrega dos ceros si es entre 1 y 9
        } else if (idMunicipio < 100) {
            idMunicipio = `0${idMunicipio}`; // Agrega un cero si es entre 10 y 99
        }

        // // URL para buscar la región seleccionada
        let urlSearch = `${urlShapeGeo}21mun&CQL_FILTER=cve_mun=%27${idMunicipio}%27`;

        fetch(urlSearch) // Realiza la solicitud para obtener datos de la región
            .then((response) => response.json()) // Convierte la respuesta en JSON
            .then((data) => {
                // Filtra los datos para obtener el municipio deseada
                // Filtrar los datos para obtener solo la consulta deseada
                const layerGeoJSON = data.features.find(
                    (feature) => feature.properties["cve_mun"] == idMunicipio
                );

                // Remueve la capa existente si ya existe
                if (selectLayer) {
                    map.removeLayer(selectLayer);
                }

                // Crea una nueva capa con la región seleccionada y la añade al mapa
                selectLayer = L.geoJSON(layerGeoJSON.geometry, {
                    style: {
                        color: "var(--color4)", // Rojo vibrante para el borde
                        weight: 8, // Borde más grueso
                        opacity: 1, // Opacidad completa del borde
                        fillColor: "var(--color4)", // Relleno rojo suave
                        fillOpacity: 0.8, // Opacidad más ligera del relleno
                        dashArray: "5, 5", // Borde punteado para mayor visibilidad
                        shadowColor: "var(--color4)", // Sombra negra
                        shadowBlur: 10, // Difuminado de la sombra
                        shadowOffsetX: 2, // Desplazamiento de la sombra
                        shadowOffsetY: 2, // Desplazamiento de la sombra
                    },
                }).addTo(map); //Agrega la capa al mapa

                // Ajusta los límites del mapa para mostrar la capa seleccionada
                map.fitBounds(selectLayer.getBounds(), {
                    animate: true,
                    duration: 1000,
                    easeLinearity: 0.5,
                    maxZoom: 8, // (opcional) Ajusta el nivel de zoom máximo
                });

                const nombreMunicipio = layerGeoJSON.properties["nomgeo"];
                selectLayer.bindPopup(`<b>${nombreMunicipio}</b>`).openPopup();

                selectLayer.bringToBack(); // Envía la capa al fondo
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

itemRegion.forEach((el) => {
    el.addEventListener("mouseleave", () => {
        if (selectLayer) {
            map.removeLayer(selectLayer);
        }

        let boundsMexico = [
            [21.043716, -99.249698],
            [17.7107, -96.443203],
        ];

        map.fitBounds(boundsMexico, {
            animate: true,
            duration: 1000,
            easeLinearity: 0.5,
            maxZoom: 8,
        });
    });
});

// Suponiendo que ya tienes la capa GeoJSON añadida como en el código anterior:
fetch(`${urlShapeGeo}21mun`)
    .then((response) => response.json())
    .then((data) => {
        // Añades la capa GeoJSON al mapa y asignas el evento click a cada municipio
        L.geoJSON(data, {
            style: {
                color: "var(--color2)",
                weight: 1,
                opacity: 1,
                fillOpacity: 0,
            },
            onEachFeature: function (feature, layer) {
                // Añades el evento click a cada municipio
                layer.on("click", function () {
                    // Obtener el id del municipio desde las propiedades del GeoJSON
                    let idMun = feature.properties.cve_mun;

                    // Realiza la solicitud al servidor como en el script original
                    fetch("/obtener_planes/" + idMun)
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error("La solicitud ha fallado");
                            }
                            return response.text();
                        })
                        .then((data) => {
                            // Ocultar el mapa y mostrar los planes en el contenedor
                            $mapa.classList.add("d-none");
                            const $containerResults =
                                document.getElementById("container-results");
                            $containerResults.innerHTML = data;
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                        });
                });
            },
        }).addTo(map);
    })
    .catch((error) => console.error("Error:", error));

    