<?php

headerVshoes($data);
// getModal('Modal_carrito', $data);


$arrProducto = $data['producto'];
$arrProductos = $data['productos'];
$arrProducto = $data['producto'];
$arrImagenes = $arrProducto['imagenes'];
$rutaCategoria = $arrProducto['categoria_id'] . '/' . $arrProducto['url_categoria'];
// echo $rutaCategoria;
$urlProducto = base_url() . "/vshoesProductos/producto/" . $arrProducto['id_producto'] . "/" . $arrProducto['url_producto'];
// echo $urlProducto;

// dep($data);
?>


<div class="contenedor">
    <nav style="margin-top: 5rem; " aria-label="breadcrumb">
        <ol class="menu_breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url() . '/VshoesProductos/categoria/' . $rutaCategoria; ?>"><?= $arrProducto['nombre_categoria'] ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $arrProducto['nombre_producto'] ?></li>
        </ol>
    </nav>
    <div class="detalle-producto">
        <div class="card">
            <div class="row no-gutters">
                <aside class="col-sm-6 border-right">
                    <article class="gallery-wrap">

                        <div class="img-big-wrap">
                            <?php
                            if (!empty($arrImagenes)) {



                            ?>
                                <a href="<?= $arrImagenes[0]['url_imagen'] ?>" class="item-thumb fancybox" data-fancybox="galeria">
                                    <img id="imagenBox" src="<?= $arrImagenes[0]['url_imagen'] ?>" /></a>
                            <?php


                            } else {
                                echo "Imagen no disponible.";
                            }
                            ?>
                        </div>

                        <!-- img-big-wrap.// -->
                        <div class="thumbs-wrap">
                            <?php

                            for ($i = 1; $i < count($arrImagenes); $i++) {


                            ?>

                                <a href="<?= $arrImagenes[$i]['url_imagen'] ?>" class="item-thumb fancybox" data-fancybox="galeria">
                                    <img class="item-sm" src="<?= $arrImagenes[$i]['url_imagen'] ?>" /></a>
                            <?php

                            }

                            ?>
                        </div>
                        <!-- thumbs-wrap.// -->
                    </article>
                    <!-- gallery-wrap .end// -->
                </aside>
                <main class="col-sm-6">
                    <article class="content-body">
                        <h2 class="title js-name-detail"><?= $arrProducto['nombre_producto'] ?></h2>

                        <p class="descripcion_producto">
                            <?= $arrProducto['descripcion_producto'] ?>
                        </p>

                        <div class="h3 mb-4">
                            <p class="price h4"><?= SMONEYAFTER . formatMoney($arrProducto['precio_producto']) . ' ' . SMONEYBEFORE ?></p>
                        </div>
                        <!-- price-wrap.// -->

                        <div class="form-row">
                            <div class="form-group">
                                <div class="col">
                                    <div class="h3 mb-4">
                                        <p class="price h3">Talla</p>
                                    </div>
                                    <select id="talla-producto" name="talla-producto" class=" form-control">

                                        <option selected>24</option>
                                        <option>26</option>
                                        <option>28</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col">
                                    <div class="h3 mb-4">
                                        <p class="price h3">Color</p>
                                    </div>
                                    <select id="color-producto" name="color-producto" class=" form-control">



                                        <option selected><?= $arrProducto['nombre_color'] ?></option>



                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="col">
                                    <div class="h3 mb-4">
                                        <p class="price h3">Cantidad</p>
                                    </div>

                                    <!-- <input id="cantidad-producto" class=" form-control" type="number" name="cantidad-producto" id="" value="1" min="1" max="5"> -->

                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fa fa-minus"></i>
                                        </div>

                                        <input id="cantidad-producto" class="mtext-104 cl3 num-product" type="number" name="cantidad-producto" value="1" min="1" max="5">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">

                        </div>
                        <div class="form-row">
                            <div class="col">
                                <button id="<?= openssl_encrypt($arrProducto['id_producto'], METODOENCRYPT, KEY); ?>" class="btn-overlay btn-bg js-addcart-detail">
                                    Agregar al carrito

                                </button>
                            </div>

                            <!-- col.// -->
                        </div>
                        <br>
                        <hr>
                        <br>


                        <div class="flex-w compartir">


                            <a href="" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $urlProducto; ?> &t=<?= $arrProducto['nombre_producto'] ?>','ventanacompartir', 'toolbar=0, status=0, width=650, height=450');">

                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="https://twitter.com/intent/tweet?text=<?= $arrProducto['nombre_producto']; ?>&url=<?= $urlProducto; ?>&hashtags=<?= HASHTAGS; ?>" target="_blank" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="https://api.whatsapp.com/send?text=<?=  $arrProducto['nombre_producto'].' '.$urlProducto; ?>" target="_blank" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="WhatsApp">
                                <i class="fa fa-whatsapp" aria-hidden="true"></i>
                            </a>

                        </div>
                        <!-- col.// -->
            </div>

            <!-- row.// -->
            </article>
            <!-- product-info-aside .// -->
            </main>
            <!-- col.// -->
        </div>
        <!-- row.// -->
    </div>
</div>
</div>
<?php

footerVshoes($data);
?>