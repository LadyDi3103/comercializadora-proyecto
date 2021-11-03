<?php

require_once("Libraries/Core/Mysql.php");

trait ProductosTrait
{
    private $conexion;
    private $strCategoria;
    private $intIdCategoria;
    private $intIdProducto;
    private $strProducto;
    private $intCantidadProductos;
    private $strOpcion;
    private $strUrl;


    public function getProductosTrait()
    {

        $this->conexion = new Mysql();

        $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color,
                        p.url_producto
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        -- pasar al hosting
        WHERE p.status = 1 and p.status != 0 ORDER BY p.id_producto DESC";
        $request = $this->conexion->select_all($sql);
        if (count($request) > 0) {
            for ($p = 0; $p < count($request); $p++) {
                $intIdProducto = $request[$p]['id_producto'];

                $sqlImagenes = "SELECT producto_id, imagen FROM imagen_producto WHERE producto_id = $intIdProducto";
                $arrImagenes = $this->conexion->select_all($sqlImagenes);
                if (count($arrImagenes) > 0) {
                    for ($i = 0; $i < count($arrImagenes); $i++) {
                        $arrImagenes[$i]['url_imagen'] = media() . '/images/uploads/' . $arrImagenes[$i]['imagen'];
                    }
                }
                $request[$p]['imagenes'] = $arrImagenes;
            }
        }
        return $request;
    }
    public function getProductosCategorias(int $idCategoria,string $url)
    {

        $this->intIdCategoria = $idCategoria;
        $this->strUrl = $url;
        $this->conexion = new Mysql();
        $sql_categorias = "SELECT id_categoria,nombre_categoria FROM categorias WHERE id_categoria = '{$this->intIdCategoria}'";
        $request = $this->conexion->select($sql_categorias);
        if (!empty($request)) {

            $this->strCategoria = $request['nombre_categoria'];
            $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color,
                        p.url_producto
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        WHERE  p.status = 1 and p.status != 0 AND p.categoria_id = $this->intIdCategoria AND c.url_categoria = '{$this->strUrl}' ";
            $request = $this->conexion->select_all($sql);
            if (count($request) > 0) {
                for ($p = 0; $p < count($request); $p++) {
                    $intIdProducto = $request[$p]['id_producto'];

                    $sqlImagenes = "SELECT imagen FROM imagen_producto WHERE producto_id = $intIdProducto";
                    $arrImagenes = $this->conexion->select_all($sqlImagenes);
                    if (count($arrImagenes) > 0) {
                        for ($i = 0; $i < count($arrImagenes); $i++) {
                            $arrImagenes[$i]['url_imagen'] = media() . '/images/uploads/' . $arrImagenes[$i]['imagen'];
                        }
                    }
                    $request[$p]['imagenes'] = $arrImagenes;
                }
            }
            $request = array(
                'id_categoria'=> $this->intIdCategoria,
                'categoria'=> $this->strCategoria,
                'productos'=> $request
                
            );
        }







        return $request;
    }


    public function getProductoTrait(int $idProducto, string $url)
    {

        $this->conexion = new Mysql();
        $this->intIdProducto=$idProducto;
        $this->strUrl = $url;

        $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        p.categoria_id,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color,
                        p.url_producto,
                        c.url_categoria
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        WHERE p.status != 0 AND p.id_producto = '{$this->intIdProducto}' AND p.url_producto = '{$this->strUrl}'";
        $request = $this->conexion->select($sql);
        if (!empty($request) > 0) {

            $intIdProducto = $request['id_producto'];

            $sqlImagenes = "SELECT producto_id, imagen FROM imagen_producto WHERE producto_id = $intIdProducto";
            $arrImagenes = $this->conexion->select_all($sqlImagenes);
            if (count($arrImagenes) > 0) {
                for ($i = 0; $i < count($arrImagenes); $i++) {
                    $arrImagenes[$i]['url_imagen'] = media() . '/images/uploads/' . $arrImagenes[$i]['imagen'];
                }
            }
            $request['imagenes'] = $arrImagenes;
        }

        return $request;
    }
    
    public function getProductosRand(int $idCategoria, int $cantidadProductos, string $opcion)
    {
        $this->intIdCategoria = $idCategoria;
        $this->intCantidadProductos = $cantidadProductos;
        $this->strOpcion = $opcion;
        $this->conexion = new Mysql();

        
        if ($opcion == "r") {
            $this->strOpcion = " RAND() ";
        } elseif ($opcion == "a") {
            $this->strOpcion = " id_producto ASC ";
        } elseif ($opcion == "d") {
            $this->strOpcion = " id_producto DESC ";
        }
        $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color,
                        p.url_producto
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        WHERE p.status !=0 AND p.categoria_id = $this->intIdCategoria
        ORDER BY $this->strOpcion LIMIT  $this->intCantidadProductos";
        // echo $sql;exit;

        $request = $this->conexion->select_all($sql);
        if (count($request) > 0) {
            for ($p = 0; $p < count($request); $p++) {
                $intIdProducto = $request[$p]['id_producto'];

                $sqlImagenes = "SELECT imagen FROM imagen_producto WHERE producto_id = $intIdProducto";
                $arrImagenes = $this->conexion->select_all($sqlImagenes);
                if (count($arrImagenes) > 0) {
                    for ($i = 0; $i < count($arrImagenes); $i++) {
                        $arrImagenes[$i]['url_imagen'] = media() . '/images/uploads/' . $arrImagenes[$i]['imagen'];
                    }
                }
                $request[$p]['imagenes'] = $arrImagenes;
            }
        }




        



        return $request;
    }
    
    public function getIdProductoTrait(int $idProducto)
    {
    
        $this->conexion = new Mysql();
        $this->intIdProducto=$idProducto;
      
        $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        p.categoria_id,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color,
                        p.url_producto,
                        c.url_categoria
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        WHERE p.status != 0 AND p.id_producto = '{$this->intIdProducto}'";
        $request = $this->conexion->select($sql);
        if (!empty($request) > 0) {
    
            $intIdProducto = $request['id_producto'];
    
            $sqlImagenes = "SELECT producto_id, imagen FROM imagen_producto WHERE producto_id = $intIdProducto";
            $arrImagenes = $this->conexion->select_all($sqlImagenes);
            if (count($arrImagenes) > 0) {
                for ($i = 0; $i < count($arrImagenes); $i++) {
                    $arrImagenes[$i]['url_imagen'] = media() . '/images/uploads/' . $arrImagenes[$i]['imagen'];
                }
            }else{
                $arrImagenes[0]['url_imagen'] = media() . '/images/uploads/portada_categoria.png';
            }
            $request['imagenes'] = $arrImagenes;
        }
    
        return $request;
    }
   
public function cantidadProd($busqueda)
{
       $this->conexion = new Mysql();
    $sql_select = "SELECT COUNT(*) as total_productos FROM producto WHERE nombre_producto LIKE '%$busqueda%' AND status =  1 "; 
    $respuesta = $this->conexion->select($sql_select);
    $total_productos = $respuesta;
    return $total_productos;
}
public function getProdBusqueda($busqueda,$desde, $prodPagina)
{
    $this->conexion = new Mysql();

 $sql = "SELECT p.id_producto,
                        p.codigo_producto,
                        p.nombre_producto,
                        p.descripcion_producto,
                        p.precio_producto,
                        p.stockTotal,
                        p.status,
                        pr.nombre_proveedor,
                        c.nombre_categoria,
                        co.nombre_color,
                        p.url_producto
        
        FROM producto p
        INNER JOIN proveedor pr ON p.proveedor_id = pr.id_proveedor
        INNER JOIN categorias c ON p.categoria_id = c.id_categoria
        INNER JOIN colores co ON p.color_id = co.id_color
        
        WHERE p.status = 1 and p.nombre_producto LIKE '%$busqueda%' ORDER BY p.id_producto DESC LIMIT $desde, $prodPagina";
       
       $request = $this->conexion->select_all($sql);

      if(count($request) > 0){
					for ($pr=0; $pr < count($request) ; $pr++) { 
						$intIdProducto = $request[$pr]['id_producto'];
						$sqlImg = "SELECT imagen
								FROM imagen_producto
								WHERE producto_id = $intIdProducto";
						$arrImg = $this->conexion->select_all($sqlImg);
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_imagen'] = media().'/images/uploads/'.$arrImg[$i]['imagen'];
							}
						}
						$request[$pr]['imagenes'] = $arrImg;
					}
				}
		return $request;


}


}
