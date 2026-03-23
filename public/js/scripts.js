$(".owl-carousel").owlCarousel({
  autoplay: true,
  smartSpeed: 1500,
  dots: true,
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
AOS.init();

function pageLoaded() {
  let loaderSection = document.querySelector(".loader-section");
  loaderSection.classList.add("loaded");
}
document.onload = pageLoaded();
let mybutton = document.getElementById("myBtn");
window.onscroll = function () {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

const navbar = document.getElementById("navbar");
const navbarMovil = document.getElementById("movil-navbar");
const encabezado = document.querySelector(".encabezado");
let lastScrollTop = 0;

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;

  if (currentScroll > 50) {
    // Aplica la clase sticky cuando se desplaza hacia abajo o arriba
    navbar.classList.add("sticky");
    encabezado.classList.add("py-1");
    // encabezado.style.padding = "0.1rem 4rem"
  } else {
    // Remueve la clase sticky cuando vuelve a la parte superior
    navbar.classList.remove("sticky");
    encabezado.classList.remove("py-1");
    // encabezado.style.padding = "1rem 4rem"
  }

  lastScrollTop = currentScroll;
});

document.addEventListener("DOMContentLoaded", function () {
  const menuButton = document.getElementById("menuButton");
  const menuOverlay = document.getElementById("menuOverlay");
  const mobileMenu = document.getElementById("mobileMenu");

  menuButton.addEventListener("click", function () {
    mobileMenu.classList.add("active");
    menuOverlay.classList.add("active");
  });

  menuOverlay.addEventListener("click", function () {
    mobileMenu.classList.remove("active");
    menuOverlay.classList.remove("active");
  });
});

window.addEventListener("load", function () {
  let modal = document.getElementById("customSearchModal");

  window.openSearchModal = function () {
    modal.classList.add("show");
  };

  window.closeSearchModal = function () {
    modal.classList.remove("show");
  };

  window.onclick = function (event) {
    if (event.target === modal) {
      closeSearchModal();
    }
  };
});
