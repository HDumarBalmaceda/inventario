  
  // Alerta para registro exitoso 
  document.addEventListener('DOMContentLoaded', function () {
        const alerta = document.getElementById('alerta-mensaje');
        if (alerta) {
            setTimeout(() => {
                alerta.style.transition = "opacity 0.5s";
                alerta.style.opacity = "0";
                setTimeout(() => alerta.remove(), 500);
            }, 5000);
        }
    });