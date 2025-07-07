<?php

require_once dirname(__DIR__) . '/modelos/modeloMantenimiento.php';
require_once dirname(__DIR__) . '/modelos/modeloDispositivo.php';
require_once dirname(__DIR__) . '/modelos/modeloUsuario.php';
require_once dirname(__DIR__) . '/vistas/enviar.php';

class controladorMantenimiento {
    private $modelo;

    public function __construct() {
        $this->modelo = new modeloMantenimiento();
    }

    public function mostrarMantenimientos() {
        // inicializa variables para errores y edicion
        $error = '';
        $editando = false;
        $mantenimientoEditar = null;

        // obtiene la lista de dispositivos para los selects
        $dispositivoModel = new modeloDispositivo();
        $dispositivos = $dispositivoModel->listarDispositivos();

        // obtiene la lista de usuarios para los selects
        $usuarioModel = new modeloUsuario();
        $usuarios = $usuarioModel->obtenerUsuarios();

        // si se recibe el parametro eliminar, borra el mantenimiento y redirige
        if (isset($_GET['eliminar'])) {
            $this->modelo->eliminarMantenimiento($_GET['eliminar']);
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // si se recibe el parametro editar, obtiene los datos del mantenimiento para editar
        if (isset($_GET['editar'])) {
            $mantenimientoEditar = $this->modelo->obtenerMantenimientoPorId($_GET['editar']);
            $editando = true;
        }

        // si se envia el formulario de actualizacion, procesa la edicion del mantenimiento
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
            $this->modelo->setId($_POST['id']);
            $this->modelo->setCodigoDispositivo($_POST['codigo_dispositivo']);
            $this->modelo->setFechaUltimoMantenimiento($_POST['fecha_ultimo_mantenimiento']);
            $this->modelo->setFechaProximoMantenimiento($_POST['fecha_proximo_mantenimiento']);
            $this->modelo->setDescripcionProximoMantenimiento($_POST['descripcion_proximo_mantenimiento']);
            $this->modelo->setPersonaAsignada($_POST['persona_asignada'] ?: null);

            $this->modelo->actualizarMantenimiento();
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // si se envia el formulario para tomar mantenimiento pendiente, asigna la persona
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tomar_mantenimiento'])) {
            $id = $_POST['tomar_mantenimiento'];
            $usuario_id = $_SESSION['usuario']['id'];
            $this->modelo->asignarPersona($id, $usuario_id);
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // si se envia el formulario de registro, agrega un nuevo mantenimiento sin asignar persona
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
            $this->modelo->setCodigoDispositivo($_POST['codigo_dispositivo']);
            $this->modelo->setFechaUltimoMantenimiento($_POST['fecha_ultimo_mantenimiento']);
            $this->modelo->setFechaProximoMantenimiento($_POST['fecha_proximo_mantenimiento']);
            $this->modelo->setDescripcionProximoMantenimiento($_POST['descripcion_proximo_mantenimiento']);
            $this->modelo->setPersonaAsignada(null);

            $this->modelo->agregarMantenimiento();
            // envia correo de notificacion de mantenimiento
            /*
            enviarCorreoMantenimiento(
                $_POST['codigo_dispositivo'],
                $_POST['fecha_ultimo_mantenimiento'],
                $_POST['fecha_proximo_mantenimiento'],
                $_POST['descripcion_proximo_mantenimiento']
            );*/

            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // si se envia el formulario para realizar mantenimiento, marca como realizado si corresponde
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['realizar_mantenimiento'])) {
            $id = $_POST['realizar_mantenimiento'];
            $mantenimiento = $this->modelo->obtenerMantenimientoPorId($id);
            // solo la persona asignada puede marcar como realizado
            if ($mantenimiento && $mantenimiento['persona_asignada'] == $_SESSION['usuario']['id']) {
                $this->modelo->marcarComoRealizado($id);
            }
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // obtiene la lista de proximos mantenimientos
        $proximos = $this->modelo->listarProximosMantenimientos();
        // obtiene la lista de mantenimientos pendientes
        $pendientes = $this->modelo->listarMantenimientosPendientes();

        // obtiene las fechas del ultimo mantenimiento realizado por cada dispositivo
        $fechasUltimo = [];
        foreach ($dispositivos as $d) {
            $fechasUltimo[$d['codigo_dispositivo']] = $this->modelo->obtenerUltimaFechaRealizado($d['codigo_dispositivo']);
        }

        // incluye la vista para mostrar los mantenimientos
        include dirname(__DIR__) . '/vistas/vistaMantenimiento.php';
    }
}
?>