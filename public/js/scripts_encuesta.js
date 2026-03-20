let lengua_9_6_1 = document.querySelectorAll('input[name="9_6"]');
let container_lengua_9_6_1 = document.getElementById("container_lengua_9_6_1");
const select_lengua_9_6_1 = document.getElementById("select_lengua_9_6_1");
lengua_9_6_1.forEach((radio) => {
    radio.addEventListener("change", (e) => {
        e.target.value === "1"
            ? container_lengua_9_6_1.classList.remove("d-none")
            : container_lengua_9_6_1.classList.add("d-none");

        select_lengua_9_6_1.selectedIndex = 0;
    });
});

let discapacidad_9_7_1 = document.querySelectorAll('input[name="9_7"]');
let container_discapacidad_9_7_1 = document.getElementById(
    "container_discapacidad_9_7_1"
);
const select_discapacidad_9_7_1 = document.getElementById(
    "select_discapacidad_9_7_1"
);

discapacidad_9_7_1.forEach((radio) => {
    radio.addEventListener("change", (e) => {
        e.target.value === "1"
            ? container_discapacidad_9_7_1.classList.remove("d-none")
            : container_discapacidad_9_7_1.classList.add("d-none");

        select_discapacidad_9_7_1.selectedIndex = 0;
    });
});

// problematica

let lengua_indigena = document.querySelectorAll(
    'input[name="lengua_indigena"]'
);
let container_lengua_indigena = document.getElementById("container_lengua_indigena");
const select_lengua_indigena = document.getElementById("select_lengua_indigena");
lengua_indigena.forEach((radio) => {
    radio.addEventListener("change", (e) => {
        e.target.value === "1"
            ? container_lengua_indigena.classList.remove("d-none")
            : container_lengua_indigena.classList.add("d-none");

        select_lengua_indigena.selectedIndex = 0;
    });
});

let discapacidad = document.querySelectorAll('input[name="discapacidad"]');
let container_discapacidad_si = document.getElementById(
    "container_discapacidad_si"
);
const select_discapacidad_si = document.getElementById(
    "select_discapacidad_si"
);

discapacidad.forEach((radio) => {
    radio.addEventListener("change", (e) => {
        e.target.value === "1"
            ? container_discapacidad_si.classList.remove("d-none")
            : container_discapacidad_si.classList.add("d-none");

        select_discapacidad_si.selectedIndex = 0;
    });
});
