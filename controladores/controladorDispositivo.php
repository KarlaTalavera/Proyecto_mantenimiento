<?php
require_once dirname(__DIR__) . '/modelos/modeloDispositivo.php';

class controladorDispositivo {
    private $modelo;

    public function __construct() {
        $this->modelo = new modeloDispositivo();
    }

    public function mostrarDispositivos() {
        $ubicaciones = [
            'CAR' => 'Cardiología',
            'LAB' => 'Laboratorio',
            'QUI' => 'Quirófano'
        ];
        $tipos = [
            'COM' => 'Computadora',
            'IMP' => 'Impresora',
            'MON' => 'Monitor'
        ];

        $error = '';
        $editando = false;
        $dispositivoEditar = null;

        // Eliminar
        if (isset($_GET['eliminar'])) {
            $this->modelo->eliminarDispositivo($_GET['eliminar']);
            header("Location: index.php?vista=dispositivos");
            exit();
        }

        // Editar (mostrar datos)
        if (isset($_GET['editar'])) {
            $dispositivoEditar = $this->modelo->obtenerDispositivoPorCodigo($_GET['editar']);
            $editando = true;
        }

        // Guardar edición
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
            $ubicacion = $_POST['ubicacion'];
            $tipo = $_POST['tipo_dispositivo'];
            $numero = $_POST['numero_identificador'];
            $codigo = strtoupper($ubicacion) . strtoupper($tipo) . '-' . $numero;

            // Validar código único (excepto para el propio dispositivo)
            if ($this->modelo->codigoExiste($codigo, $_POST['codigo_original'])) {
                $error = "Ya existe un dispositivo con el código $codigo.";
            } else {
                $this->modelo->actualizarDispositivo($_POST['codigo_original'], $codigo, $tipo, $ubicacion, $numero);
                header("Location: index.php?vista=dispositivos");
                exit();
            }
            $dispositivoEditar = [
                'codigo_dispositivo' => $_POST['codigo_original'],
                'tipo_dispositivo' => $tipo,
                'ubicacion' => $ubicacion,
                'numero_identificador' => $numero
            ];
            $editando = true;
        }

        // Registrar nuevo
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
            $ubicacion = $_POST['ubicacion'];
            $tipo = $_POST['tipo_dispositivo'];
            $numero = $_POST['numero_identificador'];
            $codigo = strtoupper($ubicacion) . strtoupper($tipo) . '-' . $numero;

            if ($this->modelo->codigoExiste($codigo)) {
                $error = "Ya existe un dispositivo con el código $codigo.";
            } else {
                $this->modelo->agregarDispositivo($codigo, $tipo, $ubicacion, $numero);
                header("Location: index.php?vista=dispositivos");
                exit();
            }
        }

        $dispositivos = $this->modelo->listarDispositivos();
        include dirname(__DIR__) . '/vistas/vistaDispositivo.php';
    }
}
?>