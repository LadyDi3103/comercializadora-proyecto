<?php 
// archivo que cargará las vistas

class Views{
    
    function getView($controller, $view, $data= "" ){
        // Ej. Home/Home
        $controller = get_class($controller); 
        // la clase es Home.
        
        // condicion que permite buscar la vista para Home
        if ($controller == "Home") {
            // si la vista es Home muestra Views/Home.php
            $view = "Views/".$view.".php";
    }else{
        // si la vista no es Home, entonces busca en otra carpeta dentro de Views
        $view = "Views/".$controller."/".$view.".php";
    }

    require_once($view);
}



}




?>