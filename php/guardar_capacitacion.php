<?php
include 'conexion.php';

$titulo = $_POST['titulo'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$url = '';

if ($tipo === 'archivo' && isset($_FILES['archivo'])) {
    $targetDir = "../uploads/"; // Ajusta la ruta
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = basename($_FILES['archivo']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $targetFilePath)) {
        $url = $targetFilePath;
    } else {
        echo json_encode(["success" => false, "error" => "Error al subir el archivo."]);
        exit();
    }
} elseif ($tipo === 'enlace') {
    $url = $_POST['url'] ?? '';
}

$sql = "INSERT INTO MaterialCapacitacion (titulo, descripcion, tipo, url) VALUES (:titulo, :descripcion, :tipo, :url)";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':descripcion', $descripcion);
$stmt->bindParam(':tipo', $tipo);
$stmt->bindParam(':url', $url);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "Error al guardar en la base de datos."]);
}
