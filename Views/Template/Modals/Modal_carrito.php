<?php
$total = 0;

if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
    # code...


?>



    <?php

    foreach ($_SESSION['arrCarrito'] as $producto) {
        $total += $producto['cantidad'] * $producto['precio'];
        $idProducto = openssl_encrypt($producto['id_producto'], METODOENCRYPT, KEY);


    ?>
        <div class="item">
            <div class="header-cart-item-img" idproducto="<?= $idProducto ?>" opcion="1" onclick="fntDelProducto(this)">
                <img class="img-producto" src="<?= $producto['imagen'] ?>" />
            </div>
            <div class="detalle-producto">
                <p class="nombre-producto"><?= $producto['nombre'] ?></p>
                <p class="precio-producto"><?= $producto['cantidad'] . ' x ' . SMONEYAFTER . formatMoney($producto['precio']) . SMONEYBEFORE ?></p>
            </div>
        </div>
    <?php
    }
    ?>


    <div class="total">
        <p class="precio-total">Total: <span> <?= SMONEYAFTER . formatMoney($total) . SMONEYBEFORE; ?></span></p>
        <a href="<?= base_url() ?>/carrito" class="btn-bg"> Ver Carrito</a>
        <a href="<?= base_url(); ?>/carrito/pagar" class="btn-bg">Procesar Pago</a>
    </div>


    <!-- Fin Menu Carrito -->

<?php
}
?>