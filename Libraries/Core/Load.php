<?php  

// Configuracion de la carga de los archivos.


// Load.php
// este archivo gestiona la carpeta y archivos de Controllers (MVC)
// Ej. peticion:  tienda_virtual/Home
$controller = ucwords($controller);
$controllerFile = "Controllers/".$controller.".php";

// condicion para saber si existe ese archivo

if (file_exists($controllerFile)) {
    // si existe el controlador, lo requerimos...
    require_once($controllerFile);
    // instancia...
    $controller= new $controller();

    // condicion para validar si existe el metodo
    if (method_exists($controller, $method)) {
        // si existe el metodo($method) en el controlador($controller), entonces...
        $controller->{$method}($params); 
        // utilizamos ese metodo. refiriendonos a lo que tiene la instancia controller
        // y enviamos los parametros si existen.
    }else{
        require_once("Controllers/Errors.php");
    }

    
    

    
}else{
   require_once("Controllers/Errors.php");

}




?>