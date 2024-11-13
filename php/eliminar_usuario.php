<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Consulta SQL para eliminar el usuario
    $sql = "DELETE FROM Usuarios WHERE id = :usuario_id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirigir a la lista de usuarios con mensaje de éxito
        header("Location: ../ListaUsuarios.php?mensaje=Usuario eliminado correctamente");
    } else {
        // Redirigir a la lista de usuarios con mensaje de error
        header("Location: ../ListaUsuarios.php?mensaje=Error al eliminar el usuario");
    }
} else {
    // Redirigir a la lista de usuarios si no se especifica un ID
    header("Location: ../ListaUsuarios.php?mensaje=ID de usuario no especificado");
}
?>
