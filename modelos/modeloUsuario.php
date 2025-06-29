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
        // conecta a la base de datos cuando se crea el modelo
        $bd = new Base_Datos();
        $this->conexion = $bd->Conexion_Base_Datos();
    }

    public function getId() {
        // devuelve el id del usuario
        return $this->id;
    }

    public function setId($id) {
        // pone el id del usuario
        $this->id = $id;
    }

    public function getNombre() {
        // devuelve el nombre del usuario
        return $this->nombre;
    }
    public function setNombre($nombre) {
        // pone el nombre del usuario
        $this->nombre = $nombre;
    }

    public function getApellido() {
        // devuelve el apellido del usuario
        return $this->apellido;
    }
    public function setApellido($apellido) {
        // pone el apellido del usuario
        $this->apellido = $apellido;
    }

    public function getUsuario() {
        // devuelve el nombre de usuario
        return $this->usuario;
    }
    public function setUsuario($usuario) {
        // pone el nombre de usuario
        $this->usuario = $usuario;
    }

    public function getContrasena() {
        // devuelve la contrasena
        return $this->contrasena;
    }
    public function setContrasena($contrasena) {
        // pone la contrasena
        $this->contrasena = $contrasena;
    }

    public function getRol() {
        // devuelve el rol del usuario
        return $this->rol;
    }
    public function setRol($rol) {
        // pone el rol del usuario
        $this->rol = $rol;
    }

    public function obtenerUsuarioPorNombre($usuario) {
        // busca un usuario por su nombre de usuario
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarUsuario() {
        // agrega un usuario nuevo a la base de datos
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
        // revisa si ya existe un usuario con ese nombre
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
        // trae todos los usuarios de la base de datos
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarUsuario() {
        // actualiza los datos de un usuario
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
        // borra un usuario por su id
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function listarTodos() {
        // devuelve solo el id, nombre y apellido de todos los usuarios
        $stmt = $this->conexion->query("SELECT id, nombre, apellido FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}