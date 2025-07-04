<?php

require_once dirname(__DIR__) . '/config/conexion.php';

class modeloMantenimiento {
    private $conexion;

    private $id;
    private $codigo_dispositivo;
    private $fecha_ultimo_mantenimiento;
    private $fecha_proximo_mantenimiento;
    private $descripcion_proximo_mantenimiento;
    private $persona_asignada;

    public function __construct() {
        // conecta a la base de datos cuando se crea el modelo
        $bd = new Base_Datos();
        $this->conexion = $bd->Conexion_Base_Datos();
    }

    // metodos para obtener y poner los valores de los atributos
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getCodigoDispositivo() { return $this->codigo_dispositivo; }
    public function setCodigoDispositivo($codigo) { $this->codigo_dispositivo = $codigo; }

    public function getFechaUltimoMantenimiento() { return $this->fecha_ultimo_mantenimiento; }
    public function setFechaUltimoMantenimiento($fecha) { $this->fecha_ultimo_mantenimiento = $fecha; }

    public function getFechaProximoMantenimiento() { return $this->fecha_proximo_mantenimiento; }
    public function setFechaProximoMantenimiento($fecha) { $this->fecha_proximo_mantenimiento = $fecha; }

    public function getDescripcionProximoMantenimiento() { return $this->descripcion_proximo_mantenimiento; }
    public function setDescripcionProximoMantenimiento($desc) { $this->descripcion_proximo_mantenimiento = $desc; }

    public function getPersonaAsignada() { return $this->persona_asignada; }
    public function setPersonaAsignada($persona) { $this->persona_asignada = $persona; }

    public function agregarMantenimiento() {
        // agrega un nuevo mantenimiento a la base de datos
        $sql = "INSERT INTO mantenimiento (codigo_dispositivo, fecha_ultimo_mantenimiento, fecha_proximo_mantenimiento, descripcion_proximo_mantenimiento, persona_asignada)
                VALUES (:codigo_dispositivo, :fecha_ultimo, :fecha_proximo, :descripcion, :persona_asignada)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo_dispositivo', $this->codigo_dispositivo);
        $stmt->bindParam(':fecha_ultimo', $this->fecha_ultimo_mantenimiento);
        $stmt->bindParam(':fecha_proximo', $this->fecha_proximo_mantenimiento);
        $stmt->bindParam(':descripcion', $this->descripcion_proximo_mantenimiento);
        $stmt->bindParam(':persona_asignada', $this->persona_asignada);
        return $stmt->execute();
    }

    public function eliminarMantenimiento($id) {
        // borra un mantenimiento por su id
        $sql = "DELETE FROM mantenimiento WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function obtenerMantenimientoPorId($id) {
        // busca un mantenimiento por su id
        $sql = "SELECT * FROM mantenimiento WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarMantenimiento() {
        // actualiza los datos de un mantenimiento
        $sql = "UPDATE mantenimiento SET 
                    codigo_dispositivo = :codigo_dispositivo,
                    fecha_ultimo_mantenimiento = :fecha_ultimo,
                    fecha_proximo_mantenimiento = :fecha_proximo,
                    descripcion_proximo_mantenimiento = :descripcion,
                    persona_asignada = :persona_asignada
                WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo_dispositivo', $this->codigo_dispositivo);
        $stmt->bindParam(':fecha_ultimo', $this->fecha_ultimo_mantenimiento);
        $stmt->bindParam(':fecha_proximo', $this->fecha_proximo_mantenimiento);
        $stmt->bindParam(':descripcion', $this->descripcion_proximo_mantenimiento);
        $stmt->bindParam(':persona_asignada', $this->persona_asignada);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function listarProximosMantenimientos() {
        // trae los mantenimientos que aun no vencen
        $sql = "SELECT * FROM mantenimiento WHERE fecha_proximo_mantenimiento > CURDATE() ORDER BY fecha_proximo_mantenimiento ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // trae los mantenimientos que ya vencieron y no han sido tomados
    public function listarMantenimientosPendientes() {
        $sql = "SELECT * FROM mantenimiento WHERE fecha_proximo_mantenimiento <= CURDATE() ORDER BY fecha_proximo_mantenimiento ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // asigna una persona a un mantenimiento
    public function asignarPersona($id, $persona_id) {
        $sql = "UPDATE mantenimiento SET persona_asignada = :persona WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':persona', $persona_id);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function marcarComoRealizado($id) {
        // marca el mantenimiento como realizado poniendo la fecha de hoy
        $sql = "UPDATE mantenimiento SET fecha_realizado = CURDATE() WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function obtenerUltimaFechaRealizado($codigo_dispositivo) {
        // busca la ultima fecha en que se realizo el mantenimiento de un dispositivo
        $sql = "SELECT fecha_realizado 
                FROM mantenimiento 
                WHERE codigo_dispositivo = :codigo_dispositivo 
                  AND fecha_realizado IS NOT NULL
                ORDER BY fecha_realizado DESC 
                LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':codigo_dispositivo', $codigo_dispositivo);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['fecha_realizado'] : '';
    }

    public function editar($fallo_id, $usuario_id, $descripcion, $codigo_dispositivo, $nivel_urgencia) {
        // permite editar la descripcion, dispositivo y urgencia de un fallo pendiente
        $stmt = $this->conexion->prepare("UPDATE fallos SET descripcion=?, codigo_dispositivo=?, nivel_urgencia=? WHERE id=? AND id_usuario_reporta=? AND estado='pendiente'");
        return $stmt->execute([$descripcion, $codigo_dispositivo, $nivel_urgencia, $fallo_id, $usuario_id]);
    }
}
?>