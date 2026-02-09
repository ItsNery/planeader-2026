document.addEventListener("DOMContentLoaded", () => {
    // --- LÓGICA DEL MENÚ DE HAMBURGUESA (ya la teníamos) ---
    const hamburgerButton = document.getElementById("hamburger-menu");
    const mainNav = document.getElementById("main-nav");

    if (hamburgerButton && mainNav) {
        hamburgerButton.addEventListener("click", () => {
            mainNav.classList.toggle("is-active");
        });
    }

    // --- NUEVA LÓGICA PARA EL MENÚ STICKY ---

    // Solo ejecutamos la lógica del sticky en pantallas de escritorio
    if (window.innerWidth >= 992) {
        // 1. Seleccionar los elementos
        const headerTop = document.querySelector(".header-top"); // La parte de los logos
        // mainNav ya lo tenemos seleccionado arriba

        // 2. Calcular el punto de activación
        // El menú se hará sticky cuando el scroll pase la altura de la sección de logos
        const stickyTriggerPoint = headerTop.offsetHeight;

        // 3. Escuchar el evento de scroll en la ventana
        window.addEventListener("scroll", () => {
            // Comprobamos la posición actual del scroll
            if (window.scrollY > stickyTriggerPoint) {
                // Si hemos pasado el punto de activación...
                mainNav.classList.add("is-sticky");
                // Añadimos un padding al body para evitar el salto de contenido
                document.body.style.paddingTop = mainNav.offsetHeight + "px";
            } else {
                // Si volvemos a subir...
                mainNav.classList.remove("is-sticky");
                // Quitamos el padding del body
                document.body.style.paddingTop = "0";
            }
        });
    }
    // Script para el loader
    function pageLoaded() {
        let loaderSection = document.querySelector(".loader-section");
        loaderSection.classList.add("loaded");
    }
    document.onload = pageLoaded();

    // Seleccionamos los elementos del DOM
    const scrollTopBtn = document.getElementById("scrollTopBtn");
    const progressCircle = document.querySelector(".progress-ring__circle");

    // Obtenemos el radio del círculo y calculamos su circunferencia
    const radius = progressCircle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    // Asignamos la circunferencia al estilo del círculo
    // Esto crea un "guion" (dash) del tamaño del círculo y un "espacio" (gap) igual
    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    // Inicialmente, movemos el "guion" fuera de la vista
    progressCircle.style.strokeDashoffset = circumference;

    // Función para actualizar el offset del círculo según el scroll
    function setProgress() {
        // Altura total del documento
        const scrollHeight = document.documentElement.scrollHeight;
        // Altura visible del navegador (viewport)
        const clientHeight = document.documentElement.clientHeight;
        // Posición actual del scroll
        const scrollTop = window.scrollY;

        // Calculamos cuánto se puede scrollear en total
        const scrollableHeight = scrollHeight - clientHeight;

        // Si no hay nada que scrollear (página corta), salimos
        if (scrollableHeight <= 0) return;

        // Calculamos el progreso del scroll (de 0 a 1)
        const scrollFraction = scrollTop / scrollableHeight;

        // Calculamos el offset que debe tener el círculo
        const offset = circumference - scrollFraction * circumference;
        progressCircle.style.strokeDashoffset = offset;

        // Mostramos u ocultamos el botón
        // Se muestra después de scrollear 300px
        if (scrollTop > 300) {
            scrollTopBtn.classList.add("show");
        } else {
            scrollTopBtn.classList.remove("show");
        }
    }

    // Función para volver arriba suavemente al hacer clic
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    }

    // Añadimos los escuchadores de eventos
    window.addEventListener("scroll", setProgress);
    scrollTopBtn.addEventListener("click", scrollToTop);

    // Ejecutamos la función una vez al cargar por si la página ya está scrolleada
    setProgress();
});

// JS para el Carrusel de Histórico de PEDs
$(document).ready(function () {
    $("#carrusel-historico").owlCarousel({
        loop: true,
        margin: 25,
        nav: true, // Por defecto, la navegación está activa en pantallas grandes
        dots: true, // Por defecto, los dots también están activos
        items: 3,
        navText: [
            "<i class='fa-solid fa-caret-left'></i>",
            "<i class='fa-solid fa-caret-right'></i>",
        ],
        responsive: {
            // Pantallas muy pequeñas (móviles en vertical)
            0: {
                items: 1,
                stagePadding: 30,
                nav: false, // <-- AQUÍ: Ocultamos los botones de navegación
                dots: false, // <-- AQUÍ: Ocultamos los puntos
            },
            // Pantallas medianas (tablets)
            768: {
                items: 2, // <-- SUGERENCIA: Mostrar 2 items en tablets se ve mejor
                stagePadding: 40,
                nav: true, // <-- En tablets, volvemos a mostrar la navegación
                dots: true, // <-- Y los puntos
            },
            // Pantallas grandes (escritorio)
            1000: {
                items: 3,
                stagePadding: 50,
                nav: true,
                dots: true,
            },
        },
    });

    $(".owl-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: false,
        center: true,
        loop: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
            },
            600: {
                items: 3,
                nav: false,
            },
            1000: {
                items: 3,
                nav: false,
                loop: true,
            },
        },
    });
});

window.addEventListener("load", function () {
    function openSearchModal() {
        document.getElementById("customSearchModal").style.display = "block";
    }

    function closeSearchModal() {
        document.getElementById("customSearchModal").style.display = "none";
    }

    window.onclick = function (event) {
        let modal = document.getElementById("customSearchModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };

    // Hacer que las funciones sean accesibles globalmente
    window.openSearchModal = openSearchModal;
    window.closeSearchModal = closeSearchModal;
});
