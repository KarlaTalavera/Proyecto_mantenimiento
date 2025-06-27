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
        $error = '';
        $editando = false;
        $mantenimientoEditar = null;

        // Para selects
        $dispositivoModel = new modeloDispositivo();
        $dispositivos = $dispositivoModel->listarDispositivos();

        $usuarioModel = new modeloUsuario();
        $usuarios = $usuarioModel->obtenerUsuarios();

        // Eliminar
        if (isset($_GET['eliminar'])) {
            $this->modelo->eliminarMantenimiento($_GET['eliminar']);
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // Editar (mostrar datos)
        if (isset($_GET['editar'])) {
            $mantenimientoEditar = $this->modelo->obtenerMantenimientoPorId($_GET['editar']);
            $editando = true;
        }

        // Guardar edición
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

           // Tomar mantenimiento pendiente
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tomar_mantenimiento'])) {
            $id = $_POST['tomar_mantenimiento'];
            $usuario_id = $_SESSION['usuario']['id'];
            $this->modelo->asignarPersona($id, $usuario_id);
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

           // Registrar nuevo (NO asignar persona)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
            $this->modelo->setCodigoDispositivo($_POST['codigo_dispositivo']);
            $this->modelo->setFechaUltimoMantenimiento($_POST['fecha_ultimo_mantenimiento']);
            $this->modelo->setFechaProximoMantenimiento($_POST['fecha_proximo_mantenimiento']);
            $this->modelo->setDescripcionProximoMantenimiento($_POST['descripcion_proximo_mantenimiento']);
            $this->modelo->setPersonaAsignada(null); // No asignar persona

            $this->modelo->agregarMantenimiento();
            // Enviar correo
                enviarCorreoMantenimiento(
                $_POST['codigo_dispositivo'],
                $_POST['fecha_ultimo_mantenimiento'],
                $_POST['fecha_proximo_mantenimiento'],
                $_POST['descripcion_proximo_mantenimiento']
            );

            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['realizar_mantenimiento'])) {
            $id = $_POST['realizar_mantenimiento'];
            $mantenimiento = $this->modelo->obtenerMantenimientoPorId($id);
            // Solo la persona asignada puede marcar como realizado
            if ($mantenimiento && $mantenimiento['persona_asignada'] == $_SESSION['usuario']['id']) {
                $this->modelo->marcarComoRealizado($id);
            }
            header("Location: index.php?vista=mantenimiento");
            exit();
        }

        // Listados
        $proximos = $this->modelo->listarProximosMantenimientos();
        $pendientes = $this->modelo->listarMantenimientosPendientes();
   
        $fechasUltimo = [];
        foreach ($dispositivos as $d) {
            $fechasUltimo[$d['codigo_dispositivo']] = $this->modelo->obtenerUltimaFechaRealizado($d['codigo_dispositivo']);
        }

        include dirname(__DIR__) . '/vistas/vistaMantenimiento.php';
    }
}
?>