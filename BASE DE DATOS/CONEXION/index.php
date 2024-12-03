<?php
session_start();
include('conexion.php'); // Incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $password = $_POST['password'];

    // Verificar las credenciales del usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios_nuevos WHERE nombre_usuario = ?");
    $stmt->bind_param('s', $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
            $_SESSION['rol'] = $user['rol'];

            // Redirigir según el rol del usuario
            if ($user['rol'] === 'administrador') {
                header('Location: admin.php');
            } else {
                header('Location: usuario.php');
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuario</title>
    <link rel="stylesheet" href="css/index.css"> <!-- Vincular el archivo CSS -->
    <!-- Importar la fuente Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Círculos animados en el fondo -->
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="login-container">
        <h2>BIENVENIDO</h2>

        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <label for="nombre_usuario">Nombre de Usuario:</label>
            <input type="text" name="nombre_usuario" id="nombre_usuario" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required><br>

            <button type="submit">Iniciar Sesión</button>
        </form>

        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí...!!</a></p>
    </div>
</body>
</html>
