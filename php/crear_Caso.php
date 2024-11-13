<?php
include 'conexion.php';

header('Content-Type: application/json'); // Respuesta JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Depuración: Verifica si el array POST tiene los valores esperados
    if (!isset($_POST['usuario_id']) || !isset($_POST['abogado_id'])) {
        echo json_encode(["success" => false, "error" => "Faltan campos requeridos."]);
        exit;
    }

    $numero_caso = $_POST['numero_caso'];
    $descripcion = $_POST['descripcion'];
    $usuario_id = $_POST['usuario_id'];
    $abogado_id = $_POST['abogado_id'];
    $secretario_id = !empty($_POST['secretario_id']) ? $_POST['secretario_id'] : null;

    try {
        $conexion->beginTransaction();

        // Insertar el caso en la tabla Casos
        $sql = "INSERT INTO Casos (numero_caso, descripcion, estado) VALUES (:numero_caso, :descripcion, 'abierto')";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':numero_caso', $numero_caso);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();

        // Obtener el ID del caso recién creado
        $caso_id = $conexion->lastInsertId();

        // Insertar la asignación en la tabla Asignaciones
        $sql = "INSERT INTO Asignaciones (caso_id, cliente_id, abogado_id, secretario_id) VALUES (:caso_id, :usuario_id, :abogado_id, :secretario_id)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':caso_id', $caso_id);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':abogado_id', $abogado_id);
        $stmt->bindParam(':secretario_id', $secretario_id, PDO::PARAM_INT);
        $stmt->execute();

        $conexion->commit();

        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        $conexion->rollBack();
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Método de solicitud no válido."]);
}
