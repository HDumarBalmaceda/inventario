<?php

// Indicamos que la respuesta será en formato JSON
header('Content-Type: application/json');

// Conexión a la base de datos
require_once "../../conexion/conexionDb.php";

// =========================
// 1. Capturar parámetros
// =========================
$tipo  = $_GET['tipo']  ?? ''; // entrada o salida
$campo = $_GET['campo'] ?? ''; // columna a filtrar
$valor = $_GET['valor'] ?? ''; // texto de búsqueda

// Validación de parámetros
if (empty($tipo) || empty($campo) || empty($valor)) {
    echo json_encode(["status" => "error", "message" => "Faltan parámetros"]);
    exit;
}

// =========================
// 2. Validar columna recibida
// =========================
$columnasValidas = [
    "tipo",              // <- columna "virtual"
    "nombre_elemento",
    "origen_destino",
    "serial",
    "modelo",
    "activo",
    "fecha_registro",    // <- siempre usaremos este nombre en la respuesta
    "observaciones"
];

if (!in_array($campo, $columnasValidas)) {
    echo json_encode(["status" => "error", "message" => "Campo no válido"]);
    exit;
}

// =========================
// 3. Determinar tabla según el tipo
// =========================
if ($tipo === "entrada") {
    $tabla = "inventario";
    $columnaSQL = ($campo === "origen_destino") ? "origen" : $campo;
    $columnaFecha = "fecha_registro"; // columna real en inventario
} elseif ($tipo === "salida") {
    $tabla = "salidas"; // 👈 plural
    $columnaSQL = ($campo === "origen_destino") ? "destino" : $campo;
    $columnaFecha = "fecha_salida"; // 👈 columna real en salidas
} else {
    echo json_encode(["status" => "error", "message" => "Tipo no válido"]);
    exit;
}

// Si el campo es "fecha_registro", en salidas se debe usar "fecha_salida"
if ($campo === "fecha_registro") {
    $columnaSQL = $columnaFecha;
}

// =========================
// 4. Caso especial: filtrar por "tipo"
// =========================
if ($campo === "tipo") {
    if (stripos($tipo, $valor) === false) {
        echo json_encode(["status" => "success", "data" => []]);
        exit;
    }

    $sql = "SELECT 
                '$tipo' AS tipo,
                nombre_elemento,
                " . ($tipo === "entrada" ? "origen" : "destino") . " AS origen_destino,
                serial, modelo, activo,
                $columnaFecha AS fecha_registro,
                observaciones
            FROM $tabla";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

} else {
    // =========================
    // 5. Construir consulta normal con filtro
    // =========================
    $sql = "SELECT 
                '$tipo' AS tipo,
                nombre_elemento,
                " . ($tipo === "entrada" ? "origen" : "destino") . " AS origen_destino,
                serial, modelo, activo,
                $columnaFecha AS fecha_registro,
                observaciones
            FROM $tabla
            WHERE $columnaSQL LIKE ?";

    $stmt = $conn->prepare($sql);
    $busqueda = "%$valor%";
    $stmt->bind_param("s", $busqueda);
    $stmt->execute();
}

// =========================
// 6. Obtener resultados
// =========================
$result = $stmt->get_result();
$datos = [];
while ($row = $result->fetch_assoc()) {
    $datos[] = $row;
}

// =========================
// 7. Devolver respuesta JSON
// =========================
echo json_encode(["status" => "success", "data" => $datos], JSON_UNESCAPED_UNICODE);
