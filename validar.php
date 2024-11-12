<?php
session_start();
include('db.php'); // Conexión a la base de datos

if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);

    // Consulta para verificar el administrador y su cargo
    $consulta = "SELECT admins.nombre, admins.id, cargo.descripcion 
                 FROM admins 
                 JOIN cargo ON admins.id = cargo.id
                 WHERE admins.nombre='$usuario' AND admins.pswd='$password'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) == 1) {
        $admin_data = mysqli_fetch_assoc($resultado);
        $_SESSION['admin'] = $admin_data['nombre']; // Guarda el nombre del admin en la sesión
        $_SESSION['cargo'] = $admin_data['descripcion']; // Guarda el cargo en la sesión
        header("Location: admin.php");
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='login_admin.php';</script>";
    }
} else {
    header("Location: login_admin.php");
    exit();
}
?>