<?php
require_once("Models/TiposPagoTrait.php");

class Pedidos extends Controllers
{
    use TiposPagoTrait;

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
        getPermisos(6);
    }

    public function Pedidos()
    {
        // invocar la vista
        // con this nos referimos a la clase views

        // $data es un array que contiene toda la info de la vista

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $data['page_tag'] = "Pedidos";
        $data['page_title'] = "Pedidos <small>V-SHOES</small>";
        $data['page_name'] = "Pedidos";
        $data['page_functions_js'] = "functions_pedidos.js";


        $this->views->getView($this, "Pedidos", $data);
    }

    public function getPedidos()
    {
        if ($_SESSION['modulos']['r']) {

            $idPersona = "";
            if ($_SESSION['usuarioData']['id_rol'] == 4) {
                $idPersona = $_SESSION['usuarioData']['id_persona'];
            }
            $arrData = $this->model->selectPedidos($idPersona);
            // dep($arrData);
            for ($i = 0; $i < count($arrData); $i++) {
                $btnVer = '';
                $btnEditar = '';
                $btnEliminar = '';
                $arrData[$i]['transaccion'] = $arrData[$i]['referencia'];
                if ($arrData[$i]['transaccionP_id'] != "") {
                    $arrData[$i]['transaccion'] = $arrData[$i]["transaccionP_id"];
                }



                $arrData[$i]['monto'] = SMONEYAFTER . formatMoney($arrData[$i]['monto']) . ' ' . SMONEYBEFORE;


                if ($_SESSION['modulos']['r']) {

                    $btnVer .= '<a title ="Ver Pedido" href="' . base_url() . '/pedidos/pedido/' . $arrData[$i]['id_pedido'] . '" target ="_blanck" class="btn btn-warning btn-sm"> <i class="far fa-eye"></i></a>
                   ';


                    if ($arrData[$i]['tipoPago_id'] == 1) {
                        $btnVer .= '
                        <a title ="Ver Transacción" href="' . base_url() . '/pedidos/transaccion/' . $arrData[$i]['transaccionP_id'] . '" target ="_blanck" class="btn btn-info btn-sm"> <i class="fa fa-paypal"></i></a>
                        
                       ';
                    } else {
                        $btnVer .= '<button class="btn btn-info btn-sm" disabled=""><i class="fa fa-paypal"></i></button>';
                    }
                }
                if ($_SESSION['modulos']['u']) {
                    $btnEditar = '<button class="btn btn-success btn-sm" onClick="fntEditPedido(this, ' . $arrData[$i]['id_pedido'] . ')" title="Editar Pedido"><i class="fa fa-edit"></i></button>';
                }

                if ($_SESSION['modulos']['d']) {

                    $btnEliminar = '<button class="btn btn-danger btn-sm " onClick="fntDeletePedido(' . $arrData[$i]['id_pedido'] . ')" title="Eliminar Pedido"><i class="fa fa-trash"></i></button>';
                }


                $arrData[$i]['opciones'] = '<div class="text-center">' . $btnVer . ' ' . $btnEditar . ' ' . $btnEliminar . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function Pedido($idPedido)
    {
        if (!is_numeric($idPedido)) {
            header('Location: ' . base_url() . '/pedidos');
        }
        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $idPersona = "";
        if ($_SESSION['usuarioData']['id_rol'] == 4) {
            $idPersona = $_SESSION['usuarioData']['id_persona'];
        }


        $data['page_tag'] = "Pedido";
        $data['page_title'] = "Pedido <small>V-SHOES</small>";
        $data['page_name'] = "Pedido";

        $data['arrPedido'] = $this->model->selectPedido($idPedido, $idPersona);

        $this->views->getView($this, "Pedido", $data);
    }

    public function Transaccion($numTransaccion)
    {

        if (empty($_SESSION['modulos']['r'])) {
            header('Location: ' . base_url() . '/dashboard');
        }
        $idPersona = "";
        if ($_SESSION['usuarioData']['id_rol'] == 4) {
            $idPersona = $_SESSION['usuarioData']['id_persona'];
        }

        $requestTP = $this->model->selectTP($numTransaccion, $idPersona);
        // dep($requestTP); exit;
        $data['page_tag'] = "Transacción";
        $data['page_title'] = "Transacción <small>V-SHOES</small>";
        $data['page_name'] = "Transaccion";
        $data['page_functions_js'] = "functions_pedidos.js";
        $data['arrTransaccion'] = $requestTP;
        $this->views->getView($this, "Transaccion", $data);
    }

    public function getTp(string $numTransaccion)
    {
        if ($_SESSION['modulos']['r'] and $_SESSION['usuarioData']['id_rol'] != 4) {
            if ($numTransaccion == "") {
                $arrResponse = array("status" => false, "msg" => "Los datos son incorrectos.");
            } else {
                $numTransaccion = strClean($numTransaccion);
                $request_transaccion = $this->model->selectTP($numTransaccion);
                // dep($request_transaccion);
                if (empty($request_transaccion)) {
                    $arrResponse = array("status" => false, "msg" => "Los datos no estan disponibles.");
                } else {
                    $modalReembolso = getFile("Template/Modals/Modal_reembolsos", $request_transaccion);
                    $arrResponse = array("status" => true, "modalR" => $modalReembolso);
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setReembolso()
    {
        if ($_POST) {
            if ($_SESSION['modulos']['u'] and $_SESSION['usuarioData']['id_rol'] != 4) {
                $numTransaccion = strClean($_POST['idTransaccion']);
                $observaciones = strClean($_POST['observaciones']);
                $request_transaccion = $this->model->reembolsoP($numTransaccion, $observaciones);

                if ($request_transaccion) {
                    $arrResponse = array("status" => true, "msg" => "El reembolso se ha realizado con éxito");
                } else {
                    $arrResponse = array("status" => false, "msg" => "No se ha podiso realizar el reembolso.");
                }
            } else {
                $arrResponse = array("status" => false, "msg" => "No se puede realizar la petición.");
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPedido(string $idPedido)
    {
        if ($_SESSION['modulos']['u'] and $_SESSION['usuarioData']['id_rol'] != 4) {
            if ($idPedido == "") {
                $arrResponse = array("status" => false, "msg" => "Los datos son incorrectos.");
            } else {
                $request_pedido = $this->model->selectPedido($idPedido, "");


                if (empty($request_pedido)) {
                    $arrResponse = array("status" => false, "msg" => "Los datos no están disponibles.");
                } else {
                    $request_pedido['tipo_pago'] = $this->getTiposPago();
                    $modalPedido = getFile("Template/Modals/Modal_pedido", $request_pedido);

                    $arrResponse = array('status' => true, 'modalPedido' => $modalPedido);
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function setPedido()
    {

        if ($_POST) {
            if ($_SESSION['modulos']['u'] and $_SESSION['usuarioData']['id_rol'] != 4) {

                $id_pedido = !empty($_POST['idPedido'])  ? intval($_POST['idPedido']) : "";
                $numTransaccion = !empty($_POST['txtTransaccionP'])  ? strClean($_POST['txtTransaccionP']) : "";
                $id_pago = !empty($_POST['listaPagos']) ? intval($_POST['listaPagos']) : "";
                $estado = !empty($_POST['listaEstado']) ? strClean($_POST['listaEstado']) : "";

                if ($id_pedido == "") {
                    $arrResponse = array("status" => false, "msg" => "Los datos son incorrectos.");
                } else {
                    if ($id_pago == "") {
                        if ($estado == "") {
                            $arrResponse = array("status" => false, "msg" => "Los datos son incorrectos.");
                        } else {
                            $request_pedido = $this->model->updatePedido($id_pedido, "", "", $estado);
                            if ($estado == "En camino") {
                                $request_pedido = $this->model->selectPedido($id_pedido, "");
                                $email = $request_pedido['persona']['email_persona'];

                                $dataCliente = array(
                                    'asunto' => "Tu pedido está en camino.",

                                    'email' => $email,
                                );
                                sendEmail($dataCliente, 'email_enviado');
                            } elseif ($estado == "Entregado") {
                                $request_pedido = $this->model->selectPedido($id_pedido, "");
                                $email = $request_pedido['persona']['email_persona'];

                                $dataCliente = array(
                                    'asunto' => "Tu pedido se ha entregado.",

                                    'email' => $email,
                                );
                                sendEmail($dataCliente, 'email_entregado');
                            }


                            if ($request_pedido) {
                                $arrResponse = array("status" => true, "msg" => "Los datos han sido actualizados.");
                            } else {
                                $arrResponse = array("status" => false, "msg" => "Los datos no se han podido actualizar.");
                            }
                        }
                    } else {
                        if ($numTransaccion == "" or $id_pago == "" or $estado == "") {
                            $arrResponse = array("status" => false, "msg" => "Los datos son incorrectos.");
                        } else {
                            $request_pedido = $this->model->updatePedido($id_pedido, $numTransaccion, $id_pago, $estado);
                            if ($estado == "En camino") {
                                $request_pedido = $this->model->selectPedido($id_pedido, "");
                                $email = $request_pedido['persona']['email_persona'];

                                $dataCliente = array(
                                    'asunto' => "Tu pedido está en camino.",


                                    'email' => $email,
                                );
                                sendEmail($dataCliente, 'email_enviado');
                            } elseif ($estado == "Entregado") {
                                $request_pedido = $this->model->selectPedido($id_pedido, "");
                                $email = $request_pedido['persona']['email_persona'];

                                $dataCliente = array(
                                    'asunto' => "Tu pedido se ha entregado.",


                                    'email' => $email,
                                );
                                sendEmail($dataCliente, 'email_entregado');
                            }

                           
                           
                            if ($request_pedido) {
                                $arrResponse = array("status" => true, "msg" => "Los datos han sido actualizados.");
                            } else {
                                $arrResponse = array("status" => false, "msg" => "Los datos no se han podido actualizar.");
                            }
                        }
                    }
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}
