<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Dunkin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(#ffffff, #fef4eb);">
<div id="formRegistro" class="card p-4 shadow-lg" style="width: 350px; border-radius: 10px; background-color: #f2f4f4">
  <div class="d-flex justify-content-center mb-3">
    <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;">
  </div>
  <h4 class="text-center text-dark mb-3">Registro</h4>

  <!-- formulario para ingresar los datos del registro-->

  <form id="formDatos" action="../controladores/registroCon.php" method="POST" enctype="multipart/form-data">
   
  <div class="mb-3">
      <label class="form-label text-dark">Nombre</label>
      <input type="text" name="nombre" class="form-control" required placeholder="Nombre">
  </div>

    <div class="mb-3">
      <label class="form-label text-dark">Correo Electrónico</label>
      <input type="email" name="correo" class="form-control" required placeholder="Correo electrónico">
    </div>

    <div class="mb-3">
      <label class="form-label text-dark">Contraseña</label>
      <input type="password" name="clave" class="form-control" required placeholder="Contraseña">
    </div>

    <div class="mb-3">
      <label class="form-label text-dark">Confirma contraseña</label>
      <input type="password" name="confirmarClave" class="form-control" required placeholder="Confirmar contraseña">
    </div>

    <button type="submit" class="btn w-100" style="background-color: #F5821F; color: white; border: none;">
      Registrarse
    </button>

    <div class="tex-center my-3">
      <a href="../../index.php">Volver al Inicio</a>
    </div>

  </form>
</div>

<!-- Formulario para ingresar el codigo de verifiaccion  -->

 
  <!-- Contenedor principal del formulario -->
  <div id="formVerificacion" class="card p-4 shadow-lg" style="width: 350px; border-radius: 10px; background-color: #f2f4f4; display:none;">
    
    <!-- Logo centrado de Dunkin' -->
    <div class="d-flex justify-content-center mb-3">
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;">
    </div>

    <!-- Título del formulario -->
    <h4 class="text-center text-dark mb-3">Verificar código</h4>

    <!-- Inicio del formulario -->
    <form id = "formCodigo" action="../controladores/verificarCodigoR.php" method="POST">
      
      <!-- Campo de correo electrónico -->
      <div class="mb-3">
        <label class="form-label text-dark">Correo Electrónico</label>
        <input type="email" name="correo" class="form-control" required placeholder="Correo electrónico">
      </div>
      
      <!-- Verificar código -->
      <div class="mb-3">
        <label class="form-label text-dark">Código</label>
        <input type="text" name="codigo" class="form-control" required placeholder="Código de verificación">
      </div>

      <!-- Botón de envío con color personalizado -->
      <button type="submit" class="btn w-100"  style="background-color: #F5821F; color: white; border: none;">
        Registrarse
      </button>

      
      <div class="tex-center my-3">
        <span><a href="../../index.php">Volver al Inicio</a></span>
      </div>
      
    </form>
  </div>

<!--archivos js-->
<script src="../../public/js/registro.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
