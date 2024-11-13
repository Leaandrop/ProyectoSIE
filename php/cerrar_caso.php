<?php
include 'conexion.php';

if (isset($_POST['caso_id'])) {  // Cambia 'id' a 'caso_id'
    $caso_id = $_POST['caso_id'];
    $fecha_cierre = date('Y-m-d H:i:s'); // Fecha y hora actual

    // Asegúrate de que el nombre de la tabla sea correcto
    $sql = "UPDATE Casos SET estado = 'cerrado', fecha_cierre = :fecha_cierre WHERE id = :caso_id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':fecha_cierre', $fecha_cierre);
    $stmt->bindParam(':caso_id', $caso_id, PDO::PARAM_INT);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "fecha_cierre" => $fecha_cierre]);
    } else {
        echo json_encode(["success" => false, "error" => "No se pudo cerrar el caso."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "ID de caso no especificado."]);
}
?>