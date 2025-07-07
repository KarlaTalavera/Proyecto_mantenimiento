<?php
require_once dirname(__DIR__) . '/config/conexion.php';

class modeloDispositivo {
    private $conexion;

    public function __construct() {
        // aqui se conecta a la base de datos usando la clase base_datos
        $db = new Base_Datos();
        $this->conexion = $db->Conexion_Base_Datos();
    }

    public function listarDispositivos() {
        // trae todos los dispositivos de la tabla
        $sql = "SELECT * FROM dispositivos";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos() {
        // devuelve solo el codigo, ubicacion y tipo de cada dispositivo ordenados por codigo
        $stmt = $this->conexion->query("SELECT codigo_dispositivo, ubicacion, tipo_dispositivo FROM dispositivos ORDER BY codigo_dispositivo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregarDispositivo($codigo, $tipo, $ubicacion, $numero) {
        // agrega un nuevo dispositivo a la base de datos
        $sql = "INSERT INTO dispositivos (codigo_dispositivo, tipo_dispositivo, ubicacion, numero_identificador) VALUES (:codigo, :tipo, :ubicacion, :numero)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':numero', $numero);
        return $stmt->execute();
    }

    public function eliminarDispositivo($codigo) {
        // borra un dispositivo segun su codigo
        $sql = "DELETE FROM dispositivos WHERE codigo_dispositivo = :codigo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        return $stmt->execute();
    }

    public function obtenerDispositivoPorCodigo($codigo) {
        // busca un dispositivo por su codigo
        $sql = "SELECT * FROM dispositivos WHERE codigo_dispositivo = :codigo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarDispositivo($codigoOriginal, $codigo, $tipo, $ubicacion, $numero) {
        // actualiza los datos de un dispositivo usando su codigo original
        $sql = "UPDATE dispositivos SET codigo_dispositivo = :codigo, tipo_dispositivo = :tipo, ubicacion = :ubicacion, numero_identificador = :numero WHERE codigo_dispositivo = :codigoOriginal";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':codigoOriginal', $codigoOriginal);
        return $stmt->execute();
    }

    public function codigoExiste($codigo, $codigoOriginal = null) {
        // revisa si ya hay un dispositivo con ese codigo
        if ($codigoOriginal) {
            $sql = "SELECT COUNT(*) FROM dispositivos WHERE codigo_dispositivo = :codigo AND codigo_dispositivo != :codigoOriginal";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':codigoOriginal', $codigoOriginal);
        } else {
            $sql = "SELECT COUNT(*) FROM dispositivos WHERE codigo_dispositivo = :codigo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':codigo', $codigo);
        }
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?>