<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// utilizamos los metodos de los traits para visualizar en el home los productos y las categorias 

require_once("Models/CategoriasTrait.php");
require_once("Models/ProductosTrait.php");
require_once("Models/TiposPagoTrait.php");
require_once("Models/ClientesTrait.php");
class Carrito extends Controllers
{
    use CategoriasTrait, ProductosTrait, TiposPagoTrait, ClientesTrait;
    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
    }

    public function carrito()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        $data['page_tag'] =  NOMBRE_EMPRESA . " | " . "Carrito";
        $data['page_title'] =  NOMBRE_EMPRESA . " | " . "Carrito";
        $data['page_name'] = "Carrito";


        $this->views->getView($this, "Carrito", $data);
    }

    public function pagar()
    {
        if (empty($_SESSION['arrCarrito'])) {
            header("Location: " . base_url());
            die();
        }

     
        $data['page_tag'] =  NOMBRE_EMPRESA . " | " . "Procesar Pago";
        $data['page_title'] =  NOMBRE_EMPRESA . " | " . "Procesar Pago";
        $data['page_name'] = "pago";
        $data['tipos_pago'] = $this->getTiposPago();


        $this->views->getView($this, "pago", $data);
    }
}
