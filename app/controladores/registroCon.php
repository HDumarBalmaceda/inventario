<?php
// Mostrar errores en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); // Devolverá JSON

include '../../conexion/conexionDb.php';
include 'enviarCodRegistro.php';

$response = []; // Respuesta que se enviará al JS

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $clave = trim($_POST["clave"]);
    $confirmarClave = trim($_POST["confirmarClave"]);

    // Validaciones
    if (empty($nombre) || empty($correo) || empty($clave) || empty($confirmarClave)) {
        $response = ['status' => 'warning', 'message' => 'Todos los campos son obligatorios.'];
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $response = ['status' => 'warning', 'message' => 'El correo no es válido.'];
    } elseif ($clave !== $confirmarClave) {
        $response = ['status' => 'error', 'message' => 'Las contraseñas no coinciden.'];
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $clave)) {
        $response = ['status' => 'warning', 'message' => 'La contraseña debe tener al menos 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo.'];
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $response = ['status' => 'error', 'message' => 'El correo ya está registrado. Usa otro.'];
        } else {
            $conn->query("DELETE FROM usuarios_pendientes WHERE expira_en < NOW()");

            $claveHash = password_hash($clave, PASSWORD_DEFAULT);
            $codigo = rand(100000, 999999);
            $codigoHash = password_hash($codigo, PASSWORD_DEFAULT);
            $expiraEn = date('Y-m-d H:i:s', strtotime('+3 minutes'));

            $stmtInsert = $conn->prepare("INSERT INTO usuarios_pendientes (nombre, correo, clave, codigo, expira_en) VALUES (?, ?, ?, ?, ?)");
            $stmtInsert->bind_param("sssss", $nombre, $correo, $claveHash, $codigoHash, $expiraEn);
            $stmtInsert->execute();
            $stmtInsert->close();

            enviarCodigoWhatsapp($nombre, $correo, $codigo);

            $response = [
                'status' => 'success',
                'message' => '✅ Código enviado por WhatsApp.',
                'correo' => $correo
            ];
        }

        $stmt->close();
        $conn->close();
    }

    echo json_encode($response);
}
?>
