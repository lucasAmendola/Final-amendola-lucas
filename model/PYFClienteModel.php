<?php

class clienteModel{
    private $db;

    function __construct(){
        $this-> db = new PDO('mysql:host=localhost;'.'dbname=PFY_sistem;charset=utf8', 
                                  'root', '');
    }
    function checkDniUsuarios($dni_user){
        $peticion = $this->db->prepare('SELECT * FROM cliente WHERE dni=?');
        $peticion->execute(array($dni_user));
        $respuesta = $peticion->fetch(pdo::FETCH_OBJ);
        return $respuesta;
    }
    function nuevoUsuario($nombre, $dni_user, $telefono, $direccion, $ejecutivo){
        $peticion = $this->db->prepare('INSERT INTO cliente (nombre, dni, telefono, direccion, ejecutivo) VALUES(?,?,?,?,?)');
        $peticion->execute(array($nombre, $dni_user, $telefono, $direccion, $ejecutivo));
        return $this->db->lastInsertId();
    }
}