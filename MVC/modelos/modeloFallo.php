<?php
require_once dirname(__DIR__) . '/config/conexion.php';

class modeloFallo {
    private $conexion;

    private $id;
    private $id_usuario_reporta;
    private $id_admin_toma;
    private $codigo_dispositivo;
    private $descripcion;
    private $estado;
    private $fecha_reporte;
    private $fecha_tomado;
    private $fecha_atendido;
    private $fecha_resuelto;

    public function __construct() {
        // conecta a la base de datos cuando se crea el modelo
        $db = new Base_Datos();
        $this->conexion = $db->Conexion_Base_Datos();
    }

    // metodos para obtener y poner los valores de los atributos
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getIdUsuarioReporta() { return $this->id_usuario_reporta; }
    public function setIdUsuarioReporta($id_usuario_reporta) { $this->id_usuario_reporta = $id_usuario_reporta; }

    public function getIdAdminToma() { return $this->id_admin_toma; }
    public function setIdAdminToma($id_admin_toma) { $this->id_admin_toma = $id_admin_toma; }

    public function getCodigoDispositivo() { return $this->codigo_dispositivo; }
    public function setCodigoDispositivo($codigo_dispositivo) { $this->codigo_dispositivo = $codigo_dispositivo; }

    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getEstado() { return $this->estado; }
    public function setEstado($estado) { $this->estado = $estado; }

    public function getFechaReporte() { return $this->fecha_reporte; }
    public function setFechaReporte($fecha_reporte) { $this->fecha_reporte = $fecha_reporte; }

    public function getFechaTomado() { return $this->fecha_tomado; }
    public function setFechaTomado($fecha_tomado) { $this->fecha_tomado = $fecha_tomado; }

    public function getFechaAtendido() { return $this->fecha_atendido; }
    public function setFechaAtendido($fecha_atendido) { $this->fecha_atendido = $fecha_atendido; }

    public function getFechaResuelto() { return $this->fecha_resuelto; }
    public function setFechaResuelto($fecha_resuelto) { $this->fecha_resuelto = $fecha_resuelto; }

    public function listarPorUsuario($usuario_id) {
        // trae todos los fallos de un usuario que no esten resueltos
        $stmt = $this->conexion->prepare("
            SELECT f.*, d.ubicacion, d.tipo_dispositivo
            FROM fallos f
            JOIN dispositivos d ON f.codigo_dispositivo = d.codigo_dispositivo
            WHERE f.id_usuario_reporta = ?
            AND f.estado NOT IN ('resuelto')
            ORDER BY 
                FIELD(f.nivel_urgencia, 'alto', 'mediano', 'bajo'), 
                f.fecha_reporte DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        // agrega un nuevo fallo a la base de datos
        $stmt = $this->conexion->prepare("
            INSERT INTO fallos (id_usuario_reporta, codigo_dispositivo, descripcion, nivel_urgencia) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_usuario_reporta'],
            $data['codigo_dispositivo'],
            $data['descripcion'],
            $data['nivel_urgencia']
        ]);
    }

    public function listarTodos() {
        // devuelve todos los fallos con info del dispositivo
        $stmt = $this->conexion->query("
            SELECT f.*, d.ubicacion, d.tipo_dispositivo
            FROM fallos f
            JOIN dispositivos d ON f.codigo_dispositivo = d.codigo_dispositivo
            ORDER BY 
                FIELD(f.nivel_urgencia, 'alto', 'mediano', 'bajo'), 
                f.fecha_reporte DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        // busca un fallo por su id
        $stmt = $this->conexion->prepare("SELECT * FROM fallos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tomarFallo($fallo_id, $admin_id) {
        // el admin toma el fallo si esta pendiente
        $stmt = $this->conexion->prepare("UPDATE fallos SET estado='tomado', id_admin_toma=?, fecha_tomado=NOW() WHERE id=? AND estado='pendiente'");
        return $stmt->execute([$admin_id, $fallo_id]);
    }

    public function atenderFallo($fallo_id, $admin_id) {
        // el admin marca el fallo como por confirmacion si lo tomo antes
        $stmt = $this->conexion->prepare("UPDATE fallos SET estado='por_confirmacion', fecha_atendido=NOW() WHERE id=? AND id_admin_toma=? AND estado='tomado'");
        return $stmt->execute([$fallo_id, $admin_id]);
    }

    public function marcarResuelto($fallo_id, $usuario_id) {
        // el usuario marca el fallo como resuelto si ya fue atendido o es persistente
        $stmt = $this->conexion->prepare("UPDATE fallos SET estado='resuelto', fecha_resuelto=NOW() WHERE id=? AND id_usuario_reporta=? AND (estado='por_confirmacion' OR estado='persistente')");
        return $stmt->execute([$fallo_id, $usuario_id]);
    }

    public function marcarPersistente($fallo_id, $usuario_id) {
        // el usuario dice que el fallo sigue igual despues de la atencion
        $stmt = $this->conexion->prepare("UPDATE fallos SET estado='persistente' WHERE id=? AND id_usuario_reporta=? AND estado='por_confirmacion'");
        return $stmt->execute([$fallo_id, $usuario_id]);
    }

    public function eliminar($fallo_id, $usuario_id) {
        // borra el fallo si lo reporto el usuario
        $stmt = $this->conexion->prepare("DELETE FROM fallos WHERE id=? AND id_usuario_reporta=?");
        return $stmt->execute([$fallo_id, $usuario_id]);
    }

    public function editar($fallo_id, $usuario_id, $descripcion) {
        // permite editar la descripcion de un fallo pendiente
        $stmt = $this->conexion->prepare("UPDATE fallos SET descripcion=? WHERE id=? AND id_usuario_reporta=? AND estado='pendiente'");
        return $stmt->execute([$descripcion, $fallo_id, $usuario_id]);
    }

    public function eliminarPorAdmin($fallo_id) {
        // el admin puede borrar cualquier fallo
        $stmt = $this->conexion->prepare("DELETE FROM fallos WHERE id=?");
        return $stmt->execute([$fallo_id]);
    }
}