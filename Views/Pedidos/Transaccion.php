<?php
headerAdmin($data);

?>


<div id="modalReembolso">

</div>



<main class="app-content">
    <div class="app-title">
        <div>
            <h1><?= $data['page_title'] ?></h1>

        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">


                <?php

                // dep($data['arrTransaccion']);
                if (empty($data['arrTransaccion'])) {
                    # code...

                ?>

                    <p>Datos no encontrados.</p>

                <?php

                } else {
                    // DATOS DE TRANSACCION DE PAYPAL
                    $datosTransaccion = $data['arrTransaccion']->purchase_units[0];
                    $numTransaccion = $datosTransaccion->payments->captures[0]->id;
                    $fecha = $datosTransaccion->payments->captures[0]->create_time;
                    $status = $datosTransaccion->payments->captures[0]->status;
                    $monto = $datosTransaccion->payments->captures[0]->amount->value;
                    $divisa = $datosTransaccion->payments->captures[0]->amount->currency_code;
                    // FIN DATOS DE TRANSACCION DE PAYPAL

                    // DATOS DE CLIENTE DE PAYPAL
                    $datosCliente = $data['arrTransaccion']->payer;
                    $nombre = $datosCliente->name->given_name . ' ' . $datosCliente->name->surname;
                    $correoElectronico = $datosCliente->email_address;
                    $telefono = isset($datosCliente->phone) ?$datosCliente->phone->phone_number->national_number : "";
                    $codigoPais = $datosCliente->address->country_code;
                    $direccionCalle = $datosTransaccion->shipping->address->address_line_1;
                    $direccionColonia = $datosTransaccion->shipping->address->address_line_2;
                    $direccionDelegacion = $datosTransaccion->shipping->address->admin_area_2;
                    $direccionCiudad = $datosTransaccion->shipping->address->admin_area_1;
                    $direccionCP = $datosTransaccion->shipping->address->postal_code;
                    $direccionCodigoPais = $datosTransaccion->shipping->address->country_code;


                    // FIN DATOS DE CLIENTE DE PAYPAL


                    // DATOS DE EMPRESA DE PAYPAL

                    $emailEmpresa = $datosTransaccion->payee->email_address;
                    $descripcionVenta = $datosTransaccion->description;
                    $montoTotal = $datosTransaccion->amount->value;
                    // FIN DATOS DE EMPRESA DE PAYPAL


                    // DATOS PRECIOS PAYPAL
                    $totalPaypal = $datosTransaccion->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
                    $comisionPaypal = $datosTransaccion->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
                    $importePaypal = $datosTransaccion->payments->captures[0]->seller_receivable_breakdown->net_amount->value;

                    // DATOS REEMBOLSO

                    $reembolsoP = false;
                    if (isset($datosTransaccion->payments->refunds)) {
                        $reembolsoP = true;
                        $importeReembolso = $datosTransaccion->payments->refunds[0]->seller_payable_breakdown->gross_amount->value;
                        $comisionReembolso = $datosTransaccion->payments->refunds[0]->seller_payable_breakdown->paypal_fee->value;
                        $totalReembolso = $datosTransaccion->payments->refunds[0]->seller_payable_breakdown->net_amount->value;
                        $fechaReembolso = $datosTransaccion->payments->refunds[0]->update_time;
                    }

                    // FIN DATOS REEMBOLSO

                ?>
                    <section id="sPedido" class="invoice">
                        <div class="row mb-4">
                            <div class="col-6">
                                <h2 class="page-header texttitulo"><img src="<?= media(); ?>/front/img/paypal.jpg" alt=""></h2>
                            </div>
                            <?php
                            if (!$reembolsoP) {
                                if ($_SESSION['modulos']['u'] and $_SESSION['usuarioData']['id_rol'] != 4) {

                            ?>
                                    <div class="col-6 text-right">
                                        <button class="btn btn-primary" onclick="fntReembolso('<?= $numTransaccion ?>');"><i class="fa fa-reply-all"> </i> Reembolso</button>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-12">
                                <address>
                                    <b class="texttitulo">Movimiento: </b><br>

                                    <b class="texttitulo">Transacción: <?= $numTransaccion; ?></b><br>
                                    <b class="texttitulo">Fecha:</b> <?= $fecha; ?><br>
                                    <b class="texttitulo">Estado:</b> <?= $status; ?><br>
                                    <b class="texttitulo">Monto:</b> <?= SMONEYAFTER . formatMoney($monto) . ' ' . SMONEYBEFORE ?><br>
                                    <b class="texttitulo">Divisa:</b> <?= $divisa; ?><br>
                                </address>
                            </div>
                            <div class="col-12">
                                <address>
                                    <b class="texttitulo">Cliente: </b><br>
                                    <b class="texttitulo">Nombre:</b> <?= $nombre; ?><br>
                                    <b class="texttitulo">Telefono:</b> <?= $telefono; ?><br>
                                    <b class="texttitulo">Email:</b> <?= $correoElectronico; ?><br>
                                    <b class="texttitulo">Dirección:</b> <?= $direccionCalle . ', ' . $direccionColonia;  ?><br>
                                    <?= $direccionDelegacion . ', ' . $direccionCiudad . ', ' . $direccionCP; ?><br>

                                </address>
                            </div>
                            <div class="col-12">
                                <b class="texttitulo">Empresa: </b><br>
                                <b class="texttitulo">Email:</b> <?= $emailEmpresa; ?><br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <?php
                                if ($reembolsoP) {

                                ?>
                                    <table class="table  table-striped">
                                        <thead>
                                            <b class="texttitulo">Detalle del movimiento: </b><br>

                                            <tr class="texttitulo">
                                                <th>Movimiento</th>
                                                <th>Importe </th>
                                                <th>Comisión de Paypal</th>

                                                <th>Total</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($_SESSION['usuarioData']['id_rol'] == 4) {


                                            ?>
                                                <tr>
                                                    <td><?= $fechaReembolso . ' Reembolso para ' . $nombre ?></td>
                                                    <td>- <?= SMONEYAFTER . formatMoney($importeReembolso) . ' ' . SMONEYBEFORE ?></td>
                                                    <td> <?= SMONEYAFTER . formatMoney('0.00') . ' ' . SMONEYBEFORE ?></td>
                                                    <td>- <?= SMONEYAFTER . formatMoney($importeReembolso) . ' ' . SMONEYBEFORE ?></td>
                                                </tr>
                                            <?php } else {


                                            ?>
                                                <tr>
                                                    <td><?= $fechaReembolso . ' Reembolso para ' . $nombre ?></td>
                                                    <td>- <?= SMONEYAFTER . formatMoney($importeReembolso) . ' ' . SMONEYBEFORE ?></td>
                                                    <td>- <?= SMONEYAFTER . formatMoney($comisionPaypal) . ' ' . SMONEYBEFORE ?></td>
                                                    <td>- <?= SMONEYAFTER . formatMoney($totalReembolso) . ' ' . SMONEYBEFORE ?></td>
                                                </tr>
                                                <tr>
                                                    <td><?= $fechaReembolso . ' Cancelación de la comisión de Paypal ' ?></td>
                                                    <td> <?= SMONEYAFTER . formatMoney($comisionPaypal) . ' ' . SMONEYBEFORE ?></td>
                                                    <td> <?= SMONEYAFTER . formatMoney('0.00') . ' ' . SMONEYBEFORE ?></td>
                                                    <td> <?= SMONEYAFTER . formatMoney($comisionPaypal) . ' ' . SMONEYBEFORE ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                <?php } ?>

                                <hr>

                                <table class="table table-striped">
                                    <thead>
                                        <b class="texttitulo">Detalle del pedido: </b><br>
                                        <tr class="texttitulo">
                                            <th>Pedido</th>
                                            <th>Cantidad</th>

                                            <th>Precio</th>
                                            <th>SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $descripcionVenta; ?></td>
                                            <td>1</td>
                                            <td> <?= SMONEYAFTER . formatMoney($montoTotal) . ' ' . SMONEYBEFORE ?></td>
                                            <td> <?= SMONEYAFTER . formatMoney($montoTotal) . ' ' . SMONEYBEFORE ?></td>

                                        </tr>

                                    </tbody>
                                    <tfoot>


                                        <tr>
                                            <th colspan="3" class="text-right">Total:</th>
                                            <td class="text-right"><?= SMONEYAFTER . formatMoney($montoTotal) . ' ' . SMONEYBEFORE ?></td>
                                        </tr>

                                    </tfoot>

                                </table>
                                <hr>
                                <?php
                                if ($_SESSION['usuarioData']['id_rol'] != 4) {


                                ?>
                                    <table class="table table-striped">
                                        <thead>
                                            <b class="texttitulo">Detalle del pago: </b><br>

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td widht="250"><strong>Total</strong></td>
                                                <td> <?= SMONEYAFTER . formatMoney($totalPaypal) . ' ' . SMONEYBEFORE ?></td>
                                            </tr>
                                            <tr>
                                                <td widht="250"><strong>Comisión de Paypal</strong></td>
                                                <td> <?= SMONEYAFTER . formatMoney($comisionPaypal) . ' ' . SMONEYBEFORE ?></td>
                                            </tr>
                                            <tr>
                                                <td widht="250"><strong>Importe de Paypal</strong></td>
                                                <td> <?= SMONEYAFTER . formatMoney($importePaypal) . ' ' . SMONEYBEFORE ?></td>
                                            </tr>

                                        </tbody>

                                    </table>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('sPedido');"><i class="fa fa-print"></i> Imprimir</a></div>
                        </div>
                    </section>

                <?php
                }

                ?>
            </div>

        </div>
    </div>


</main>


<?php
footerAdmin($data);
?>