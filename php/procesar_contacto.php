<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$host = 'localhost:3308';
$dbname = 'valbuenaabogados';
$user = 'root';
$password = '';

try {
    // Conexión a la base de datos usando PDO
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa<br>";
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si se recibió una solicitud POST
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? null;
    $email = $_POST['email'] ?? null;
    $mensaje = $_POST['mensaje'] ?? null;

    // Verificar que todos los campos estén completos
    if ($nombre && $email && $mensaje) {
        // Insertar los datos en la tabla Contactos
        $sql = "INSERT INTO Contactos (nombre, correo, mensaje) VALUES (:nombre, :email, :mensaje)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':mensaje', $mensaje);

        if ($stmt->execute()) {
            echo "¡Gracias! Tu mensaje ha sido enviado correctamente.";
        } else {
            echo "Hubo un error al enviar tu mensaje. Intenta nuevamente.";
        }
    } else {
        echo "Por favor completa todos los campos del formulario.";
    }
} else {
    echo "No se recibieron datos POST.";
}
?>
