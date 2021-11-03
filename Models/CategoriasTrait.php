<?php

require_once("Libraries/Core/Mysql.php");

trait CategoriasTrait
{
    private $conexion;


    public function getCategoriasTrait(string $categorias)
    {
        $this->conexion = new Mysql();
        $sql = "SELECT id_categoria, nombre_categoria, descripcion_categoria , imagen_categoria, url_categoria  FROM categorias
        WHERE status_categoria = 1  AND id_categoria IN ($categorias)";
        $request = $this->conexion->select_all($sql);
        if (count($request) > 0) {
            for ($i = 0; $i < count($request); $i++) {
                $request[$i]['imagen_categoria'] = BASE_URL . '/Assets/images/uploads/' . $request[$i]['imagen_categoria'];
            }
        }
        return $request;
    }
}
