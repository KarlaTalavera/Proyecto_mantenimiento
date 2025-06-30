<?php
require_once dirname(__DIR__) . '/modelos/modeloFallo.php';
require_once dirname(__DIR__) . '/modelos/modeloDispositivo.php';
require_once dirname(__DIR__) . '/modelos/modeloUsuario.php';
require_once dirname(__DIR__) . '/vistas/enviar.php';


class controladorFallo {
    private $modelo;

    public function __construct() {
        $this->modelo = new modeloFallo();
    }

    public function mostrarFalloUsuario() {
        // obtiene el id del usuario actual desde la sesion
        $usuario_id = $_SESSION['usuario']['id'];

        // crea una instancia del modelo de dispositivo y obtiene la lista de todos los dispositivos
        $modeloDispositivo = new modeloDispositivo();
        $dispositivos = $modeloDispositivo->listarTodos();

        // inicializa la variable para editar fallos
        $falloEditar = null; 

        // maneja las acciones del usuario segun el metodo post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // si el usuario crea un fallo, lo registra en la base de datos
            if (isset($_POST['crear'])) {
                $this->modelo->crear([
                    'id_usuario_reporta' => $usuario_id,
                    'codigo_dispositivo' => $_POST['codigo_dispositivo'],
                    'descripcion' => $_POST['descripcion'],
                    'nivel_urgencia' => $_POST['nivel_urgencia']
                ]);

                // Obtener datos del dispositivo
                $modeloDispositivo = new modeloDispositivo();
                $dispositivo = $modeloDispositivo->obtenerDispositivoPorCodigo($_POST['codigo_dispositivo']);

                // Obtener datos del usuario
                $modeloUsuario = new modeloUsuario();
                $usuario = $modeloUsuario->obtenerPorId($usuario_id);

               enviarCorreoFalloReportado(
                    $_POST['codigo_dispositivo'],
                    $dispositivo['ubicacion'] ?? '',
                    $dispositivo['tipo_dispositivo'] ?? '',
                    $_POST['nivel_urgencia'],
                    $_POST['descripcion'],
                    ($usuario['nombre'] ?? '') . ' ' . ($usuario['apellido'] ?? '')
                );
                header("Location: index.php?vista=fallos");
                exit();
            }
            // si el usuario quiere editar, carga los datos del fallo a editar
            if (isset($_POST['editar'])) {
                $falloEditar = $this->modelo->obtenerPorId($_POST['fallo_id']);
            }
            // si el usuario guarda la edicion, actualiza el fallo
            if (isset($_POST['guardar_edicion'])) {
                $this->modelo->editar(
                    $_POST['fallo_id'],
                    $usuario_id,
                    $_POST['descripcion'],
                    $_POST['codigo_dispositivo'],
                    $_POST['nivel_urgencia']
                );
                header("Location: index.php?vista=fallos");
                exit();
            }
            // si el usuario elimina un fallo, lo borra de la base de datos
            if (isset($_POST['eliminar'])) {
                $this->modelo->eliminar($_POST['fallo_id'], $usuario_id);
                header("Location: index.php?vista=fallos");
                exit();
            }
            // si el usuario marca un fallo como resuelto, actualiza el estado
            if (isset($_POST['resuelto'])) {
                $this->modelo->marcarResuelto($_POST['fallo_id'], $usuario_id);
                header("Location: index.php?vista=fallos");
                exit();
            }
            // si el usuario marca un fallo como persistente, actualiza el estado
            if (isset($_POST['persistente'])) {
                $this->modelo->marcarPersistente($_POST['fallo_id'], $usuario_id);
                header("Location: index.php?vista=fallos");
                exit();
            }
        }

        // crea una instancia del modelo de usuario y obtiene la lista de todos los usuarios
        $modeloUsuario = new modeloUsuario();
        $usuarios = $modeloUsuario->listarTodos();

        // obtiene la lista de fallos reportados por el usuario actual
        $fallos = $this->modelo->listarPorUsuario($usuario_id);
        // incluye la vista para mostrar los fallos del usuario
        include dirname(__DIR__) . '/vistas/vistaFalloUsuario.php';
    }

    public function mostrarFalloAdmin() {
        // obtiene el id del admin desde la sesion
        $admin_id = $_SESSION['usuario']['id'];

        // crea una instancia del modelo de usuario y obtiene la lista de todos los usuarios
        $modeloUsuario = new modeloUsuario();
        $usuarios = $modeloUsuario->listarTodos();

        // maneja las acciones del admin segun el metodo post
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // si el admin toma un fallo, lo asigna a su usuario
            if (isset($_POST['tomar'])) {
                $this->modelo->tomarFallo($_POST['fallo_id'], $admin_id);
            }
            // si el admin atiende un fallo, actualiza el estado
            if (isset($_POST['atender'])) {
                $this->modelo->atenderFallo($_POST['fallo_id'], $admin_id);
            }
            // si el admin elimina un fallo, lo borra de la base de datos
            if (isset($_POST['eliminar_admin'])) {
                $this->modelo->eliminarPorAdmin($_POST['fallo_id']);
            }
            // redirige a la vista de fallos despues de cualquier accion
            header("Location: index.php?vista=fallos");
            exit();
        }

        // obtiene la lista de todos los fallos para mostrar al admin
        $fallos = $this->modelo->listarTodos();
        // incluye la vista para mostrar los fallos al admin
        include dirname(__DIR__) . '/vistas/vistaFalloAdmin.php';
    }
}