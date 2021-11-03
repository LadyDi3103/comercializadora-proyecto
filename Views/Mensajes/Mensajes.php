<?php headerAdmin($data);
getModal('Modal_mensaje', $data);
 ?>
<main class="app-content">
    <div class="app-title">


        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url(); ?>/mensajes"><?= $data['page_title'] ?></a></li>
        </ul>
    </div>

    <!-- DATA TABLE -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tableMensajes" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre de Contacto</th>
                                    <th>Email de Contacto</th>
                                    <th>Fecha</th>
                                    <th>Opciones</th>

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



V-SHOES | Mensajes

