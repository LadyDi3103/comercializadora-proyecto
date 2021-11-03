<!-- Modal -->
<div class="modal fade" id="modalFormCodigos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Generar Código QR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de colores -->
            <div class="modal-body">


                <div class="tile-body">

                    <form class="formularioCodigos" id="formCodigos" name="formCodigos">
                        <input type="hidden" id="idCodigo" name="idCodigo" value="">
                        <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>
                        <div class="form-datos">
                            <label class="control-label" for="listaProductos">Producto<span class="required">*</span></label>
                            <select class="formtxt form-control" data-live-search="true" id="listaProductos" name="listaProductos" required=""></select>
                        </div>

                        <div class="form-datos">
                            <label class="control-label" for="txtUrl">URL<span class="required">*</span></label>

                            <input class="formtxt form-control" name="text" id="text" type="text" value="" style="width:80%" /><br />
                            <div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
                        </div>

                        <hr>

                        <div class="form-datos">
                            <button id="btnActionForm" class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-cancelar" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>


                </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!--Fin Modal para formulario de colores -->

<!--Fin Modal para formulario de  colores-->



<!-- Modal mostrar informacion de  colores -->
<div class="modal fade" id="modalVerCodigo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Código QR</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                
                <div class="form-datos">
                    <label class="control-label" for="nombreProducto">Nombre Producto<span class="required"></label>
                    <input class="formtxt form-control" data-live-search="true" id="nombreProducto" name="nombreProducto" disabled>
                </div>

                <div class="form-datos">
                    <label class="control-label" for="txtUrl">URL<span class="required"></label>

                    <input class="formtxt form-control" name="text" id="textv" type="text" value="" style="width:80%"  /><br />
                    <div id="qrcodev" style="width:100px; height:100px; margin-top:15px;"></div>
                </div>

                <hr>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-guardar" data-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<!--Fin Modal para mostrar información de  colores-->