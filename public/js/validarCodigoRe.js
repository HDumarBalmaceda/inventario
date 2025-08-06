//js para verificar el codigo de verificacion 
document.getElementById("formCodigoform").addEventListener("submit", function (e) {
  e.preventDefault();

  const codigo = document.getElementById("codigo").value;
  const correo = document.getElementById("correoOculto").value;

  fetch("../../app/controladores/validarCodigoRe.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `codigo=${encodeURIComponent(codigo)}&correo=${encodeURIComponent(correo)}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        icon: 'success',
        title: 'Código correcto',
        text: data.message,
        confirmButtonColor: '#F5821F'
      }).then(() => {
        // Mostrar el formulario de cambio de contraseña
        document.getElementById("formCodigo").style.display = "none";
        document.getElementById("formCambio").style.display = "block";
        document.getElementById("correoCambio").value = document.getElementById("email").value;
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Código incorrecto',
        text: data.message,
        confirmButtonColor: '#F5821F'
      });
    }
  })
  .catch(() => {
    Swal.fire({
      icon: 'error',
      title: 'Error del servidor',
      text: 'No se pudo verificar el código.',
      confirmButtonColor: '#F5821F'
    });
  });
});
