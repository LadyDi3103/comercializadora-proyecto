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
      <li class="breadcrumb-item"><a href="#"><?= $data['page_title'] ?></a></li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="tile">
        <div class="tile-body">Bienvenido.

<?php 
// echo getTokenPaypal();

// $respuestaApi = getConnectionCurl(URLPL. "/v2/checkout/orders/0LU398550U819200A", "application/json", getTokenPaypal());
// dep($respuestaApi);
// $respuestaPost = postConnectionCurl(URLPL. "/v2/payments/captures/3G130889R5951554P/refund", "application/json", getTokenPaypal());
// dep($respuestaPost);


?>
        </div>
        
      </div>
    </div>
  </div>
</main>


<?php
footerAdmin($data);
?>