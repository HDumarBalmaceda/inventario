<?php
header('Content-Type: application/json');
require_once "../../conexion/conexionDb.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Captura de datos
    $tipo            = $_POST['tipo'] ?? '';
    $nombre_elemento = $_POST['nombre_elemento'] ?? '';
    $origen          = $_POST['origen'] ?? '';
    $serial          = $_POST['serial'] ?? '';
    $modelo          = $_POST['modelo'] ?? '';
    $activo          = $_POST['activo'] ?? '';
    $fecha_registro  = $_POST['fecha_registro'] ?? '';
    $observaciones   = $_POST['observaciones'] ?? '';

    // 2. Validación
    if (empty($tipo) || empty($nombre_elemento) || empty($serial) || empty($modelo) || empty($activo) || empty($fecha_registro)) {
        echo json_encode([
            "status" => "error",
            "message" => "Todos los campos obligatorios deben llenarse"
        ]);
        exit;
    }

    // 3. Manejo de archivo
    $nombreArchivo = null;
    if (!empty($_FILES['archivo']['name'])) {
        $carpetaDestino = "../../imagenes/archivos";

        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        $nombreArchivo = time() . "_" . basename($_FILES['archivo']['name']);
        $rutaArchivo   = $carpetaDestino . "/" . $nombreArchivo; // <-- agregado el "/"

        if (!move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaArchivo)) {
            echo json_encode([
                "status" => "error",
                "message" => "Error al subir el archivo"
            ]);
            exit;
        }
    }

    // 4. Inserción según tipo
    if ($tipo === "entrada") {
        $sql = "INSERT INTO inventario 
                (nombre_elemento, origen, serial, modelo, activo, fecha_registro, observaciones, archivos)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nombre_elemento, $origen, $serial, $modelo, $activo, $fecha_registro, $observaciones, $nombreArchivo);

    } elseif ($tipo === "salida") {
        $destino = $origen;
        $sql = "INSERT INTO salidas 
                (nombre_elemento, destino, serial, modelo, activo, fecha_salida, observaciones, archivos)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $nombre_elemento, $destino, $serial, $modelo, $activo, $fecha_registro, $observaciones, $nombreArchivo);

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Tipo de registro inválido"
        ]);
        exit;
    }

    // 5. Ejecutar
    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Registro guardado correctamente",
            "redirect" => $_SERVER['HTTP_REFERER']
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error al guardar: " . $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();

} else {
    echo json_encode([
        "status" => "error",
        "message" => "Solicitud inválida"
    ]);
}
?>