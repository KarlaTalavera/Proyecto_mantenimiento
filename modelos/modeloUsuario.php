<?php

require_once dirname(__DIR__) . '/config/conexion.php';

class modeloUsuario {

    private $conexion;

    private $id;
    private $nombre;
    private $apellido;
    private $usuario;
    private $contrasena;
    private $rol;

    public function __construct() {
        $bd = new Base_Datos();
        $this->conexion = $bd->Conexion_Base_Datos();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getUsuario() {
        return $this->usuario;
    }
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getContrasena() {
        return $this->contrasena;
    }
    public function setContrasena($contrasena) {
        $this->contrasena = $contrasena;
    }

    public function getRol() {
        return $this->rol;
    }
    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function agregarUsuario() {
        $sql = "INSERT INTO usuarios (nombre, apellido, usuario, contrasena, rol) VALUES (:nombre, :apellido, :usuario, :contrasena, :rol)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':usuario', $this->usuario);
        $contrasenaHash = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $stmt->bindParam(':contrasena', $contrasenaHash);
        $stmt->bindParam(':rol', $this->rol);
        return $stmt->execute();
    }

    public function usuarioExiste($usuario, $id = null) {
    if ($id) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario AND id != :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':id', $id);
    } else {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
    }
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
    }

    public function obtenerUsuarios() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarUsuario() {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, usuario = :usuario, contrasena = :contrasena, rol = :rol WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':contrasena', password_hash($this->contrasena, PASSWORD_DEFAULT));
        $stmt->bindParam(':rol', $this->rol);
        return $stmt->execute();
    }

    public function eliminarUsuario() {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }


}