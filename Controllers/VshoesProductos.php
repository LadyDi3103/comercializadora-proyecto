<?php
// este archivo hereda de controllers para poder utilziar el modelo igual a la clase
// y asi utilizar los metodos correspondientes
// utlizamos los metodos del trait para obtener los productos por categorias

require_once("Models/CategoriasTrait.php");
require_once("Models/ProductosTrait.php");
require_once("Models/ClientesTrait.php");
require_once("Models/LoginModel.php");


class VshoesProductos extends Controllers
{
    use CategoriasTrait, ProductosTrait, ClientesTrait;
    public $login;
    public function __construct()
    {
        // ejecutamos el metodo constructor del la clase Controllers
        parent::__construct();
        session_start();
        $this->login = new LoginModel();
    }

    public function vshoesProductos()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        $data['page_tag'] = NOMBRE_EMPRESA . " | " . "Tienda";
        $data['page_title'] = NOMBRE_EMPRESA . " | " . "Productos";
        $data['page_name'] = "Productos";

        $data['productos'] = $this->getProductosTrait();


        // dep($data);
        // exit;

        $this->views->getView($this, "Tienda", $data);
    }


    public function categoria($params)
    {
        if (empty($params)) {
            header("location", base_url());
        } else {
            $arrParams = explode(",", $params);
            $idCategoria  = intval($arrParams[0]);
            $url = strClean($arrParams[1]);
            $informacionCategoria =  $this->getProductosCategorias($idCategoria, $url);
            // dep($informacionCategoria);
            // exit;

            $categoria = strClean($params);
            // dep($this->getProductosCategorias($categoria));
            $data['page_tag'] = NOMBRE_EMPRESA . " | " . $informacionCategoria['categoria'];
            $data['page_title'] = $informacionCategoria['categoria'];
            $data['page_name'] = "Categorías";
            $data['productos'] = $informacionCategoria['productos'];
            $this->views->getView($this, "Categoria", $data);
        }
    }
    public function producto($params)
    {
        if (empty($params)) {
            header("location", base_url());
        } else {
            $arrParams = explode(",", $params);
            $idProducto  = intval($arrParams[0]);
            $url = strClean($arrParams[1]);
            $informacionProducto =  $this->getProductoTrait($idProducto, $url);

            if (empty($informacionProducto)) {
                header("Location:" . base_url());
            }

            // dep($this->getProductosRand($arrProducto['categoria_id'], 2, "r"));
            $data['page_tag'] = NOMBRE_EMPRESA . " | " . $informacionProducto['nombre_producto'];
            $data['page_title'] = $informacionProducto['nombre_producto'];
            $data['page_name'] = "Producto";
            $data['producto'] = $informacionProducto;
            $data['productos'] = $this->getProductosRand($informacionProducto['categoria_id'], 2, "r");
            $this->views->getView($this, "Producto", $data);
        }
    }

    public function agregarCarrito()
    {
        if ($_POST) {
            // unset($_SESSION['arrCarrito']);exit;
            $arrCarrito = array();
            $cantidadProductos = 0;
            $idProducto = openssl_decrypt($_POST['id'], METODOENCRYPT, KEY);
            $cantidad = $_POST['cantidad'];
            $color = $_POST['color'];
            $talla = $_POST['talla'];
            if (is_numeric($idProducto) and is_numeric($cantidad) and is_numeric($talla) and is_string($color)) {
                $arrDetalleProducto = $this->getIdProductoTrait($idProducto);

                if (!empty($arrDetalleProducto)) {
                    $arrProducto = array(
                        'id_producto' => $idProducto,
                        'nombre' => $arrDetalleProducto['nombre_producto'],
                        'cantidad' => $cantidad,
                        'precio' => $arrDetalleProducto['precio_producto'],
                        'imagen' => $arrDetalleProducto['imagenes'][0]['url_imagen'],
                        'color' => $color,
                        'talla' => $talla
                    );


                    if (isset($_SESSION['arrCarrito'])) {
                        $add = true;
                        $arrCarrito = $_SESSION['arrCarrito'];
                        for ($p = 0; $p < count($arrCarrito); $p++) {
                            if ($arrCarrito[$p]['id_producto'] == $idProducto and $arrCarrito[$p]['cantidad']) {
                                $arrCarrito[$p]['cantidad'] += $cantidad;
                                $add = false;
                            }
                        }
                        if ($add) {
                            array_push($arrCarrito, $arrProducto);
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito;

                        // dep($_SESSION['arrCarrito']);
                        // exit;
                    } else {
                        array_push($arrCarrito, $arrProducto);
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    }

                    foreach ($_SESSION['arrCarrito'] as $productosCarrito) {
                        $cantidadProductos += $productosCarrito['cantidad'];
                    }
                    $htmlCarrito = "";
                    $htmlCarrito = getFile('Template/Modals/Modal_carrito', $_SESSION['arrCarrito']);
                    $arrResponse = array(
                        "status" => true,
                        "msg" => "El producto se ha agregado al carrito.",
                        "cantidadCarrito" => $cantidadProductos,
                        "htmlCarrito" => $htmlCarrito
                    );
                } else {
                    $arrResponse = array("status" => false, "msg" => "El producto no existe");
                }

                // exit;
            } else {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);




            // echo $idProducto . ' - ' . $_POST['cantidad'];
        }

        die();
    }
    public function eliminarCarrito()
    {
        if ($_POST) {
            $arrCarrito = array();
            $cantidadProductos = 0;
            $total = 0;
            $idProducto = openssl_decrypt($_POST['id'], METODOENCRYPT, KEY);
            $opcion = $_POST['opcion'];
            if (is_numeric($idProducto) and ($opcion == 1 or $opcion == 2)) {
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($i = 0; $i < count($arrCarrito); $i++) {
                    if ($arrCarrito[$i]['id_producto'] == $idProducto) {
                        unset($arrCarrito[$i]);
                    }
                }
                sort($arrCarrito);
                $_SESSION['arrCarrito'] = $arrCarrito;
                foreach ($_SESSION['arrCarrito'] as $productosCarrito) {
                    $cantidadProductos += $productosCarrito['cantidad'];
                    $total += $productosCarrito['cantidad'] * $productosCarrito['precio'];
                }
                $htmlCarrito = "";
                if ($opcion == 1) {
                    $htmlCarrito = getFile('Template/Modals/Modal_carrito', $_SESSION['arrCarrito']);
                }
                $arrResponse = array(
                    "status" => true,
                    "msg" => "El producto se ha eliminado del carrito.",
                    "cantidadCarrito" => $cantidadProductos,
                    "htmlCarrito" => $htmlCarrito,
                    "subTotal" => SMONEYAFTER . formatMoney($total) . SMONEYBEFORE,
                    "total" =>  SMONEYAFTER . formatMoney($total + PRECIOENVIO) . SMONEYBEFORE
                );
            } else {
                $arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function actualizarCarrito()
    {
        if ($_POST) {
            $arrCarrito = array();
            $precioProductos = 0;
            $subTotal = 0;
            $total = 0;
            $idProducto = openssl_decrypt($_POST['idProducto'], METODOENCRYPT, KEY);
            $cantidad = intval($_POST['cantidad']);
            if (is_numeric($idProducto) and $cantidad > 0) {
                $arrCarrito = $_SESSION['arrCarrito'];
                // dep($arrCarrito); exit;
                for ($i = 0; $i < count($arrCarrito); $i++) {
                    if ($arrCarrito[$i]['id_producto'] == $idProducto) {
                        $arrCarrito[$i]['cantidad'] = $cantidad;
                        $precioProductos = $arrCarrito[$i]['precio'] * $cantidad;
                        break;
                    }
                }
                $_SESSION['arrCarrito'] = $arrCarrito;
                foreach ($_SESSION['arrCarrito'] as $productosCarrito) {
                    $subTotal += $productosCarrito['cantidad'] * $productosCarrito['precio'];
                }
                $arrResponse = array(
                    "status" => true,
                    "msg" => 'El producto se ha actualizado',
                    "precioProductos" => SMONEYAFTER . formatMoney($precioProductos) . SMONEYBEFORE,
                    "subTotal" => SMONEYAFTER . formatMoney($subTotal) . SMONEYBEFORE,
                    "total" => SMONEYAFTER . formatMoney($subTotal + PRECIOENVIO) . SMONEYBEFORE
                );
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Datos inocrrectos.');
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function registroCliente()
    {
        if ($_POST) {
            error_reporting(0);

            // dep($_POST);
            // exit;

            // Validacion datos vacios
            if (empty($_POST['txtNombres']) || empty($_POST['txtApellidos']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmailCliente'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $strNombresCliente = ucwords(strClean($_POST['txtNombres']));
                $strApellidosCliente = ucwords(strClean($_POST['txtApellidos']));
                $strTelefonoCliente = strClean($_POST['txtTelefono']);
                $strEmailCliente = strtolower(strClean($_POST['txtEmailCliente']));
                $intTipoCliente = 4;
                $request_SetCliente = "";

                $strPassword = passGenerator();
                $strPasswordEncrypted = hash("SHA256", $strPassword);

                $request_SetCliente = $this->insertCliente(
                    $strNombresCliente,
                    $strApellidosCliente,
                    $strTelefonoCliente,
                    $strEmailCliente,
                    $strPasswordEncrypted,
                    $intTipoCliente

                );

                // Validacion de la respuesta, sie s mayor a 0 se hizo un create o update
                if ($request_SetCliente > 0) {
                    // Validacion si es option 1 o 2
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    $nombreCliente = $strNombresCliente . ' ' . $strApellidosCliente;
                    $dataCliente = array(
                        'nombreCliente' => $nombreCliente,
                        'email' => $strEmailCliente,
                        'password' => $strPassword,
                        'asunto' => 'Bienvenido a V-SHOES',

                    );
                    $_SESSION['idUsuario'] = $request_SetCliente;
                    $_SESSION['login'] = true;
                    $this->login->sessionLogin($request_SetCliente);

                    // sendEmail($dataCliente, 'email_bienvenida');
                } elseif ($request_SetCliente == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => 'El email ya existe, ingrese otro.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se han podido almacenar los datos.');
                }
            }
            // sleep(3);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function venta()
    {

        if ($_POST) {
            $idTransaccionP = NULL;
            $datosP = NULL;
            $personaId = $_SESSION['idUsuario'];
            $monto = 0;
            $tipoPago = intval($_POST['tipoPago']);
            $direccionEnvio = strClean(ucwords($_POST['direccion'])) . ', ' . strClean(strtoupper($_POST['colonia'])) . ', ' . strClean(strtoupper($_POST['ciudad'])) . ', ' . strClean(strtoupper($_POST['estado'])) . ', ' . strClean($_POST['codigoPostal']);
            $statusPedido = "Pendiente";
            $subTotal = 0;
            $precioEnvio = PRECIOENVIO;

            if (!empty($_SESSION['arrCarrito'])) {
                foreach ($_SESSION['arrCarrito'] as $productosCarrito) {
                    $subTotal += $productosCarrito['cantidad'] * $productosCarrito['precio'];
                }
                $monto = $subTotal + PRECIOENVIO;
                if (empty($_POST['dataPaypal'])) {
                    $request_pedido = $this->insertPedido(
                        $idTransaccionP,
                        $datosP,
                        $personaId,
                        $monto,
                        $precioEnvio,
                        $tipoPago,
                        $direccionEnvio,
                        $statusPedido
                    );

                    if ($request_pedido > 0) {
                        foreach ($_SESSION['arrCarrito'] as $productosCarrito) {
                            $idProducto = $productosCarrito['id_producto'];
                            $precioProducto = $productosCarrito['precio'];
                            $cantidadProductos = $productosCarrito['cantidad'];
                            $colorProducto = $productosCarrito['color'];
                            $tallaProducto = $productosCarrito['talla'];
                            $this->insertDetallePedido($request_pedido, $idProducto, $precioProducto, $cantidadProductos, $colorProducto, $tallaProducto);
                        }
                        $dataOrden = $this->getPedido($request_pedido);
                        $dataEmailOrden = array(
                            'asunto' => "Se ha creado tu pedido No." . $request_pedido,
                            'email' => $_SESSION['usuarioData']['email_persona'],
                            'copiaEmail' => EMAIL_COPIA,
                            'detalleOrden' => $dataOrden
                        );
                        // sendEmail($dataEmailOrden, "email_orden");
                        $numOrden = openssl_encrypt($request_pedido, METODOENCRYPT, KEY);
                        $numTransaccion = openssl_encrypt($idTransaccionP, METODOENCRYPT, KEY);
                        $arrResponse = array("status" => true, "numOrden" => $numOrden, "numTransaccion" => $numTransaccion, "msg" => "Pedido realizado con éxito.");
                        $_SESSION['dataOrden'] = $arrResponse;
                        unset($_SESSION['arrCarrito']);
                        session_regenerate_id(true);
                    }
                } else {
                    $jsonP = $_POST['dataPaypal'];
                    $objP = json_decode($jsonP);
                    $statusPedido = "Aprobado";
                    if (is_object($objP)) {
                        $datosP = $jsonP;
                        $idTransaccionP = $objP->purchase_units[0]->payments->captures[0]->id;
                        if ($objP->status == "COMPLETED") {
                            $totalP = formatMoney($objP->purchase_units[0]->amount->value);
                            if ($monto == $totalP) {
                                $statusPedido = "Completo";
                            }
                            $request_pedido = $this->insertPedido(
                                $idTransaccionP,
                                $datosP,
                                $personaId,
                                $monto,
                                $precioEnvio,
                                $tipoPago,
                                $direccionEnvio,
                                $statusPedido
                            );

                            if ($request_pedido > 0) {
                                foreach ($_SESSION['arrCarrito'] as $productosCarrito) {
                                    $idProducto = $productosCarrito['id_producto'];
                                    $precioProducto = $productosCarrito['precio'];
                                    $cantidadProductos = $productosCarrito['cantidad'];
                                    $colorProducto = $productosCarrito['color'];
                                    $tallaProducto = $productosCarrito['talla'];
                                    $this->insertDetallePedido($request_pedido, $idProducto, $precioProducto, $cantidadProductos, $colorProducto, $tallaProducto);
                                }
                                $dataOrden = $this->getPedido($request_pedido);
                                $dataEmailOrden = array(
                                    'asunto' => "Se ha creado tu pedido No." . $request_pedido,
                                    'email' => $_SESSION['usuarioData']['email_persona'],
                                    'copiaEmail' => EMAIL_COPIA,
                                    'detalleOrden' => $dataOrden
                                );
                                // sendEmail($dataEmailOrden, "email_orden");
                                $numOrden = openssl_encrypt($request_pedido, METODOENCRYPT, KEY);
                                $numTransaccion = openssl_encrypt($idTransaccionP, METODOENCRYPT, KEY);
                                $arrResponse = array("status" => true, "numOrden" => $numOrden, "numTransaccion" => $numTransaccion, "msg" => "Pedido realizado con éxito.");
                                $_SESSION['dataOrden'] = $arrResponse;
                                unset($_SESSION['arrCarrito']);
                                session_regenerate_id(true);
                            } else {
                                $arrResponse = array("status" => false, "msg" => "No se ha podido procesar el pedido.");
                            }
                        } else {
                            $arrResponse = array("status" => false, "msg" => "No se ha podido realizar el pago con Paypal.");
                        }
                    } else {
                        $arrResponse = array("status" => false, "msg" => "No se ha podido hacer la transacción del pago.");
                    }
                }
            } else {
                $arrResponse = array("status" => false, "msg" => "No se ha podido procesar el pedido.");
            }
        } else {
            $arrResponse = array("status" => false, "msg" => "No se ha podido procesar el pedido.");
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        die();
    }

    public function confirmacionPedido()
    {
        if (empty($_SESSION['dataOrden'])) {
            header("Location: " . base_url());
        } else {

            $dataOrden = $_SESSION['dataOrden'];
            $numOrden = openssl_decrypt($dataOrden['numOrden'], METODOENCRYPT, KEY);
            $numTransaccion = openssl_decrypt($dataOrden['numTransaccion'], METODOENCRYPT, KEY);

            $data['page_tag'] = NOMBRE_EMPRESA . " | " . "Confirmación de Pedido";
            $data['page_title'] = NOMBRE_EMPRESA . " | " . "Confirmación de  Pedido";
            $data['page_name'] = "Confirmar de Pedido";
            $data['numOrden'] = $numOrden;
            $data['numTransaccion'] = $numTransaccion;
            $this->views->getView($this, "ConfirmacionPedido", $data);
        }
        unset($_SESSION['dataOrden']);
    }


    public function buscar()
    {
        if (empty($_REQUEST['s'])) {
            header("Location: " . base_url());
        } else {
            $busqueda = strClean($_REQUEST['s']);
        }
        $pag = empty($_REQUEST['producto']) ? 1 : intval($_REQUEST['producto']);
        $cantidadPr = $this->cantidadProd($busqueda);
        $total_productos = $cantidadPr['total_productos'];
        $desde = ($pag - 1) * PRODENPAG;
        $productos_mostrar = ceil($total_productos / PRODENPAG);
        $data['totalProd'] = $this->getProdBusqueda($busqueda, $desde, PRODENPAG);


        $data['page_tag'] = NOMBRE_EMPRESA;
        $data['page_title'] = "Resultado de: " . $busqueda;
        $data['page_name'] = "vshoes";
        $data['pagina'] = $pag;
        $data['total_paginas'] = $productos_mostrar;
        $data['busqueda'] = $busqueda;
        // $data['categorias'] = $this->getProductosCategoria();
        $this->views->getView($this, "Busqueda", $data);
    }


    public function contacto()
    {
        if ($_POST) {
            //    dep($_POST);
            $nombreContacto = ucwords(strtolower(strClean($_POST['nombreContacto'])));

            $emailContacto = strtolower(strClean($_POST['emailContacto']));
            $mensajeContacto = strClean($_POST['mensajeContacto']);
            $contacto = $this->setContacto($nombreContacto, $emailContacto, $mensajeContacto);
            if ($contacto > 0) {
                $arrResponse = array("status" => true, "msg" => "Su mensaje se ha enviado con éxito.");

                $datosContacto = array(
                    'asunto' => "Nuevo mensaje de contacto.",
                    'email' => EMAIL_EMPRESA,
                    'nombreContacto' => $nombreContacto,
                    'emailContacto' => $emailContacto,
                    'mensajeContacto' => $mensajeContacto
                );
                sendEmail($datosContacto, "email_mensaje");
            } else {
                $arrResponse = array("status" => false, "msg" => "No se ha podido enviar su mensaje.");
            }

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
