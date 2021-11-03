<?php  


    // Autoload para cargar automaticamente las clases

    spl_autoload_register(function($class){

    // condicion para requerir el archivo.
        if (file_exists("Libraries/".'Core/'.$class.".php")) {
        require_once("Libraries/".'Core/'.$class.".php");
        }
    /*
    Ejemplo:
    clase Controllers
    Libraries/Core/Controllers.php
    **
    *********SI EXISTE, REQUIERE ESE MISMO ARCHIVO***********
    */
});?>