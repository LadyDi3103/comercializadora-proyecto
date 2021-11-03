<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// utilizamos los metodos de los traits para visualizar en el home los productos y las categorias 

class Mensajes extends Controllers
{
    // use CategoriasTrait, ProductosTrait, TiposPagoTrait;
    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        // el numero en la funcion getPermisos es el ID del modulo, si cambia en la BD, lo cambiamos en la funcion
        getPermisos(10);
    }


    public function Mensajes()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] =  NOMBRE_EMPRESA . " | " . "Mensajes";
        $data['page_title'] =  NOMBRE_EMPRESA . " | " . "Mensajes";
        $data['page_name'] = "Mensajes";
        $data['page_functions_js'] = "functions_mensajes.js";



        $this->views->getView($this, "Mensajes", $data);
    }

    public function getMensajes()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectMensajes();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                
               
                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm " onClick="fntViewMensaje(' . $arrData[$i]['id_contacto'] . ')" title="Ver Mensaje"><i class="fa fa-eye"></i></button>';
                }
                

                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . '</div>';
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getMensaje(int $id_contacto)
    {
        if ($_SESSION['modulos']['r']) {
            $id_contacto = intval($id_contacto);

            if ($id_contacto > 0) {
                $arrData = $this->model->selectMensaje($id_contacto);

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
