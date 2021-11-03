<?php

// use JetBrains\PhpStorm\ArrayShape;

require_once("Libraries/Core/Mysql.php");

trait ClientesTrait
{
    private $conexion;

    private $intIdCliente;

    private $strNombresCliente;
    private $strApellidosCliente;
    private $strTelefonoCliente;
    private $strEmailCliente;
    private $strPasswordCliente;
    private $strTokenCliente;
    private $strIdTransCliente;

    private $intTipoCliente;




    public function insertCliente(string $nombresCliente, string $apellidosCliente, string $telefonoCliente, string $emailCliente, string $passwordCliente, int $tipoCliente)
    {
        $this->conexion = new Mysql();
        $this->strNombresCliente = $nombresCliente;
        $this->strApellidosCliente = $apellidosCliente;
        $this->strTelefonoCliente = $telefonoCliente;
        $this->strEmailCliente = $emailCliente;
        $this->strPasswordCliente = $passwordCliente;
        $this->intTipoCliente = $tipoCliente;


        $return = 0;

        // Consulta

        $sql = "SELECT * FROM persona WHERE email_persona = '{$this->strEmailCliente}'";
        $request = $this->conexion->select_all($sql);

        // Validacion, si la respuesta de la consulta esta vacia, entonces:

        if (empty($request)) {
            $query_insert = "INSERT INTO persona (nombres, apellidos, telefono_persona, email_persona, password_persona,  rol_id) VALUES (?,?,?,?,?,?)";
            $arrData = array(

                $this->strNombresCliente,
                $this->strApellidosCliente,
                $this->strTelefonoCliente,
                $this->strEmailCliente,
                $this->strPasswordCliente,
                $this->intTipoCliente


            );
            $request_insert = $this->conexion->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            // Si la respuesta no esta vacia:
            $return = "exist";
        }
        return $return;
    }

    public function insertDetallePedidoTmp(array $pedido)
    {
        $this->conexion = new Mysql();

        $this->intIdCliente = $pedido['id_cliente'];
        $this->strIdTransCliente = $pedido['id_transaccion'];

        $productos = $pedido['productos'];
        $this->conexion = new Mysql();

        $sql = "SELECT * FROM detalle_temp WHERE transaccion_id = '{$this->strIdTransCliente}' AND persona_id = $this->intIdCliente";
        $request = $this->conexion->select_all($sql);
        if (empty($request)) {
            foreach ($productos as $producto) {
                $query_insert = "INSERT INTO detalle_temp(persona_id, producto_id, precio, cantidad, color, talla, transaccion_id) 
                VALUES (?,?,?,?,?,?,?)";

                $arrData = array(
                    $this->intIdCliente,
                    $producto['id_producto'],
                    $producto['precio'],
                    $producto['cantidad'],
                    $producto['color'],
                    $producto['talla'],
                    $this->strIdTransCliente
                );
                $request_insert = $this->conexion->insert($query_insert, $arrData);
            }
        } else {

            $sql_delete = "DELETE FROM detalle_temp WHERE transaccion_id = '{$this->strIdTransCliente}' AND persona_id = $this->intIdCliente";
            $request = $this->conexion->delete($sql_delete);
            foreach ($productos as $producto) {
                $query_insert = "INSERT INTO detalle_temp(persona_id, producto_id, precio, cantidad, color, talla, transaccion_id) 
                VALUES (?,?,?,?,?,?,?)";

                $arrData = array(
                    $this->intIdCliente,
                    $producto['id_producto'],
                    $producto['precio'],
                    $producto['cantidad'],
                    $producto['color'],
                    $producto['talla'],
                    $this->strIdTransCliente
                );
                $request_insert = $this->conexion->insert($query_insert, $arrData);
            }
        }
    }

    public function insertPedido(string $idTransaccionP = NULL, string $datosP = NULL, int $personaId, float $monto, float $precioEnvio, int $tipoPago, string $direccionEnvio, string $statusPedido)
    {
        $this->conexion = new Mysql();
        $query_insert = "INSERT INTO pedido (transaccionP_id, datosP, persona_id, monto, precio_envio, tipoPago_id,direccion,status_pedido) VALUE (?,?,?,?,?,?,?,?)";
        $arrData = array(
            $idTransaccionP,
            $datosP,
            $personaId,
            $monto,
            $precioEnvio,
            $tipoPago,
            $direccionEnvio,
            $statusPedido
        );
        $request_insert = $this->conexion->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function insertDetallePedido(int $idPedido, int $idProducto, float $precioProducto, int $cantidadProductos, string $colorProducto, string $tallaProducto)
    {
        $this->conexion = new Mysql();
        $query_insert = "INSERT INTO detalle_pedido (pedido_id, producto_id, precio, cantidad, color, talla) VALUE (?,?,?,?,?,?)";
        $arrData = array($idPedido, $idProducto, $precioProducto, $cantidadProductos, $colorProducto, $tallaProducto);
        $request_insert = $this->conexion->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function getPedido(int $idPedido)
    {
        $this->conexion = new Mysql();
        $request = array();
        $sql = "SELECT pd.id_pedido,
        pd.persona_id,
        pd.referencia,
        pd.transaccionP_id,
        pd.fecha,
        pd.monto,
        pd.precio_envio,
        pd.direccion,
        pg.nombre,
        pd.tipoPago_id,
        pd.status_pedido
        FROM pedido as pd
        INNER JOIN tipo_pago pg
        ON pd.tipoPago_id = pg.id_tipoPago
        WHERE pd.id_pedido =  $idPedido;";
        $request_orden = $this->conexion->select($sql);
        if ($request_orden > 0) {
            $sql_productos = "SELECT pr.nombre_producto, 
            pd.precio,
            pd.cantidad, 
            pd.color,
            pd.talla 
            FROM detalle_pedido pd 
            INNER JOIN producto pr
            ON pd.producto_id = pr.id_producto
            WHERE pd.pedido_id = $idPedido";
            $request_productos = $this->conexion->select_all($sql_productos);
            $request = array(
                "orden" => $request_orden,
                "detallePedido" => $request_productos
            );
        }
        return $request;
    }
    public function setContacto(string $nombre, string $email, string $mensaje)
    {
        $this->conexion = new Mysql();

        $nombre = $nombre != "" ? $nombre : "";
        $email = $email != "" ? $email : "";
        $mensaje = $mensaje != "" ? $mensaje : "";


        $sql = "INSERT INTO contactos (nombre_contacto, email_contacto, mensaje_contacto) VALUES (?,?,?)";
        $arrData = array($nombre, $email, $mensaje);



        $request_insert = $this->conexion->insert($sql, $arrData);
        
        return $request_insert;
    }
}
