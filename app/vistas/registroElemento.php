
<?php
//verificar la sesion  
require_once "../controladores/verificarSesion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario Dunkin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <link rel="stylesheet" href="/prueba-2/public/css/styleElemento.css?v=2">

</head>
<body>

<!-- barra de navegación -->
<!-- Navbar principal con fondo claro -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #f2f4f4;">
  <div class="container-fluid">

    <!-- Logo de la empresa y título "Inventario" alineados horizontalmente -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <!-- Imagen del logo -->
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;" class="me-2">
      <!-- Texto al lado del logo -->
      <span class="fs-4 text-dark">Inventario</span>
    </a>

    <!-- Botón de hamburguesa para móviles (colapsa/expande el menú) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenido del navbar que se colapsa en pantallas pequeñas -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      
      <!-- Botones de navegación alineados a la derecha -->
      <div class="navbar-nav gap-2">
        <!-- Botón para ver el inventario -->
        <a href="inventario.php" class="btn btn-warning rounded-pill">📋 Ver Inventario</a>
        
        <!-- Botón para registrar salidas -->
        <a href="salidas.php" class="btn btn-info rounded-pill text-white">➕ Registrar Salidas</a>
        
        <!-- Botón para ver las salidas registradas -->
        <a href="verSalidas.php" class="btn btn-success rounded-pill">📦 Ver Salidas</a>
        
        <!-- Botón para cerrar sesión -->
        <button id="btnLogout" class="btn btn-danger rounded-pill">
        🚪 Cerrar sesión
        </button>
      </div>
    </div>

  </div>
</nav>


<!-- Contenedor centrado -->
<div class="container center-container">

  <!-- Formulario -->
  <div class="card p-4 shadow-lg w-100" style="max-width: 700px; border-radius: 10px; background-color: #f2f4f4;">
    <h4 class="text-center text-dark mb-4">Registrar Elemento</h4>

    <form action="../controladores/registroElemeCon.php" method="POST" enctype="multipart/form-data">
      <div class="row">
        
        <!-- Columna izquierda -->
        <div class="col-md-6">
          
          
          <label class="text-dark" for="tipo">Tipo de registro:</label>
          <select class="form-select mb-3" name="tipo" id="tipo" required>
            <option value="">-- Seleccione --</option>
            <option value="entrada">Entrada</option>
            <option value="salida">Salida</option>
          </select>

          <label class="text-dark">Nombre del Elemento:</label>
          <input type="text" class="form-control mb-3" name="nombre_elemento" required placeholder="Nombre del elemento">

          <label class="text-dark" id="label_origen_destino">Origen:</label>
          <input type="text" class="form-control mb-3" name="origen" id="origen_destino" required placeholder="Origen">

          <label class="text-dark">Serial:</label>
          <input type="text" class="form-control mb-3" name="serial" required placeholder="Serial">

          <label class="text-dark">Modelo:</label>
          <input type="text" class="form-control mb-3" name="modelo" required placeholder="Modelo">

          </div>

        <!-- Columna derecha -->
        <div class="col-md-6">

          <label class="text-dark">Activo:</label>
          <input type="text" class="form-control mb-3" name="activo" required placeholder="Activo">
          
          <label class="text-dark">Fecha de Registro:</label>
          <input type="date" class="form-control mb-3" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required>

          <label class="text-dark">Observaciones:</label>
          <textarea class="form-control mb-3" name="observaciones" style= "height: 118px;"></textarea>

          <label class="text-dark">Adjuntar Archivo:</label>
          <input type="file" class="form-control mb-3" name="archivo">

        </div>
      </div>

      <!-- Botón -->
      <div class="d-grid mt-3">
        <button type="submit" class="btn w-100" style="background-color: #F5821F; color: white; border: none;">
          Agregar Elemento
        </button>
      </div>
    </form>
  </div>
</div>


  <!--archivos js y conexion con bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

<script src="../../public/js/registroElemento.js"></script>  
<script src="../../public/js/tipoRegistro.js"></script>
<script src="../../public/js/cerrarSesionAlerta.js"></script>


</body>
</html>
