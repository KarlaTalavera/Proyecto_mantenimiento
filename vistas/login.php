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