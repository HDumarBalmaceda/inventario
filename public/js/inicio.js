document.querySelector("#formLogin").addEventListener("submit", function (e) {
    e.preventDefault(); // Previene que se recargue la página

    const formData = new FormData(this);

    // fetch para manejar las respuestas del controlador 
    fetch("app/controladores/verificarInicio.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {

               window.location.href = 'app/vistas/entradas.php';

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de inicio de sesión',
                    text: data.message,
                    confirmButtonText: 'Intentar de nuevo'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error en el sistema sistema',
                text: 'Ocurrió un error inesperado.',
                confirmButtonText: 'Cerrar'
            });
            console.error(error);
        });
});
