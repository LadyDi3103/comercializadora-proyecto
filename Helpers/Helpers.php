<?php

// la función retorna la url base del proyecto que esta en el archivo de configuracion
function base_url()
{
    return BASE_URL;
}

// Funcion que devuelve la url de Assets
function media()
{
    return BASE_URL . "/Assets";
}

// Funcion para vistas template admin, recibe data, informacion del controlador
function headerAdmin($data = "")
{
    $view_header = "Views/Template/Header_admin.php";
    require_once($view_header);
}
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/Footer_admin.php";
    require_once($view_footer);
}
// Funciones para vistas template vshoes recibe data, informacion del controlador
function headerVshoes($data = "")
{
    $view_header = "Views/Template/Header_vshoes.php";
    require_once($view_header);
}
function footerVshoes($data = "")
{
    $view_footer = "Views/Template/Footer_vshoes.php";
    require_once($view_footer);
}

// funcion que nos permite mostar los arrays con formato

function dep($data)
{
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}
function getFile(string $url, $data)
{
    ob_start();
    require_once("Views/{$url}.php");
    $file = ob_get_clean();
    return $file;
}

function sendEmail($data, $template)
{
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    $copiaEmail = !empty($data['copiaEmail']) ? $data['copiaEmail'] : "";
    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    $de .= "Cc: $copiaEmail\r\n";
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}

function getPermisos(int $idModulo)
{
    require_once("Models/PermisosModel.php");
    // variable que nos permite crear objetos de tipo PermisosNodel
    $objPermisos = new PermisosModel();
    // obtener el id del rol logueado atraves de las variables de sesion
    $idRol  = $_SESSION['usuarioData']['id_rol'];
    $arrPermisos = $objPermisos->permisosModulo($idRol);
    // almacenar permisos del rol
    $permisos = '';
    // almacenar permisos de cada modulo
    $permisosModulo = '';

    // validar el array de permisos
    if (count($arrPermisos) > 0) {
        $permisos = $arrPermisos;
        $permisosModulo = isset($arrPermisos[$idModulo]) ? $arrPermisos[$idModulo] : "";
    }
    $_SESSION['permisos'] = $permisos;
    $_SESSION['modulos'] = $permisosModulo;
}

function sessionUsuario(int $idUsuario)
{
    require_once("Models/LoginModel.php");
    $objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idUsuario);
    return $request;
}

function uploadImage(array $data, string $nombre)
{
    $url_tmp = $data['tmp_name'];
    $destino = 'Assets/images/uploads/' . $nombre;
    $move = move_uploaded_file($url_tmp, $destino);
    return $move;
}

function deleteFile(string $nombre)
{
    unlink('Assets/images/uploads/' . $nombre);
}
function strClean($strcadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strcadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); //Elimina \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}
// Funcion para eliminar acentos
function clearString(string $string)
{
    $string = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $string
    );

    $string = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $string
    );

    $string = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $string
    );

    $string = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $string
    );

    $string = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $string
    );


    $string = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç', ',', '.', ';', ':'),
        array('N', 'n', 'C', 'c', '', '', '', ''),
        $string
    );
    return $string;
}

// Funcion que genera una contraseña de 10 caracteres
// Se le mandrá al usuario cuando se registre
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);


    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

// Funcion para reestablecer contraseñas por medio de token
function token()
{

    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token  = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}

// Función para darle formato a las cantidades

function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}


// Funciones para API PAYPAL

function getTokenPaypal()
{
    $loginPL = curl_init(URLPL . "/v1/oauth2/token");
    curl_setopt($loginPL, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($loginPL, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($loginPL, CURLOPT_USERPWD, IDCLIENTE . ":" . SECRET);
    curl_setopt($loginPL, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
    $response = curl_exec($loginPL);
    $responseError = curl_error($loginPL);
    curl_close($loginPL);

    if ($responseError) {
        $peticion = "CURL ERROR NUM:" . $responseError;
    } else {

        $responseJson = json_decode($response);
        $peticion = $responseJson->access_token;
    }


    return $peticion;
}

function getConnectionCurl(string $url, string $contentType = null, string $token)
{
    $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
    //    validacion para el token
    if ($token != null) {
        $arrHeader = array(
            'Content-Type:' . $content_type,
            'Authorization: Bearer ' . $token
        );
    } else {
        $arrHeader = array(
            'Content-Type:' . $content_type

        );
    }


    $arrHeader = array(
        'Content-Type:' . $content_type,
        'Authorization: Bearer ' . getTokenPaypal()
    );

    $iniciarCurl = curl_init();
    curl_setopt($iniciarCurl, CURLOPT_URL, $url);
    curl_setopt($iniciarCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($iniciarCurl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($iniciarCurl, CURLOPT_HTTPHEADER, $arrHeader);

    $response = curl_exec($iniciarCurl);
    $error = curl_error($iniciarCurl);
    curl_close($iniciarCurl);

    if ($error) {
        $peticion = "CURL ERROR NUM:" . $error;
    } else {

        $peticion = json_decode($response);
    }


    return $peticion;
}
function postConnectionCurl(string $url, string $contentType = null, string $token)
{
    $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
    //    validacion para el token
    if ($token != null) {
        $arrHeader = array(
            'Content-Type:' . $content_type,
            'Authorization: Bearer ' . $token
        );
    } else {
        $arrHeader = array(
            'Content-Type:' . $content_type

        );
    }


    $arrHeader = array(
        'Content-Type:' . $content_type,
        'Authorization: Bearer ' . getTokenPaypal()
    );

    $iniciarCurl = curl_init();
    curl_setopt($iniciarCurl, CURLOPT_URL, $url);
    curl_setopt($iniciarCurl, CURLOPT_POST, TRUE);
    curl_setopt($iniciarCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($iniciarCurl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($iniciarCurl, CURLOPT_HTTPHEADER, $arrHeader);

    $response = curl_exec($iniciarCurl);
    $error = curl_error($iniciarCurl);
    curl_close($iniciarCurl);

    if ($error) {
        $peticion = "CURL ERROR NUM:" . $error;
    } else {

        $peticion = json_decode($response);
    }


    return $peticion;
}
