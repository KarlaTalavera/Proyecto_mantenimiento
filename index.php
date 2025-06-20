<?php

require_once 'config/conexion.php';
$controlador = isset($_GET['controlador']) ? $_GET['controlador'] : 'usuario';

require_once 'controladores/controladorUsuario.php';

$controlador = new controladorUsuario();
$controlador->mostrarUsuarios();
