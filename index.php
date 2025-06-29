<?php
session_start();
// si no hay usuario en la sesion, manda al login
if (!isset($_SESSION['usuario'])) {
    header('Location: vistas/login.php');
    exit();
}

// incluye los controladores y la conexion
require_once 'config/conexion.php';
require_once 'controladores/controladorUsuario.php';
require_once 'controladores/controladorDispositivo.php';
require_once 'controladores/controladorMantenimiento.php';
require_once 'controladores/controladorFallo.php';

// toma la vista de la url o pone usuarios por defecto
$vista = $_GET['vista'] ?? 'usuarios';
$rol = $_SESSION['usuario']['rol'] ?? 'usuario';

// segun la vista, crea el controlador y llama la funcion correspondiente es como si index fuera otro controlador
switch ($vista) {
    case 'usuarios':
        $controlador = new controladorUsuario();
        $controlador->mostrarUsuarios();
        break;
    case 'dispositivos':
        $controlador = new controladorDispositivo();
        $controlador->mostrarDispositivos();
        break;
    case 'mantenimiento':
        $controlador = new controladorMantenimiento();
        $controlador->mostrarMantenimientos();
        break;
    case 'fallos':
        $controlador = new controladorFallo();
        if ($rol === 'administrador') {
            $controlador->mostrarFalloAdmin();
        } else {
            $controlador->mostrarFalloUsuario();
        }
        break;
    default:
        echo "Vista no encontrada";
}