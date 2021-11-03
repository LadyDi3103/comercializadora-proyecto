<!-- Modal -->
<div class="modal fade" id="modalFormTallas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nueva Talla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de talla -->
            <div class="modal-body">


                <div class="tile-body">

                    <form class="formularioTallas" id="formTallas" name="formTallas">
                        <input type="hidden" id="idTalla" name="idTalla" value="">
                        <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>

                        <div class="form-datos">
                            <label class="control-label" for="intTalla">Talla<span class="required">*</span></label>
                            <input class="formtxt form-control valid validNumero" id="intTalla" name="intTalla" type="text" placeholder="Talla" required="" onkeypress="return controlTag(event);">
                        </div>

                        <div class="form-datos">
                            <label for="listaEstados" for="listaEstados">Estado<span class="required">*</span></label>
                            <select class="formtxt form-control selectpicker" id="listaEstados" name="listaEstados" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
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
<!--Fin Modal para formulario de talla  -->

<!--Fin Modal para formulario de  talla -->



<!-- Modal mostrar informacion de  talla -->
<div class="modal fade" id="modalVerTallas" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos de la Talla</h5>

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
                            <td>Talla</td>
                            <td id="celTalla"></td>
                        </tr>


                        <tr>
                            <td>Status</td>
                            <td id="celStatus"></td>
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

<!--Fin Modal para mostrar información de  tallas-->