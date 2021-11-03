<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Proveedores extends Controllers
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
        getPermisos(5);
    }

    public function Proveedores()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Proveedores";
        $data['page_title'] = "Proveedores <small>V-SHOES</small>";
        $data['page_name'] = "Proveedores";
        $data['page_functions_js'] = "functions_proveedores.js";


        $this->views->getView($this, "Proveedores", $data);
    }

    public function setProveedor()
    {
        if ($_POST) {


            // dep($_POST);
            // exit;

            // Validacion datos vacios
            if (empty($_POST['txtNombreProveedor']) || empty($_POST['strTelefonoProveedor']) || empty($_POST['txtEmailProveedor']) || empty($_POST['listaEstados'])){
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdProveedor = intval($_POST['idProveedor']);
                $strNombreProveedor = ucwords(strClean($_POST['txtNombreProveedor']));
                $strTelefonoProveedor = strClean($_POST['strTelefonoProveedor']);
                $strEmailProveedor = strtolower(strClean($_POST['txtEmailProveedor']));
                $intStatusProveedor = intval($_POST['listaEstados']);

                $request_SetProveedor = "";

                // Validacion de id, si es 0 no se envia, entonces se crea un usuario
                // Si se envia un id significa que se actualizarán los datos
                if ($intIdProveedor == 0) {
                    // Validacion para contraseña
                    $option = 1;

                    if ($_SESSION['modulos']['w']) {
                        $request_SetProveedor = $this->model->insertProveedor($strNombreProveedor, $strTelefonoProveedor, $strEmailProveedor, $intStatusProveedor);
                    }
                } else {

                    $option = 2;
                    // Validacion actualziar contraseña, si está vacia no actualizamos, 

                    if ($_SESSION['modulos']['u']) {
                        $request_SetProveedor = $this->model->updateProveedor(
                            $intIdProveedor,
                            $strNombreProveedor,
                            $strTelefonoProveedor,
                            $strEmailProveedor,
                            $intStatusProveedor

                        );
                    }
                }
                // Validacion de la respuesta, sie s mayor a 0 se hizo un create o update
                if ($request_SetProveedor > 0) {
                    // Validacion si es option 1 o 2

                    if ($option == 1) {

                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_SetProveedor == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'El email ya existe, ingrese otro.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se han podido almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProveedores()
    {

        $arrData = $this->model->selectProveedores();
        // dep($arrData);
        // exit();
        if ($_SESSION['modulos']['r']) {
            # code...

            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';
                if ($arrData[$i]['status_proveedor'] == 1) {
                    $arrData[$i]['status_proveedor'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status_proveedor'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewProveedor" onClick="fntViewProveedor(' . $arrData[$i]['id_proveedor'] . ')" title="Ver Proveedor"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm btnEditProveedor" onClick="fntEditProveedor(this, ' . $arrData[$i]['id_proveedor'] . ')" title="Editar Proveedor"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteProveedor" onClick="fntDeleteProveedor(' . $arrData[$i]['id_proveedor'] . ')" title="Eliminar Proveedor"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProveedor($idProveedor)
    {
        if ($_SESSION['modulos']['r']) {

            $idProveedor = intval($idProveedor);
            if ($idProveedor > 0) {
                $arrData = $this->model->selectProveedor($idProveedor);
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

    public function delProveedor()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdProveedor = intval($_POST['idProveedor']);
                $request_DeleteProveedor = $this->model->deleteProveedor($intIdProveedor);
                if ($request_DeleteProveedor == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el proveedor.');
                } elseif($request_DeleteProveedor == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar el proveedor, esta asociado a un producto.');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el proveedor.');

                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getSelectProveedores()
    {
        $options = "";
        $arrData = $this->model->selectProveedores();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count(($arrData)); $i++) {
                if ($arrData[$i]['status_proveedor'] == 1) {
                    $options .= '<option value = "' . $arrData[$i]['id_proveedor'] . '">' . $arrData[$i]['nombre_proveedor'] . '</option>';
                }
            }
        }
        echo $options;
        die();
    }
}
