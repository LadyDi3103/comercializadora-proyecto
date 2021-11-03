<?php

headerVshoes($data);
// getModal('Modal_carrito', $data);
getModal('Modal_producto', $data);

$arrSlider = $data['slider'];
$arrCards = $data['cards'];
$arrProductos = $data['productos'];
// dep($arrProductos);
?>



<!-- SLIDER -->

<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">


        <div class="carousel-item active slider-productos">
            <img src="<?= $arrSlider[0]['imagen_categoria'] ?>" class="d-block tamaño-img" alt="..." />
            <div class="carousel-caption d-block d-md-block">
                <h3 class="animate__animated animate__fadeInDown"><?= $arrSlider[0]['nombre_categoria'] ?></h3>
                <p class="animate__animated animate__fadeInLeft">
                    <?= $arrSlider[0]['descripcion_categoria'] ?>
                </p>
                <a class="" href="<?php $url = $arrSlider[0]['url_categoria'];
                                    echo  base_url() . '/vshoesProductos/categoria/' .  $arrSlider[0]['id_categoria'] . '/' . $url; ?>">Ver Productos</a>

            </div>
        </div>
        <?php
        for ($i = 1; $i < count($arrSlider); $i++) {
            $url = $arrSlider[$i]['url_categoria'];

        ?>
            <div class="carousel-item slider-productos">
                <img src="<?= $arrSlider[$i]['imagen_categoria'] ?>" class="d-block tamaño-img" alt="..." />
                <div class="carousel-caption d-block d-md-block">
                    <h3 class="animate__animated animate__fadeInDown"><?= $arrSlider[$i]['nombre_categoria'] ?></h3>
                    <p class="animate__animated animate__fadeInLeft">
                        <?= $arrSlider[$i]['descripcion_categoria'] ?>
                    </p>
                    <a class="" href="<?= base_url() . '/vshoesProductos/categoria/' . $arrSlider[$i]['id_categoria'] . '/' . $url; ?>">Ver Productos</a>
                </div>
            </div>

        <?php } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- FIN SLIDER -->

<!-- CATEGORIAS -->
<div class="contenedor">
    <h2 class="categorias_titulo animate__animated animate__rotateInDownLeft">
        Categorias
    </h2>
    <hr>
    <div class="contenedor-categorias">

        <?php
        for ($i = 0; $i < count($arrCards); $i++) {
            $url = $arrSlider[$i]['url_categoria'];

        ?>
            <figure>
                <img src="<?= $arrSlider[$i]['imagen_categoria'] ?>" alt="" />

                <div class="capa-texto">
                    <h3 class="animate__animated animate__fadeInDown"><?= $arrSlider[$i]['nombre_categoria'] ?></h3>
                </div>

                <div class="capa">
                    <h3><?= $arrSlider[$i]['nombre_categoria'] ?></h3>
                    <a href="<?= base_url() . '/vshoesProductos/categoria/' . $arrSlider[$i]['id_categoria'] . '/' . $url; ?>">Ver más</a>
                </div>
            </figure>
        <?php } ?>


    </div>
</div>
<!-- FIN CATEGORIAS -->

<!-- PRODUCTOS NUEVOS -->

<div class="contenedor">
    <h2 class="categorias_titulo animate__animated animate__rotateInDownLeft">
        Productos nuevos
    </h2>
    <hr>
    <div class="row">

        <?php
        for ($i = 0; $i < count($arrProductos); $i++) {
            $url = $arrProductos[$i]['url_producto'];

            if (count($arrProductos[$i]['imagenes'])) {
                $imagenCategoria = $arrProductos[$i]['imagenes'][0]['url_imagen'];
            } else {
                $imagenCategoria = media() . '/images/uploads/portada_categoria.png';
            }

        ?>
            <div class="col-md-3 col-sm-6">
                <figure class="card card-product-grid">
                    <div class="img-wrap">
                        <img src="<?= $imagenCategoria ?>" alt="<?= $arrProductos[$i]['nombre_producto'] ?>" />
                        <a href="<?= base_url() . '/vshoesProductos/producto/' . $arrProductos[$i]['id_producto'] . '/' . $url; ?>" class="btn-overlay btn-bg" type="button">
                            Ver Producto
                        </a>
                    </div>
                    <figcaption class="info-wrap border-top">
                        <p class="title"><?= $arrProductos[$i]['nombre_producto'] ?></p>
                        <div class="price mt-2"><?= SMONEYAFTER . formatMoney($arrProductos[$i]['precio_producto']) . SMONEYBEFORE ?></div>
                    </figcaption>
                </figure>
            </div>
        <?php
        }
        ?>


    </div>



    <br />
    <br />
    <br />
    <br />
    <br />
</div>
<!-- FIN PRODUCTOS NUEVOS -->

<?php

footerVshoes($data);
?>