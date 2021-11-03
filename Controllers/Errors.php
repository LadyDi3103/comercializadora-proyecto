<?php  
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos

class Errors extends Controllers{

public function __construct()
{
    // ejecutamos el metodo constructor del la clase Controllers
   parent::__construct();
}
    public function notFound()
    {
        $this->views->getView($this, "Errors");
    }
 
}



$notFound = new Errors();
$notFound->notFound();




?>