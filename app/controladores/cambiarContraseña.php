<?php

header('Content-Type: application/json');

// Validar que llegan ambas contraseñas
if (!isset($_POST['nueva']) || !isset($_POST['confirmar']) || empty($_POST['nueva']) || empty($_POST['confirmar'])) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

$nueva = trim($_POST['nueva']);
$confirmar = trim($_POST['confirmar']);
$correo = trim($_POST['correo']); // Este lo incluiremos como campo oculto en el formCambio

// Verificar que coincidan
if ($nueva !== $confirmar) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
    exit;
}

// Verificar la complejidad
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $nueva)) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial.']);
    exit;
}

// Conectar con la base de datos
$conexion = new mysqli("localhost", "root", "", "db1");
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión con la base de datos.']);
    exit;
}

// Encriptar la nueva contraseña
$claveHash = password_hash($nueva, PASSWORD_DEFAULT);

// Actualizar en la base de datos
$update = $conexion->prepare("UPDATE usuarios SET clave = ? WHERE correo = ?");
$update->bind_param("ss", $claveHash, $correo);

if ($update->execute()) {
    echo json_encode(['success' => true, 'message' => 'Contraseña actualizada exitosamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo actualizar la contraseña.']);
}

$update->close();
$conexion->close();

?>