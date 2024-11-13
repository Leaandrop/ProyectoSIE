<?php
include 'conexion.php';

$sql = "SELECT titulo, descripcion, tipo, url FROM MaterialCapacitacion";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(["success" => true, "materiales" => $materiales]);
?>
