<?php

require_once dirname(__DIR__) . '/modelos/modeloUsuario.php';

class controladorUsuario {
   
    private $modelo;

    public function __construct() {
        $this->modelo = new modeloUsuario();
    }

    public function mostrarUsuarios() {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['registrar'])) {
            if ($this->modelo->usuarioExiste($_POST['usuario'])) {
                $error = "El usuario '" . htmlspecialchars($_POST['usuario']) . "' ya existe";
            } else {
                try {
                    $this->modelo->setNombre($_POST['nombre']);
                    $this->modelo->setApellido($_POST['apellido']);
                    $this->modelo->setUsuario($_POST['usuario']);
                    $this->modelo->setContrasena($_POST['contrasena']);
                    $this->modelo->setRol($_POST['rol']);
                    $this->modelo->agregarUsuario();
                    header("Location: index.php");
                    exit();
                } catch (PDOException $e) {
                    $error = "Error al registrar usuario: " . $e->getMessage();
                }
            }
        }
            if (isset($_POST['actualizar'])) {
                $this->modelo->setId($_POST['id']);
                $this->modelo->setNombre($_POST['nombre']);
                $this->modelo->setApellido($_POST['apellido']);
                $this->modelo->setUsuario($_POST['usuario']);
                $this->modelo->setRol($_POST['rol']);
                if (!empty($_POST['contrasena'])) {
                    $this->modelo->setContrasena($_POST['contrasena']);
                } else {
                    $this->modelo->setContrasena(null);
                }

                // Verifica duplicado excluyendo el usuario actual
                if ($this->modelo->usuarioExiste($_POST['usuario'], $_POST['id'])) {
                    $error = "El usuario '" . htmlspecialchars($_POST['usuario']) . "' ya existe";
                } else {
                    $this->modelo->editarUsuario();
                    header("Location: index.php");
                    exit();
                }
            }
        }

        // Si viene el parámetro editar, busca el usuario
        $usuarioEditar = null;
        if (isset($_GET['editar'])) {
            $idEditar = $_GET['editar'];
            $usuarios = $this->modelo->obtenerUsuarios();
            foreach ($usuarios as $u) {
                if ($u['id'] == $idEditar) {
                    $usuarioEditar = $u;
                    break;
                }
            }
        }

        if (isset($_GET['eliminar'])) {
            $this->modelo->setId($_GET['eliminar']);
             $this->modelo->eliminarUsuario();
             header("Location: index.php");
             exit();
            }
        // Obtener usuarios para la tabla
        $usuarios = $this->modelo->obtenerUsuarios();
        // Mostrar la vista y pasar los usuarios y el usuario a editar
        require dirname(__DIR__) . '/vistas/vistaUsuario.php';
    }
}

