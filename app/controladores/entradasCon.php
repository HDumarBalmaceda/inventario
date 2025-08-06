<?php

session_start();


// Incluir el archivo de conexión
include 'conexion/conexionDb.php';
// Incluir función de envío de correos con composer
require 'vendor/autoload.php';

// Inicializar mensaje de respuesta
$mensaje = "";

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_elemento = $_POST['nombre_elemento'] ?? null;
    $origen = $_POST['origen'] ?? null;
    $serial = $_POST['serial'] ?? null;
    $modelo = $_POST['modelo'] ?? null;
    $activo = $_POST['activo'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $fecha_registro = $_POST['fecha_registro'] ?? null;
    $observaciones = $_POST['observaciones'] ?? null;
    $enviar_correo = $_POST['enviar_correo'] ?? null;
    $correos = $_POST['correos'] ?? null; // Campo para los correos adicionales

    // Validar que no falten datos
    if ($nombre_elemento && $origen && $serial && $modelo && $activo && $cantidad && $fecha_registro && $enviar_correo) {
        $nombre_elemento = $conn->real_escape_string($nombre_elemento);
        $origen = $conn->real_escape_string($origen);
        $serial = $conn->real_escape_string($serial);
        $modelo = $conn->real_escape_string($modelo);
        $activo = $conn->real_escape_string($activo);
        $cantidad = intval($cantidad);
        $fecha_registro = $conn->real_escape_string($fecha_registro);
        $observaciones = $conn->real_escape_string($observaciones);
        $correos = $conn->real_escape_string($correos);

        // Insertar en la base de datos
        $sql = "INSERT INTO Inventario (nombre_elemento, origen, serial, modelo, activo, cantidad, fecha_registro, observaciones) 
                VALUES ('$nombre_elemento', '$origen', '$serial', '$modelo', '$activo', $cantidad, '$fecha_registro', '$observaciones')";

        if ($conn->query($sql) === TRUE) {
            $mensaje = "Elemento agregado correctamente al inventario.";

            // Enviar correo si está activada la opción
            if ($enviar_correo == "si") {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'inventariosistemas61@gmail.com'; 
                    $mail->Password = 'tynjafqwjlgqwfzh'; 
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('inventariosistemas61@gmail.com', 'Sistema Inventario Dunkin');


                    // Agregar los correos adicionales
                    $emails = explode(',', $correos);
                    foreach ($emails as $email) {
                        $mail->addAddress(trim($email)); // Agregar cada dirección
                    }

                    $mail->isHTML(true);
                    $mail->Subject = 'Confirmacion de ingreso al inventario';
                    $mail->Body = "
<html>
<head> 
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baloo+2&display=swap');

        body {
            font-family: 'Baloo 2', cursive, sans-serif;
            background-color: #fff3f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2, h3 {
            text-align: center;
            font-weight: bold;
            color: #e21b5a; /* rosa dunkin */
            margin-bottom: 10px;
        }

        h2 {
            font-size: 24px;
        }

        h3 {
            font-size: 20px;
            color: #f47c20; /* naranja dunkin */
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 12px 10px;
            border: 1px solid #fdd9ec;
            font-size: 15px;
        }

        .label {
            background-color: #f47c20;
            color: white;
            font-weight: bold;
            width: 40%;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
   <div class='container'>
  
    <h2>DONUCOL S.A. 
    <br>
    NIT: 860.508.791-1
    </h2>
        <h3>Registro de Nueva Entrada al Inventario</h3>
        <table>
            <tr>
                <td class='label'>Nombre del Elemento</td>
                <td>$nombre_elemento</td>
            </tr>
            <tr>
                <td class='label'>Origen</td>
                <td>$origen</td>
            </tr>
            <tr>
                <td class='label'>Serial</td>
                <td>$serial</td>
            </tr>
            <tr>
                <td class='label'>Modelo</td>
                <td>$modelo</td>
            </tr>
            <tr>
                <td class='label'>Activo</td>
                <td>$activo</td>
            </tr>
            <tr>
                <td class='label'>Cantidad</td>
                <td>$cantidad</td>
            </tr>
            <tr>
                <td class='label'>Fecha de Registro</td>
                <td>$fecha_registro</td>
            </tr>
            <tr>
                <td class='label'>Observaciones</td>
                <td>$observaciones</td>
            </tr>
        </table>
        <div class='footer'>
            Este es un mensaje automático del Sistema de Inventario Dunkin. Por favor, no responda a este correo.
            <br>
            <br>
            <br>
            Calle 63C No. 26A - 65 Bogotá D.C. - Colombia
            PBX: (571) 2100 200 Fax. (571) 2102493
            email: contactenos@dunkindonuts.com.co
        </div>
    </div>
</body>
</html>
";
                    // Adjuntar archivo si existe
                    if (!empty($_FILES['archivo']['name'])) {
                        $archivo_tmp = $_FILES['archivo']['tmp_name'];
                        $archivo_nombre = $_FILES['archivo']['name'];
                        $mail->addAttachment($archivo_tmp, $archivo_nombre);
                    }

                    $mail->send();
                } catch (Exception $e) {
                    $mensaje .= " Error al enviar el correo: {$mail->ErrorInfo}";
                }
            }

           header("Location: entradas.php?mensaje=" . urlencode($mensaje));
           exit;

        } else {
            $mensaje = "Error: " . $conn->error;
        }
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}

// Recuperar los datos de la base de datos
$sql = "SELECT * FROM Inventario";
$result = $conn->query($sql);

?>