<?php



class Categorias extends Controllers
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
        getPermisos(7);
    }

    public function Categorias()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Categorías";
        $data['page_title'] = "Categorías <small>V-SHOES</small>";
        $data['page_name'] = "Categorías";
        $data['page_functions_js'] = "functions_categorias.js";


        $this->views->getView($this, "Categorias", $data);
    }
    public function setCategoria()
    {
        if ($_POST) {

            if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listaEstados'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
            } else {
                $intIdCategoria = intval($_POST['idCategoria']);
                $strNombreCategoria = strClean($_POST['txtNombre']);
                $strDescripcionCategoria = strClean($_POST['txtDescripcion']);
                $intStatusCategoria = intval($_POST['listaEstados']);
                $fotoCategoria = $_FILES['foto'];
                $nombreFoto = $fotoCategoria['name'];
                $tipoFoto =  $fotoCategoria['type'];
                $urlTmp = $fotoCategoria['tmp_name'];
                $fecha = date('ymd');
                $hora = date('Hms');
                $strImgDefault = 'portada_categoria.png';
                $request_SetCategoria = "";
                $url = strtolower(clearString($strNombreCategoria));
                $url = str_replace(" ", "-", $url);
                if ($nombreFoto != '') {
                    $strImgDefault = 'img_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                }


                if ($intIdCategoria == 0) {
                    if ($_SESSION['modulos']['w']) {
                        //   Enviamos informacion al modelo RolesModel.php
                        // Insertar CAtegoria nuevo
                        $request_SetCategoria = $this->model->insertCategoria($strNombreCategoria, $strDescripcionCategoria, $strImgDefault, $intStatusCategoria, $url);
                        $option = 1;
                    }
                } else {
                    if ($_SESSION['modulos']['u']) {
                        if ($nombreFoto == '') {
                            if ($_POST['fotoActualizada'] != 'portada_categoria.png' && $_POST['fotoDesactualizada'] == 0) {
                                $strImgDefault = $_POST['fotoActualizada'];
                            }
                        }
                        // Actualizar CAtegoria existente
                        $request_SetCategoria = $this->model->updateCategoria($intIdCategoria, $strNombreCategoria, $strDescripcionCategoria, $strImgDefault, $intStatusCategoria, $url);
                        $option = 2;
                    }
                }
                // Validacion para la respuesta del metodo insertCAtegoria
                if ($request_SetCategoria > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                        if ($nombreFoto != "") {
                            uploadImage($fotoCategoria, $strImgDefault);
                        }
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                        if ($nombreFoto != "") {
                            uploadImage($fotoCategoria, $strImgDefault);
                        }
                        if (($nombreFoto == '' && $_POST['fotoDesactualizada'] == 1 && $_POST['fotoActualizada'] != 'portada_categoria.png')
                            || ($nombreFoto != '' && $_POST['fotoActualizada'] != 'portada_categoria.png')
                        ) {
                            deleteFile($_POST['fotoActualizada']);
                        }
                    }
                } elseif ($request_SetCategoria == "exist") {
                    $arrResponse = array('status' => false, 'msg' => "La categoria ya existe.");
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getCategorias()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectCategorias();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';
                if ($arrData[$i]['status_categoria'] == 1) {
                    $arrData[$i]['status_categoria'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status_categoria'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewCategoria" onClick="fntViewCategoria(' . $arrData[$i]['id_categoria'] . ')" title="Ver Categoria"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm btnEditCategoria" onClick="fntEditCategoria(this,' . $arrData[$i]['id_categoria'] . ')" title="Editar Categoria"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteCategoria" onClick="fntDeleteCategoria(' . $arrData[$i]['id_categoria'] . ')" title="Eliminar Categoria"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getCategoria(int $idCategoria)
    {
        if ($_SESSION['modulos']['r']) {
            $intIdCategoria = intval($idCategoria);
            if ($intIdCategoria > 0) {
                $arrData = $this->model->selectCategoria($intIdCategoria);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, "msg" => 'Datos no encontrados.');
                } else {
                    $arrData['url_img'] = media() . '/images/uploads/' . $arrData['imagen_categoria'];
                    $arrResponse = array('status' => true, "data" => $arrData);
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delCategoria()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdCategoria = intval($_POST['idCategoria']);
                $request_deleteCategoria = $this->model->deleteCategoria($intIdCategoria);
                if ($request_deleteCategoria == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoria.');
                } elseif ($request_deleteCategoria == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar la categoria, esta asociada a un producto.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoria.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getSelectCategorias()
    {
        $options = "";
        $arrData = $this->model->selectCategorias();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count(($arrData)); $i++) {
                if ($arrData[$i]['status_categoria'] == 1) {
                    $options .= '<option value = "' . $arrData[$i]['id_categoria'] . '">' . $arrData[$i]['nombre_categoria'] . '</option>';
                }
            }
        }
        echo $options;
        die();
    }
}
