<!-- Modal -->
<div class="modal fade" id="modalFormRol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nuevo Rol</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de roles -->
            <div class="modal-body">


                <div class="tile-body">

                    <form class="formularioRoles " id="formRoles" name="formRoles">
                        <input type="hidden" id="idRol" name="idRol" value="">
                        <div class="form-datos">
                            <label class="control-label" for="txtNombre">Nombre</label>
                            <input class="formtxt form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del rol" required="">
                        </div>

                        <div class="form-datos">
                            <label class="control-label" for="txtDescripcion">Descripción</label>
                            <textarea class="formtxt form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción" required=""></textarea>
                        </div>
                        <div class="form-datos">
                            <label for="listaEstados" for="listaEstados">Estado</label>
                            <select class="formtxt form-control selectpicker" id="listaEstados" name="listaEstados" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
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
<!--Fin Modal para formulario de roles -->