<!-- Modal -->


<div class="modal fade" id="modalFormPedido" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de pedidos -->
            <div class="modal-body">


                <div class="tile-body">

                    <form class="formularioPedido" id="formPedido" name="formPedido">

                        <input type="hidden" id="idPedido" name="idPedido" value="<?= $data['pedido']['id_pedido'] ?>" required="">
                        <table class="table table-bordered">
                            <input type="hidden" id="numTransaccion" value="">
                            <tbody>

                                <tr>
                                    <td>Número de Pedido:</td>
                                    <td><?= $data['pedido']['id_pedido'] ?></td>
                                </tr>
                                <tr>
                                    <td>Datos del Cliente:</td>
                                    <td><?= $data['persona']['nombres'] . ' ' . $data['persona']['apellidos']  ?> </td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td><?= SMONEYAFTER . formatMoney($data['pedido']['monto']) . ' ' . SMONEYBEFORE ?></td>
                                </tr>
                                <tr>
                                    <td>Número de Transacción:</td>


                                    <td> <?php if ($data['pedido']['tipoPago_id'] == 1) {
                                                echo $data['pedido']['transaccionP_id'];
                                            } else { ?><input type="text" name="txtTransaccionP" class="form-control " id="txtTransaccionP" value="<?= $data['pedido']['referencia'] ?>" required="">
                                        <?php } ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Tipo de Pago:</td>
                                    <td>
                                        <?php if ($data['pedido']['tipoPago_id'] == 1) {
                                            echo $data['pedido']['nombre'];
                                        } else { ?>
                                            <select name="listaPagos" class="form-control selectpicker" id="listaPagos" data-live-search="true" required="">
                                                <?php
                                                for ($i = 0; $i < count($data['tipo_pago']); $i++) {


                                                    $selected = "";
                                                    if ($data['tipo_pago'][$i]['id_tipoPago'] == $data['pedido']['tipoPago_id']) {
                                                        $selected = " selected";
                                                    }
                                                ?>
                                                    <option value="<?= $data['tipo_pago'][$i]['id_tipoPago'] ?>" <?= $selected ?> ><?= $data['tipo_pago'][$i]['nombre'] ?> </option>
                                                <?php   }

                                                ?>
                                            </select>
                                        <?php } ?>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Estado:</td>
                                    <td> <select name="listaEstado" class="form-control selectpicker" id="listaEstado" data-live-search="true" required="">

                                            <?php

                                            for ($i = 0; $i < count(STATUS_PEDIDO); $i++) {

                                                $selected = "";
                                                if (STATUS_PEDIDO[$i] ==  $data['pedido']['status_pedido']) {
                                                    $selected = " selected ";
                                                }

                                            ?>
                                                <option value="<?= STATUS_PEDIDO[$i] ?>" <?= $selected ?>> <?= STATUS_PEDIDO[$i] ?> </option>
                                            <?php } ?>
                                        </select></td>
                                </tr>




                            </tbody>

                        </table>
                        <div class="form-datos">
                            <button id="btnActionForm" class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar Pedido</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-cancelar" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>
                    </form>
                </div>

            </div>


        </div>
    </div>
</div>
</div>
<!--Fin Modal para formulario de pedidos-->