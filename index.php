<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: vistas/login.php');
    exit();
}
require_once 'config/conexion.php';
require_once 'controladores/controladorUsuario.php';
$controlador = new controladorUsuario();
$controlador->mostrarUsuarios();