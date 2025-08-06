// js para manejar las respuestas del back
console.log('cargando enviarCodigoRe.js');
document.getElementById("formRecuperacion").addEventListener("submit", function (e) {
  e.preventDefault();

  const email = document.getElementById("email").value;

  fetch("../../app/controladores/controladorContraseña.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `email=${encodeURIComponent(email)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Código enviado',
        text: data.message,
        confirmButtonColor: '#F5821F'
      }).then(() => {
        // Cambiar de formulario
        document.getElementById("formEmail").style.display = "none";
        document.getElementById("formCodigo").style.display = "block";
        document.getElementById("correoOculto").value = document.getElementById("email").value;
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: data.message,
        confirmButtonColor: '#F5821F'
      });
    }
  })
  .catch(() => {
    Swal.fire({
      icon: 'error',
      title: 'Error del servidor',
      text: 'No se pudo procesar la solicitud.',
      confirmButtonColor: '#F5821F'
    });
  });
});
