<?php



class Productos extends Controllers
{

    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
        //    generar id de sesion
        // session_regenerate_id(true);
        //  validacion, si la variable de sesion esta vacia:

        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        // el numero en la funcion getPermisos es el ID del modulo, si cambia en la BD, lo cambiamos en la funcion
        getPermisos(4);
    }

    public function Productos()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Productos";
        $data['page_title'] = "Productos <small>V-SHOES</small>";
        $data['page_name'] = "Productos";
        $data['page_functions_js'] = "functions_productos.js";


        $this->views->getView($this, "Productos", $data);
    }

    public function getProductos()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectProductos();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';
                if ($arrData[$i]['status'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                $arrData[$i]['precio_producto'] = SMONEYAFTER . '' . formatMoney($arrData[$i]['precio_producto']) . ' ' . SMONEYBEFORE;
                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewProducto" onClick="fntViewProducto( ' . $arrData[$i]['id_producto'] . ')" title="Ver Producto"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm btnEditProducto" onClick="fntEditProducto(this,' . $arrData[$i]['id_producto'] . ')" title="Editar Producto"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteProducto" onClick="fntDeleteProducto(' . $arrData[$i]['id_producto'] . ')" title="Eliminar Producto"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function setProducto()
    {
        if ($_POST) {
            // dep($_POST);
            // die();
            if (empty($_POST['txtCodigo']) || empty($_POST['txtNombre']) ||  empty($_POST['txtPrecio']) || empty($_POST['listaCategorias']) || empty($_POST['listaEstados']) || empty($_POST['listaColores']) || empty($_POST['listaProveedores'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
            } else {
                $intIdProducto = intval($_POST['idProducto']);
                $strCodigoProducto = strClean($_POST['txtCodigo']);
                $strNombreProducto = strClean($_POST['txtNombre']);
                $strDescripcionProducto = strClean($_POST['txtDescripcion']);
                $strPrecioProducto = strClean($_POST['txtPrecio']);
                $intStockProducto = intval($_POST['txtStock']);
                $intStatusProducto = intval($_POST['listaEstados']);
                $intProveedorProducto = intval($_POST['listaProveedores']);
                $intCategoriaProducto = intval($_POST['listaCategorias']);
                $intColorProducto = intval($_POST['listaColores']);
                $request_SetProducto = "";

                $url = strtolower(clearString($strNombreProducto));
                $url = str_replace(" ","-", $url);

                if ($intIdProducto == 0) {
                    $option = 1;
                    if ($_SESSION['modulos']['w']) {
                        $request_SetProducto = $this->model->insertProducto(
                            $strCodigoProducto,
                            $strNombreProducto,
                            $strDescripcionProducto,
                            $strPrecioProducto,
                            $intStockProducto,
                            $intStatusProducto,
                            $intProveedorProducto,
                            $intCategoriaProducto,
                            $intColorProducto,
                            $url
                        );
                    }
                } else {
                    $option = 2;
                    if ($_SESSION['modulos']['u']) {
                        $request_SetProducto = $this->model->updateProducto(
                            $intIdProducto,
                            $strCodigoProducto,
                            $strNombreProducto,
                            $strDescripcionProducto,
                            $strPrecioProducto,
                            $intStockProducto,
                            $intStatusProducto,
                            $intProveedorProducto,
                            $intCategoriaProducto,
                            $intColorProducto,
                            $url
                        );
                    }
                }
                // Validacion para la respuesta del metodo insertCAtegoria
                if ($request_SetProducto > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'id_producto' => $request_SetProducto, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'id_producto' => $request_SetProducto, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_SetProducto == "exist") {
                    $arrResponse = array('status' => false, 'msg' => "El producto ya existe.");
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getProducto($idProducto)
    {
        if ($_SESSION['modulos']['r']) {
            $intIdProducto = intval($idProducto);

            if ($intIdProducto > 0) {
                $arrData = $this->model->selectProducto($intIdProducto);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrImagenes = $this->model->selectImagenes($idProducto);
                    if (count($arrImagenes) > 0) {
                        for ($i = 0; $i < count($arrImagenes); $i++) {
                            $arrImagenes[$i]['url_imagen'] =  media() . '/images/uploads/' . $arrImagenes[$i]['imagen'];
                        }
                    }
                    $arrData['imagenes'] = $arrImagenes;
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                // dep($arrResponse);
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }
        }
    }

    public function setImagen()
    {

        if ($_POST) {

            if (empty($_POST['idproducto'])) {
                $arrResponse = array('status' => false, 'msg' => "Error en los datos.");
            } else {
                $intIdProducto = intval($_POST['idproducto']);

                $imagenProducto =  $_FILES['foto'];
                $nombreImagenProducto = 'prcto_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                $request_SetImagen = $this->model->insertImagen($intIdProducto, $nombreImagenProducto);

                if ($request_SetImagen) {
                    $uploadImagen = uploadImage($imagenProducto, $nombreImagenProducto);
                    $arrResponse = array('status' => true, 'imgnombre' => $nombreImagenProducto, 'msg' => 'Imagen guardada correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => "No es posible almacenar la imagen.");
                }
            }


            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }



        die();
    }

    public function deleteFile()
    {
        if ($_POST) {

            if (empty($_POST['idProducto']) || empty($_POST['foto'])) {
                $arrResponse = array('status' => false, 'msg' => "Error en los datos.");
            } else {
                $intIdProducto = intval($_POST['idProducto']);

                $imagenNombre =  strClean($_POST['foto']);
                $requestImagen = $this->model->deleteImagen($intIdProducto, $imagenNombre);
                if ($requestImagen) {
                    $deleteImagen = deleteFile($imagenNombre);
                    $arrResponse = array('status' => true, 'msg' => 'Imagen eliminada correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => "No es posible eliminar la imagen.");
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }


    public function delProducto()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdProducto = intval($_POST['idProducto']);
                $request_DeleteProducto = $this->model->deleteProducto($intIdProducto);
                if ($request_DeleteProducto) {
                    $arrResponse = array('status' => true, 'msg' => 'El producto ha sido eliminad correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se ha podido eliminar el  producto.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }


    public function getSelectProductos()
    {
        $options = "";
        $arrData = $this->model->selectProductos();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count(($arrData)); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $options .= '<option value = "' . $arrData[$i]['id_producto'] . '">' . $arrData[$i]['nombre_producto'] . '</option>';
                }
            }
        }
        echo $options;
        die();
    }

}
