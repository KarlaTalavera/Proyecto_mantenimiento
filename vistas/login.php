<?php
session_start();
require_once '../modelos/modeloUsuario.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    if ($usuario === '' || $contrasena === '') {
        $error = "Todos los campos son obligatorios.";
    } else {
        $modelo = new modeloUsuario();

        $datos = $modelo->obtenerUsuarioPorNombre($usuario);

        if ($datos && password_verify($contrasena, $datos['contrasena'])) {
            $_SESSION['usuario'] = $datos['usuario'];
            $_SESSION['rol'] = $datos['rol'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['apellido'] = $datos['apellido'];
            if ($datos['rol'] === 'administrador') {
                header('Location: ../index.php');
            } else {
                // Aquí puedes poner la ruta de la interfaz de usuario normal
                // Por ahora, solo muestra un mensaje
                header('Location: bienvenida_usuario.php');
            }
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilos/estilologin.css">
</head>
<body>
    <section class="container">
        <article class="formulario-contacto">
            <section class="cabeza-formulario">
                <span>Inicio</span>
            </section>
            <form method="POST" class="formulario">
                <section class="input_box">
                    <input type="text" id="usuario" name= "usuario" class="input-field" required>
                    <label for="usuario" class="label">Usuario</label>
                </section>

                <section class="input_box">
                    <input type="password" name= "contrasena" id="contrasena" class="input-field" required>
                    <label for="contrasena" class="label">Contraseña</label>
                </section>
                <?php if ($error): ?>
                        <div style="color: #ffb3b3; margin-bottom: 10px; text-align:center;"><?php echo $error; ?></div>
                <?php endif; ?>
                <button type="submit" class="submit-button">Iniciar Sesión</button>
            </form>
        </article>
    </section>
    
</body>
</html>