<!-- Modal para permisos -->
<div class="modal fade modalPermisos" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Permisos para Roles de Usuario</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                
                <!-- contenido -->
                <div class="col-md-12">
                    <div class="tile">
                        <form action="" id="formPermisos" name="formPermisos">
                        <input type="hidden" name="idRol" id="idRol" value="<?= $data['rol_id']; ?>" required="">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Módulo</th>
                                            <th>Ver</th>
                                            <th>Crear</th>
                                            <th>Actualizar</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $num = 1;
                                        $modulos = $data['modulos'];
                                        for ($i = 0; $i < count($modulos); $i++) {
                                            $permisos = $modulos[$i]['permisos'];
                                            $rCheck = $permisos['r'] == 1 ? " checked " : "";
                                            $wCheck = $permisos['w'] == 1 ? " checked " : "";
                                            $uCheck = $permisos['u'] == 1 ? " checked " : "";
                                            $dCheck = $permisos['d'] == 1 ? " checked " : "";
                                            $idModulo = $modulos[$i]['id_modulo'];

                                        ?>
                                            <tr>
                                                <td><?= $num; ?>
                                                    <input type="hidden" name="modulos[<?= $i; ?>][id_modulo]" value="<?= $idModulo ?>" required>
                                                </td>
                                                <td>
                                                    <?= $modulos[$i]['titulo_modulo'] ?>
                                                </td>
                                                
                                                <td>
                                                    <div class="toggle-flip">
                                                        <label>
                                                            <input type="checkbox" name="modulos[<?= $i; ?>][r]" <?= $rCheck ?>><span class=" flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="toggle-flip">
                                                        <label>
                                                            <input type="checkbox" name="modulos[<?= $i; ?>][w]" <?= $wCheck ?>><span class=" flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="toggle-flip">
                                                        <label>
                                                            <input type="checkbox" name="modulos[<?= $i; ?>][u]" <?= $uCheck ?>><span class=" flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="toggle-flip">
                                                        <label>
                                                            <input type="checkbox" name="modulos[<?= $i; ?>][d]" <?= $dCheck ?>><span class=" flip-indecator" data-toggle-on="ON" data-toggle-off="OFF"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                            $num++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-guardar" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Guardar</button>&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-cancelar" href="#" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Salir</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para permisos -->