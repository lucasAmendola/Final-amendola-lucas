<?php

class tarjetaModel{
    private $db;

    function __construct(){
        $this-> db = new PDO('mysql:host=localhost;'.'dbname=PFY_sistem;charset=utf8', 
                                  'root', '');
    }
    function tarjetasEjecutivas($tarjeta, $id){
        $peticion = $this->db->prepare('UPDATE tarjeta SET tipo_tarjeta=? WHERE id_cliente=?');
        $peticion->execute(array($tarjeta, $id));
    }
    function obtenerTarjetaDeUsuario($id){
        $peticion = $this->db->prepare('SELECT * FROM tarjeta WHERE id_cliente=?');
        $peticion->execute(array($id));
        $respuesta = $peticion->fetchAll(pdo::FETCH_OBJ);
        return $respuesta;
    }
}