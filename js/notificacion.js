let eventoNuevo = document.getElementById("eventoNuevo").textContent;
let misEventos = document.getElementById("misEventos");
if (eventoNuevo == "true"){
    misEventos.classList.add("boton-oscilante");
}


let novedadNueva = document.getElementById("novedadNueva").textContent;
let novedades = document.getElementById("novedades");
if (novedadNueva == "true"){
    novedades.classList.add("boton-oscilante");
}
