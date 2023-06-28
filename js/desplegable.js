const botonDesplegar = document.getElementById("desplegar");
const sidebar = document.getElementById("sidebar");

botonDesplegar.addEventListener("click", () => {
  sidebar.classList.toggle("desplegado");
});