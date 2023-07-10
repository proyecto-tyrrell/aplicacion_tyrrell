document.getElementById("form-agregar-evento-2").addEventListener("submit", function(event) {
    let usuariosSelect = document.getElementById("multiple-checkboxes2");

    // Verificar si no se ha seleccionado ningún usuario
    if (usuariosSelect.selectedOptions.length === 0) {
        event.preventDefault(); // Evitar que el formulario se envíe
        let mensajeError = document.createElement("p");
        mensajeError.innerText = "Debe ingresar al menos un usuario";
        mensajeError.classList.add("alert", "alert-danger", "text-center");
        document.getElementById("form-agregar-evento-2").appendChild(mensajeError);
    }
});