<?php

headerVshoes($data);

?>




<div class="contenedor">
    <div class="jumbotron">
        <h1 class="display-4">¡Gracias por tu pedido!</h1>
        <p class="lead"><?= NOMBRE_EMPRESA . " ha procesado su pedido con éxito." ?></p>
        <p>No. Orden: <strong> <?= $data['numOrden'];  ?></strong></p>
        <?php
        if (!empty($data['numTransaccion'])) {


        ?>
            <p>No. Transacción: <strong> <?= $data['numTransaccion'];  ?></strong></p>

        <?php } ?>
        <hr class="my-4">
        <p>Te contactaremos cuando se envíen los artículos.</p>
        <p>Los detalles de tu pedido los puedes consultar en: <a class="link-style" href="<?= base_url() ?>/login">Mi cuenta</a>.</p>
        <br>
        <a class="btn-bg" href="<?= base_url(); ?>" role="button">Continuar</a>
    </div>
</div>

<?php

footerVshoes($data);
?>