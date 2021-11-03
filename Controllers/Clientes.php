<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Clientes extends Controllers
{

    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
        //    generar id de sesion
        // session_regenerate_id(true);
        //  validacion, si la variable de sesion esta vacia:

        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        // el numero en la funcion getPermisos es el ID del modulo, si cambia en la BD, lo cambiamos en la funcion
        getPermisos(3);
    }

    public function Clientes()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Clientes";
        $data['page_title'] = "Clientes <small>V-SHOES</small>";
        $data['page_name'] = "Clientes";
        $data['page_functions_js'] = "functions_clientes.js";


        $this->views->getView($this, "Clientes", $data);
    }

    public function setCliente()
    {
        if ($_POST) {
            error_reporting(0);

            // dep($_POST);
            // exit;

            // Validacion datos vacios
            if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombresCliente']) || empty($_POST['txtApellidosCliente']) || empty($_POST['strTelefonoCliente']) || empty($_POST['txtEmailCliente']) || empty($_POST['txtRfc']) || empty($_POST['txtDireccionFiscal'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdCliente = intval($_POST['idCliente']);
                $strIdentificacion = strClean($_POST['txtIdentificacion']);
                $strNombresCliente = ucwords(strClean($_POST['txtNombresCliente']));
                $strApellidosCliente = ucwords(strClean($_POST['txtApellidosCliente']));
                $strTelefonoCliente = strClean($_POST['strTelefonoCliente']);
                $strEmailCliente = strtolower(strClean($_POST['txtEmailCliente']));
                $strRfcCliente = strClean($_POST['txtRfc']);
                $strDireccionFiscal = strClean($_POST['txtDireccionFiscal']);
                $intTipoCliente = 4;
                $request_SetCliente = "";



                // Validacion de id, si es 0 no se envia, entonces se crea un usuario
                // Si se envia un id significa que se actualizarán los datos
                if ($intIdCliente == 0) {
                    // Validacion para contraseña
                    $option = 1;
                    $strPassword = empty($_POST['txtPassCliente']) ?  passGenerator() :  $_POST['txtPassCliente'];
                    $strPasswordEncrypted = hash("SHA256", $strPassword);

                    if ($_SESSION['modulos']['w']) {
                        $request_SetCliente = $this->model->insertCliente(
                            $strIdentificacion,
                            $strNombresCliente,
                            $strApellidosCliente,
                            $strTelefonoCliente,
                            $strEmailCliente,
                            $strPasswordEncrypted,
                            $strRfcCliente,
                            $strDireccionFiscal,
                            $intTipoCliente

                        );
                    }
                } else {

                    $option = 2;
                    // Validacion actualziar contraseña, si está vacia no actualizamos, 
                    $strPassword = empty($_POST['txtPassCliente']) ? "" : hash("SHA256", $_POST['txtPassCliente']);
                    if ($_SESSION['modulos']['u']) {
                        $request_SetCliente = $this->model->updateCliente(
                            $intIdCliente,
                            $strIdentificacion,
                            $strNombresCliente,
                            $strApellidosCliente,
                            $strTelefonoCliente,
                            $strEmailCliente,
                            $strPassword,
                            $strRfcCliente,
                            $strDireccionFiscal

                        );
                    }
                }
                // Validacion de la respuesta, sie s mayor a 0 se hizo un create o update
                if ($request_SetCliente > 0) {
                    // Validacion si es option 1 o 2

                    if ($option == 1) {

                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        $nombreCliente = $strNombresCliente . ' ' . $strApellidosCliente;
                        $dataCliente = array(
                            'nombreCliente' => $nombreCliente,
                            'email' => $strEmailCliente,
                            'password' => $strPassword,
                            'asunto' => 'Bienvenido a V-SHOES',

                        );
                        sendEmail($dataCliente, 'email_bienvenida');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_SetCliente == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'El email o la identificacion ya existe, ingrese otro.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se han podido almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getClientes()
    {

        $arrData = $this->model->selectClientes();
        // dep($arrData);
        // exit();
        if ($_SESSION['modulos']['r']) {
            # code...

            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';

                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewCliente" onClick="fntViewCliente(' . $arrData[$i]['id_persona'] . ')" title="Ver Cliente"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm btnEditCliente" onClick="fntEditCliente(this, ' . $arrData[$i]['id_persona'] . ')" title="Editar Cliente"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteCliente" onClick="fntDeleteCliente(' . $arrData[$i]['id_persona'] . ')" title="Eliminar Cliente"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCliente($idPersona)
    {
        if ($_SESSION['modulos']['r']) {
            // echo $idPersona;
            // die();
            $idCliente = intval($idPersona);
            if ($idCliente > 0) {
                $arrData = $this->model->selectCliente($idCliente);
                // dep($arrData);
                // validacion para usuaios existentes
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delCliente()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdPersona = intval($_POST['idCliente']);
                $request_DeleteUser = $this->model->deleteCliente($intIdPersona);
                if ($request_DeleteUser) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el cliente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Ha ocurrido un error al eliminar el cliente.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
