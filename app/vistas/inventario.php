<?php
//verificar la sesion  
require_once "../controladores/verificarSesion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Dunkin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/prueba-2/public/css/styleInventario.css?v=2">

</head>
<body>
    
<!--Barra de navegacion-->
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #f2f4f4;">
  <div class="container-fluid">
    
    <!-- Logo + Texto -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px;" class="me-2">
      <span class="fs-4 text-dark">Inventario</span>
    </a>
    
    <!-- Botones de navegación -->
    <div class="collapse navbar-collapse justify-content-end">
      <div class="navbar-nav gap-2">
        <!-- Botón para ver inventario -->
        <a href="" class="btn btn-warning rounded-pill">📋 Ver Inventario</a>
        <!-- Botón para registrar nuevo elemento -->
        <a href="registroElemento.php" class="btn btn-info rounded-pill text-white">➕ Registrar Elemento</a>
        <!-- Botón para cerrar sesión -->
        <button id="btnLogout" class="btn btn-danger rounded-pill">
        🚪 Cerrar sesión
        </button>
        </a>
      </div>
    </div>
  </div>
</nav>

<!--contenido principal-->

<!--botones de entrada y salidas -->
<div class="container mt-4">
<div class="d-flex justify-content-end gap-2 mb-3">
  <button id="btnEntradas" class="btn btn-success btn-ls px-4">📥 Ver Entradas</button>
  <button id="btnSalidas" class="btn btn-primary btn-ls px-4">📤 Ver Salidas</button>

<!--boton de filtros-->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownFiltro" data-bs-toggle="dropdown" aria-expanded="false">
      🔎 Filtros
    </button>
    <ul class="dropdown-menu" id="menuFiltros" aria-labelledby="dropdownFiltro">
      <li><a class="dropdown-item filtro-opcion" data-sort="fecha_desc" href="#">📅 Fecha: Más reciente primero</a></li>
      <li><a class="dropdown-item filtro-opcion" data-sort="fecha_asc"  href="#">📅 Fecha: Más antiguo primero</a></li>
      <li><hr class="dropdown-divider"></li>
      <li><a class="dropdown-item filtro-opcion" data-sort="nombre_asc" href="#">🔤 Nombre A → Z</a></li>
      <li><a class="dropdown-item filtro-opcion" data-sort="nombre_desc" href="#">🔤 Nombre Z → A</a></li>
    </ul>
  </div>
</div>


      <!-- Título de la sección -->
    <h3 class="mb-3 text-dark" >📋 Lista de Inventario:</h3>

    <!-- Contenedor responsive para la tabla -->
    <div class="table-responsive">
        <!-- Tabla del inventario -->
        <table class="table table-bordered table-striped" style="background-color: #e9ecef; color: #000; border-radius: 8px; overflow: hidden;">
            <!-- Encabezado -->
            <thead style="background-color: #ced4da; color: #000;">
                <tr>
                    <th>Tipo</th>
                    <th>Nombre Elemento</th>
                    <th id = "colOrigenDestino">Origen/Destino</th>
                    <th>Serial</th>
                    <th>Modelo</th>
                    <th>Activo</th>
                    <th>Fecha Registro</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>

                <!-- Fila de inputs -->
                 <tr>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="tipo" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="nombre_elemento" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="origen_destino" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="serial" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="modelo" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="activo" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="fecha_registro" placeholder="Filtrar..."></th>
                    <th><input type="text" class="form-control form-control-sm filtro-col" data-col="observaciones" placeholder="Filtrar..."></th>
                    <th>editar</th>
                 </tr>
            </thead>
            
            <!-- Cuerpo de la tabla (llenado dinámicamente con JS) -->
            <tbody id="tablaInventario">
                <!-- Aquí se insertarán las filas desde inventario.js -->
            </tbody>
        </table>
    </div>
</div>

<!-- SweetAlert2 para alertas -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Archivo JS para manejar inventario -->
<script src="../../public/js/inventario.js"></script>
<script src="../../public/js/filtrosInventario.js"></script>
<script src="../../public/js/buscadorInventario.js"></script>
<script src="../../public/js/cerrarSesionAlerta.js"></script>
<script src="../../public/js/editarInventario.js"></script>
<!-- Bootstrap JS (incluye Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
