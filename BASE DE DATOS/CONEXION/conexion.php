<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'domotica_tesis';
$user = 'root'; 
$password = ''; 

// Crear la conexión
$conn = new mysqli($host, $user, $password, $db);

// Comprobar si la conexión es exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
