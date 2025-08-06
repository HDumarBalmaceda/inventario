<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Dunkin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<!-- Cuerpo de la página con fondo en degradado claro -->
<body class="d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(#ffffff, #fef4eb);">
  
  <!-- Contenedor principal del formulario -->
  <div class="card p-4 shadow-lg" style="width: 350px; border-radius: 10px; background-color: #f2f4f4 ">
    
    <!-- Logo centrado de Dunkin' -->
    <div class="d-flex justify-content-center mb-3">
      <img src="imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;">
    </div>

    <!-- Título del formulario -->
    <h4 class="text-center text-dark mb-3">Iniciar sesión</h4>

    <!-- Inicio del formulario -->
    <form id = "formLogin" action="app/controladores/verificarInicio.php" method="POST" enctype="multipart/form-data">
      
      <!-- Campo de correo electrónico -->
      <div class="mb-3">
        <label class="form-label text-dark">Correo Electrónico</label>
        <input type="email" name="correo" class="form-control" required placeholder="Correo electrónico">
      </div>

      <!-- Campo de contraseña -->
      <div class="mb-3">
        <label class="form-label text-dark">Contraseña</label>
        <input type="password" name="clave" class="form-control" required placeholder="Contraseña">
      </div>

      <div class="text-end mb-3">
                <a href="app/vistas/recuperarContraseña.php" class="text-primary text-decoration-none">¿Olvidó su contraseña?</a>
            </div>

      <!-- Botón de envío con color personalizado -->
      <button type="submit" class="btn w-100" style="background-color: #F5821F; color: white; border: none;">
        Iniciar sesión
      </button>
      
      <!--Link para enviar a la vista de creacion de usuario -->
      <div class="text-center my-3">
       <a href="app/vistas/registro.php" class="text-decoration-none text-primary">Crear usuario</a>
      </div>


    </form>
    <div id="mensaje" class="mt-4"></div>

  </div>
 
<script src="public/js/inicio.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 
</body>
</html>