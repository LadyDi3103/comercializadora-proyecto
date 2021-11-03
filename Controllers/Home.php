<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// utilizamos los metodos de los traits para visualizar en el home los productos y las categorias 

require_once("Models/CategoriasTrait.php");
require_once("Models/ProductosTrait.php");
class Home extends Controllers
{
    use CategoriasTrait, ProductosTrait;
    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
    }

    public function home()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        $data['page_tag'] = "V-SHOES";
        $data['page_title'] = "V-SHOES";
        $data['page_name'] = "V-SHOES";
        $data['slider'] = $this->getCategoriasTrait(SLIDER_CATEGORIAS);
        $data['cards'] = $this->getCategoriasTrait(CARDS_CATEGORIAS);
        $data['productos'] = $this->getProductosTrait();

        // dep($data);
        // exit;

        $this->views->getView($this, "Home", $data);
    }
}
