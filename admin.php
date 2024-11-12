<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$clave = "";
$bd = "reportes";

$conexion = mysqli_connect($servidor, $usuario, $clave, $bd);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificar si se ha enviado una actualización de estado
if (isset($_POST['actualizar_estado'])) {
    $reporte_id = $_POST['reporte_id'];
    $nuevo_estado = $_POST['nuevo_estado'];

    $query_update = "UPDATE usuarios SET estado='$nuevo_estado' WHERE id='$reporte_id'";
    mysqli_query($conexion, $query_update);
    header("Location: admin.php"); // Recarga la página para evitar reenvío de formulario
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
    <div class="admin-container">
        <h1>Panel de Administración</h1>
        <div class="admin-info">
            <p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong></p>
            <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
        </div>

        <h2>Administrar Reportes</h2>
        <table>
            <tr>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Ubicación</th>
                <th>Estado</th>
                <th>Actualizar Estado</th>
            </tr>
            <?php
            // Obtener todos los reportes
            $query = "SELECT * FROM usuarios";
            $result = mysqli_query($conexion, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $catproble = htmlspecialchars($row['catproble']);
                $desproble = htmlspecialchars($row['desproble']);
                $ubicacion = htmlspecialchars($row['ubicacion']);
                $estado = htmlspecialchars($row['estado']);

                echo "<tr>";
                echo "<td>$catproble</td>";
                echo "<td>$desproble</td>";
                echo "<td>$ubicacion</td>";
                echo "<td>$estado</td>";
                echo "<td>
                        <form method='post' action=''>
                            <input type='hidden' name='reporte_id' value='$id'>
                            <select name='nuevo_estado'>
                                <option value='Pendiente' " . ($estado == 'Pendiente' ? 'selected' : '') . ">Pendiente</option>
                                <option value='En proceso' " . ($estado == 'En proceso' ? 'selected' : '') . ">En Proceso</option>
                                <option value='Resuelto' " . ($estado == 'Resuelto' ? 'selected' : '') . ">Resuelto</option>
                            </select>
                            <input type='submit' name='actualizar_estado' value='Actualizar'>
                        </form>
                        <span class='estado-" . strtolower(str_replace(' ', '-', $estado)) . "'></span>
                    </td>";
                echo "</tr>";
            }

            if (isset($_POST['eliminar_reporte'])) {
                $reporte_id = $_POST['eliminar_reporte_id'];
                $query_delete = "DELETE FROM usuarios WHERE id='$reporte_id'";
                mysqli_query($conexion_reportes, $query_delete);
                header("Location: admin.php"); // Recarga la página para actualizar la lista de reportes
                exit();
            }

            mysqli_close($conexion);
            ?>
        </table>
    </div>
</body>
</html>
