<?php
session_start();
header('Content-Type: application/json');

// Cargar clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

$response = ['success' => false, 'message' => ''];

// Verifica que se haya recibido el correo
if (empty($_POST['email'])) {
    $response['message'] = 'No se recibió el correo electrónico.';
    echo json_encode($response);
    exit;
}

$email = trim($_POST['email']);
$codigo = rand(100000, 999999);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "db1");

if ($conexion->connect_error) {
    $response['message'] = 'Error al conectar con la base de datos.';
    echo json_encode($response);
    exit;
}

//include '../../conexion/conexionDb.php';

// Validar que el correo existe en la tabla usuarios
$verificacion = $conexion->prepare("SELECT id FROM usuarios WHERE correo = ?");
$verificacion->bind_param("s", $email);
$verificacion->execute();
$verificacion->store_result();

if ($verificacion->num_rows === 0) {
    $response['message'] = 'El correo no está registrado en el sistema.';
    echo json_encode($response);
    $verificacion->close();
    $conexion->close();
    exit;
}
$verificacion->close();

// Guardamos valores en sesión
$_SESSION['email_usuario'] = $email;
$_SESSION['codigo_verificacion'] = $codigo;

// Insertar el código en la tabla
$sql = "INSERT INTO codigos_verificacion (correo, codigo, fecha_envio, estado) VALUES (?, ?, NOW(), 1)";
$stmt = $conexion->prepare($sql);
if (!$stmt) {
    $response['message'] = 'Error al preparar la consulta SQL.';
    echo json_encode($response);
    $conexion->close();
    exit;
}

$stmt->bind_param("ss", $email, $codigo);
if (!$stmt->execute()) {
    $response['message'] = 'No se pudo guardar el código en la base de datos.';
    echo json_encode($response);
    $stmt->close();
    $conexion->close();
    exit;
}
$stmt->close();
$conexion->close();

// Enviar el correo
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'inventariosistemas61@gmail.com';
    $mail->Password = 'tynjafqwjlgqwfzh'; // Contraseña de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('inventariosistemas61@gmail.com', 'Sistema Inventario Dunkin');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = '=?UTF-8?B?' . base64_encode('Tu código de verificación') . '?=';
    $mail->Body = "Hola, tu código de verificación es: <b>$codigo</b>";
    

    $mail->send();
    $response['success'] = true;
    $response['message'] = 'Código enviado correctamente al correo.';
    echo json_encode($response);
} catch (Exception $e) {
    $response['message'] = 'Error al enviar el correo: ' . $mail->ErrorInfo;
    echo json_encode($response);
}
?>