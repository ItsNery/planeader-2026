/**
 * Configuración del Mapa de Planes Municipales de Desarrollo
 */

// --- CONFIGURACIÓN Y CONSTANTES ---
const URL_BASE = "https://geoportal.puebla.gob.mx/";
const URL_WMS = `${URL_BASE}geoserver/wms`;
const URL_WFS = `${URL_BASE}geoserver/wfs?service=WFS&version=1.0.0&request=GetFeature&srsName=EPSG:4326&outputFormat=application/json&typeName=21mun`;

// Clave y TTL para caché en localStorage (24 horas en milisegundos)
const CACHE_KEY = "geojson_21mun_data";
const CACHE_TS_KEY = "geojson_21mun_timestamp";
const CACHE_TTL = 24 * 60 * 60 * 1000;

let geojsonLayer = null;
let selectLayer = null;
let allMunicipiosData = null;

const $mapWrapper = document.querySelector(".mapa-wrapper");
const $mapContainer = document.getElementById("mapa");
const $mapLoader = document.getElementById("map-loader");
const $resultsContainer = document.getElementById("container-results");
const $sidebarItems = document.querySelectorAll(".leaderboard__profile");
const $searchInput = document.getElementById("buscar-municipio");

// --- INICIALIZACIÓN DEL MAPA ---
const map = L.map("mapa", {
  zoom: 8,
  minZoom: 8,
}).setView([19.35, -97.8], 8);

// Estilo base para los municipios
const styleBase = {
  color: "var(--color1, #808080)",
  weight: 1,
  opacity: 0.5,
  fillColor: "#A9A9A9",
  fillOpacity: 0.1,
};

// Estilo para resaltado (hover/select)
const styleHighlight = {
  color: "var(--color4, #FF0000)",
  weight: 3,
  opacity: 1,
  fillColor: "var(--color4, #FF0000)",
  fillOpacity: 0.3,
  dashArray: "5, 5",
};

// --- FUNCIONES CORE ---

/**
 * Formatea el ID del municipio a 3 dígitos (ej: 1 -> 001, 10 -> 010)
 */
function formatId(id) {
  return String(id).padStart(3, "0");
}

/**
 * Intenta obtener los datos GeoJSON de localStorage.
 * Devuelve null si no hay caché, si expiró o si está corrupto.
 */
function getCachedGeoJSON() {
  try {
    const timestamp = localStorage.getItem(CACHE_TS_KEY);
    if (!timestamp) return null;

    const age = Date.now() - parseInt(timestamp, 10);
    if (age > CACHE_TTL) {
      // Caché expirado, limpiar
      localStorage.removeItem(CACHE_KEY);
      localStorage.removeItem(CACHE_TS_KEY);
      return null;
    }

    const data = localStorage.getItem(CACHE_KEY);
    if (!data) return null;

    return JSON.parse(data);
  } catch (e) {
    console.warn("Error leyendo caché de municipios:", e);
    return null;
  }
}

/**
 * Guarda los datos GeoJSON en localStorage con la marca de tiempo actual.
 */
function setCachedGeoJSON(data) {
  try {
    localStorage.setItem(CACHE_KEY, JSON.stringify(data));
    localStorage.setItem(CACHE_TS_KEY, String(Date.now()));
  } catch (e) {
    // localStorage lleno o no disponible — no es crítico
    console.warn("No se pudo guardar caché de municipios:", e);
  }
}

/**
 * Carga los datos GeoJSON de todos los municipios.
 * Primero intenta usar la caché de localStorage; si no existe o expiró,
 * descarga los datos del servidor WFS y los guarda en caché.
 */
async function initMap() {
  try {
    // Intentar cargar desde caché
    allMunicipiosData = getCachedGeoJSON();

    if (!allMunicipiosData) {
      // Sin caché válido — descargar del servidor
      const response = await fetch(URL_WFS);
      allMunicipiosData = await response.json();
      setCachedGeoJSON(allMunicipiosData);
      console.info("Capa 21mun cargada desde el servidor y cacheada.");
    } else {
      console.info("Capa 21mun cargada desde caché local.");
    }

    // Ocultar loader
    if ($mapLoader) {
      $mapLoader.classList.remove("d-flex");
      $mapLoader.style.display = "none";
    }

    // Añadir capa GeoJSON al mapa
    geojsonLayer = L.geoJSON(allMunicipiosData, {
      style: styleBase,
      onEachFeature: (feature, layer) => {
        layer.on({
          mouseover: (e) => highlightFeature(feature.properties.cve_mun),
          mouseout: resetHighlight,
          click: (e) => cargarPlanes(feature.properties.cve_mun),
        });
      },
    }).addTo(map);

    setupEventListeners();
  } catch (error) {
    console.error("Error cargando GeoJSON:", error);
    Swal.fire({
      icon: "error",
      title: "Error de conexión",
      text: "No se pudieron cargar los límites de los municipios.",
    });
  }
}

/**
 * Resalta un municipio en el mapa dado su ID (cve_mun)
 */
function highlightFeature(idMun) {
  const formattedId = formatId(idMun);

  // Encontrar el feature correspondiente
  const feature = allMunicipiosData.features.find(
    (f) => f.properties.cve_mun == formattedId,
  );

  if (!feature) return;

  // Remover capa previa
  if (selectLayer) map.removeLayer(selectLayer);

  // Crear capa de resaltado
  selectLayer = L.geoJSON(feature.geometry, {
    style: styleHighlight,
    interactive: false, // Evita que esta capa intercepte eventos del ratón (corrige parpadeo)
  }).addTo(map);

  // Mostrar popup sobre la capa base para que no desaparezca al mover el ratón
  const popupContent = `
    <div class="custom-popup-container">
      <div class="custom-popup-header">
        <h4 class="custom-popup-title">${feature.properties.nomgeo}</h4>
      </div>

    </div>
  `;

  geojsonLayer.eachLayer((layer) => {
    if (layer.feature.properties.cve_mun === formattedId) {
      layer.bindPopup(popupContent).openPopup();
    }
  });
}

/**
 * Quita el resaltado
 */
function resetHighlight() {
  if (selectLayer) {
    map.removeLayer(selectLayer);
    selectLayer = null;
  }
  map.closePopup(); // Cierra cualquier popup abierto al salir del área
}

/**
 * Carga los planes de un municipio mediante AJAX
 */
async function cargarPlanes(idMun) {
  const numericId = parseInt(idMun);
  try {
    const response = await fetch(`/obtener_planes/${numericId}`);
    if (!response.ok) throw new Error("Falla en la respuesta");

    const html = await response.text();

    // Ocultar mapa y mostrar resultados
    if ($mapWrapper) $mapWrapper.classList.add("d-none");
    if ($resultsContainer) {
      $resultsContainer.innerHTML = html;
      $resultsContainer.scrollIntoView({ behavior: "smooth" });
    }
  } catch (error) {
    console.error("Error:", error);
    Swal.fire({
      icon: "error",
      title: "Error",
      text: "No se pudieron obtener los planes de este municipio.",
    });
  }
}

/**
 * Cierra la vista de info y vuelve al mapa
 */
window.cerrarInfoMunicipio = function () {
  if ($resultsContainer) $resultsContainer.innerHTML = "";
  if ($mapWrapper) $mapWrapper.classList.remove("d-none");
  if (map) {
    setTimeout(() => {
      map.invalidateSize();
    }, 100);
  }
};

// --- EVENT LISTENERS ---

function setupEventListeners() {
  // Hover en la lista lateral
  $sidebarItems.forEach((el) => {
    el.addEventListener("mouseenter", () => {
      const id = el.dataset.id;
      highlightFeature(id);
    });

    el.addEventListener("mouseleave", resetHighlight);

    el.addEventListener("click", () => {
      cargarPlanes(el.dataset.id);
    });
  });

  // Búsqueda en sidebar
  if ($searchInput) {
    $searchInput.addEventListener("input", function () {
      const query = this.value.toLowerCase();
      $sidebarItems.forEach((el) => {
        const name = el
          .querySelector(".leaderboard__name")
          .textContent.toLowerCase();
        const container = el.closest("tr") || el;
        container.style.display = name.includes(query) ? "" : "none";
      });
    });
  }

  // Limpieza al salir del mapa
  map.on("mouseout", resetHighlight);

  // Al abrir popup, prevenir que el scroll/click salga del mapa
  map.on("popupopen", function (e) {
    const popupNode = e.popup.getElement();
    if (popupNode) {
      L.DomEvent.disableClickPropagation(popupNode);
      L.DomEvent.disableScrollPropagation(popupNode);
    }
  });

  // Botón de información estilo mapa regionalización
  const btnInfo = document.getElementById("btnInfo");
  if (btnInfo) {
    btnInfo.addEventListener("click", () => {
      Swal.fire({
        icon: "info",
        title: "Información",
        html: "Seleccione un municipio de la lista o haga clic en el mapa para ver los planes disponibles.",
        confirmButtonText: "Cerrar",
      });
    });
  }
}
// --- LÓGICA DE MODAL (DOCUMENTOS) ---
// Delegación de eventos para el modal que se carga dinámicamente
document.addEventListener("click", (e) => {
  const btn = e.target.closest(".js-open-modal");
  if (btn) {
    e.preventDefault();
    const modal = document.getElementById("myModal");
    const iframe = document.getElementById("modalIframe");
    const title = document.getElementById("modalTitle");

    if (modal && iframe) {
      title.textContent = btn.dataset.title;
      iframe.src = btn.dataset.src;
      modal.style.display = "block";
    }
  }
});

// Cerrar modal
window.closeModal = function () {
  const modal = document.getElementById("myModal");
  const iframe = document.getElementById("modalIframe");
  if (modal) modal.style.display = "none";
  if (iframe) iframe.src = "";
};

// Listeners básicos para modal
document.addEventListener("DOMContentLoaded", () => {
  const closeBtn = document.querySelector("#myModal .close-btn");
  if (closeBtn) closeBtn.onclick = closeModal;

  window.onclick = (e) => {
    const modal = document.getElementById("myModal");
    if (e.target == modal) closeModal();
  };

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeModal();
  });
});

// Arrancar inicialización
initMap();
