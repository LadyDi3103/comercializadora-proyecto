<!-- Modal -->
<div class="modal fade" id="modalFormPerfilUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerResgistro">
                <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal para formulario de usuarios-->
            <div class="modal-body">
                <form class="formulario contenedor form-horizontal" id="formPerfilUsuario" name="formPerfilUsuario">

                    <p class="text-danger">Los campos marcados con (<span class="required">*</span>) son obligatorios </p>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label is-invalid" for="txtIdentificacion">Identificación</label>
                            <input class="formtxt form-control" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación" required="" value="<?= $_SESSION['usuarioData']['identificacion_persona']; ?>" readonly disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtNombresUsuario">Nombre&#40;s&#41;<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto " id="txtNombresUsuario" name="txtNombresUsuario" type="text" placeholder="Nombres del Usuario" required="" value="<?= $_SESSION['usuarioData']['nombres']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtApellidosUsuario">Apellido&#40;s&#41;<span class="required">*</span></label>
                            <input class="formtxt form-control valid validTexto" id="txtApellidosUsuario" name="txtApellidosUsuario" type="text" placeholder="Apellidos del Usuario" required="" value="<?= $_SESSION['usuarioData']['apellidos']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="strTelefonoUsuario">Teléfono<span class="required">*</span></label>
                            <input class="formtxt form-control valid validNumero" id="strTelefonoUsuario" name="strTelefonoUsuario" type="text" placeholder="Teléfono del Usuario" required="" value="<?= $_SESSION['usuarioData']['telefono_persona']; ?>" onkeypress="return controlTag(event);">
                        </div>
                        <div class=" form-group col-md-6">
                            <label class="control-label" for="txtEmailUsuario">Email</label>
                            <input class="formtxt form-control valid validEmail" id="txtEmailUsuario" name="txtEmailUsuario" type="email" placeholder="Email del Usuario" required="" value="<?= $_SESSION['usuarioData']['email_persona']; ?>" readonly disabled>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtPassUsuario">Contraseña</label>
                            <input class="formtxt form-control" id="txtPassUsuario" name="txtPassUsuario" type="password" placeholder="Contraseña del Usuario">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label" for="txtPassUsuarioConfirm">Confirmar Contraseña</label>
                            <input class="formtxt form-control" id="txtPassUsuarioConfirm" name="txtPassUsuarioConfirm" type="password" placeholder="Contraseña del Usuario">
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-cancelar" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!--Fin Modal para formulario de usuarios-->