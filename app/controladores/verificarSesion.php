<?php
session_start();

// Evitar cache de páginas privadas
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0");

if (!isset($_SESSION['usuario'])) {
    // Si es una petición AJAX, devolvemos JSON
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        http_response_code(401); // No autorizado
        echo json_encode(["error" => "Sesión expirada"]);
        exit;
    }

    // Si es carga normal de página, redirigir
    header("Location: ../../index.php");
    exit();
}
?>