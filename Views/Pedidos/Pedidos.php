<?php headerAdmin($data);
// getModal('Modal_productos', $data);
?>
<div id="modalPedido"></div>
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


    <!-- DATA TABLE -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablePedidos" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Num. Transacción</th>
                                    <th>Fecha</th>
                                    <th>Pago</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN DATA TABLE -->


</main>


<?php
footerAdmin($data);
?>