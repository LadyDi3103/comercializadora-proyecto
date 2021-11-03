<?php

headerVshoes($data);
// getModal('Modal_carrito', $data);
getModal('Modal_producto', $data);
$totalCarrito = 0;
$precioTotal = 0;

foreach ($_SESSION['arrCarrito'] as $producto) {
    $totalCarrito += $producto['precio'] * $producto['cantidad'];
}
$precioTotal = $totalCarrito + PRECIOENVIO;

?>


<script src="https://www.paypal.com/sdk/js?client-id=<?= IDCLIENTE ?>&currency=MXN">
</script>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?= $precioTotal; ?>
                    },
                    description: "Compra realizada en V-SHOES por <?= SMONEYAFTER . $precioTotal . SMONEYBEFORE ?>"
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                let base_url = "<?= base_url(); ?>";
                let direccion = document.getElementById("txtDireccion").value;
                let codigoPostal = document.getElementById("intCodigoPostal").value;
                let estado = document.getElementById("txtEstado").value;
                let ciudad = document.getElementById("txtCiudad").value;
                let colonia = document.getElementById("txtColonia").value;
                let tipoPago = 1;

                let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');

                let ajaxUrl = base_url+'/VshoesProductos/venta';
                let formData = new FormData();
                formData.append('direccion', direccion);
                formData.append('codigoPostal', codigoPostal);
                formData.append('estado', estado);
                formData.append('ciudad', ciudad);
                formData.append('colonia', colonia);
                formData.append('tipoPago',tipoPago);
                formData.append('dataPaypal', JSON.stringify(details));
                request.open("POST", ajaxUrl,true);
                request.send(formData);
                request.onreadystatechange = function (){
                    if (request.readyState  !=4 ) return;
                    if (request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            window.location = base_url+"/VshoesProductos/confirmacionPedido";
                        }else{
                            swal("", objData.msg, "error");
                        }
                    }
                }
            });
        }
    }).render('#paypal-button-container'); // Display payment options on your web page
</script>


<div class="contenedor">
    <nav style="margin-top: 5rem; " aria-label="breadcrumb">
        <ol class="menu_breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Inicio</a></li>
            <li class="breadcrumb-item active" aria-current="page">Proceso de Pago</li>

        </ol>
    </nav>
    <h2 class="categorias_titulo animate__animated animate__rotateInDownLeft">
        Dirección de Envío
    </h2>
    <hr>
    <div class="row detalle-carrito">
        <aside class="col-lg-9">
            <div class="card">

                <div class="table-responsive">

                    <table class="table table-borderless table-shopping-cart" id="tablaCarrito">
                        <article class="card-body">
                            <header class="mb-4">
                                <h4 class="card-title"></h4>
                            </header>

                            <?php
                            if (isset($_SESSION['login'])) {

                            ?>
                                <div class="form-group">
                                    <label>Dirección de la calle</label>
                                    <input id="txtDireccion" type="text" class="form-control" placeholder="">

                                </div>
                                <div class="form-group">
                                    <label>Código Postal</label>
                                    <input id="intCodigoPostal" type="number" class="form-control" placeholder="">

                                </div>
                                <div class="form-group">
                                    <label>Estado/Provincia/Región</label>
                                    <input id="txtEstado" type="text" class="form-control" placeholder="">

                                </div>
                                <div class="form-group">
                                    <label>Ciudad</label>
                                    <input id="txtCiudad" type="text" class="form-control" placeholder="">

                                </div>
                                <div class="form-group">
                                    <label>Colonia</label>
                                    <input id="txtColonia" type="text" class="form-control" placeholder="">

                                </div>
                            <?php } else {
                            ?>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#login" role="tab" aria-controls="home" aria-selected="true">Iniciar Sesión</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="profile" aria-selected="false">Crear Cuenta</a>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <form name="formLogin" id="formLogin">
                                        <div class=" tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="form-group">
                                                <label for="txtEmail">Email</label>
                                                <input id="txtEmail" id="txtEmail" name="txtEmail" type="email" class="form-control formtx valid validEmail" placeholder="Ingresa tu email">
                                            </div>
                                            <div class="form-group">
                                                <label for="txtPassword">Contraseña</label>
                                                <input id="txtPassword" name="txtPassword" type="password" class="form-control formtx" placeholder="Ingresa tu contraseña">
                                            </div>
                                            <button type="submit" class=" btn-bg "> Iniciar Sesión</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="registro" role="tabpanel" aria-labelledby="profile-tab">
                                    <form id="formRegistro">
                                        <div class="tab-pane fade show" id="registro" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="form-group">
                                                <label for="txtNombres">Nombres</label>
                                                <input id="txtNombres" name="txtNombres" type="text" class="form-control formtx valid validTexto" placeholder="Ingresa tu nombre" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="txtApellidos">Apellidos</label>
                                                <input id="txtApellidos" name="txtApellidos" type="text" class="form-control formtx valid validTexto" placeholder="Ingresa tu contraseña" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="txtTelefono">Teléfono</label>
                                                <input class="form-control formtx valid validNumero" id="txtTelefono" name="txtTelefono" type="text" placeholder="Ingresa tu teléfono" required="" onkeypress="return controlTag(event);">
                                            </div>
                                            <div class=" form-group">
                                                <label for="txtEmailCliente">Email</label>
                                                <input class=" form-control formtx valid validEmail" id="txtEmailCliente" name="txtEmailCliente" type="email" placeholder="Ingresa tu email" required="">
                                            </div>
                                            <button type="submit" class=" btn-bg ">Regístrate</button>
                                    </form>
                                </div>





                </div>
            <?php } ?>

            </form>
            </article>
            </table>

            </div>

            <div class="card-body border-top ">
                <p class="icontext "><i class="icon iconos fa fa-truck"></i> Envío gratis</p>
            </div>

    </div>

    </aside>
    <aside class="col-lg-3">


        <div class="card">
            <div class="card-body">
                <dl class="dlist-align">
                    <dt>SubTotal:</dt>
                    <dd id="subtotal" class="text-right"><?= SMONEYAFTER . formatMoney($totalCarrito) . SMONEYBEFORE; ?></dd>

                </dl>
                <dl class="dlist-align">
                    <dt>Envío:</dt>
                    <dd class="text-right"><?= SMONEYAFTER . formatMoney(PRECIOENVIO) . SMONEYBEFORE; ?></dd>

                </dl>


                <hr>
                <dl class="dlist-align">
                    <dt>Total:</dt>
                    <dd id="total" class="text-right"><?= SMONEYAFTER . formatMoney($precioTotal) . SMONEYBEFORE; ?></dd>

                </dl>

                <?php
                if (isset($_SESSION['login'])) {

                ?>
                    <div id="tiposPago" class="notBlock">

                        <h4 class="titulo">
                            Método de pago
                        </h4>


                        <div class="metodosPago">
                            <div>
                                <label for="paypal">
                                    <input type="radio" id="paypal" class="metodoPago" name="metodo-pago" checked="" value="Paypal">
                                    <img src="<?= media() ?>/front/img/paypal.jpg" alt="PayPal" class="ml-space-sm" width="74" height="20">
                                </label>
                            </div>
                            <div>
                                <label for="contraentrega">
                                    <input type="radio" id="contraentrega" class="metodoPago" name="metodo-pago" value="CT">
                                    <span>Otro tipo de pago</span>
                                </label>
                            </div>
                            <div id="tipoPago" class="notBlock">
                                <label for="listaTipoPago">Tipo de pago</label>
                                <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                    <select id="listaTipoPago" class="form-select form-select-lg mb-3" name="listaTipoPago">

                                        <?php

                                        if (count($data['tipos_pago']) > 0) {
                                            foreach ($data['tipos_pago'] as $tipoPago) {
                                                if ($tipoPago['id_tipoPago'] != 1) {


                                        ?>
                                                    <option value="<?= $tipoPago['id_tipoPago'] ?>"><?= $tipoPago['nombre'] ?></option>
                                        <?php
                                                }
                                            }
                                        } ?>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                                <br>
                                <button type="submit" id="pagar" class=" btn-bg btn-block"> Pagar </button>
                            </div>
                            <div id="pagoPaypal">
                                <div>
                                    <p>Para completar la transacción, te enviaremos a los servidores seguros de PayPal.</p>
                                </div>
                                <br>
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>
                    </div>

                    <hr><br>

                <?php }
                ?>
                <a href="<?= base_url() ?>/vshoesProductos" class="btn-bg-white btn-light btn-block">Continuar Comprando</a>
            </div>
        </div>

    </aside>

</div>



</div>


<?php

footerVshoes($data);
?>