let seleccionados = false;

botonModal = document.getElementById("botonModal");

function selectAll() {
  const checkboxes = document.querySelectorAll('input[name="usuarios[]"]');
  if (seleccionados == false) {
    checkboxes.forEach((checkbox) => {
      checkbox.checked = true;
    });
    seleccionados = true;
  } else {
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });
    seleccionados = false;
  }

  event.stopPropagation();
}
