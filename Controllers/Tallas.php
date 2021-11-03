<?php



class  Tallas extends Controllers
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
        getPermisos(8);
    }
    public function Tallas()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Tallas";
        $data['page_title'] = "Tallas <small>V-SHOES</small>";
        $data['page_name'] = "Tallas";
        $data['page_functions_js'] = "functions_tallas.js";


        $this->views->getView($this, "Tallas", $data);
    }

    public function setTalla()
    {
        if ($_POST) {
            // dep($_POST);
            // exit();
            if (empty($_POST['intTalla'])  || empty($_POST['listaEstados'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
            } else {
                $intIdTalla = intval($_POST['idTalla']);
                $intTalla = intval($_POST['intTalla']);
                $intStatusTalla = intval($_POST['listaEstados']);
                $request_SetTalla = "";



                if ($intIdTalla == 0) {
                    $option = 1;

                    if ($_SESSION['modulos']['w']) {
                        //   Enviamos informacion al modelo TallaModel.php
                        // Insertar Talla nuevo
                        $request_SetTalla = $this->model->insertTalla($intTalla,  $intStatusTalla);
                    }
                } else {
                    $option = 2;

                    if ($_SESSION['modulos']['u']) {

                        // Actualizar Talla existente
                        $request_SetTalla = $this->model->updateTalla($intIdTalla, $intTalla, $intStatusTalla);
                    }
                }
                // Validacion para la respuesta del metodo insertColor
                if ($request_SetTalla > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_SetTalla == "exist") {
                    $arrResponse = array('status' => false, 'msg' => "La talla ya existe.");
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getTallas()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectTallas();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';
                if ($arrData[$i]['status_talla'] == 1) {
                    $arrData[$i]['status_talla'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status_talla'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewTalla" onClick="fntViewTalla(' . $arrData[$i]['id_numeroTalla'] . ')" title="Ver Talla"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm btnEditTalla" onClick="fntEditTalla(this,' . $arrData[$i]['id_numeroTalla'] . ')" title="Editar Talla"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteTalla" onClick="fntDeleteTalla(' . $arrData[$i]['id_numeroTalla'] . ')" title="Eliminar Talla"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getTalla($idTalla)
    {
        if ($_SESSION['modulos']['r']) {

            $idTalla = intval($idTalla);
            if ($idTalla > 0) {
                $arrData = $this->model->selectTalla($idTalla);
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

    public function delTalla()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdTalla = intval($_POST['idTalla']);
                $request_DeleteTalla = $this->model->deleteTalla($intIdTalla);
                if ($request_DeleteTalla == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la talla.');
                } elseif ($request_DeleteTalla == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar la talla esta asociado a un producto.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la talla.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
