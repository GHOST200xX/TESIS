<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <h1>Panel de Administración</h1>

    <div class="container">
        <p>Bienvenido, <?php echo $_SESSION['nombre_usuario']; ?></p>
        
        <ul>
            <li><a href="gestionar_usuarios.php">Gestionar Usuarios</a></li>
            <li><a href="gestionar_dispositivos.php">Gestionar Dispositivos Domóticos</a></li>
        </ul>

        <a href="logout.php" class="logout">Cerrar Sesión</a>
    </div>
</body>
</html>
