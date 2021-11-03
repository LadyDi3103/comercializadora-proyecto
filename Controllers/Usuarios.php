<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Usuarios extends Controllers
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
        getPermisos(2);
    }

    public function Usuarios()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = "Usuarios <small>V-SHOES</small>";
        $data['page_name'] = "Usuarios";
        $data['page_functions_js'] = "functions_usuarios.js";


        $this->views->getView($this, "Usuarios", $data);
    }

    public function setUsuario()
    {
        if ($_POST) {
            // dep($_POST);
            // die();

            // Validacion datos vacios
            if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombresUsuario']) || empty($_POST['txtApellidosUsuario']) || empty($_POST['strTelefonoUsuario']) || empty($_POST['txtEmailUsuario'])  || empty($_POST['listaRoles']) || empty($_POST['listaEstados'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdUsuario = intval($_POST['idUsuario']);
                $strIdentificacion = strClean($_POST['txtIdentificacion']);
                $strNombresUsuario = ucwords(strClean($_POST['txtNombresUsuario']));
                $strApellidosUsuario = ucwords(strClean($_POST['txtApellidosUsuario']));
                $strTelefonoUsuario = strClean($_POST['strTelefonoUsuario']);
                $strEmailUsuario = strtolower(strClean($_POST['txtEmailUsuario']));

                $intTipoUsuario = intval(strClean($_POST['listaRoles']));
                $intEstado = intval(strClean($_POST['listaEstados']));
                $request_SetUser  = "";
                // Validacion de id, si es 0 no se envia, entonces se crea un usuario
                // Si se envia un id significa que se actualizarán los datos
                if ($intIdUsuario == 0) {
                    // Validacion para contraseña
                    $option = 1;
                    $strPassword = empty($_POST['txtPassUsuario']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassUsuario']);
                    if ($_SESSION['modulos']['w']) {
                        $request_SetUser = $this->model->insertUsuario(
                            $strIdentificacion,
                            $strNombresUsuario,
                            $strApellidosUsuario,
                            $strTelefonoUsuario,
                            $strEmailUsuario,
                            $strPassword,
                            $intTipoUsuario,
                            $intEstado
                        );
                    }
                } else {

                    $option = 2;
                    // Validacion actualziar contraseña, si está vacia no actualizamos, 
                    $strPassword = empty($_POST['txtPassUsuario']) ? "" : hash("SHA256", $_POST['txtPassUsuario']);
                    if ($_SESSION['modulos']['u']) {
                        $request_SetUser = $this->model->updateUsuario(
                            $intIdUsuario,
                            $strIdentificacion,
                            $strNombresUsuario,
                            $strApellidosUsuario,
                            $strTelefonoUsuario,
                            $strEmailUsuario,
                            $strPassword,
                            $intTipoUsuario,
                            $intEstado
                        );
                    }
                }
                // Validacion de la respuesta, sie s mayor a 0 se hizo un create o update
                if ($request_SetUser > 0) {
                    // Validacion si es option 1 o 2

                    if ($option == 1) {

                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                    }
                } elseif ($request_SetUser == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'El email o la identificacion ya existe, ingrese otro.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se han podido almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    public function getUsuarios()
    {
        if ($_SESSION['modulos']['r']) {
            $arrData = $this->model->selectUsuarios();
            // dep($arrData);
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';

                if ($arrData[$i]['status_persona'] == 1) {
                    $arrData[$i]['status_persona'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status_persona'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['modulos']['r']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnViewUsuario" onClick="fntViewUsuario(' . $arrData[$i]['id_persona'] . ')" title="Ver Usuario"><i class="fa fa-eye"></i></button>';
                }
                if ($_SESSION['modulos']['u']) {
                    if (($_SESSION['idUsuario'] == 1 and $_SESSION['usuarioData']['id_rol'] == 1) ||
                        ($_SESSION['usuarioData']['id_rol'] == 1 and $arrData[$i]['id_rol'] != 1)
                    ) {

                        $btnEditar = '<button class="btn btn-success btn-sm btnEditUsuario" onClick="fntEditUsuario(this,' . $arrData[$i]['id_persona'] . ')" title="Editar Usuario"><i class="fa fa-edit"></i></button>';
                    } else {
                        $btnEditar = '<button class="btn btn-success btn-sm btnEditUsuario" disabled  title="Editar Usuario"><i class="fa fa-edit"></i></button>';
                    }
                }
                if ($_SESSION['modulos']['d']) {
                    if (($_SESSION['idUsuario'] == 1 and $_SESSION['usuarioData']['id_rol'] == 1) ||
                        ($_SESSION['usuarioData']['id_rol'] == 1 and $arrData[$i]['id_rol'] != 1) and
                        ($_SESSION['usuarioData']['id_persona'] != $arrData[$i]['id_persona'])
                    ) {
                        $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteUsuario" onClick="fntDeleteUsuario(' . $arrData[$i]['id_persona'] . ')" title="Eliminar Usuario"><i class="fa fa-trash"></i></button>';
                    } else {
                        $btnEliminar = '<button class="btn btn-danger btn-sm btnDeleteUsuario" disabled title="Eliminar Usuario"><i class="fa fa-trash"></i></button>';
                    }
                }

                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuario($idPersona)
    {
        if ($_SESSION['modulos']['r']) {
            // echo $idPersona;
            // die();
            $idUsuario = intval($idPersona);
            if ($idUsuario > 0) {
                $arrData = $this->model->selectUsuario($idUsuario);
                // dep($arrData);
                // validacion para usuaios existentes
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }

                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
    public function delUsuario()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['d']) {
                $intIdPersona = intval($_POST['idUsuario']);
                $request_DeleteUser = $this->model->deleteUsuario($intIdPersona);
                if ($request_DeleteUser) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Ha ocurrido un error al eliminar el usario.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function perfil()
    {
        $data['page_tag'] = "Perfil";
        $data['page_title'] = "Perfil de Usuario";
        $data['page_name'] = "Perfil";
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, "Perfil", $data);
    }

    public function updateUsuario()
    {
        //    dep($_POST);

        if ($_POST) {
            if (empty($_POST['txtNombresUsuario']) || empty($_POST['txtApellidosUsuario']) || empty($_POST['strTelefonoUsuario'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                $intIdUsuario = $_SESSION['idUsuario'];
                $strNombresUsuario = ucwords(strClean($_POST['txtNombresUsuario']));
                $strApellidosUsuario = ucwords(strClean($_POST['txtApellidosUsuario']));
                $strTelefonoUsuario = strClean($_POST['strTelefonoUsuario']);
                $strPasswordUsuario = "";
                if (!empty($_POST['txtPassUsuario'])) {
                    $strPasswordUsuario = hash("SHA256", $_POST['txtPassUsuario']);
                }
                $request_UpdateUser = $this->model->updatePeril($intIdUsuario, $strNombresUsuario, $strApellidosUsuario, $strTelefonoUsuario, $strPasswordUsuario);
                if ($request_UpdateUser) {
                    sessionUsuario($_SESSION['idUsuario']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se han podido actulizar sus datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setDatosFiscales()
    {
        // dep($_POST);

        if ($_POST) {
            if (empty($_POST['txtRfc']) || empty($_POST['txtDireccionFiscal'])) {
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos.');
            } else {
                $intIdUsuario = $_SESSION['idUsuario'];
                $strRfc = ucwords(strClean($_POST['txtRfc']));
                $strDireccionFiscal = ucwords(strClean($_POST['txtDireccionFiscal']));
                $request_SetDatosFiscales = $this->model->updateDatosFiscales($intIdUsuario, $strRfc, $strDireccionFiscal);

                if ($request_SetDatosFiscales) {
                    sessionUsuario($_SESSION['idUsuario']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos almacenados correctamente.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se han podido almacenar sus datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
