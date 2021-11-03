<?php
$cantidadProductos = 0;
if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
    foreach ($_SESSION['arrCarrito'] as $producto) {
        $cantidadProductos += $producto['cantidad'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?php
    $nombrePortal = NOMBRE_EMPRESA;
    $descripcion = DESCRIPCION_EMPRESA;
    $nombreProducto = NOMBRE_EMPRESA;
    $url = base_url();
    $urlImagen = media() . "/images/portada.jpeg";

    if (!empty($data['producto'])) {
        $descripcion ="El mayor confort.";
        $nombreProducto = NOMBRE_EMPRESA;
        $url = base_url() . "/vshoesProductos/producto/" . $data['producto']['id_producto'] . "/" . $data['producto']['url_producto']; {
        }
        $urlImagen = $data['producto']['imagenes'][0]['url_imagen'];
    ?>
        <meta property="og:locale" content='es_ES' />
        <meta property="og:type" content='website' />
        <meta property="og:site_name" content='<?= $nombrePortal; ?>' />
        <meta property="og:description" content='<?= $descripcion; ?>' />
        <meta property="og:url" content='<?= $url; ?>' />
        <meta property="og:image" content='<?= $urlImagen; ?>' />
    <?php
    }

    ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= media() ?>/images/logo.bmp" />
    <script src="https://use.fontawesome.com/5e80805285.js"></script>
    <!-- Bootstrap4 files-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />

    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.1.3/hamburgers.min.css" />
    <link rel="stylesheet" href="<?= media() ?>/front/vendor/node_modules/animate.css/animate.css" />
    
    <link rel="stylesheet" href="<?= media() ?>/front/css/pushbar.css" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    
    <link href="<?= media() ?>/front/css/bootstrap.css" rel="stylesheet" />

    <link href="<?= media() ?>/front/css/ui.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="<?= media() ?>/front/css/estilos.css" />


    

    <title><?= $data['page_tag']; ?></title>
</head>

<body>
    <!-- <ul class="nav bg-dark navbar-dark">
        <li><a class="nav-link text-white" href="">bienvenido</a></li>

    </ul> -->
    <div id="loading">
        <div class="">
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
        </div>
    </div>
    <!-- Menu -->
    <header class="header-menu">



        <section class="contenedor-menu">

            <div class="logo">
                <a href="<?= base_url() ?>">V-SHOES</a>
            </div>

            <button class="menu-boton">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path d="M4 6H20V8H4zM4 11H20V13H4zM4 16H20V18H4z" />
                </svg>
                <svg class="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                </svg>
            </button>

            <nav class="menu-principal">

                <a href="<?= base_url() ?>">Inicio</a>

                <a href="<?= base_url() ?>/vshoesProductos">Tienda</a>
                <a href="<?= base_url() ?>/nosotros">Nosotros</a>
                <a href="<?= base_url() ?>/contacto">Contacto</a>
                <a href="<?= base_url() ?>/login">Mi cuenta</a>
                <a href="<?= base_url() ?>/carrito">Carrito</a>
            </nav>

            <div class="iconos">
                <button class="search-boton js-show-modal-search"><i class="fa fa-search" aria-hidden="true"></i></button>
                <?php if ($data['page_name'] != "Carrito" and $data['page_name'] != "pago") {
                    # code...
                ?>
                    <button data-pushbar-target="pushbar-menu" class="btn-cart cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span id="cantidadCarrito" class="badge badge-pill badge-dark cart_menu_num"><?= $cantidadProductos; ?></span>
                    </button>
            </div>
        <?php
                }
        ?>
        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src="<?= media() ?>/front/img/icon-close2.png" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w " method="get" action="<?= base_url() ?>/vshoesProductos/buscar">
                    <button class="flex-c-m trans-04">
                        <i class="fa fa-search"></i>
                    </button>

                    <input type="hidden" name="producto" value="1">
                    <input class="plh3" type="text" name="s" placeholder="Buscar...">
                </form>
            </div>
        </div>

        </section>

    </header>
    <!-- Fin Menu -->
    <!-- Menu Carrito -->

    <div data-pushbar-id="pushbar-menu" data-pushbar-direction="right" class="pushbar-menu">
        <div class="info-menu">
            <button data-pushbar-close><i class="fa fa-times"></i></button>
            <h3>Tu Carrito</h3>
            <div id="productoCarrito" class="contenedor">

                <?= getModal('Modal_carrito', $data); ?>
            </div>
        </div>
    </div>