<?php  

require_once("Config/Config.php");
require_once("Helpers/Helpers.php"); 
// Si existen valores en la url, devuelve la ruta, si no, manda a home/home
$url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
// la url se convierte en array
$arrUrl = explode("/", $url);

// asignacion de la  posicion a una variable
$controller = $arrUrl[0];
$method = $arrUrl[0];
$params = "";

// la condicion indica que si en la posicion 1 tiene valor, se le asigna ese nombre
// si no tiene contenido, al metodo se le asigna el mismo que el controlador
if (!empty($arrUrl[1])) {
    if ($arrUrl[1] != "") {
        $method = $arrUrl[1];
    }
}

// la condicion para capturar los parametros
if (!empty($arrUrl[2])) {
    if ($arrUrl[2] != "") {
        for ($i=2; $i < count($arrUrl); $i++) { 
            $params.= $arrUrl[$i]. ',';
        }
        $params = trim($params, ',');
       
    }
}

// requeriomos el Autoload de las clases
require_once("Libraries/Core/Autoload.php");

// requerir el Load de los archivos
require_once("Libraries/Core/Load.php");

// echo "<br>";
// print_r($arrUrl);
// echo "<br>";


// echo "- controlador: ".$controller;
// echo "<br>";
// echo " - método: ".$method;
// echo "<br>";
// echo " - parametros:  ".$params;
?>