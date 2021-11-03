<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// instancia a los metodos
// visualiza los datos extaidos de la BD

class Login extends Controllers
{

        public function __construct()
        {
                // iniciar la sesion
                session_start();
                //  validar si ya existe una sesion
                if (isset($_SESSION['login'])) {
                        header('Location: ' . base_url() . '/dashboard');
                }
                // ejecutamos el metodo constructor del la clase Controllers
                parent::__construct();
        }

        public function login()
        {
                // invocar la vista
                // con this nos referimos a la clase views

                // $data es un array que contiene toda la info de la vista

                $data['page_tag'] = "Login - V-SHOES";
                $data['page_title'] = "Login";
                $data['page_name'] = "Login";
                $data['page_functions_js'] = "functions_login.js";

                $this->views->getView($this, "Login", $data);
        }

        public function loginUsuario()
        {
                // dep($_POST);
                // validar campos vacios
                if ($_POST) {
                        if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                                $arrResponse = array('status' => false, 'msg' => 'Error en los datos');
                        } else {
                                $strUsuario = strtolower(strClean($_POST['txtEmail']));
                                $strPassword = hash("SHA256", $_POST['txtPassword']);
                                $request = $this->model->loginUsuario($strUsuario, $strPassword);
                                // dep($request);
                                // validacion si los datos de request no coinciden con datos en la BD
                                if (empty($request)) {
                                        $arrResponse = array('status' => false, 'msg' => 'El email o la contraseña son incorrectos.');
                                } else {
                                        $arrData = $request;
                                        // Validacion para crear las variables de sesion, si es 1 las crea
                                        if ($arrData['status_persona'] == 1) {
                                                $_SESSION['idUsuario'] = $arrData['id_persona'];
                                                $_SESSION['login'] = true;
                                                $arrData = $this->model->sessionLogin($_SESSION['idUsuario']);

                                                sessionUsuario($_SESSION['idUsuario']);
                                                
                                                $arrResponse = array('status' => true, 'msg' => 'OK');
                                        } else {
                                                $arrResponse = array('status' => false, 'msg' => 'El usuario se ecuentra inactivo.');
                                        }
                                }
                        }
                        // convertir a JSON el array y retornar al archivo de funciones JS
                   
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                }
                die();
        }

        public function resetPassword()
        {
                // dep($_POST);
                if ($_POST) {
                        error_reporting(0);
                        if (empty($_POST['txtEmailReset'])) {
                                $arrResponse = array('status' => false, 'msg' => "Error en los datos");
                        } else {
                                $token = token();
                                $strEmail = strtolower(strClean($_POST['txtEmailReset']));
                                $arrData = $this->model->getUsuarioEmail($strEmail);
                                if (empty($arrData)) {
                                        $arrResponse = array('status' => false, 'msg' => "Usuario no encontrado");
                                } else {
                                        $idPersona = $arrData['id_persona'];
                                        $nombreUsuario = $arrData['nombres'] . ' ' . $arrData['apellidos'];
                                        $urlRecuperacion = base_url() . '/login/confirmarUsuario/' . $strEmail . '/' . $token;
                                        // http://localhost/vshoes/login/confirmarUsuario/ifervb@gmail.com/1eebf3574a9574ee7f28-39f3621df585eef800ab-3498f711996031d67277-b7e46adfc75a3ecfe15b
                                        $requestUpdate = $this->model->setTokenUsuario($idPersona, $token);
                                        $dataUsuario = array('nombreUsuario'=> $nombreUsuario,
                                        'email'=> $strEmail,
                                        'asunto'=> 'Restablecer contraseña - '.NOMBRE_REMITENTE,
                                        'urlRecuperacion'=> $urlRecuperacion);
                                        
                                        if ($requestUpdate) {
                                                
                                                $enviarEmail = sendEmail($dataUsuario, 'email_cambiarPassword');
                                                // var_dump($enviarEmail);
                                                if ($enviarEmail) {
                                                        $arrResponse = array('status' => true, 'msg' => "Se ha enviado un email a tu cuenta de correo para cambiar la contraseña.");
                                                        
                                                }else{
                                                        $arrResponse = array('status' => false, 'msg' => "No se ha podido realizar la petición, intente más tarde.");

                                                }
                                        } else {
                                                $arrResponse = array('status' => false, 'msg' => "No se ha podido realizar la petición, intente más tarde.");
                                        }
                                }
                        }
                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                }
                die();
        }

        public function confirmarUsuario(string $params)
        {
                if (empty($params)) {
                        header('Location: ' . base_url());
                } else {
                        // echo $params;
                        $arrParams = explode(',', $params);
                        // dep($arrParams);
                        $strEmail = strClean($arrParams[0]);
                        $strToken = strClean($arrParams[1]);
                        // consulta hacia la BD por medio del modelo

                        $arrResponse = $this->model->getUsuario($strEmail, $strToken);
                        // validar respuesta, si viene vacia redirecciona a la ruta raiz
                        if (empty($arrResponse)) {
                                header("location: " . base_url());
                        } else {
                                $data['page_tag'] = "Cambiar contraseña - V-SHOES";
                                $data['page_title'] = "Cambiar contraseña";
                                $data['page_name'] = "Cambiar_password";
                                $data['email_persona'] = $strEmail;
                                $data['token'] = $strToken;
                                $data['id_persona'] = $arrResponse['id_persona'];
                                $data['page_functions_js'] = "functions_login.js";
                                $this->views->getView($this, "CambiarPassword", $data);
                        }
                }
                die();
        }

        public function setPassword()
        {
                // dep($_POST);
                if (empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirmar'])) {
                        $arrResponse = array('status' => false, 'msg' => "Error en los datos");
                } else {
                        $intIdPersona = intval($_POST['idUsuario']);
                        $strPassword = $_POST['txtPassword'];
                        $strPasswordConfirmar = $_POST['txtPasswordConfirmar'];
                        $strEmail = strClean($_POST['txtEmail']);
                        $strToken = strClean($_POST['txtToken']);

                        if ($strPassword != $strPasswordConfirmar) {
                                $arrResponse = array('status' => false, 'msg' => "Las contraseñas no coinciden.");
                        } else {
                                // consulta para verificar que el email y eltoken sean correctos
                                $arrResponseUsuario = $this->model->getUsuario($strEmail, $strToken);
                                // validar respuesta, si viene vacia redirecciona a la ruta raiz
                                if (empty($arrResponseUsuario)) {
                                        $arrResponse = array('status' => false, 'msg' => "Error en los datos.");
                                } else {
                                        $strPassword = hash("SHA256", $strPassword);
                                        $requestPassword = $this->model->insertPassword($intIdPersona, $strPassword);

                                        // validacion de la respuesta
                                        if ($requestPassword) {
                                                $arrResponse = array('status' => true, 'msg' => "La contraseña se ha actualizado.");
                                        } else {
                                                $arrResponse = array('status' => false, 'msg' => "No se ha podido realizar la petición, intente más tarde,");
                                        }
                                }
                        }
                        // sleep(5);

                        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                        die();
                }
        }
}
