<?php

require_once './model/PYFClienteModel.php';
require_once './helper/helper.php';
require_once './model/PFYActividadModel.php';

class clienteController{

    private $clienteModel;
    private $actividadModel;
    private $tarjetaModel;
    private $clienteView;
    private $helper;

    function __construct(){
        $this->clienteModel = new clienteModel;
        $this->actividadModel = new actividadModel;
        $this->tarjetaModel = new tarjetaModel;
        $this->clienteView = new clienteView;
        $this->helper = new AuthHelper;
    }

    
   /*1*/ function nuevoCliente(){
       if($this->helper->checkAdmin()){ 
            if(isset($_POST['nombre'],$_POST['dni'],$_POST['telefono'], $_POST['direccion'],$_POST['ejecutivo'])){
                $nombre = $_POST['nombre'];
                $dni_user = $_POST['dni'];
                $telefono = $_POST['telefono'];
                $direccion = $_POST['direccion'];
                $ejecutivo = $_POST['ejecutivo'];

                $dni = $this->model->checkDniUsuarios($dni_user);

                if($dni){
                    $mensaje = 'Ya existe un usuario con su mismo DNI!';
                    $this->clienteView->renderError($mensaje);
                }
                    else{
                        $mensaje = 'Bienvenido a PFY!!';
                        $id = $this->clienteModel->nuevoUsuario($nombre, $dni_user, $telefono, $direccion, $ejecutivo);
                        $this->view->renderHome($mensaje);
                    }
                if($ejecutivo == true){
                     $tarjeta = $this->CardHelper->getBussinesCard();
                     $this->tarjetaModel->tarjetasEjecutivas($tarjeta, $id);
                }

                if($id != 0){
                    $bono = 200;
                    $this->actividadModel->bonoDeBienvenida($bono, $id);
            }
                    else{
                            $mensaje = 'Ya existe un usuario con su mismos datos!';
                            $this->clienteView->renderError($mensaje);
                    }
         }
      }
    }


  /*2*/  function generarResumenDeCliente(){
            if($this->helper->checkLoggedIn()){
                if(isset($_POST['nombre'], $_POST['dni'])){
                    $id = $_SESSION['id'];

                        $actividad = $this->actividadModel->obtenerActividadDeCliente($id);
                        $tarjeta = $this->tarjetaModel->obtenerTarjetaDeUsuario($id);

                        if(($actividad)&&($tarjeta)){
                            $this->clienteView->mostrarResumenDeUsuario($actividad, $tarjeta);
                        }
                        else {
                            $mensaje = 'No hay tarjetas ni actividad asociadas a su usuario';
                            $this->clienteView->renderError($mensaje);
                        }
                    }
                else {
                    $mensaje = 'Complete los datos necesarios';
                            $this->clienteView->renderError($mensaje);
                }
            }
            else {
                $mensaje = 'Usted debe Loguearse';
                $this->clienteView->renderError($mensaje);
            }
        }


        /*3*/ function transferenciaDeKilometros(){
            if($this->helper->checkLoggedIn()){
                if(isset($_POST['dni'], $_POST['kms'])){
                    $id_user = $_SESSION['id'];
                    $dni_destinatario = $_POST['dni'];
                    $transferencia = $_POST['kms'];

                    
                    $saldo = $this->actividadModel->obtenerActividadDeCliente($id_user);

                    if($saldo > $transferencia){
                        $id_destinatario = $this->clienteModel->checkDniUsuarios($dni_destinatario);
                            if($id_destinatario){
                                 $this->actividadModel->realizarTransferencia($id_destinatario, $transferencia);
                                 $mensaje = 'Transferencia realizada!';
                                 $this->clienteView->renderMensaje($mensaje);
                                }
                            
                                else {
                                    $mensaje = 'Su destinatario no existe!';
                                    $this->clienteView->renderError($mensaje);
                                }
                         }          
                        else {
                            $mensaje = 'Su cuenta no posee el saldo suficiente';
                            $this->clienteView->renderError($mensaje);
                    }
                }
            }     
        }
    }