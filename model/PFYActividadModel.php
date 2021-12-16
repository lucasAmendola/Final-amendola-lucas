<?php

class actividadModel{

    private $db;

    function __construct(){
        $this->db =  new PDO('mysql:host=localhost;'.'dbname=PFY_sistem;charset=utf8', 
        'root', '');
    }
    function bonoDeBienvenida($bono, $id){
        $peticion = $this->db->prepare('INSERT INTO actividad (kms) VALUES(?) WHERE id_cliente=?');
        $peticion->execute(array($bono));
    }
    function obtenerActividadDeCliente($id){
        $peticion = $this->db->prepare('SELECT * FROM activad WHERE id_cliente=?');
        $peticion->execute(array($id));
        $respuesta = $peticion->fetch(pdo::FETCH_OBJ);
        return $respuesta;
    }
    function realizarTransferencia($id_destinatario, $transferencia){
        $peticion = $this->db->prepare('UPDATE actividad SET kms=? WHERE id_cliente=?');
        $peticion->execute(array($transferencia, $id_destinatario));
    }
}