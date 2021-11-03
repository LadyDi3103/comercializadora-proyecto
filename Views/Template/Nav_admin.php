     <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media(); ?>/IMAGES/perfil.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['usuarioData']['nombres'] . " " . $_SESSION['usuarioData']['apellidos']; ?>
          </p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['usuarioData']['nombre_rol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <!-- validacion, si existe la sesion, verifica si existe el elemento 2 del array de permisos-->
        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
          <li>
            <a class="app-menu__item" href="<?= base_url();  ?>/dashboard">
              <i class="app-menu__icon fa fa-dashboard"></i>
              <span class="app-menu__label">Panel Administrativo</span>
            </a>
          </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
          <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
              <i class="app-menu__icon fa fa-users"></i>
              <span class="app-menu__label">Usuarios</span>
              <i class="treeview-indicator fa fa-angle-right">
              </i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a class="treeview-item" href="<?= base_url();  ?>/usuarios">
                  <i class="icon fa fa-circle-o"></i>Usuarios</a>
              </li>
              <li>
                <a class="treeview-item" href="<?= base_url();  ?>/roles">
                  <i class="icon fa fa-circle-o"></i>Roles</a>
              </li>
            </ul>
          </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
          <li>
            <a class="app-menu__item" href="<?= base_url();  ?>/clientes">
              <i class="app-menu__icon fa fa-user" aria-hidden="true"></i>
              <span class="app-menu__label">Clientes</span>
            </a>
          </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][4]['r']) || !empty($_SESSION['permisos'][7]['r']) || !empty($_SESSION['permisos'][8]['r']) || !empty($_SESSION['permisos'][9]['r'])) { ?>
          <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
              <i class="app-menu__icon fa fa-users"></i>
              <span class="app-menu__label">Productos</span>
              <i class="treeview-indicator fa fa-angle-right">
              </i>
            </a>
            <ul class="treeview-menu">
              <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
                <li>
                  <a class="treeview-item" href="<?= base_url();  ?>/productos">
                    <i class="icon fa fa-circle-o"></i>Productos</a>
                </li>
              <?php } ?>

              <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
                <li>
                  <a class="treeview-item" href="<?= base_url();  ?>/categorias">
                    <i class="icon fa fa-circle-o"></i>Categorias</a>
                </li>
              <?php } ?>

              <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
                <li>
                  <a class="treeview-item" href="<?= base_url();  ?>/tallas">
                    <i class="icon fa fa-circle-o"></i>Tallas</a>
                </li>
              <?php } ?>

              <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
                <li>
                  <a class="treeview-item" href="<?= base_url();  ?>/colores">
                    <i class="icon fa fa-circle-o"></i>Colores</a>
                </li>
              <?php } ?>
              <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
                <li>
                  <a class="treeview-item" href="<?= base_url();  ?>/codigos">
                    <i class="icon fa fa-circle-o"></i>Códigos QR</a>
                </li>
              <?php } ?>

            </ul>
          </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
          <li>
            <a class="app-menu__item" href="<?= base_url();  ?>/proveedores">
              <i class="app-menu__icon fa fa-address-book" aria-hidden="true"></i>
              <span class="app-menu__label">Proveedores</span>
            </a>
          </li>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
          <li>
            <a class="app-menu__item" href="<?= base_url();  ?>/pedidos">
              <i class="app-menu__icon fa fa-cart-arrow-down" aria-hidden="true"></i>
              <span class="app-menu__label">Pedidos</span>
            </a>
          </li>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][10]['r'])) { ?>
          <li>
            <a class="app-menu__item" href="<?= base_url();  ?>/mensajes">
              <i class="app-menu__icon fas fa-envelope" aria-hidden="true"></i>
              <span class="app-menu__label">Mensajes</span>
            </a>
          </li>
        <?php } ?>


        <li>
          <a class="app-menu__item" href="<?= base_url();  ?>/logout">
            <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
            <span class="app-menu__label">Cerrar Sesión</span>
          </a>
        </li>
      </ul>
    </aside>