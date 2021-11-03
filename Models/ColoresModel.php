<?php

// este archivo se comunica con mysql.php para obtener los metodos


class ColoresModel extends Mysql
{

    public $intIdColor;
    public $strNombreColor;
    public $intStatusColor;



    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }

    // Metodo insert para cateogrias
    public function insertColor(string $nombreColor, int $statusColor)
    {
        $return = 0;
        $this->strNombreColor = $nombreColor;
        $this->intStatusColor = $statusColor;



        $sql = "SELECT * FROM colores WHERE nombre_color = '{$this->strNombreColor}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO colores (nombre_color, status_color) VALUES(?,?)";
            $arrData = array($this->strNombreColor, $this->intStatusColor);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    
    public function selectColores()
    {

        $sql = "SELECT * FROM colores
        WHERE status_color !=0";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectColor(int $idColor)
    {
        $this->intIdColor = $idColor;

        $sql = "SELECT * FROM colores
                WHERE id_color = $this->intIdColor";
        $request = $this->select($sql);
        return $request;
    }

    public function updateColor(int $idColor, string $nombreColor,  int $statusColor)
    {
        $this->intIdColor = $idColor;
        $this->strNombreColor = $nombreColor;
        
        $this->intStatusColor = $statusColor;

        $sql = "SELECT * FROM colores WHERE nombre_color = '{$this->strNombreColor}' AND id_color != $this->intIdColor";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE colores SET nombre_color = ?,  status_color = ? WHERE id_color = $this->intIdColor";
            $arrData = array(
                $this->strNombreColor,
                
                $this->intStatusColor
            );
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteColor(int $idColor)
    {
        $this->intIdColor = $idColor;
        // consulta para buscar en tabla producto el id de la color a eliminar
        $sql = "SELECT * FROM producto WHERE color_id = $this->intIdColor";
        $request = $this->select_all(($sql));
        // Validacion: si esta vacio no hay color asociado, entonces:
        if (empty($request)) {
            // update al estado de la tabla color(0 = eliminado, 1 = activo, 2 = inactivo)
            $query_delete = "UPDATE colores SET status_color = ? WHERE id_color = $this->intIdColor";
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
