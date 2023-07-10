document.getElementById("cambiarPass").addEventListener("submit", function(event) {
    let pass1 = document.getElementById("pass1").value;
    let pass2 = document.getElementById("pass2").value;

    if (pass1 != pass2){
        event.preventDefault();
        let mensajeError = document.createElement("p");
        mensajeError.innerText = "Las contraseñas no coinciden";
        mensajeError.classList.add("alert", "alert-danger", "text-center");
        document.getElementById("form").appendChild(mensajeError);
    }

    if (pass1.length < 8){
        event.preventDefault();
        let mensajeError = document.createElement("p");
        mensajeError.innerText = "Debe contener al menos 8 caracteres";
        mensajeError.classList.add("alert", "alert-danger", "text-center");
        document.getElementById("form").appendChild(mensajeError);
    }
});

let mostrar = false;

function mostrarForm(){
    mostrar = true;
    actualizarForm();
}

function ocultarForm(){
    mostrar = false;
    actualizarForm();
}

function actualizarForm(){
    let form = document.getElementById("form");
    let datos = document.getElementById("datos");

    if (mostrar){
        datos.style.display="none";
        form.style.display="flex";
    } else{
        datos.style.display="block";
        form.style.display="none";
    }
}