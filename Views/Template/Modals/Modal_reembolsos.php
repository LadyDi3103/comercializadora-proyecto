<?php
$datosTransaccion = $data->purchase_units[0];
$datosCliente = $data->payer;


// DATOS DE TRANSACCION DE PAYPAL
$numTransaccion = $datosTransaccion->payments->captures[0]->id;

// DATOS DE CLIENTE DE PAYPAL
$nombre = $datosCliente->name->given_name . ' ' . $datosCliente->name->surname;
$correoElectronico = $datosCliente->email_address;
$telefono = isset($datosCliente->phone) ? $datosCliente->phone->phone_number->national_number : "";

$codigoPais = $datosCliente->address->country_code;

// DATOS PRECIOS PAYPAL
$totalPaypal = $datosTransaccion->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
$comisionPaypal = $datosTransaccion->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
$importePaypal = $datosTransaccion->payments->captures[0]->seller_receivable_breakdown->net_amount->value;

?>


<!-- Modal mostrar informacion de Productos -->
<div class="modal fade" id="modalFormReembolso" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos del Reembolso</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">
                    <input type="hidden" id="numTransaccion" value="<?= $numTransaccion ?>">
                    <tbody>

                        <tr>
                            <td>Número de Transaccion:</td>
                            <td><?= $numTransaccion ?></td>
                        </tr>
                        <tr>
                            <td>Datos del Cliente:</td>
                            <td><?= $nombre ?> <br> <?= $correoElectronico ?> <br> <?= $telefono ?> </td>
                        </tr>
                        <tr>
                            <td>Importe del Reembolso:</td>
                            <td><?= SMONEYAFTER . formatMoney($totalPaypal) . SMONEYBEFORE ?></td>
                        </tr>
                        <tr>
                            <td>Comision de Paypal:</td>
                            <td><?= SMONEYAFTER . formatMoney($comisionPaypal) . SMONEYBEFORE ?></td>
                        </tr>
                        <tr>
                            <td>Total del Reembolso:</td>
                            <td><?= SMONEYAFTER . formatMoney($importePaypal) . SMONEYBEFORE ?></td>
                        </tr>
                        <tr>
                            <td>Observaciones:</td>
                            <td><textarea name="" id="txtObservaciones" class="form-control"></textarea></td>
                        </tr>




                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" onclick="fntReembolsar();">
                    Hacer reembolso
                </button>
                <button type="button" class="btn btn-guardar" data-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<!--Fin Modal para mostrar información de producto-->