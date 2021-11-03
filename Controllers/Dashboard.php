<?php  
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Dashboard extends Controllers{

public function __construct()
{
    // ejecutamos el metodo constructor del la clase Controllers
   parent::__construct();
   session_start();
//    generar id de sesion
//    session_regenerate_id(true);
   if (empty($_SESSION['login'])) {

       header('Location: '.base_url().'/login');
   }
        getPermisos(1);


}
    
public function dashboard(){
    // invocar la vista
    // con this nos referimos a la clase views

    // $data es un array que contiene toda la info de la vista
    
    $data['page_id']=2;
    $data['page_tag']= "V-SHOES";
    $data['page_title']= "Panel Administrativo";
    $data['page_name']= "dashboard";
        $data['page_functions_js'] = "functions_dashboard.js";
   
    
    $this->views->getView($this,"Dashboard", $data);
}

}
