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