<?php
include '../../conexion/conexionDb.php';
include 'enviarCodRegistro.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $clavePlano = trim($_POST["clave"]);
    $codigo = rand(100000, 999999); // Código real para enviar

    // Validación mínima
    if (empty($nombre) || empty($correo) || empty($clavePlano)) {
        echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
        exit();
    }

    // Validación de contraseña segura
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $clavePlano)) {
        echo "<script>alert('La contraseña debe tener al menos 8 caracteres, incluyendo mayúsculas, minúsculas, números y un carácter especial.'); window.history.back();</script>";
        exit();
    }

    // Hashear contraseña y código
    $claveHash = password_hash($clavePlano, PASSWORD_DEFAULT);
    $codigoHash = password_hash($codigo, PASSWORD_DEFAULT);
    $expiraEn = date('Y-m-d H:i:s', strtotime('+3 minutes'));

    // Eliminar registros expirados automáticamente antes
    $conn->query("DELETE FROM usuarios_pendientes WHERE expira_en < NOW()");

    // Eliminar registros con el mismo correo (por intento anterior fallido)
    $stmtDelete = $conn->prepare("DELETE FROM usuarios_pendientes WHERE correo = ?");
    $stmtDelete->bind_param("s", $correo);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Guardar en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuarios_pendientes (nombre, correo, clave, codigo, expira_en) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $correo, $claveHash, $codigoHash, $expiraEn);
    $stmt->execute();
    $stmt->close();

    // Enviar código original al usuario por WhatsApp
    enviarCodigoWhatsapp($nombre, $correo, $codigo);
}
?>
