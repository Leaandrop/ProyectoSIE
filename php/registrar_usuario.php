<?php
include 'conexion.php';

header('Content-Type: application/json'); // Define el tipo de respuesta como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $NUIP = $_POST['NUIP'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $contrasena = md5($_POST['contrasena']); // Encriptar la contraseña
    $rol = $_POST['rol'];
    $numero_licencia = $_POST['numero_licencia'];
    $especialidad = $_POST['especialidad'];

    try {
        $sql = "INSERT INTO Usuarios (nombre, apellido, NUIP, telefono, direccion, email, contrasena, rol, numero_licencia, especialidad, estado)
                VALUES (:nombre, :apellido, :NUIP, :telefono, :direccion, :email, :contrasena, :rol, :numero_licencia, :especialidad, 'activo')";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':NUIP', $NUIP);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':numero_licencia', $numero_licencia);
        $stmt->bindParam(':especialidad', $especialidad);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "No se pudo registrar el usuario."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Método de solicitud no permitido."]);
}