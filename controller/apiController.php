<?php

require_once './model/PFYActividadModel.php';
require_once './model/PFYTarjetasModel.php';
require_once './model/PYFClienteModel.php';
require_once 'apiView.php';

class apiClientesController{
    private $tarjetasModel;
    private $clienteModel;
    private $actividadModel;
    private $view;

    function __construct(){
        $this->clienteModel = new clienteModel;
        $this->tarjetasModel = new tarjetaModel;
        $this->actividadModel = new actividadModel;
        $this->view  = new apiView;
    }
    function obtenertarjetasPersonales($params = null){
        $id = $params[':ID'];
        $usuario = $this->clienteModel->obtenerUsuarioById($id);

        if($usuario){
            $tarjetas = $this->tarjetaModel->obtenertarjetasDeUsuarios($id);
            $this->view->response($tarjetas, 200);
        }
        else {
            $this->view->response('No se han encontrado tarjetas', 404);
        }
    }   
    function obtenerActividad($params = null){
        $id = $params[':ID'];
        $usuario = $this->clienteModel->obtenerUsuarioById($id);

        if($usuario){
            $actividad = $this->actividadModel->obtenerActividadDeUsuario($id);
            $this->view->response($actividad, 200);
        }
        else {
            $this->view->response('No se han encontrado registros de actividad', 404);
        }
    }
    function deleteTarjeta($params = null){
        $cliente_id = $params['ID'];
        $id_tarjeta = $params[':NUMERO_TARJETA'];

        $usuario = $this->clienteModel->obtenerUsuarioById($id);

        if($usuario){
            $this->tarjetasModel->eliminarTarjeta($cliente_id, $id_tarjeta);
            $this->view->response("La tarjeta numero:$id_tarjeta del usuario id:$cliente_id ha sido eliminada", 200);
        }
        else {
            $this->view->response("La tarjeta numero:$id_tarjeta del usuario id:$cliente_id NO ha podido ser eliminada", 404);
        }
    }
}