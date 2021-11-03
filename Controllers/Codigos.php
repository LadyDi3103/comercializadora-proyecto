<?php



class Codigos extends Controllers
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
        // getPermisos(9);
    }
    public function Codigos()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Codigos";
        $data['page_title'] = "Codigos <small>V-SHOES</small>";
        $data['page_name'] = "Codigos";
        $data['page_functions_js'] = "functions_codigos.js";


        $this->views->getView($this, "Codigos", $data);
    }

    public function setCodigo()
    {
        if ($_POST) {
            // dep($_POST);
            // die();
            if (empty($_POST['text'])  || empty($_POST['listaProductos'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
            } else {
                $intIdCodigo = intval($_POST['idCodigo']);
                $producto = strClean($_POST['listaProductos']);
                $url = $_POST['text'];
                $request_SetColor = "";

                $request_SetColor = $this->model->insertCodigo($producto,  $url);

                // Validacion para la respuesta del metodo insertColor
                if ($request_SetColor > 0) {

                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCodigos()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectCodigos();
            // dep($arrData);exit;
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';

                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewColor" onClick="fntViewCodigo(' . $arrData[$i]['id_codigo'] . ')" title="Ver Color"><i class="fa fa-eye"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function getCodigo(int $idCodigo)
    {
        if ($_SESSION['modulos']['r']) {

            $idCodigo = intval($idCodigo);
            if ($idCodigo > 0) {
                $arrData = $this->model->selectCodigo($idCodigo);
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
}
