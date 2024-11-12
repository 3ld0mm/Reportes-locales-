<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "reportes"; // Cambia este valor al nombre real de tu base de datos

$conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Problemas Locales de Fusagasugá</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Reporte de Problemas Locales - Fusagasugá</h1>
    </header>
    <nav class="main-menu">
        <div class="main-menu-links">
            <a href="#home">Inicio</a>
            <a href="#report">Crear Reporte</a>
            <a href="#contact">Contacto</a>
        </div>
        <!-- Enlace de inicio de sesión para administradores -->
        <a href="login_admin.php" class="login-link">Admin</a>
    </nav>


    <div class="container" id="cases">
        <h2>Casos Registrados</h2>
        <div class="cases-list">
            <?php
            // Consulta para obtener todos los reportes
            $query = "SELECT * FROM usuarios";
            $result = mysqli_query($conexion, $query);

            if (mysqli_num_rows($result) > 0) {
                // Mostrar cada reporte de la base de datos
                while ($row = mysqli_fetch_assoc($result)) {
                    $catproble = htmlspecialchars($row['catproble']);
                    $desproble = htmlspecialchars($row['desproble']);
                    $ubicacion = htmlspecialchars($row['ubicacion']);
                    $nombre = htmlspecialchars($row['nombre']);
                    $estado = htmlspecialchars($row['estado']);
                    
                    echo "<div class='case-item'>";
                    echo "<span class='case-category'>$catproble</span>";
                    echo "<p>$desproble</p>";
                    echo "<small>Ubicación: $ubicacion</small><br>";
                    echo "<small>Reportado por: $nombre</small>";
                    echo "<span class='case-status status-$estado'>" . ucfirst($estado) . "</span>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay reportes disponibles.</p>";
            }

            mysqli_close($conexion);
            ?>
        </div>
    </div>



    <div class="container" id="report">
        <h2>Crear Nuevo Reporte</h2>
        <form method="post" action="">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="telefono" placeholder="Número de teléfono" required>
            <input type="text" name="catproble" placeholder="Categoría del problema" required>
            <!-- Campo de descripción del problema como textarea -->
            <textarea name="desproble" placeholder="Descripción del problema" required rows="4"></textarea>
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <input type="submit" name="enviar_reporte" value="Enviar Reporte">
        </form>
    </div>

    <div class="container" id="contact">
        <h2>Contacto</h2>
        <form method="post" action="">
            <input type="text" name="nombre_contacto" placeholder="Nombre" required>
            <input type="text" name="correo" placeholder="Correo" required>
            <textarea name="mensaje" placeholder="Mensaje" required rows="4"></textarea>
            <input type="submit" name="enviar_contacto" value="Enviar Mensaje">
        </form>
    </div>

    <?php
        $servidor = "localhost";
        $usuario = "root";
        $clave = "";
        $bd = "reportes";

        // Conexión a la base de datos 'reportes' para el formulario de reporte
        $conexion_reportes = mysqli_connect($servidor, $usuario, $clave, $bd);

        if (!$conexion_reportes) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        if (isset($_POST['enviar_reporte'])) {
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $catproble = $_POST['catproble'];
            $desproble = $_POST['desproble'];
            $ubicacion = $_POST['ubicacion'];

            $insertar_reporte = "INSERT INTO usuarios (nombre, telefono, catproble, desproble, ubicacion) 
                                VALUES ('$nombre', '$telefono', '$catproble', '$desproble', '$ubicacion')";

            if (mysqli_query($conexion_reportes, $insertar_reporte)) {
                echo "<script>showNotification('Reporte enviado correctamente', 'success');</script>";
            } else {
                $error_msg = mysqli_error($conexion_reportes);
                echo "<script>showNotification('Error al enviar el reporte: $error_msg', 'error');</script>";
            }
        }

        mysqli_close($conexion_reportes);
    ?>

    <!-- JavaScript para mostrar la notificación -->
    <script>
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.innerText = message;
            notification.className = 'notification'; // Resetear clases
            if (type === 'error') {
                notification.classList.add('error');
            }
            notification.style.display = 'block';
            setTimeout(() => {
                notification.style.display = 'none';
            }, 5000); // Ocultar después de 5 segundos
        }
    </script>
</body>
</html>
