<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: vistas/login.php');
    exit();
}
require_once 'config/conexion.php';
require_once 'controladores/controladorUsuario.php';

$vista = $_GET['vista'] ?? 'usuarios';

switch ($vista) {
    case 'usuarios':
        $controlador = new controladorUsuario();
        $controlador->mostrarUsuarios();
        break;
    // Aquí puedes agregar más casos para otras vistas
    default:
        echo "Vista no encontrada";
}