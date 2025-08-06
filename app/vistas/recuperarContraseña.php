<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <!-- CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- JavaScript de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-gradient" style="background: linear-gradient(#534f8a, #695be6);">



<!--formulario de email y envia el codigo-->


    <div id="formEmail" class="card p-4 shadow-lg" style="width: 350px; border-radius: 10px; background-color: #f2f4f4 ">

    <!-- Logo centrado de Dunkin' -->
    <div class="d-flex justify-content-center mb-3">
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;">
    </div>

        <h2 class="text-center text-dark mb-3">Recupere su contraseña</h2>
       <form id="formRecuperacion" action="../controladores/controladorContraseña.php"method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Ingrese su correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" >
            </div>
            <button type="submit" class="btn w-100"  style="background-color: #F5821F; color: white; border: none;" >Enviar código</button>
        </form>
    </div>

<!--formulario de para ingresar el codigo -->
    <div id="formCodigo" class="card p-4 shadow-lg" style="width: 350px; border-radius: 10px; background-color: #f2f4f4; display: none; ">
    
    <!-- Logo centrado de Dunkin' -->
    <div class="d-flex justify-content-center mb-3">
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;">
    </div>
    
    <h2 class="text-center text-dark mb-3">Ingrese el código</h2>
        <form id="formCodigoform" action="../controladores/validarCodigoRe.php" method="POST"> 
            <div class="mb-3">
                <label for="codigo" class="form-label">Código de verificación</label>
                <input type="text" name="codigo" id="codigo" class="form-control" >
            </div>
             <input type="hidden" name="correo" id="correoOculto">
            <button type="submit" class="btn w-100"  style="background-color: #F5821F; color: white; border: none;" onclick="">Verificar</button>
        </form>
    </div> 


<!--formulario para cambiar contraseña -->

    <div id="formCambio" class="card p-4 shadow-lg" style="width: 350px; border-radius: 10px; background-color: #f2f4f4; display: none;">
    
    <!-- Logo centrado de Dunkin'-->
    <div class="d-flex justify-content-center mb-3">
      <img src="../../imagenes/LOGO DUNKIN NUEVO 2024 sticker.png" alt="Inventario Dunkin" style="width: 150px; height: auto;">
    </div>
    
    <h2 class="text-center text-dark mb-3">Cambio de contraseña</h2>
        <form action="../controladores/cambiarContraseña.php" id="cambio-form" method="POST">
            <div class="mb-3">
                <label for="nueva" class="form-label">Nueva contraseña</label>
                <input type="password" name="nueva" id="nueva" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label for="confirmar" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="confirmar" id="confirmar" class="form-control" required>
            </div>
            <input type="hidden" name="correo" id="correoCambio">
            <button type="submit" class="btn w-100"  style="background-color: #F5821F; color: white; border: none;">Cambiar contraseña</button>
        </form>
    </div>


    <!--archivos js-->
    <script src="../../public/js/enviarCodigoRe.js"></script> 
    <script src="../../public/js/validarCodigoRe.js"></script> 
    <script src="../../public/js/cambiarContraseña.js"></script>

    <!-- alertas de sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</body>
</html>