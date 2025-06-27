<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: vistas/login.php');
    exit();
}
require_once 'config/conexion.php';
require_once 'controladores/controladorUsuario.php';
require_once 'controladores/controladorDispositivo.php';
require_once 'controladores/controladorMantenimiento.php';

$vista = $_GET['vista'] ?? 'usuarios';

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
    default:
        echo "Vista no encontrada";
}