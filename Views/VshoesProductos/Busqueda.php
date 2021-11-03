<?php

headerVshoes($data);
// getModal('Modal_carrito', $data);


$arrProductos = $data['totalProd'];


// dep($arrProductos);

?>


<!-- PRODUCTOS NUEVOS -->

<div class="contenedor">
    <nav style="margin-top: 5rem; " aria-label="breadcrumb">
        <ol class="menu_breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tienda</li>

        </ol>
    </nav>
    <h2 class="categorias_titulo animate__animated animate__rotateInDownLeft">
        <?= $data['page_title']; ?>
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
                        <a href="<?= base_url() . '/vshoesProductos/producto/' . $arrProductos[$i]['id_producto'].'/'.$url; ?>" class="btn-overlay btn-bg" type="button">
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