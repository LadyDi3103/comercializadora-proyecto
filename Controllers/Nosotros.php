<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// utilizamos los metodos de los traits para visualizar en el home los productos y las categorias 

class Nosotros extends Controllers
{
    // use CategoriasTrait, ProductosTrait, TiposPagoTrait;
    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
    }

    public function nosotros()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        $data['page_tag'] =  NOMBRE_EMPRESA . " | " . "Nosotros";
        $data['page_title'] =  NOMBRE_EMPRESA . " | " . "Nosotros";
        $data['page_name'] = "Nosotros";


        $this->views->getView($this, "Nosotros", $data);
    }

   
}
