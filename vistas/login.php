<?php
session_start();
require_once '../modelos/modeloUsuario.php';

// inicializa la variable de error
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // toma los valores del formulario y quita espacios
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    // revisa si los campos estan vacios
    if ($usuario === '' || $contrasena === '') {
        $error = "Todos los campos son obligatorios.";
    } else {
        // crea el modelo y busca el usuario por nombre
        $modelo = new modeloUsuario();
        $datos = $modelo->obtenerUsuarioPorNombre($usuario);

        // si encuentra el usuario y la contraseña es correcta, inicia la sesion
        if ($datos && password_verify($contrasena, $datos['contrasena'])) {
            $_SESSION['usuario'] = [
                'id' => $datos['id'],
                'usuario' => $datos['usuario'],
                'rol' => $datos['rol'],
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido']
            ];
            // redirige segun el rol
            if ($datos['rol'] === 'administrador') {
                header('Location: ../index.php');
            } else if ($datos['rol'] === 'usuario') {
                header('Location: ../index.php');
            } else {
                $error = "Rol de usuario no reconocido.";
            }
            exit();
        } else {
            // si no coincide usuario o contraseña, muestra error
            $error = "Usuario o contraseña incorrectos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilos/estilologin.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
</head>
    <body>
        <div class="login-center-container">
            <div class="login-card-horizontal">
                <div class="login-card-photo">
                    <img src="estilos/imagenes/ASCARDIO.png" alt="Logo Ascardio" alt="Logo Ascardio">
                </div>
                <div class="login-card-form">
                    <form method="POST" class="login-formbox" autocomplete="off">
                        <div class="login-title">Inicio de Sesión</div>
                        <?php if ($error): ?>
                            <div class="login-error"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>
                        <div class="login-inputbox">
                            <input type="text" id="usuario" name="usuario" class="login-input" required autocomplete="username" placeholder=" " />
                            <label for="usuario" class="login-label">Usuario</label>
                            <i class="lni lni-user"></i>
                        </div>
                        <div class="login-inputbox">
                            <input type="password" name="contrasena" id="contrasena" class="login-input" required autocomplete="current-password" placeholder=" " />
                            <label for="contrasena" class="login-label">Contraseña</label>
                            <i class="lni lni-lock"></i>
                        </div>
                        <button type="submit" class="login-btn">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>