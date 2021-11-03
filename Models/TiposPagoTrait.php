<?php

require_once("Libraries/Core/Mysql.php");

trait TiposPagoTrait
{
    private $conexion;


    public function getTiposPago()
    {
        $this->conexion = new Mysql();
        $sql = "SELECT * FROM tipo_pago WHERE status_tipoPago  != 0";
        $request = $this->conexion->select_all($sql);
        
        return $request;
    }
}
