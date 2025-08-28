<?php
session_start();
session_unset();
session_destroy();

// Devolvemos respuesta JSON en lugar de redirigir
header('Content-Type: application/json');
echo json_encode(["status" => "success", "message" => "Sesión cerrada"]);
exit;
?>