<?php
session_start();
if (!isset($_SESSION['nombre_usuario']) || $_SESSION['rol'] !== 'usuario') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <link rel="stylesheet" href="css/usuario.css">
</head>
<body>
    <h1>Bienvenido a la Plataforma Domótica</h1>

    <div class="container">
        <p>Usuario: <?php echo $_SESSION['nombre_usuario']; ?></p>
        <p>Aquí puedes controlar tus dispositivos domóticos (funcionalidad próxima).</p>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>
