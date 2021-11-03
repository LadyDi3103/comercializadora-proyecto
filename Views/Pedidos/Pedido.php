<?php
headerAdmin($data);

?>
<main class="app-content">
  <div class="app-title">
    <div>
      <h1><?= $data['page_title'] ?></h1>

    </div>
    <ul class="app-breadcrumb breadcrumb">
      <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
      <li class="breadcrumb-item"><a href="<?= base_url(); ?>/pedidos"><?= $data['page_title'] ?></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
      
        
<?php 
if (empty($data['arrPedido'])) {
    # code...

?>

<p>Datos no encontrados.</p>

<?php

}else{

    $dataPersona = $data['arrPedido']['persona'];
    $dataPedido = $data['arrPedido']['pedido'];
    $dataProducto = $data['arrPedido']['producto'];
    $transaccion = $dataPedido['transaccionP_id'] != "" ?
$dataPedido['transaccionP_id'] :
$dataPedido['referencia'];
?>
    <section id="sPedido"  class="invoice">
              <div class="row mb-4">
                <div class="col-6">
                  <h2 class="page-header texttitulo">V-SHOES</h2>
                </div>
                <div class="col-6">
                  <h5 class="text-right texttitulo">Fecha: <?= $dataPedido['fecha'] ?></h5>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-12">De
                  <address><strong class="texttitulo"><?= NOMBRE_EMPRESA ?></strong><br>Av. Instituto Tecnológico S/N  <br> Colonia La comunidad C.P 54070, <br>Tlalnepantla de Baz, México<br>Email: <?= EMAIL_EMPRESA ?></address>
                </div>
                <div class="col-12">Para
                  <address><strong class="texttitulo"><?= $dataPersona['nombres'].' '.$dataPersona['apellidos'] ?></strong><br><?= $dataPedido['direccion']?><br>Teléfono: <?= $dataPersona['telefono_persona']?> <br>Email: <?= $dataPersona['email_persona']?></address>
                </div>
                <div class="col-12"><b class="texttitulo">Transacción: <?= $transaccion; ?></b><br><b class="texttitulo">Orden:</b> <?= $dataPedido['id_pedido']?><br><b class="texttitulo">Tipo de pago:</b> <?= $dataPedido['nombre']?><br><b class="texttitulo">Estado:</b> <?= $dataPedido['status_pedido']?><br><b class="texttitulo">Monto:</b> <?= SMONEYAFTER. formatMoney($dataPedido['monto']).' '. SMONEYBEFORE?><br></div>
              </div>
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr class="texttitulo">
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Código de Producto</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>SubTotal</th>
                      </tr>
                    </thead>
                    <tbody>

                    <?php

$precioTotal = 0;
if (count($dataProducto) > 0 ) {
    # code...


                    foreach ($dataProducto as $producto) {
                      
                    $precioTotal += $producto['cantidad'] * $producto['precio'];
                    ?>
                      <tr>
                        <td><?=$producto['cantidad']?></td>
                        <td><?=$producto['nombre_producto']?></td>
                        <td><?=$producto['codigo_producto']?></td>
                        <td><?=$producto['descripcion_producto']?></td>
                        <td><?= SMONEYAFTER.formatMoney($producto['precio']) .' '.SMONEYBEFORE?></td>
                        <td><?= SMONEYAFTER. formatMoney($producto['cantidad'] * $producto['precio']).' '. SMONEYBEFORE ?> </td>
                      </tr>
                     <?php 
                    }
                     }
                     ?>
                    </tbody>
                    <tfoot>

                <tr>
                    <th colspan="5" class="text-right">SubTotal</th>
                    <td class="text-right"> <?= SMONEYAFTER. formatMoney($precioTotal) .' '. SMONEYBEFORE  ?></td>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">Envío</th>
                    <td class="text-right"><?= SMONEYAFTER. formatMoney( $dataPedido['precio_envio']) .' '. SMONEYBEFORE  ?></td>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">Total</th>
                    <td class="text-right"><?= SMONEYAFTER. formatMoney( $dataPedido['monto']) .' '. SMONEYBEFORE  ?></td>
                </tr>

                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row d-print-none mt-2">
                <div class="col-12 text-right"><a class="btn btn-primary" href="javascript:window.print('#sPedido');" ><i class="fa fa-print"></i> Imprimir</a></div>
              </div>
    </section>

<?php
}

?>
        </div>
        
      </div>
    </div>
 
  
</main>


<?php
footerAdmin($data);
?>