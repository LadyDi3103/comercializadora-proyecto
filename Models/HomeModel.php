<?php  

// este archivo se comunica con mysql.php para obtener los metodos

// require_once("CategoriasModel.php");
class HomeModel extends Mysql{
private $objCategoria;
public function __construct()
{
//   echo "Mensajes desde el modelo Home";
parent::__construct();
// $this->objCategoria = new CategoriasModel();
}

public function getCategoriasFront()
{
// return $this->objCategoria->selectCategorias();
}



}
