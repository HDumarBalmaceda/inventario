<?php
// Activa errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
header('Content-Type: application/json'); // Establece respuesta como JSON

// conexion a la base de datos 
include '../../conexion/conexionDb.php';

// Verifica conexión
if (!$conn) {
    echo json_encode([
        'success' => false,
        'type' => 'db',
        'message' => 'Error en la conexión a la base de datos.'
    ]);
    exit();
}

// Verifica método POST en el formulario 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contraseñaIngresada = $_POST['clave'] ?? '';

    // verifica que todos los campos este completos 
    if (empty($correo) || empty($contraseñaIngresada)) {
        echo json_encode([
            'success' => false,
            'type' => 'vacio',
            'message' => 'Todos los campos son obligatorios.'
        ]);
        exit();
    }
    // consulta en la base de datos que el correo ingresado exista 
    $stmt = $conn->prepare('SELECT id, clave FROM usuarios WHERE correo = ?');
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $stmt->close();
        $conn->close();
        echo json_encode([
            'success' => false,
            'type' => 'correo',
            'message' => 'El correo no está registrado.'
        ]);
        exit();
    }

    $stmt->bind_result($id, $hashAlmacenado);
    $stmt->fetch();

    // verifica la contraseña y si es correcta deja seguir a la siguiente ventana si no da el mensaje de error 
    if (password_verify($contraseñaIngresada, $hashAlmacenado)) {
        $_SESSION['usuario'] = $correo;

        echo json_encode([
            'success' => true,
            'redirect' => '../vistas/entradas.php',
            'message' => 'Inicio de sesión exitoso.'
        ]);
        exit();
    } else {
        echo json_encode([
            'success' => false,
            'type' => 'error',
            'message' => 'Contraseña incorrecta.'
        ]);
        exit();
    }

    // cierra la conexion a la base y las consultas sql 
    $stmt->close();
    $conn->close();
}
?>