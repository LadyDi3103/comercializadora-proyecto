<?php

// este archivo se comunica con mysql.php para obtener los metodos


class ProveedoresModel extends Mysql
{
    private $intIdProveedor;
    private $strNombreProveedor;
    private $strTelefonoProveedor;
    private $strEmailProveedor;
    public $intStatusProveedor;


    public function __construct()
    {

        parent::__construct();
    }

    public function insertProveedor(string $nombreProveedor,  string $telefonoProveedor, string $emailProveedor, int $statusProveedor)
    {


        $this->strNombreProveedor = $nombreProveedor;

        $this->strTelefonoProveedor = $telefonoProveedor;
        $this->strEmailProveedor = $emailProveedor;
        $this->intStatusProveedor = $statusProveedor;

        $return = 0;

        // Consulta

        $sql = "SELECT * FROM proveedor WHERE email_proveedor = '{$this->strEmailProveedor}'";
        $request = $this->select_all($sql);

        // Validacion, si la respuesta de la consulta esta vacia, entonces:

        if (empty($request)) {
            $query_insert = "INSERT INTO proveedor (nombre_proveedor,  telefono_proveedor, email_proveedor, status_proveedor) VALUES (?,?,?,?)";
            $arrData = array(

                $this->strNombreProveedor,
                $this->strTelefonoProveedor,
                $this->strEmailProveedor,
                $this->intStatusProveedor,

            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            // Si la respuesta no esta vacia:
            $return = "exist";
        }
        return $return;
    }

    public function selectProveedores()
    {

        $sql = "SELECT * FROM proveedor
        WHERE status_proveedor !=0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectProveedor(int $idProveedor)
    {
        $this->intIdProveedor = $idProveedor;
        $sql = "SELECT id_proveedor, nombre_proveedor, telefono_proveedor, email_proveedor,status_proveedor,
       DATE_FORMAT(date_created, '%d-%m-%Y') as fechaRegistro
        FROM proveedor 
        WHERE id_proveedor = $this->intIdProveedor";
        // echo $sql; exit;
        $request = $this->select($sql);
        return $request;
    }

    public function updateProveedor(int $idProveedor,  string $nombreProveedor,  string $telefonoProveedor, string $emailProveedor, int $statusProveedor)
    {
        $this->intIdProveedor = $idProveedor;

        $this->strNombreProveedor = $nombreProveedor;

        $this->strTelefonoProveedor = $telefonoProveedor;
        $this->strEmailProveedor = $emailProveedor;
        $this->intStatusProveedor = $statusProveedor;


        // Validacion para  email existentes

        $sql = "SELECT * FROM proveedor WHERE (email_proveedor= '{$this->strEmailProveedor}' AND id_proveedor!= $this->intIdProveedor)";

        $request = $this->select_all($sql);

        // Valdiacion: si no trae registro se procede a actualizar
        if (empty($request)) {


            $sql = "UPDATE proveedor SET  nombre_proveedor=?,  telefono_proveedor=?, email_proveedor=?, status_proveedor=?
                WHERE id_proveedor = $this->intIdProveedor";
            $arrData = array(

                $this->strNombreProveedor,

                $this->strTelefonoProveedor,
                $this->strEmailProveedor,
                $this->intStatusProveedor,

            );

            $request = $this->update($sql, $arrData);
        } else {

            $request = "exist";
        }
        return $request;
    }

    public function deleteProveedor(int $idProveedor)
    {
         
        $this->intIdProveedor = $idProveedor;
        // consulta para buscar en tabla producto el id del proveedor a eliminar

        $sql = "SELECT * FROM producto WHERE proveedor_id = $this->intIdProveedor";
        $request = $this->select_all(($sql));


        // Validacion: si esta vacio no hay proveedor asociado, entonces:
        if (empty($request)) {
            // update al estado de la tabla proveedor (0 = eliminado, 1 = activo, 2 = inactivo)
            $query_delete = "UPDATE proveedor SET status_proveedor = ? WHERE id_proveedor = $this->intIdProveedor";
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
