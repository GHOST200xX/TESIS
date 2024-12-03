<?php
include('conexion.php');

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['confirm-password'];

    if ($password !== $password_confirm) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM usuarios_nuevos WHERE nombre_usuario = ?");
        $stmt->bind_param('s', $nombre_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "El nombre de usuario ya existe.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $rol = 'usuario';
            $stmt = $conn->prepare("INSERT INTO usuarios_nuevos (nombre_usuario, password, rol, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $nombre_usuario, $password_hash, $rol, $email);

            if ($stmt->execute()) {
                $success = true;
            } else {
                $error = "Error al registrar el usuario.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" href="css/registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos para el mensaje flotante */
        .message-flotante {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            opacity: 0;
            z-index: 9999;
            display: none;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Usuarios</h2>

        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="registro.php" enctype="multipart/form-data">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm-password">Confirmar Contraseña</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <label for="telefono">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" required>

        

            <button type="submit">Registrarse</button>
        </form>
    </div>

    <?php if ($success): ?>
        <!-- Mensaje flotante de éxito -->
        <div id="mensajeExito" class="message-flotante">
            Usuario creado exitosamente, seras redirigido a iniciar sesion.
        </div>

        <script>
            // Mostrar el mensaje flotante y redirigir después de 3 segundos
            window.onload = function() {
                var mensaje = document.getElementById('mensajeExito');
                mensaje.style.display = 'block';
                setTimeout(function() {
                    mensaje.style.opacity = '1';  // Mostrar con transición
                }, 10);  // Pequeño retraso para aplicar la transición

                // Redirigir después de 3 segundos
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);  // 3000 ms = 3 segundos
            };
        </script>
    <?php endif; ?>
</body>
</html>
