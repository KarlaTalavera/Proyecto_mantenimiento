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
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
    <body>
         <header class="header-transparente position-absolute w-100 top-0">
            <div class="container d-flex justify-content-between align-items-center py-3">
                <a href="#" class="logo d-flex align-items-center text-white text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="30" fill="white" class="me-2">
                        <path d="M269.4 2.9C265.2 1 260.7 0 256 0s-9.2 1-13.4 2.9L54.3 82.8c-22 9.3-38.4 31-38.3 57.2c.5 99.2 41.3 280.7 213.6 363.2c16.7 8 36.1 8 52.8 0C454.7 420.7 495.5 239.2 496 140c.1-26.2-16.3-47.9-38.3-57.2L269.4 2.9zM144 221.3c0-33.8 27.4-61.3 61.3-61.3c16.2 0 31.8 6.5 43.3 17.9l7.4 7.4 7.4-7.4c11.5-11.5 27.1-17.9 43.3-17.9c33.8 0 61.3 27.4 61.3 61.3c0 16.2-6.5 31.8-17.9 43.3l-82.7 82.7c-6.2 6.2-16.4 6.2-22.6 0l-82.7-82.7c-11.5-11.5-17.9-27.1-17.9-43.3z"/>
                    </svg>
                    <span class="fw-bold fs-5">Sistema de Control de Mantenimiento</span>
                </a>
                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a class="nav-link text-white" href="../../index.html">Inicio</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="login-center-container">
            <div class="login-card-horizontal">
                <div class="login-card-photo">
                    <img src="estilos/imagenes/ASCARDIO.png" alt="Logo Ascardio" >
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