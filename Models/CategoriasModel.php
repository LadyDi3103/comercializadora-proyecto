<?php

// este archivo se comunica con mysql.php para obtener los metodos


class CategoriasModel extends Mysql
{

    public $intIdCategoria;
    public $strNombreCategoria;
    public $strDescripcionCategoria;
    public $strImgCategoria;
    public $intStatusCategoria;
    public $strUrlCategoria;




    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }

    // Metodo insert para cateogrias
    public function insertCategoria(string $nombreCategoria, string $descripcionCategoria, string $imgCategoria, int $statusCategoria, string $urlCategoria)
    {
        $return = 0;
        $this->strNombreCategoria = $nombreCategoria;
        $this->strDescripcionCategoria = $descripcionCategoria;
        $this->strImgCategoria = $imgCategoria;
        $this->intStatusCategoria = $statusCategoria;
        $this->strUrlCategoria = $urlCategoria;



        $sql = "SELECT * FROM categorias WHERE nombre_categoria = '{$this->strNombreCategoria}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO categorias(nombre_categoria, descripcion_categoria, imagen_categoria, status_categoria, url_categoria) VALUES(?,?,?,?,?)";
            $arrData = array($this->strNombreCategoria, $this->strDescripcionCategoria, $this->strImgCategoria, $this->intStatusCategoria, $this->strUrlCategoria);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectCategorias()
    {

        $sql = "SELECT * FROM categorias
        WHERE status_categoria !=0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCategoria(int $idCategoria)
    {
        $this->intIdCategoria = $idCategoria;

        $sql = "SELECT * FROM categorias
                WHERE id_categoria = $this->intIdCategoria";
        $request = $this->select($sql);
        return $request;
    }

    public function updateCategoria(int $idCategoria, string $nombreCategoria, string $descripcionCategoria, string $imgCategoria, int $statusCategoria, string $urlCategoria)
    {
        $this->intIdCategoria = $idCategoria;
        $this->strNombreCategoria = $nombreCategoria;
        $this->strDescripcionCategoria = $descripcionCategoria;
        $this->strImgCategoria = $imgCategoria;
        $this->intStatusCategoria = $statusCategoria;
        $this->strUrlCategoria = $urlCategoria;


        $sql = "SELECT * FROM categorias WHERE nombre_categoria = '{$this->strNombreCategoria}' AND id_categoria != $this->intIdCategoria";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE categorias SET nombre_categoria = ?, descripcion_categoria = ?, imagen_categoria = ?, status_categoria = ?, url_categoria = ? WHERE id_categoria = $this->intIdCategoria";
            $arrData = array(
                $this->strNombreCategoria,
                $this->strDescripcionCategoria,
                $this->strImgCategoria,
                $this->intStatusCategoria,
                $this->strUrlCategoria
            );
            $request = $this->update($sql, $arrData);
        }else{
            $request = "exist";
        }
        return $request;
    }

    public function deleteCategoria(int $idCategoria)
    {
        $this->intIdCategoria = $idCategoria;
        // consulta para buscar en tabla producto el id de la categoria a eliminar
        $sql = "SELECT * FROM producto WHERE categoria_id = $this->intIdCategoria";
        $request = $this->select_all(($sql));
        // Validacion: si esta vacio no hay rol asociado, entonces:
        if (empty($request)) {
            // update al estado de la tabla rol (0 = eliminado, 1 = activo, 2 = inactivo)
            $query_delete = "UPDATE categorias SET status_categoria = ? WHERE id_categoria = $this->intIdCategoria";
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
