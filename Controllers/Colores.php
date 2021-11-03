<?php



class Colores extends Controllers
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
        getPermisos(9);
    }
    public function Colores()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Colores";
        $data['page_title'] = "Colores <small>V-SHOES</small>";
        $data['page_name'] = "Colores";
        $data['page_functions_js'] = "functions_colores.js";


        $this->views->getView($this, "Colores", $data);
    }

    public function setColor()
    {
        if ($_POST) {
            // dep($_POST);
            // exit();
            if (empty($_POST['txtNombre'])  || empty($_POST['listaEstados'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
            } else {
                $intIdColor = intval($_POST['idColor']);
                $strNombreColor = strClean($_POST['txtNombre']);
                $intStatusColor = intval($_POST['listaEstados']);
                $request_SetColor = "";



                if ($intIdColor == 0) {
                    $option = 1;

                    if ($_SESSION['modulos']['w']) {
                        //   Enviamos informacion al modelo RolesModel.php
                        // Insertar Color nuevo
                        $request_SetColor = $this->model->insertColor($strNombreColor,  $intStatusColor);
                    }
                } else {
                    $option = 2;

                    if ($_SESSION['modulos']['u']) {

                        // Actualizar Color existente
                        $request_SetColor = $this->model->updateColor($intIdColor, $strNombreColor, $intStatusColor);
                    }
                }
                // Validacion para la respuesta del metodo insertColor
                if ($request_SetColor > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_SetColor == "exist") {
                    $arrResponse = array('status' => false, 'msg' => "La categoria ya existe.");
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getColores()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectColores();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';
                if ($arrData[$i]['status_color'] == 1) {
                    $arrData[$i]['status_color'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status_color'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewColor" onClick="fntViewColor(' . $arrData[$i]['id_color'] . ')" title="Ver Color"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm btnEditColor" onClick="fntEditColor(this,' . $arrData[$i]['id_color'] . ')" title="Editar Color"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteColor" onClick="fntDeleteColor(' . $arrData[$i]['id_color'] . ')" title="Eliminar Color"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getColor($idColor)
    {
        if ($_SESSION['modulos']['r']) {

            $idColor = intval($idColor);
            if ($idColor > 0) {
                $arrData = $this->model->selectColor($idColor);
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
    public function delColor()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdColor = intval($_POST['idColor']);
                $request_DeleteColor = $this->model->deleteColor($intIdColor);
                if ($request_DeleteColor == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el color.');
                } elseif ($request_DeleteColor == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar el color esta asociado a un producto.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el color.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getSelectColores()
    {
        $options = "";
        $arrData = $this->model->selectColores();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count(($arrData)); $i++) {
                if ($arrData[$i]['status_color'] == 1) {
                    $options .= '<option value = "' . $arrData[$i]['id_color'] . '">' . $arrData[$i]['nombre_color'] . '</option>';
                }
            }
        }
        echo $options;
        die();
    }
}
