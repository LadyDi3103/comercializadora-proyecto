<?php

// este archivo se comunica con mysql.php para obtener los metodos


class PermisosModel extends Mysql
{

    public $intIdPermiso;
    public $intRolId;
    public $intModuloId;
    public $r;
    public $w;
    public $u;
    public $d;

    public function __construct()
    {

        parent::__construct();
    }

    public function selectModulos()
    {
        $sql = "SELECT * FROM modulo WHERE status_modulo != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPermisosRol(int $rolId)
    {
        $this->intRolId = $rolId;
        $sql = "SELECT * FROM permisos WHERE rol_id = $this->intRolId";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deletePermisos(int $idRol)
    {
        $this->intRolId = $idRol;
        $sql = "DELETE FROM permisos WHERE rol_id = $this->intRolId";
        $request = $this->delete($sql);
        return $request;
    }

    public function insertPermiso(int $idRol, int $idModulo, int $r, int $w, int $u, int $d)
    {

        $this->intRolId = $idRol;
        $this->intModuloId = $idModulo;
        $this->r = $r;
        $this->w = $w;
        $this->u = $u;
        $this->d = $d;

        $query_insert = "INSERT INTO permisos(rol_id, modulo_id, r, w, u, d) VALUES (?,?,?,?,?,?)";
        $arrData = array($this->intRolId, $this->intModuloId, $this->r, $this->w, $this->u, $this->d);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }
    
    public function permisosModulo(int $idRol)
    {
        $this->intRolId = $idRol;

        $sql = "SELECT p.rol_id, p.modulo_id, m.titulo_modulo as modulo, p.r, p.w, p.u, p.d FROM permisos p
        INNER JOIN modulo m ON p.modulo_id = m.id_modulo
        WHERE p.rol_id = $this->intRolId";

        $request = $this->select_all($sql);
        // dep($request);
        // crear un array
        $arrPermisos = array();
        // ciclo para recorrer los elementos de request
        for ($i=0; $i < count($request) ; $i++) { 
            $arrPermisos[$request[$i]['modulo_id']] = $request[$i];
        }
        return $arrPermisos;
        // dep($arrPermisos);

       
    }
}
?>