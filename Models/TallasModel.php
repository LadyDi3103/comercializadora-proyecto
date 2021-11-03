<?php

// este archivo se comunica con mysql.php para obtener los metodos


class TallasModel extends Mysql
{

    public $intIdTalla;
    public $intTalla;
    public $intStatusTalla;



    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }

    // Metodo insert para cateogrias
    public function insertTalla(int $talla, int $statusTalla)
    {
        $return = 0;
        $this->intTalla = $talla;
        $this->intStatusTalla = $statusTalla;



        $sql = "SELECT * FROM numeros_talla WHERE numero = '{$this->intTalla}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO numeros_talla (numero, status_talla) VALUES(?,?)";
            $arrData = array($this->intTalla, $this->intStatusTalla);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectTallas()
    {

        $sql = "SELECT * FROM numeros_talla
        WHERE status_talla !=0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectTalla(int $idTalla)
    {
        $this->intIdTalla = $idTalla;

        $sql = "SELECT * FROM numeros_talla
                WHERE id_numeroTalla = $this->intIdTalla";
        $request = $this->select($sql);
        return $request;
    }

    public function updateTalla(int $idTalla, int $talla,  int $statusTalla)
    {
        $this->intIdTalla = $idTalla;
        $this->intTalla = $talla;

        $this->intStatusTalla = $statusTalla;

        $sql = "SELECT * FROM numeros_talla WHERE numero = '{$this->intTalla}' AND id_numeroTalla != $this->intIdTalla";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE numeros_talla SET numero = ?,  status_talla = ? WHERE id_numeroTalla = $this->intIdTalla";
            $arrData = array(
                $this->intTalla,

                $this->intStatusTalla
            );
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }


    public function deleteTalla(int $idTalla)
    {
        $this->intIdTalla = $idTalla;
        // consulta para buscar en tabla producto el id de la color a eliminar
        $sql = "SELECT * FROM detalle_producto WHERE talla_id = $this->intIdTalla";
        $request = $this->select_all(($sql));
        // Validacion: si esta vacio no hay color asociado, entonces:
        if (empty($request)) {
            // update al estado de la tabla color(0 = eliminado, 1 = activo, 2 = inactivo)
            $query_delete = "UPDATE numeros_talla SET status_talla = ? WHERE id_numeroTalla = $this->intIdTalla";
            $arrData = array(0);
            $request = $this->update($query_delete, $arrData);
            if ($request) {
                $request = 'ok';
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }
}
