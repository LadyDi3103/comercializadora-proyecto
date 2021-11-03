<!-- Modal -->
<div class="modal fade" id="modalFormCategoria" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nueva Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de categorias -->
            <div class="modal-body">


                <div class="tile-body">

                    <form class="formularioCategorias " id="formCategorias" name="formCategorias">
                        <input type="hidden" id="idCategoria" name="idCategoria" value="">
                        <input type="hidden" id="fotoActualizada" name="fotoActualizada" value="">
                        <input type="hidden" id="fotoDesactualizada" name="fotoDesactualizada" value="0">
                        <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>

                        <div class="form-datos">
                            <label class="control-label" for="txtNombre">Nombre<span class="required">*</span></label>
                            <input class="formtxt form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre de la categoría" required="">
                        </div>

                        <div class="form-datos">
                            <label class="control-label" for="txtDescripcion">Descripción<span class="required">*</span></label>
                            <textarea class="formtxt form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción de la categoría" required=""></textarea>
                        </div>
                        <div class="form-datos">
                            <label for="listaEstados" for="listaEstados">Estado<span class="required">*</span></label>
                            <select class="formtxt form-control selectpicker" id="listaEstados" name="listaEstados" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                        <hr>
                        <div class="photo">
                            <label for="foto">Foto de la Categoría</label>
                            <div class="prevPhoto">
                                <span class="delPhoto notBlock">X</span>
                                <label for="foto"></label>
                                <div>
                                    <img id="img" src="<?= media(); ?>/images/uploads/portada_categoria.png">
                                </div>
                            </div>
                            <div class="upimg">
                                <input type="file" name="foto" id="foto">
                            </div>
                            <div id="form_alert"></div>
                        </div>
                        <div class="form-datos">
                            <button id="btnActionForm" class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;<a class="btn btn-cancelar" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
                        </div>


                </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!--Fin Modal para formulario de categorias -->

<!--Fin Modal para formulario de Proveecategorias-->



<!-- Modal mostrar informacion de Proveecategorias -->
<div class="modal fade" id="modalVerCategorias" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos de la Categoria</h5>

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
                            <td>Nombre</td>
                            <td id="celNombre"></td>
                        </tr>

                        <tr>
                            <td>Descripcion</td>
                            <td id="celDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="celStatus"></td>
                        </tr>
                        <tr>
                            <td>Foto</td>
                            <td id="celFoto"></td>
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

<!--Fin Modal para mostrar información de proveecategorias-->