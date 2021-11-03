<?php  
// este archivo gestiona la carpeta y archivos de Models (MVC)
// invocamos el modelo
// Hace las instancias a las clases

class Controllers {


public function __construct()
{
    // instancia de la vista
    $this->views = new Views();
    
    // para utilizar el metodo loadModel, se carga en el constructor
    // ya que en una clase el constructor se ejecuta primero.
    $this->loadModel();
}


// metodo que sirve para cargar los modelos (conexion a una BD)
public function loadModel()
{
   $model = get_class($this)."Model";
//  Ej.  HomeModel

$routClass = "Models/".$model.".php";
// Ej.  Models/HomeModel.php

// condicio para validar si el archivo existe

if (file_exists($routClass)) {
    require_once($routClass);

    // crar la instancia de la clase que corresponde al modelo
    $this->model = new $model();
    // Ej.  HomeModel = new HomeModel();
}

}


    
}




 


?>