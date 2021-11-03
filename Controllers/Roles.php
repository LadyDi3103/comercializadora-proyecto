<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Roles extends Controllers
{

    public function __construct()
    {
        parent::__construct();
        session_start();
        //    generar id de sesion
        //    session_regenerate_id(true);  

        //  validacion, si la variable de sesion esta vacia:
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }
        getPermisos(2);
        // ejecutamos el metodo constructor del la clase Controllers
    }

    public function roles()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista
        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_id'] = 3;
        $data['page_tag'] = "Roles de Usuario";
        $data['page_title'] = "Roles de Usuario <small>V-SHOES</small>";
        $data['page_name'] = "rol_usuario";
        $data['page_functions_js'] = "functions_roles.js";


        $this->views->getView($this, "Roles", $data);
    }


    // Obtener roles

    public function getRoles()
    {
        if ($_SESSION['modulos']['r']) {
            $btnVer = '';
            $btnEditar = '';
            $btnEliminar = '';
            $arrData = $this->model->selectRoles();
            // dep($arrData);
            // dep($arrData[0]['status_rol']); exit;
            for ($i = 0; $i < count($arrData); $i++) {

                if ($arrData[$i]['status_rol'] == 1) {
                    $arrData[$i]['status_rol'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status_rol'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['modulos']['u']) {
                    $btnVer = '<button class="btn btn-warning btn-sm btnPermisosRol" onClick="fntPermisos(' . $arrData[$i]['id_rol'] . ')" title="Permisos"><i class="fa fa-key"></i></button>';
                    $btnEditar = '    <button class="btn btn-success btn-sm btnEditRol" onClick="fntEditRol(' . $arrData[$i]['id_rol'] . ')" title="Editar"><i class="fa fa-edit"></i></button>';
                }
                if ($_SESSION['modulos']['d']) {
                    $btnEliminar = ' <button class="btn btn-danger btn-sm btnDeleteRol" onClick="fntDeleteRol(' . $arrData[$i]['id_rol'] . ')" title="Eliminar"><i class="fa fa-trash"></i></button>';
                }

                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }

            // El array convertirlo a JSON
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    // Obtener Roles y agregarlos al select
    public function getSelectRoles()
    {
        $options = "";
        $arrData = $this->model->selectRoles();
        if (count($arrData) > 0) {
            for ($i = 0; $i < count(($arrData)); $i++) {
                if ($arrData[$i]['status_rol'] == 1) {
                    $options .= '<option value = "' . $arrData[$i]['id_rol'] . '">' . $arrData[$i]['nombre_rol'] . '</option>';
                }
            }
        }
        echo $options;
        die();
    }


    // Obtener un rol

    public function getRol(int $idRol)
    {
        if ($_SESSION['modulos']['r']) {
            $intIdRol = intval($idRol);
            if ($intIdRol > 0) {
                $arrData = $this->model->selectRol($intIdRol);
                // Validar la respuesta, si no encuentra registro
                // dep($arrData);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, "msg" => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, "data" => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    public function setRol()
    {
        if ($_SESSION['modulos']['w']) {

            $intIdRol = intval($_POST['idRol']);
            $strNombreRol = strClean($_POST['txtNombre']);
            $strDescripcionRol = strClean($_POST['txtDescripcion']);
            $intStatusRol = intval($_POST['listaEstados']);

            // Validacion para el id del Rol

            if ($intIdRol == 0) {
                //   Enviamos informacion al modelo RolesModel.php
                // Insertar rol nuevo
                $request_SetRol = $this->model->insertRol($strNombreRol, $strDescripcionRol, $intStatusRol);
                $option = 1;
            } else {
                // Actualizar rol existente
                $request_SetRol = $this->model->updateRol($intIdRol, $strNombreRol, $strDescripcionRol, $intStatusRol);
                $option = 2;
            }

            // Validacion para la respuesta del metodo insertRol
            if ($request_SetRol > 0) {
                if ($option == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente.');
                }
            } elseif ($request_SetRol == "exist") {
                $arrResponse = array('status' => false, 'msg' => "El rol ya existe.");
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos.');
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function deleteRol()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['w']) {
                $intIdRol = intval($_POST['idRol']);
                $request_deleteRol = $this->model->deleteRol($intIdRol);
                if ($request_deleteRol == "ok") {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el rol.');
                } elseif ($request_deleteRol == "exist") {
                    $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar el rol, está asociado a un usuario.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminarl el rol.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
