
// js para manejar las respuestas de registroCon.php con alertas 
console.log('cargando.js');

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formDatos");

    if (!form) {
        console.error("No se encontró el formulario con ID 'formDatos'");
        return;
    }

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch("../controladores/registroCon.php", {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            Swal.fire({
                icon: data.status,
                title: data.message,
                confirmButtonText: "Aceptar"
            }).then(() => {
                if (data.status === "success") {
                    document.getElementById("formRegistro").style.display = "none";
                    document.getElementById("formVerificacion").style.display = "block";

                    document.querySelector("#formCodigo input[name='correo']").value = data.correo;
                }
            });

        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error inesperado",
                text: "Ocurrió un problema al procesar el registro."
            });
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formCodigo");

    if (!form) {
        console.error("No se encontró el formulario con ID 'formCodigo'");
        return;
    }

    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch("../controladores/verificarCodigoR.php", {
                method: "POST",
                body: formData
            });

            const data = await response.json();

            Swal.fire({
                icon: data.status,
                title: data.message,
                text : "Redidirigiendo a la pagina de inicio de sesión",
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                if (data.status === "success") {
                   window.location.href = "../../index.php"
                }
            });

        } catch (error) {
            Swal.fire({
                icon: "error",
                title: "Error inesperado",
                text: "Ocurrió un problema al procesar el registro."
            });
        }
    });
});
