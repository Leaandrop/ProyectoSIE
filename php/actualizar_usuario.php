<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $NUIP = $_POST['NUIP'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $numero_licencia = $_POST['numero_licencia'];
    $especialidad = $_POST['especialidad'];

    // Si el campo de contraseña está vacío, no la actualiza
    $contrasena = !empty($_POST['contrasena']) ? md5($_POST['contrasena']) : null;

    try {
        $sql = "UPDATE Usuarios SET 
                    nombre = :nombre,
                    apellido = :apellido,
                    NUIP = :NUIP,
                    telefono = :telefono,
                    direccion = :direccion,
                    email = :email,
                    rol = :rol,
                    numero_licencia = :numero_licencia,
                    especialidad = :especialidad";

        // Agregar el campo de contraseña solo si fue proporcionado
        if ($contrasena) {
            $sql .= ", contrasena = :contrasena";
        }

        $sql .= " WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':NUIP', $NUIP);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':numero_licencia', $numero_licencia);
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);

        if ($contrasena) {
            $stmt->bindParam(':contrasena', $contrasena);
        }

        $stmt->execute();

        // Redireccionar a ListaUsuarios.php con un mensaje de éxito
        header("Location: ../ListaUsuarios.php?mensaje=actualizado");
        exit();
    } catch (PDOException $e) {
        echo "Error al actualizar el usuario: " . $e->getMessage();
    }
} else {
    echo "Solicitud no válida.";
}
?>
