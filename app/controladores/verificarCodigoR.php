<?php
session_start();

// Indicamos que el tipo de contenido será JSON
header('Content-Type: application/json');

// Incluimos la conexión a la base de datos
include '../../conexion/conexionDb.php';

// Obtenemos los datos del formulario (correo y código)
$correo = $_POST['correo'] ?? '';
$codigo = $_POST['codigo'] ?? '';

// Inicializamos la respuesta por defecto
$response = [
    'status' => 'error',
    'message' => 'Error desconocido'
];

// Validamos que los campos no estén vacíos
if (empty($correo) || empty($codigo)) {
    $response = [
        'status' => 'warning',
        'message' => 'Todos los campos son obligatorios.'
    ];
} else {
    // Consultamos si existe un registro pendiente con ese correo
    $stmt = $conn->prepare("SELECT * FROM usuarios_pendientes WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si encontramos el registro pendiente...
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificamos si el código ha expirado
        if (strtotime($usuario["expira_en"]) < time()) {
            // Eliminamos el registro pendiente si ya expiró
            $stmtDelete = $conn->prepare("DELETE FROM usuarios_pendientes WHERE correo = ?");
            $stmtDelete->bind_param("s", $correo);
            $stmtDelete->execute();
            $stmtDelete->close();

            // Enviamos respuesta de código expirado
            $response = [
                'status' => 'error',
                'message' => '⚠️ El código ha expirado. Solicita uno nuevo.'
            ];
        }
        // Verificamos si el código ingresado es correcto
        elseif (password_verify($codigo, $usuario['codigo'])) {
            // Insertamos el usuario en la tabla definitiva
            $stmtInsert = $conn->prepare("INSERT INTO usuarios (nombre, correo, clave, creado) VALUES (?, ?, ?, NOW())");
            $stmtInsert->bind_param("sss", $usuario['nombre'], $usuario['correo'], $usuario['clave']);
            $stmtInsert->execute();
            $stmtInsert->close();

            // Eliminamos el registro temporal
            $stmtDelete = $conn->prepare("DELETE FROM usuarios_pendientes WHERE correo = ?");
            $stmtDelete->bind_param("s", $correo);
            $stmtDelete->execute();
            $stmtDelete->close();

            // Enviamos respuesta exitosa y redirección al login
            $response = [
                'status' => 'success',
                'message' => 'Código verificado correctamente.',
                'redirect' => 'login.php'
            ];
        }
        // Si el código es incorrecto
        else {
            // Eliminamos el registro por seguridad
            $stmtDelete = $conn->prepare("DELETE FROM usuarios_pendientes WHERE correo = ?");
            $stmtDelete->bind_param("s", $correo);
            $stmtDelete->execute();
            $stmtDelete->close();

            // Enviamos mensaje de error y redirección a registro
            $response = [
                'status' => 'error',
                'message' => 'El código es incorrecto. Debes registrarte de nuevo.',
                'redirect' => 'registro.php'
            ];
        }
    }
    // Si no se encuentra ningún registro pendiente con ese correo
    else {
        $response = [
            'status' => 'error',
            'message' => 'No se encontró un código pendiente para este correo.',
            'redirect' => 'registro.php'
        ];
    }

    // Cerramos el statement de la consulta principal
    $stmt->close();
}

// Cerramos la conexión a la base de datos
$conn->close();

// Devolvemos la respuesta como JSON al frontend
echo json_encode($response);
?>