<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Permisos extends Controllers
{

    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
    }


    public function getPermisosRol(int $idRol)
    {
        $rolId = intval($idRol);
        if ($rolId > 0) {
            $arrModulos = $this->model->selectModulos();
            $arrPermisosRol = $this->model->selectPermisosRol($rolId);
            // dep($arrModulos);
            // dep($arrPermisosRol);
            $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
            $arrPermisoRol = array('rol_id' => $rolId);

            // Validacion. si esta vacio el array de permisos, entonces:
            if (empty($arrPermisosRol)) {
                for ($i = 0; $i < count($arrModulos); $i++) {
                    $arrModulos[$i]['permisos'] = $arrPermisos;
                }
            } else {
                for ($i = 0; $i < count($arrModulos); $i++) {
                    $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
                    if (isset($arrPermisosRol[$i])) {
                        # code...
                        $arrPermisos  = array(
                            'r' => $arrPermisosRol[$i]['r'],
                            'w' => $arrPermisosRol[$i]['w'],
                            'u' => $arrPermisosRol[$i]['u'],
                            'd' => $arrPermisosRol[$i]['d']
                        );
                    }
                    $arrModulos[$i]['permisos'] = $arrPermisos;
                }
            }
            $arrPermisoRol['modulos'] = $arrModulos;
            // dep($arrPermisoRol);
            $html = getModal("Modal_permisos", $arrPermisoRol);
        }
        die();
    }


    public function setPermisosRol()
    {
        // dep($_POST);
        // die();
        // Validación si estamos enviando información atraves de post
        // intval convierte a entero
        if ($_POST) {
            $intIdRol = intval($_POST['idRol']);
            $modulos = $_POST['modulos'];

            $this->model->deletePermisos($intIdRol);
            // recorrer todos los elementos que contiene modulos
            foreach ($modulos as $modulo) {
                // si no se envio el modulo, se le asigna 0
                $idModulo = $modulo['id_modulo'];
                $r = empty($modulo['r']) ? 0 : 1;
                $w = empty($modulo['w']) ? 0 : 1;
                $u = empty($modulo['u']) ? 0 : 1;
                $d = empty($modulo['d']) ? 0 : 1;
                $requstPermiso = $this->model->insertPermiso($intIdRol, $idModulo, $r, $w, $u, $d);
            }
            // Validacion, si es mayor a 0 si se insertaron los registros
            if ($requstPermiso > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No se han podido asignar los permisos.');
            }

            // enviamos en json hacia function_roles.js
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
