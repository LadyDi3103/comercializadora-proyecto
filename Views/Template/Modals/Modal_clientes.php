<!-- Modal -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegistro">
                <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de usuarios-->
            <div class="modal-body">


                <form class="formulario contenedor form-horizontal" id="formClientes" name="formClientes">

                    <p class="text-primary">Información Personal</p>
                    <input type="hidden" id="idCliente" name="idCliente" value="">
                    <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label is-invalid" for="txtIdentificacion">Identificación<span class="required">*</span></label>
                            <input class="formtxt form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtNombresCliente">Nombre&#40;s&#41;<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto " id="txtNombresCliente" name="txtNombresCliente" type="text" placeholder="Nombres del Cliente" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtApellidosCliente">Apellido&#40;s&#41;<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto" id="txtApellidosCliente" name="txtApellidosCliente" type="text" placeholder="Apellidos del Cliente" required="">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label" for="strTelefonoCliente">Teléfono<span class="required">*</span></label>
                            <input class="formtxt form-control valid validNumero" id="strTelefonoCliente" name="strTelefonoCliente" type="text" placeholder="Teléfono del Cliente" required="" onkeypress="return controlTag(event);">
                        </div>
                        <div class=" form-group col-md-4">
                            <label class="control-label" for="txtEmailCliente">Email</label>
                            <input class="formtxt form-control valid validEmail" id="txtEmailCliente" name="txtEmailCliente" type="email" placeholder="Email del Cliente" required="">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtPassCliente">Contraseña</label>
                            <input class="formtxt form-control" id="txtPassCliente" name="txtPassCliente" type="password" placeholder="Contraseña del Cliente">
                        </div>
                    </div>
                    <hr>
                    <p class="text-primary">Información Fiscal</p>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label>RFC<span class="required">*</span></label>
                            <input class="form-control formtxt" type="text" id="txtRfc" name="txtRfc" required>
                        </div>
                        <div class="col-md-6">
                            <label>Dirección Fiscal<span class="required">*</span></label>
                            <input class="form-control formtxt" type="text" id="txtDireccionFiscal" name="txtDireccionFiscal" required>

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

<!--Fin Modal para formulario de clientes-->


<!-- Modal mostrar informacion de Clientes -->
<div class="modal fade" id="modalVerClientes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header header-primary">

                <h5 class="modal-title" id="titleModal">Datos del Clientes</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para mostrar información de Clientes-->
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
                            <td>RFC</td>
                            <td id="celRfc"></td>
                        </tr>
                        <tr>
                            <td>Dirección Fiscal</td>
                            <td id="celDireccionFiscal"></td>
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