<?php

headerVshoes($data);
// getModal('Modal_carrito', $data);
getModal('Modal_producto', $data);
// dep($_SESSION['arrCarrito']);


?>



<div class="contenedor">
    <nav style="margin-top: 5rem; " aria-label="breadcrumb">
        <ol class="menu_breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Carrito de compras</li>

        </ol>
    </nav>
    <h2 class="categorias_titulo animate__animated animate__rotateInDownLeft">
        Carrito
    </h2>
    <hr>
    <?php

    $precioTotal = 0;
    $total = 0;

    if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {

    ?>

        <form >
            <div class="row detalle-carrito">
                <aside class="col-lg-9">
                    <div class="card">

                        <div class="table-responsive">

                            <table class="table table-borderless table-shopping-cart" id="tablaCarrito">
                                <thead class="text-muted">
                                    <tr class="small text-uppercase">
                                        <th scope="col" width="120">Producto</th>
                                        <th scope="col" width="120">Precio</th>
                                        <th scope="col" width="120">Cantidad</th>
                                        <th scope="col" width="120">Total</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($_SESSION['arrCarrito'] as $producto) {
                                        $totalCarrito = $producto['precio'] * $producto['cantidad'];
                                        $precioTotal += $totalCarrito;
                                        $idProducto = openssl_encrypt($producto['id_producto'], METODOENCRYPT, KEY);

                                        // dep($producto);
                                    ?>
                                        <tr class="<?= $idProducto ?>">
                                            <td>
                                                <figure class="itemside align-items-center">
                                                    <div class="aside header-cart-item-img" idProducto="<?= $idProducto ?>" opcion="2" onclick="fntDelProducto(this)"><img src="<?= $producto['imagen'] ?>" class="img-sm"></div>
                                                    <figcaption class="info">
                                                        <a href="#" class="title text-dark"><?= $producto['nombre'] ?></a>
                                                        <p class="text-muted small">Talla:<?= $producto['talla'] ?> <br> Color: <?= $producto['color'] ?> </p>
                                                    </figcaption>
                                                </figure>
                                            </td>
                                            <td>
                                                <div class="price-wrap">
                                                    <var class="price"><?= SMONEYAFTER . formatMoney($producto['precio']) . SMONEYBEFORE ?></var>

                                                </div> <!-- price-wrap .// -->
                                            </td>
                                            <td>
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" idProducto="<?= $idProducto ?>">
                                                        <i class="fa fa-minus"></i>
                                                    </div>

                                                    <input idProducto="<?= $idProducto ?>" class="mtext-104 cl3 num-product" type="number" name="num-product2" value="<?= $producto['cantidad'] ?>" min="1" max="5">

                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" idProducto="<?= $idProducto ?>">
                                                        <i class="fa fa-plus"></i>
                                                    </div>
                                                </div>

                                            </td>

                                            <td class="price">
                                                <div class="price-wrap">
                                                    <var><?= SMONEYAFTER . formatMoney($totalCarrito) . SMONEYBEFORE; ?></var>

                                                </div> <!-- price-wrap .// -->
                                            </td>

                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>

                        </div> <!-- table-responsive.// -->

                        <div class="card-body border-top ">
                            <p class="icontext "><i class="icon iconos fa fa-truck"></i> Envío gratis</p>
                        </div> <!-- card-body.// -->

                    </div> <!-- card.// -->

                </aside> <!-- col.// -->
                <aside class="col-lg-3">


                    <div class="card">
                        <div class="card-body">
                            <dl class="dlist-align">
                                <dt>SubTotal:</dt>
                                <dd id="subtotal" class="text-right"><?= SMONEYAFTER . formatMoney($precioTotal) . SMONEYBEFORE; ?></dd>

                            </dl>
                            <dl class="dlist-align">
                                <dt>Envío:</dt>
                                <dd class="text-right"><?= SMONEYAFTER . formatMoney(PRECIOENVIO) . SMONEYBEFORE; ?></dd>

                            </dl>


                            <hr>
                            <dl class="dlist-align">
                                <dt>Total:</dt>
                                <dd id="total" class="text-right"><?= SMONEYAFTER . formatMoney($precioTotal + PRECIOENVIO) . SMONEYBEFORE; ?></dd>

                            </dl>
                            <p class="text-center mb-3">
                                <img src="bootstrap-ecommerce-html/images/misc/payments.png" height="26">
                            </p>
                            <a href="<?= base_url(); ?>/carrito/pagar" id="pagar" class=" btn-bg btn-block"> Pagar </a>

                            <a href="<?= base_url() ?>/vshoesProductos" class="btn-bg-white btn-light btn-block">Continuar Comprando</a>
                        </div> <!-- card-body.// -->
                    </div> <!-- card.// -->

                </aside> <!-- col.// -->

            </div> <!-- row.// -->
        </form>
    <?php
    } else {
    ?>
        <br>
        <br>
        <br>
        <div class="">
            <p>No hay productos en el carrito.</p>
            <br>
            <a class=" btn-bg" href="<?= base_url() ?>/vshoesProductos">Ver Productos</a>

        </div>
        <br>
        <br>
        <br>
    <?php

    }
    ?>
</div>


<?php

footerVshoes($data);
?>