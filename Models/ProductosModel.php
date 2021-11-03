<?php

// este archivo se comunica con mysql.php para obtener los metodos


class ProductosModel extends Mysql
{

    public $intIdProducto;
    public $intCodigoProducto;
    public $strNombreProducto;
    public $strDescripcionProducto;
    public $intPrecioProducto;
    public $intStockTotal;
    public $intStatusProducto;
    public $intProveedorProducto;
    public $intCategoriaProducto;
    public $intColorProducto;
    public $strImagenProducto;
    public $strUrlProducto;




    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }



    public function selectProductos()
    {

        $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        WHERE p.status !=0";
        $request = $this->select_all($sql);
        return $request;
    }


    public function insertProducto(string $codigoProducto, string $nombreProducto,  string $descripcionProducto,  string $precioProducto, int $stockProducto, int $statusProducto, int $proveedorProducto, int $categoriaProducto, int $colorProducto, string $urlProducto)
    {


        $this->intCodigoProducto = $codigoProducto;
        $this->strNombreProducto = $nombreProducto;
        $this->strDescripcionProducto = $descripcionProducto;
        $this->intPrecioProducto = $precioProducto;
        $this->intStockTotal = $stockProducto;
        $this->intStatusProducto = $statusProducto;
        $this->intProveedorProducto = $proveedorProducto;
        $this->intCategoriaProducto = $categoriaProducto;
        $this->intColorProducto = $colorProducto;
        $this->strUrlProducto = $urlProducto;

        $return = 0;

        // Consulta

        $sql = "SELECT * FROM producto WHERE codigo_producto = '{$this->intCodigoProducto}'";
        $request = $this->select_all($sql);

        // Validacion, si la respuesta de la consulta esta vacia, entonces:

        if (empty($request)) {
            $query_insert = "INSERT INTO producto (codigo_producto, nombre_producto,descripcion_producto, precio_producto, stockTotal, status, proveedor_id, categoria_id, color_id, url_producto) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $arrData = array(

                $this->intCodigoProducto,
                $this->strNombreProducto,
                $this->strDescripcionProducto,
                $this->intPrecioProducto,
                $this->intStockTotal,
                $this->intStatusProducto,
                $this->intProveedorProducto,
                $this->intCategoriaProducto,
                $this->intColorProducto,
        $this->strUrlProducto 


            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            // Si la respuesta no esta vacia:
            $return = "exist";
        }
        return $return;
    }

      public function updateProducto(int $idProducto, string $codigoProducto, string $nombreProducto,  string $descripcionProducto,  string $precioProducto, int $stockProducto, int $statusProducto, int $proveedorProducto, int $categoriaProducto, int $colorProducto,string $urlProducto)
    {


        $this->intIdProducto = $idProducto;
        $this->intCodigoProducto = $codigoProducto;
        $this->strNombreProducto = $nombreProducto;
        $this->strDescripcionProducto = $descripcionProducto;
        $this->intPrecioProducto = $precioProducto;
        $this->intStockTotal = $stockProducto;
        $this->intStatusProducto = $statusProducto;
        $this->intProveedorProducto = $proveedorProducto;
        $this->intCategoriaProducto = $categoriaProducto;
        $this->intColorProducto = $colorProducto;
        $this->strUrlProducto = $urlProducto;


        $return = 0;

        // Consulta

        $sql = "SELECT * FROM producto WHERE codigo_producto = '{$this->intCodigoProducto}' AND id_producto != $this->intIdProducto";
        //    echo $sql;
        //    exit;
        $request = $this->select_all($sql);

        // Validacion, si la respuesta de la consulta esta vacia, entonces:

        if (empty($request)) {
            $query_update = "UPDATE producto SET codigo_producto=?, nombre_producto=?,descripcion_producto=?, precio_producto=?, stockTotal=?, status=?, proveedor_id=?, categoria_id=?, color_id=?, url_producto=? WHERE id_producto = $this->intIdProducto";
            $arrData = array(

                $this->intCodigoProducto,
                $this->strNombreProducto,
                $this->strDescripcionProducto,
                $this->intPrecioProducto,
                $this->intStockTotal,
                $this->intStatusProducto,
                $this->intProveedorProducto,
                $this->intCategoriaProducto,
                $this->intColorProducto,
                $this->strUrlProducto 
                

            );
            $request_update = $this->update($query_update, $arrData);
            $return = $request_update;
         
        } else {
            // Si la respuesta no esta vacia:
            $return = "exist";
        }
        return $return;
    }

    public function selectProducto(int $idProducto)
    {
        $this->intIdProducto = $idProducto;
        $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        p.proveedor_id,
                        pr.nombre_proveedor,
                        p.categoria_id,
                        c.nombre_categoria,
                        p.color_id,
                        co.nombre_color
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        WHERE id_producto = $this->intIdProducto";
        $request = $this->select($sql);
        return $request;
    }

    public function selectImagenes(int $idProducto)
    {
        $this->intIdProducto = $idProducto;
        $sql = "SELECT producto_id, imagen FROM imagen_producto WHERE producto_id = $this->intIdProducto";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertImagen(int $idProducto, string $imagenProducto)
    {
        $this->intIdProducto = $idProducto;
        $this->strImagenProducto = $imagenProducto;

        $query_insert = "INSERT INTO imagen_producto(producto_id, imagen) VALUES (?,?)";
        $arrData = array($this->intIdProducto,
        $this->strImagenProducto);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function deleteImagen(int $idProducto, string $imagenProducto)
    {

        $this->intIdProducto = $idProducto;
        $this->strImagenProducto = $imagenProducto;
        $query_delete = "DELETE FROM imagen_producto WHERE producto_id = $this->intIdProducto AND imagen = '{$this->strImagenProducto}'";
        $request_delete = $this->delete($query_delete);
        return $request_delete;
    }

    public function deleteProducto(int $idProducto)
    {
        $this->intIdProducto = $idProducto;
        $sql = "UPDATE producto SET status = ? WHERE id_producto = $this->intIdProducto";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;


    }
}
