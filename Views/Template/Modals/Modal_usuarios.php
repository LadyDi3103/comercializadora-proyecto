<!-- Modal -->
<div class="modal fade" id="modalFormUsuarios" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de usuarios-->
            <div class="modal-body">


                <form class="formulario contenedor form-horizontal" id="formUsuarios" name="formUsuarios">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    <p class="text-danger">
                    <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>
                    </p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label is-invalid" for="txtIdentificacion">Identificación<span class="required">*</span></label>
                            <input class="formtxt form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtNombresUsuario">Nombre&#40;s&#41;<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto " id="txtNombresUsuario" name="txtNombresUsuario" type="text" placeholder="Nombres del Usuario" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtApellidosUsuario">Apellido&#40;s&#41;<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto" id="txtApellidosUsuario" name="txtApellidosUsuario" type="text" placeholder="Apellidos del Usuario" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="strTelefonoUsuario">Teléfono<span class="required">*</span></label>
                            <input class="formtxt form-control valid validNumero" id="strTelefonoUsuario" name="strTelefonoUsuario" type="text" placeholder="Teléfono del Usuario" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class=" form-group col-md-6">
                            <label class="control-label" for="txtEmailUsuario">Email<span class="required">*</span></label>
                            <input class="formtxt form-control valid validEmail" id="txtEmailUsuario" name="txtEmailUsuario" type="email" placeholder="Email del Usuario" required="">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="listaRoles">Tipo de Usuario<span class="required">*</span></label>
                            <select class="formtxt" data-live-search="true" id="listaRoles" name="listaRoles" required="">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="listaEstados">Estado<span class="required">*</span></label>
                            <select class="formtxt selectpicker" id="listaEstados" name="listaEstados" required="">
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtPassUsuario">Contraseña</label>
                            <input class="formtxt form-control" id="txtPassUsuario" name="txtPassUsuario" type="password" placeholder="Contraseña del Usuario">
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

<!--Fin Modal para formulario de usuarios-->


<!-- Modal mostrar informacion de usuario -->
<div class="modal fade" id="modalVerUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para mostrar información de usuarios-->
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Identificación: </td>
                            <td id="celIdentificacion"></td>
                        </tr>
                        <tr>
                            <td>Nombre&#40;s&#41;</td>
                            <td id="celNombres"></td>
                        </tr>
                        <tr>
                            <td>Apellido&#40;s&#41;</td>
                            <td id="celApellidos"></td>
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
                            <td>Tipo de Usuario</td>
                            <td id="celTipoUsuario"></td>
                        </tr>
                        <tr>
                            <td>Estado</td>
                            <td id="celEstado"></td>
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

<!--Fin Modal para mostrar información de usuarios-->