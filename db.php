<?php
// Configuración de conexión a la base de datos de autenticación de administradores
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "rol"; // Nombre de la base de datos para autenticación de administradores

$conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
