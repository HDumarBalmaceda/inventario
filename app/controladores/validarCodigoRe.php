<?php
header('Content-Type: application/json');

// Validar que llegan los datos necesarios
if (!isset($_POST['codigo']) || !isset($_POST['correo']) || empty($_POST['codigo']) || empty($_POST['correo'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos.']);
    exit;
}

$codigoIngresado = trim($_POST['codigo']);
$correo = trim($_POST['correo']);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "db1");
if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión.']);
    exit;
}

// Consulta para validar el código
$sql = "SELECT * FROM codigos_verificacion 
        WHERE correo = ? AND codigo = ? AND estado = 1 
        ORDER BY fecha_envio DESC LIMIT 1";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $correo, $codigoIngresado);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    // Desactivar código y notificar éxito
    $update = $conexion->prepare("DELETE FROM codigos_verificacion WHERE correo = ? AND codigo = ?");
    $update->bind_param("ss", $correo, $codigoIngresado);
    $update->execute();

    echo json_encode(['success' => true, 'message' => 'Código correcto']);
} else {
    echo json_encode(['success' => false, 'message' => 'Código incorrecto o vencido']);
}

$stmt->close();
$conexion->close();
?>