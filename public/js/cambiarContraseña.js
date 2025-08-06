
// maneja las respuestas de cambiar contraseña 
document.getElementById("cambio-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const nueva = document.getElementById("nueva").value;
  const confirmar = document.getElementById("confirmar").value;
  const correo = document.getElementById("correoCambio").value;

  if (!nueva || !confirmar) {
    Swal.fire({
      icon: 'warning',
      title: 'Campos vacíos',
      text: 'Debes completar ambos campos.',
      confirmButtonColor: '#F5821F'
    });
    return;
  }

  if (nueva !== confirmar) {
    Swal.fire({
      icon: 'error',
      title: 'Contraseñas no coinciden',
      text: 'Por favor, verifica que ambas sean iguales.',
      confirmButtonColor: '#F5821F'
    });
    return;
  }

  fetch("../../app/controladores/cambiarContraseña.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `nueva=${encodeURIComponent(nueva)}&confirmar=${encodeURIComponent(confirmar)}&correo=${encodeURIComponent(correo)}`
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Contraseña actualizada',
          text : "Redidirigiendo a la pagina de inicio de sesión",
          timer: 3000,
        }).then(() => {
          window.location.href = '../../index.php'; // reenvia al login 
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