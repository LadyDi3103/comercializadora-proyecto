<!-- Modal -->
<div class="modal fade" id="modalFormProveedor" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nuevo Proveedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de proveedores-->
            <div class="modal-body">


                <form class="formulario contenedor form-horizontal" id="formProveedores" name="formProveedores">
                    <input type="hidden" id="idProveedor" name="idProveedor" value="">
                    <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtNombreProveedor">Nombre<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto " id="txtNombreProveedor" name="txtNombreProveedor" type="text" placeholder="Nombres del Proveedor" required="">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="strTelefonoProveedor">Teléfono<span class="required">*</span></label>
                            <input class="formtxt form-control valid validNumero" id="strTelefonoProveedor" name="strTelefonoProveedor" type="text" placeholder="Teléfono del Proveedor" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class=" form-group col-md-6">
                            <label class="control-label" for="txtEmailProveedor">Email</label>
                            <input class="formtxt form-control valid validEmail" id="txtEmailProveedor" name="txtEmailProveedor" type="email" placeholder="Email del Proveedor" required="">
                        </div>
                        <div class=" form-group col-md-6">
                            <label for="listaEstados" for="listaEstados">Estado</label>
                            <select class="formtxt form-control selectpicker" id="listaEstados" name="listaEstados" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>


                    </div>



                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-cancelar" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Fin Modal para formulario de Proveedores-->


<!-- Modal mostrar informacion de Proveedores -->
<div class="modal fade" id="modalVerProveedores" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos del Proveedor</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para mostrar información de Clientes-->
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>

                        <tr>
                            <td>Nombre</td>
                            <td id="celNombre"></td>
                        </tr>

                        <tr>
                            <td>Teléfono</td>
                            <td id="celTelefono"></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td id="celEmail"></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td id="celStatus"></td>
                        </tr>

                        <tr>
                            <td>Fecha de Registro</td>
                            <td id="celFechaRegistro"></td>
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

<!--Fin Modal para mostrar información de proveedores-->