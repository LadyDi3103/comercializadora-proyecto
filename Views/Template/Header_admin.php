<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="description" content="Comercializadora de zapatos V-SHOES">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Fernanda Vidal Isabel Del Valle">
  <meta name="theme-color" content="#4f0000">
  <title><?= $data['page_tag'] ?></title>

  <!--CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
  <!-- Font-icon css-->




</head>

<body class="app sidebar-mini">
  <div id="loading">
    <div class="">
      <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
    </div>
  </div>
  <!-- Navbar-->
  <header class="app-header"><a class="app-header__logo" href="<?= base_url();  ?>/dashboard">V-SHOES</a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fas fa-bars"></i></a>

    <ul class="app-nav">

      <!-- MENU DE USUARIO-->
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
          
          <li><a class="dropdown-item" href="<?= base_url();  ?>/Usuarios/perfil"><i class="fa fa-user fa-lg"></i> Perfil</a></li>
          <li><a class="dropdown-item" href="<?= base_url();  ?>/logout"><i class="fa fa-sign-out fa-lg"></i> Cerrar Sesión</a></li>
        </ul>
      </li>
      <!-- FIN MENU DE USUARIO -->
    </ul>
  </header>

  <?php
  require_once("Nav_admin.php");
  ?>