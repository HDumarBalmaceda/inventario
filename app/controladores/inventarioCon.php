<?php
// Respuesta en formato JSON
header('Content-Type: application/json');

// Conexión a la base de datos
require_once "../../conexion/conexionDb.php";

// 1. Obtener el parámetro "tipo" (entrada o salida)
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;

// 2. Definir la consulta SQL según el tipo de movimiento
if ($tipo === "entrada") {
    // Consulta para la tabla inventario (entradas)
    $sql = "
        SELECT 
            'entrada' AS tipo,
            nombre_elemento,
            origen AS origen_destino,
            serial,
            modelo,
            activo,
            fecha_registro,
            observaciones
        FROM inventario
        ORDER BY fecha_registro DESC
    ";
} elseif ($tipo === "salida") {
    // Consulta para la tabla salidas (salidas)
    $sql = "
        SELECT 
            'salida' AS tipo,
            nombre_elemento,
            destino AS origen_destino,
            serial,
            modelo,
            activo,
            fecha_salida AS fecha_registro,
            observaciones
        FROM salidas
        ORDER BY fecha_salida DESC
    ";
} else {
    // Respuesta en caso de parámetro inválido
    echo json_encode([
        "status" => "error",
        "message" => "Tipo de movimiento no válido. Usa ?tipo=entrada o ?tipo=salida"
    ]);
    exit;
}

// 3. Ejecutar la consulta
$result = $conn->query($sql);

// 4. Procesar resultados
$datos = [];
if ($result && $result->num_rows > 0) {
    while ($fila = $result->fetch_assoc()) {
        $datos[] = $fila;
    }
}

// 5. Respuesta final en formato JSON
echo json_encode([
    "status" => "success",
    "data" => $datos
]);

// 6. Cerrar conexión
$conn->close();
?>