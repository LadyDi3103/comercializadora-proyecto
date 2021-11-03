<?php

$detalleOrden = $data['detalleOrden']['orden'];
$detallePedido = $data['detalleOrden']['detallePedido'];


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= media() ?>/front/css/estilos_mail.css" />

    <title>Orden</title>
    <style type="text/css"></style>
</head>

<body>
    <div class="contenedor">
        <div>
            <br />
            <p class="text-center">Tu orden está creada.</p>
            <br />
            <hr />
            <br />
            <table>
                <tr>
                    <td width="33.33%">
                        <img class="logo" src="<?= media(); ?>/images/logo.jpg" alt="Logo" />
                    </td>
                    <td width="33.33%">
                        <div class="text-center">
                            <h4><strong><?= NOMBRE_EMPRESA; ?></strong><br>
                                <small>El mayor confort.</small>
                            </h4>
                            <p>
                                <?= DIRECCION_EMPRESA; ?>
                                <br>
                                Teléfono: <br> <?= TELEFONO_EMPRESA; ?>

                                <br>
                                Email: <?= EMAIL_EMPRESA; ?>

                            </p>
                        </div>
                    </td>
                    <td width="33.33%">
                        <div class="text-right">
                            <p>
                                No. Orden: <strong><?= $detalleOrden['id_pedido']; ?></strong><br />
                                Fecha: <?= $detalleOrden['fecha']; ?>

                                <br />
                                <?php
                                if ($detalleOrden['tipoPago_id'] == 1) {
                                ?>
                                    Método Pago: <?= $detalleOrden['nombre']; ?>

                                    <br />
                                    Transacción: <?= $detalleOrden['transaccionP_id']; ?>
                                <?php } else { ?>
                                    Método Pago: Pago contra entrega <br />
                                    Tipo Pago: <?= $detalleOrden['nombre']; ?>
                                <?php } ?>
                            </p>
                        </div>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="140">Nombre:</td>
                    <td>
                        <?= $_SESSION['usuarioData']['nombres'] . ' ' . $_SESSION['usuarioData']['apellidos']; ?>
                    </td>
                </tr>
                <tr>
                    <td>Teléfono</td>
                    <td><?= $_SESSION['usuarioData']['telefono_persona']; ?></td>
                </tr>
                <tr>
                    <td>Dirección de envío:</td>
                    <td><?= $detalleOrden['direccion'] ?></td>
                </tr>
            </table>
            <table>
                <thead class="table-active">
                    <tr>
                        <th>Descripción</th>
                        <th class="text-right">Precio</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody id="detalleOrden">

                    <?php
                    if (count($detallePedido) > 0) {
                        $subTotal = 0;
                        foreach ($detallePedido as $producto) {
                            $precio = formatMoney($producto['precio']);
                            $importe = $producto['precio'] * $producto['cantidad'];
                            $subTotal += $importe;
                    ?>
                            <tr>
                                <td><?= $producto['nombre_producto']; ?></td>
                                <td class="text-right"><?= SMONEYAFTER . $precio . ' ' . SMONEYBEFORE ?></td>
                                <td class="text-center"><?= $producto['cantidad']; ?></td>
                                <td class="text-right"><?= SMONEYAFTER . formatMoney($importe) . ' ' . SMONEYBEFORE ?></td>
                            </tr>

                    <?php
                        }
                    }
                    ?>


                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right">SubTotal:</th>
                        <td class="text-right"><?= SMONEYAFTER .formatMoney($subTotal). ' ' . SMONEYBEFORE ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Envío:</th>
                        <td class="text-right"><?= SMONEYAFTER .formatMoney($detalleOrden['precio_envio']) . ' ' . SMONEYBEFORE ?> </td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">Total:</th>
                        <td class="text-right"><?= SMONEYAFTER .formatMoney($detalleOrden['monto'])  . ' ' . SMONEYBEFORE ?></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center">
                <p>
                    ¿Dudas o problemas con tu pedido? ¡Te ayudamos! <br />
                    Ponte en contacto con nosotros en: <strong>vhoes053@gmail.com</strong>
                    o llama al <strong>55-6577-1520</strong> <br>
                    en un horario de <strong>10:00 am a 8:00 pm.</strong>
                </p>
                <h4>¡Gracias por tu compra!</h4>
            </div>
        </div>
    </div>
</body>

</html>