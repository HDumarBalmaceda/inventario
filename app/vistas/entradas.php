<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventario Dunkin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../public/css/styleEntradas.cs">

  <style>
    body {
      background: linear-gradient(#ffffff, #fef4eb);
      margin: 0;
      padding-top: 80px; /* espacio para navbar fija */
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1030;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .center-container {
      min-height: calc(100vh - 100px); /* ajusta según altura navbar */
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
  </style> 
</head>
<body>

<!-- barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #f2f4f4;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;" class="me-2">
      <span class="fs-4 text-dark">Inventario</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
      <div class="navbar-nav gap-2">
        <a href="ver_inventario.php" class="btn btn-warning rounded-pill">📋 Ver Inventario</a>
        <a href="salidas.php" class="btn btn-info rounded-pill text-white">➕ Registrar Salidas</a>
        <a href="verSalidas.php" class="btn btn-success rounded-pill">📦 Ver Salidas</a>
        <a href="logout.php" class="btn btn-danger rounded-pill">🚪 Cerrar sesión</a>
      </div>
    </div>
  </div>
</nav>

<!-- Contenedor centrado -->
<div class="container center-container">


  <!-- Alerta -->
  <?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success text-center w-100" id="alerta-mensaje">
      <?php echo htmlspecialchars($_GET['mensaje']); ?>
    </div>
  <?php endif; ?>

  <!-- Formulario -->
  <div class="card p-4 shadow-lg w-100" style="max-width: 700px; border-radius: 10px; background-color: #f2f4f4;">
    <h4 class="text-center text-dark mb-4">Registrar entrada </h4>
    <form action="/app/controladores/entradasCon.php" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6">
          <label class="text-dark">Nombre del Elemento:</label>
          <input type="text" class="form-control mb-2" name="nombre_elemento" required placeholder="Nombre del elemento">

          <label class="text-dark">Origen:</label>
          <input type="text" class="form-control mb-2" name="origen" required placeholder="Origen">

          <label class="text-dark">Serial:</label>
          <input type="text" class="form-control mb-2" name="serial" required placeholder="Serial">

          <label class="text-dark">Modelo:</label>
          <input type="text" class="form-control mb-2" name="modelo" required placeholder="Modelo">

          <label class="text-dark">Activo:</label>
          <input type="text" class="form-control mb-2" name="activo" required placeholder="Activo">

          <label class="text-dark">Cantidad:</label>
          <input type="number" class="form-control mb-2" name="cantidad" min="1" required placeholder="Cantidad">
        </div>

        <div class="col-md-6">
          <label class="text-dark">Fecha de Registro:</label>
          <input type="date" class="form-control mb-2" name="fecha_registro" value="<?php echo date('Y-m-d'); ?>" required>

          <label class="text-dark">Observaciones:</label>
          <textarea class="form-control mb-2" name="observaciones" rows="3"></textarea>

          <label class="text-dark">Adjuntar Archivo:</label>
          <input type="file" class="form-control mb-2" name="archivo">

      <div class="d-grid mt-3">
        <button type="submit" class="btn w-100" style="background-color: #F5821F; color: white; border: none;">
          Agregar Elemento
        </button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../public/js/entrada.js"></script>

</body>
</html>
