<!-- Modal -->
<div class="modal fade" id="modalFormProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de categorias -->
            <div class="modal-body">


                <div class="tile-body">

                    <form class="formularioProductos" id="formProductos" name="formProductos">

                        <input type="hidden" id="idProducto" name="idProducto" value="">
                        <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-datos">
                                    <label class="control-label" for="txtNombre">Nombre del Producto<span class="required">*</span></label>
                                    <input class="formtxt form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del producto" required="">
                                    <br>
                                </div>



                                <div class="form-datos">
                                    <label class="control-label" for="txtDescripcion">Descripción del Producto</label>
                                    <textarea class="formtxt form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Descripción del producto"></textarea>
                                </div>
                                <div class="form-datos">
                                    <div id="containerGallery">
                                        <span>Agregar fotos del producto</span>
                                        <button class="btnAddImage btn btn-guardar btn-sm" type="button"><i class="fas fa-plus"></i></button>
                                    </div>
                                    <hr>
                                    <div id="containerImages">


                                    </div>
                                </div>
                            </div>



                            <div class="col-md-5">
                                <div class="form-datos">
                                    <label class="control-label" for="txtCodigo">Código del Producto<span class="required">*</span></label>
                                    <input class="formtxt form-control" id="txtCodigo" name="txtCodigo" type="text" placeholder="Código del producto" required="">
                                    <br>
                                    <div id="divBarCode" class="notBlock textcenter">
                                        <div id="printCode">
                                            <svg id="barcode"></svg>
                                        </div>
                                        <!-- <button class="btn btn-success btn-sm" type="button" onclick="fntPrintBarCode(`#printCode`)"><i class="fas fa-print"></i>&nbsp;Imprimir</button> -->
                                    </div>
                                </div>
                              
<hr>
                                <div class="row">
                                    <div class="form-datos col-md-4">
                                        <label class="control-label" for="txtPrecio">Precio<span class="required">*</span></label>
                                        <input class="formtxt form-control" id="txtPrecio" name="txtPrecio" type="text" required="">
                                    </div>
                                    <div class="form-datos col-md-4">
                                        <label class="control-label" for="txtStock">Stock<span class="required">*</span></label>
                                        <input class="formtxt form-control" id="txtStock" name="txtStock" type="text" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-datos col-md-4">
                                        <label class="control-label" for="listaCategorias">Categorías<span class="required">*</span></label>
                                        <select class="formtxt form-control" data-live-search="true" id="listaCategorias" name="listaCategorias" required=""></select>
                                    </div>
                                    <div class="form-datos col-md-4">
                                        <label for="listaEstados">Estado<span class="required">*</span></label>
                                        <select class="formtxt form-control selectpicker" id="listaEstados" name="listaEstados" required="">
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-datos col-md-4">
                                        <label class="control-label" for="listaColores">Color<span class="required">*</span></label>
                                        <select class="formtxt form-control" data-live-search="true" id="listaColores" name="listaColores" required=""></select>
                                    </div>
                                    <div class="form-datos col-md-4">
                                        <label class="control-label" for="listaProveedores">Proveedor<span class="required">*</span></label>
                                        <select class="formtxt form-control" data-live-search="true" id="listaProveedores" name="listaProveedores" required=""></select>
                                    </div>
                                </div>

                                <div class="tile-footer">
                                    <button id="btnActionForm" class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">&nbsp;Guardar</span></button>&nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-cancelar" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>&nbsp;Cerrar</button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>

            </div>


        </div>
    </div>
</div>
</div>
<!--Fin Modal para formulario de categorias -->

<!--Fin Modal para formulario de Productos-->



<!-- Modal mostrar informacion de Productos -->
<div class="modal fade" id="modalVerProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos del Productos</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <td>ID:</td>
                            <td id="celId"></td>
                        </tr>
                        <tr>
                            <td>Código:</td>
                            <td id="celCodigo"></td>
                        </tr>
                        <tr>
                            <td>Nombre:</td>
                            <td id="celNombre"></td>
                        </tr>
                        <tr>
                            <td>Categoria:</td>
                            <td id="celCategoria"></td>
                        </tr>
                        <tr>
                            <td>Color:</td>
                            <td id="celColor"></td>
                        </tr>
                        <tr>
                            <td>Proveedor:</td>
                            <td id="celProveedor"></td>
                        </tr>

                        <tr>
                            <td>Descripcion:</td>
                            <td id="celDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Precio:</td>
                            <td id="celPrecio"></td>
                        </tr>

                        <tr>
                            <td>Stock:</td>
                            <td id="celStock"></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td id="celStatus"></td>
                        </tr>
                        <tr>
                            <td>Fotos:</td>
                            <td id="celFotos"></td>
                        </tr>


                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-guardar" data-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<!--Fin Modal para mostrar información de producto-->