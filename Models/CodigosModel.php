<?php

// este archivo se comunica con mysql.php para obtener los metodos


class CodigosModel extends Mysql
{

   
    public $intProducto;
    public $strUrl;
    public $intCodigo;



    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }

    // Metodo insert para cateogrias
   
    public function selectCodigos()
    {

        $sql = "SELECT cd.id_codigo, cd.producto_id, cd.url, p.nombre_producto
         FROM codigos_qr cd
         INNER JOIN producto p on cd.producto_id = p.id_producto
        ";
        $request = $this->select_all($sql);
        return $request;
    }

   public function insertCodigo(int $producto, string $url)
   {
    
        $this->intProducto= $producto;
        $this->strUrl = $url;


        $sql = "SELECT * FROM codigos_qr WHERE producto_id = '{$this->intProducto}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO codigos_qr (producto_id, url) VALUES(?,?)";
            $arrData = array($this->intProducto, $this->strUrl);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
   }


    public function selectCodigo(int $idCodigo)
    {
        $this->intCodigo = $idCodigo;

        $sql = "SELECT cd.id_codigo, cd.producto_id, cd.url, p.nombre_producto
         FROM codigos_qr cd
         INNER JOIN producto p on cd.producto_id = p.id_producto
                WHERE id_codigo = $this->intCodigo";
        $request = $this->select($sql);
        return $request;
    }
}
