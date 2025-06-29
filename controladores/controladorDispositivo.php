<?php
require_once dirname(__DIR__) . '/modelos/modeloDispositivo.php';

class controladorDispositivo {
    private $modelo;

    public function __construct() {
        $this->modelo = new modeloDispositivo();
    }

    public function mostrarDispositivos() {
        // aca tienes las ubicaciones con su abreviatura, para que el usuario no tenga que escribir todo el nombre
        $ubicaciones = [
            'CAR' => 'Cardiología',
            'LAB' => 'Laboratorio',
            'QUI' => 'Quirófano',
            'ADM' => 'Administración',
            'URG' => 'Urgencias',
            'RX'  => 'Rayos X / Radiología',
            'UCI' => 'Unidad de Cuidados Intensivos',
            'FARM'=> 'Farmacia',
            'ALM' => 'Almacén',
            'CON' => 'Consultorios Externos',
            'REH' => 'Rehabilitación',
            'PAT' => 'Patología',
            'COC' => 'Cocina / Cafetería',
            'SEG' => 'Seguridad',
            'MNT' => 'Mantenimiento',
            'LIM' => 'Limpieza',
            'PED' => 'Pediatría',
            'MAT' => 'Maternidad',
            'NEU' => 'Neurología'
        ];

        // lo mismo pero para los tipos de dispositivos, asi el codigo es mas facil de manejar
        $tipos = [
            'COM' => 'Computadora',
            'IMP' => 'Impresora',
            'MON' => 'Monitor',
            'TEL' => 'Teléfono (IP/Fijo)',
            'RED' => 'Equipo de Red (Router/Switch/AP)',
            'SER' => 'Servidor',
            'UPS' => 'UPS / Batería de Respaldo',
            'POS' => 'Punto de Venta',
            'CAM' => 'Cámara de Seguridad',
            'LEC' => 'Lector (Códigos de barras/Tarjeta)',
            'PRO' => 'Proyector',
            'EQU' => 'Equipo Médico (Conectado a red)',
            'HOS' => 'Host/Máquina Virtual',
            'PER' => 'Periférico (Teclado/Mouse/Webcam)',
            'VOZ' => 'Sistema de Voz/Intercomunicador',
            'SEN' => 'Sensor/Dispositivo IoT',
        ];

        // aca se guardan los errores y si estas editando o no
        $error = '';
        $editando = false;
        $dispositivoEditar = null;

        // si te llega el parametro eliminar por la url, borra el dispositivo y vuelve a la lista
        if (isset($_GET['eliminar'])) {
            $this->modelo->eliminarDispositivo($_GET['eliminar']);
            header("Location: index.php?vista=dispositivos");
            exit();
        }

        // si te llega el parametro editar, busca ese dispositivo y lo pone en modo edicion
        if (isset($_GET['editar'])) {
            $dispositivoEditar = $this->modelo->obtenerDispositivoPorCodigo($_GET['editar']);
            $editando = true;
        }

        // si el usuario manda el formulario para actualizar, procesa la edicion
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizar'])) {
            // toma los valores del formulario
            $ubicacion_abrev = $_POST['ubicacion'];
            $tipo_abrev = $_POST['tipo_dispositivo'];
            $numero = $_POST['numero_identificador'];

            // busca el nombre completo segun la abreviatura, si no existe deja lo que puso el usuario
            $ubicacion = $ubicaciones[$ubicacion_abrev] ?? $ubicacion_abrev;
            $tipo = $tipos[$tipo_abrev] ?? $tipo_abrev;

            // el codigo se arma con la ubicacion, tipo y numero, todo junto
            $codigo = strtoupper($ubicacion_abrev) . strtoupper($tipo_abrev) . '-' . $numero;

            // antes de actualizar, revisa que no exista otro dispositivo con ese codigo (excepto el mismo)
            if ($this->modelo->codigoExiste($codigo, $_POST['codigo_original'])) {
                // si ya existe, muestra el error
                $error = "Ya existe un dispositivo con el codigo $codigo.";
            } else {
                // si no, actualiza el dispositivo y vuelve a la lista
                $this->modelo->actualizarDispositivo($_POST['codigo_original'], $codigo, $tipo, $ubicacion, $numero);
                header("Location: index.php?vista=dispositivos");
                exit();
            }
            // si hubo error, deja los datos en el formulario para que el usuario los vea
            $dispositivoEditar = [
                'codigo_dispositivo' => $_POST['codigo_original'],
                'tipo_dispositivo' => $tipo,
                'ubicacion' => $ubicacion,
                'numero_identificador' => $numero
            ];
            $editando = true;
        }

        // si el usuario manda el formulario para registrar, agrega el nuevo dispositivo
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
            $ubicacion_abrev = $_POST['ubicacion'];
            $tipo_abrev = $_POST['tipo_dispositivo'];
            $numero = $_POST['numero_identificador'];

            // igual que arriba, busca los nombres completos
            $ubicacion = $ubicaciones[$ubicacion_abrev] ?? $ubicacion_abrev;
            $tipo = $tipos[$tipo_abrev] ?? $tipo_abrev;

            $codigo = strtoupper($ubicacion_abrev) . strtoupper($tipo_abrev) . '-' . $numero;

            // revisa si ya existe ese codigo antes de agregarlo
            if ($this->modelo->codigoExiste($codigo)) {
                $error = "Ya existe un dispositivo con el codigo $codigo.";
            } else {
                $this->modelo->agregarDispositivo($codigo, $tipo, $ubicacion, $numero);
                header("Location: index.php?vista=dispositivos");
                exit();
            }
        }

        // al final, trae todos los dispositivos para mostrarlos en la tabla
        $dispositivos = $this->modelo->listarDispositivos();
        include dirname(__DIR__) . '/vistas/vistaDispositivo.php';
    }
}
?>