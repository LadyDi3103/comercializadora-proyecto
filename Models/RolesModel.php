<?php

// este archivo se comunica con mysql.php para obtener los metodos


class RolesModel extends Mysql
{
    // propiedades del rol
    public $intIdRol;
    public $strNombreRol;
    public $strDescripcionRol;
    public $intStatusRol;

    public function __construct()
    {

        parent::__construct();
    }

    // Metodo select para roles

    public function selectRoles()
    {
        $admin = "";
        if ($_SESSION['idUsuario'] != 1) {
            $admin = " and id_rol != 1";
        }
        $sql = "SELECT * FROM rol WHERE status_rol !=0".$admin;
        $request = $this->select_all($sql);
        return $request;
    }
    // Metodo select para un rol
    public function selectRol(int $idRol)
    {
        
        $this->intIdRol = $idRol;
        $query_select = "SELECT * FROM rol WHERE id_rol =  $this->intIdRol";
        $request = $this->select($query_select);
        return $request;
    }

    // Metodo insert para roles
    public function insertRol(string $nombreRol, string $descripcionRol, int $statusRol)
    {
        $return = "";
        $this->strNombreRol = $nombreRol;
        $this->strDescripcionRol = $descripcionRol;
        $this->intStatusRol = $statusRol;

        //    Consulta rol, si existe el nombre del rol

        $sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strNombreRol}'";
        $request = $this->select_all($sql);

        // Validacion si no existe el rol
        if (empty($request)) {
            $query_insert = "INSERT INTO rol(nombre_rol, descripcion_rol, status_rol) VALUES(?,?,?)";
            $arrData = array($this->strNombreRol, $this->strDescripcionRol, $this->intStatusRol);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // Metodo update para un rol
    public function updateRol(int $idRol, string $nombreRol, string $descripcionRol, int $statusRol)
    {
        // Asignar propiedades
        $this->intIdRol = $idRol;
        $this->strNombreRol = $nombreRol;
        $this->strDescripcionRol = $descripcionRol;
        $this->intStatusRol = $statusRol;

        $sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strNombreRol}' AND id_rol != $this->intIdRol";
        $request = $this->select_all($sql);
        // Validacion, si la respuesta es vacia, hace el update
        if (empty($request)) {
            $query_update = "UPDATE rol SET nombre_rol = ?, descripcion_rol = ?, status_rol = ? WHERE id_rol = $this->intIdRol";

            $arrData = array($this->strNombreRol, $this->strDescripcionRol, $this->intStatusRol);
            $request = $this->update($query_update, $arrData);
        } else {
            $request = "exist";
        }

        return $request;
    }

    // Metodo para eliminar un rol
    public function deleteRol(int $idRol)
    {
        $this->intIdRol = $idRol;
        // consulta para buscar en tabla persona el id del rol a eliminar
        $sql = "SELECT * FROM persona WHERE rol_id = $this->intIdRol";
        $request = $this->select_all(($sql));
        // Validacion: si esta vacio no hay rol asociado, entonces:
        if (empty($request)) {
            // update al estado de la tabla rol (0 = eliminado, 1 = activo, 2 = inactivo)
        $query_delete = "UPDATE rol SET status_rol = ? WHERE id_rol = $this->intIdRol";
        $arrData = array(0);
        $request = $this->update($query_delete, $arrData);
        if ($request) {
            $request = 'ok';
        }else{
            $request = 'error';
        }
        }else{
            $request = 'exist';
        }
        return $request;
    }
}
