let mostrarRecuadro = false;

function mostrarRecuadroEliminar(id){
    mostrarRecuadro = true;
    actualizarRecuadro(id);
}

function cancelar(){
    mostrarRecuadro = false;
    actualizarRecuadro();
}

function actualizarRecuadro(id) {
  let overlay = document.getElementById("overlay");
  let recuadro = document.getElementById("confirm-box");
  let id_evento = document.getElementById("id-evento")

  if (mostrarRecuadro) {
    overlay.classList.add("overlay-visible");
    recuadro.classList.add("recuadro-visible");
    id_evento.value = id;
  } else {
    overlay.classList.remove("overlay-visible");
    recuadro.classList.remove("recuadro-visible");
  }
}