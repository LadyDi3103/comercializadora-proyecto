<?php

// este archivo se comunica con mysql.php para obtener los metodos


class MensajesModel extends Mysql
{

    

    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }

 
    public function selectMensajes()
    {

        $sql = "SELECT id_contacto, nombre_contacto, email_contacto, DATE_FORMAT(date_created, '%d%m%Y') as fecha FROM contactos
       ORDER BY id_contacto DESC";
        $request = $this->select_all($sql);
        return $request;
    }
   
public function selectMensaje(int $id_contacto){
      

        // Consulta

        $sql = "SELECT id_contacto, nombre_contacto, email_contacto, DATE_FORMAT(date_created, '%d%m%Y') as fecha, mensaje_contacto FROM contactos
         WHERE id_contacto = {$id_contacto}";
        $request = $this->select($sql);
        
        return $request;
}
}
