<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'error_log.log');

// Configuración de la base de datos
$host = 'localhost:3308';
$dbname = 'valbuenaabogados';
$user = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error de conexión: " . $e->getMessage());
}

// Función para validar la contraseña encriptada con md5
function validar_contrasena($password_ingresada, $password_almacenada) {
    $password_encriptada = md5($password_ingresada);
    return trim($password_encriptada) === trim($password_almacenada);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = :email AND estado = 'activo'";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if (validar_contrasena($password, $usuario['contrasena'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['rol'] = $usuario['rol'];

            switch ($usuario['rol']) {
                case 'SuperAdmin':
                    echo "superadmin";
                    break;
                case 'Admin':
                    echo "admin";
                    break;
                case 'Abogado':
                    echo "abogado";
                    break;
                case 'Secretario':
                    echo "secretario";
                    break;
                case 'Usuario':
                    echo "usuario";
                    break;
                default:
                    echo "error";
            }
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
} else {
    echo "error";
}