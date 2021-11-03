<?php

// este archivo se comunica con mysql.php para obtener los metodos


class PedidosModel extends Mysql
{


    public $numTransaccion;




    public function __construct()
    {
        //   echo "Mensajes desde el modelo Home";
        parent::__construct();
    }



    public function selectPedidos($idPersona = NULL)
    {
        $sentenciaWhere = "";
        if ($idPersona != null) {
            $sentenciaWhere = "WHERE pd.persona_id = " . $idPersona;
        }
        $sql = "SELECT pd.id_pedido,
                        
                        pr.nombres,
                        pr.apellidos,
                        pd.referencia,
                        pd.transaccionP_id,
                        DATE_FORMAT(pd.fecha, '%d/%m/%Y') as fecha,
                        pd.monto,
                        pd.precio_envio,
                        pd.direccion,
                        pd.tipoPago_id,
                        tp.nombre,
                        pd.status_pedido
        
        FROM pedido pd
        INNER JOIN tipo_pago tp ON pd.tipoPago_id = tp.id_tipoPago
        INNER JOIN persona pr ON pd.persona_id = pr.id_persona $sentenciaWhere";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPedido(int $idPedido, $idPersona = NULL)
    {
        $buscar = "";
        if ($idPersona != NULL) {
            $buscar = "AND pd.persona_id=" . $idPersona;
        }
        $request = array();
        $sql_pedido = "SELECT pd.id_pedido,
        pd.persona_id,
        pd.referencia,
        pd.transaccionP_id,
        DATE_FORMAT(pd.fecha, '%d/%m/%Y') as fecha,
        pd.monto,
        pd.precio_envio,
        pd.direccion,
        pg.nombre,
        pd.tipoPago_id,
        pd.status_pedido
        FROM pedido as pd
        INNER JOIN tipo_pago pg
        ON pd.tipoPago_id = pg.id_tipoPago
        WHERE pd.id_pedido =  $idPedido " . $buscar;
        $request_pedido = $this->select($sql_pedido);
        if (!empty($request_pedido)) {
            $idPersona = $request_pedido['persona_id'];
            $sql_persona = "SELECT id_persona,  
            nombres, 
            apellidos, 
            telefono_persona, 
            email_persona, 
            rfc_persona, 
            direccion_fiscal
            FROM persona 
            WHERE id_persona = $idPersona";
            $request_persona = $this->select($sql_persona);

            $sql_producto = "SELECT pr.nombre_producto, 
            pr.codigo_producto,
            pr.descripcion_producto,
            pd.precio,
            pd.cantidad, 
            pd.color,
            pd.talla
            FROM detalle_pedido pd 
            INNER JOIN producto pr
            ON pd.producto_id = pr.id_producto
            WHERE pd.pedido_id = $idPedido";
            $request_producto = $this->select_all($sql_producto);

            $request = array(
                "persona" => $request_persona,
                "pedido" => $request_pedido,
                "producto" => $request_producto

            );
        }



        return $request;
    }


    public function selectTP(string $numTransaccion, $idPersona = NULL)
    {
        $buscar = "";
        if ($idPersona != NULL) {
            $buscar = "AND persona_id=" . $idPersona;
        }
        $objTP = array();
        $sql_transaccion = "SELECT datosP FROM pedido WHERE transaccionP_id = '{$numTransaccion}'" . $buscar;
        $request_transaccion = $this->select($sql_transaccion);

        $this->numTransaccion = $numTransaccion;
        if (!empty($request_transaccion)) {


            $objData = json_decode($request_transaccion['datosP']);
            // dep($objData);exit;
            //    $hrefTP= $objData->purchase_units[0]->payments->captures[0]->links[0]->href;
            $hrefTP = "https://api.sandbox.paypal.com/v2/payments/captures/" . $this->numTransaccion;
            //    $hrefOP= $objData->purchase_units[0]->payments->captures[0]->links[2]->href;
            $hrefOP = $objData->links[0]->href;
            $objTP = getConnectionCurl($hrefOP, "application/json", getTokenPaypal());
        }
        return $objTP;
    }

    public function reembolsoP(string $numTransaccion, string $observaciones)
    {
        $response = false;
        $sql_reembolso = "SELECT id_pedido, datosP FROM pedido WHERE transaccionP_id = '{$numTransaccion}'";
        $request_reembolso = $this->select($sql_reembolso);
        $this->numTransaccion = $numTransaccion;

        if (!empty($request_reembolso)) {
            $objData = json_decode($request_reembolso['datosP']);

            // $hrefOP = $objData->links[0]->href;
            // $objTP = getConnectionCurl($hrefOP, "application/json", getTokenPaypal());


            $hrefReembolso = "https://api.sandbox.paypal.com/v2/payments/captures/" . $this->numTransaccion . "/refund";
            // $hrefReembolso = $objTP->purchase_units[0]->payments->captures[0]->links[1]->href;
            $objRP = postConnectionCurl($hrefReembolso, "application/json", getTokenPaypal());

            if (isset($objRP->status) and $objRP->status == "COMPLETED") {
                $idPedido = $request_reembolso['id_pedido'];
                $numTransaccionR = $objRP->id;
                $statusR = $objRP->status;
                $jsonData = json_encode($objRP);
                $observaciones = $observaciones;
                $query_insert = "INSERT INTO reembolso_pedido(pedido_id, num_transaccion,descripcion_reembolso,obervaciones	,status_reembolso)
                VALUES(?,?,?,?,?)";
                $arrData = array($idPedido, $numTransaccion, $statusR, $jsonData, $observaciones);
                $request_insert = $this->insert($query_insert, $arrData);

                if ($request_insert > 0) {
                    $update_pedido = "UPDATE pedido SET status_pedido = ? WHERE id_pedido = $idPedido";
                    $arrPedido = array("Reembolsado");
                    $request = $this->update($update_pedido, $arrPedido);
                    $response = true;
                }
            }
            return $response;
        }
    }


    public function updatePedido(int $id_pedido, $numTransaccion = NULL, $id_pago = NULL, string $estado)
    {
        if ($numTransaccion == NULL) {
            $query_insert = "UPDATE pedido SET status_pedido = ? WHERE id_pedido = $id_pedido";
            $arrData = array($estado);
        } else {
            $query_insert = "UPDATE pedido SET referencia = ?, tipoPago_id = ?, status_pedido = ? WHERE id_pedido = $id_pedido";
            $arrData = array(
                $numTransaccion,
                $id_pago,
                $estado
            );
        }
        $request_insert = $this->update($query_insert, $arrData);
        return $request_insert;
    }
}
