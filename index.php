<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: vistas/login.php');
    exit();
}
require_once 'config/conexion.php';
require_once 'controladores/controladorUsuario.php';
require_once 'controladores/contoladorDispositivo.php';

$vista = $_GET['vista'] ?? 'usuarios';

switch ($vista) {
    case 'usuarios':
        $controlador = new controladorUsuario();
        $controlador->mostrarUsuarios();
        break;
     case 'dispositivos':
        $controlador = new contoladorDispositivo();
        $controlador->mostrarDispositivos();
        break;
    default:
        echo "Vista no encontrada";
}