<?php
// depurar (opcional)
file_put_contents("debug_editar.txt", print_r($_POST, true));

header('Content-Type: application/json; charset=utf-8');
require_once "../../conexion/conexionDb.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tabla            = $_POST["tabla"] ?? null;
    $id_inventario    = $_POST["id_inventario"] ?? null;
    $id_salida        = $_POST["id_salida"] ?? null;
    $nombre_elemento  = $_POST["nombre_elemento"] ?? null;
    $serial           = $_POST["serial"] ?? null;
    $modelo           = $_POST["modelo"] ?? null;
    $activo           = $_POST["activo"] ?? null;
    $observaciones    = $_POST["observaciones"] ?? null;
    $archivos         = $_POST["archivos"] ?? null;

    // valores adicionales según tabla
    $origen_destino   = $_POST["origen"] ?? $_POST["origen_destino"] ?? null;
    $cantidad         = $_POST["cantidad"] ?? 1;
    $fecha_registro   = $_POST["fecha_registro"] ?? date("Y-m-d");

    if (!$tabla) {
        echo json_encode(["success" => false, "error" => "Faltan datos obligatorios"]);
        exit;
    }

    // --- ACTUALIZAR SEGÚN TABLA ---
    if ($tabla === "inventario") {
        if (!$id_inventario) {
            echo json_encode(["success" => false, "error" => "ID de inventario faltante"]);
            exit;
        }

        $sql = "UPDATE inventario SET 
                    nombre_elemento = ?, 
                    origen = ?, 
                    serial = ?, 
                    modelo = ?, 
                    activo = ?, 
                    cantidad = ?, 
                    fecha_registro = ?, 
                    observaciones = ?, 
                    archivos = ?
                WHERE id_inventario = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(["success" => false, "error" => "Error en la preparación: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("ssssissssi", 
            $nombre_elemento, 
            $origen_destino, 
            $serial, 
            $modelo, 
            $activo, 
            $cantidad, 
            $fecha_registro, 
            $observaciones, 
            $archivos, 
            $id_inventario
        );

    } elseif ($tabla === "salidas") {
        if (!$id_salida) {
            echo json_encode(["success" => false, "error" => "ID de salida faltante"]);
            exit;
        }

        $sql = "UPDATE salidas SET 
                    nombre_elemento = ?, 
                    destino = ?, 
                    serial = ?, 
                    modelo = ?, 
                    activo = ?, 
                    cantidad = ?, 
                    fecha_salida = ?, 
                    observaciones = ?, 
                    archivos = ? 
                WHERE id_salida = ?";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(["success" => false, "error" => "Error en la preparación: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("ssssissssi", 
            $nombre_elemento, 
            $destino, 
            $serial, 
            $modelo, 
            $activo, 
            $cantidad, 
            $fecha_registro,   // aquí lo usamos como fecha_salida
            $observaciones, 
            $archivos, 
            $id_salida
        );
    } else {
        echo json_encode(["success" => false, "error" => "Tabla desconocida"]);
        exit;
    }

    // Ejecutar
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registro actualizado correctamente"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error al actualizar: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
