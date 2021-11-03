   <?php headerAdmin($data);
   getModal('Modal_perfil', $data);
   ?>
   <main class="app-content">
       <div class="row user">
           <div class="col-md-12">
               <div class="profile">
                   <div class="info"><img class="user-img" src="<?= media(); ?>/images/perfil.png">
                       <h4><?= $_SESSION['usuarioData']['nombres'] . " " . $_SESSION['usuarioData']['apellidos']; ?></h4>
                       <p><?= $_SESSION['usuarioData']['nombre_rol']; ?></p>
                   </div>

               </div>
           </div>
           <div class="col-md-3">
               <div class="tile p-0">
                   <ul class="nav flex-column nav-tabs user-tabs">
                       <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos Personales</a></li>
                       <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Información Fiscal</a></li>
                   </ul>
               </div>
           </div>
           <div class="col-md-9">
               <div class="tab-content">
                   <div class="tab-pane active" id="user-timeline">
                       <div class="timeline-post">
                           <div class="post-media">
                               <div class="content">
                                   <h5>Datos Personales <button class="btn btn-sm btn-primary" type="button" onclick="openModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button></h5>

                               </div>
                           </div>
                           <table class="table table-bordered">
                               <tbody>

                                   <tr>
                                       <td>Identificación</td>
                                       <td> <?= $_SESSION['usuarioData']['identificacion_persona'] ?></td>
                                   </tr>
                                   <tr>
                                       <td>Nombre&#40;s&#41;</td>
                                       <td> <?= $_SESSION['usuarioData']['nombres'] ?></td>
                                   </tr>
                                   <tr>
                                       <td>Apellido&#40;s&#41;</td>
                                       <td> <?= $_SESSION['usuarioData']['apellidos'] ?></td>
                                   </tr>
                                   <tr>
                                       <td>Teléfono</td>
                                       <td> <?= $_SESSION['usuarioData']['telefono_persona'] ?></td>
                                   </tr>
                                   <tr>
                                       <td>Correo Electrónico</td>
                                       <td> <?= $_SESSION['usuarioData']['email_persona'] ?></td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                   </div>
                   <div class="tab-pane fade" id="user-settings">
                       <div class="tile user-settings">
                           <h4 class="line-head">Información Fiscal</h4>
                           <form action="" id="formDatosFiscales" name="formDatosFiscales">
                               <div class="row mb-4">
                                   <div class="col-md-6">
                                       <label>RFC</label>
                                       <input class="form-control formtxt" type="text" id="txtRfc" name="txtRfc" value="<?= $_SESSION['usuarioData']['rfc_persona'] ?>">
                                   </div>
                                   <div class="col-md-6">
                                       <label>Dirección Fiscal</label>
                                       <input class="form-control formtxt" type="text" id="txtDireccionFiscal" name="txtDireccionFiscal" value="<?= $_SESSION['usuarioData']['direccion_fiscal'] ?>">

                                   </div>
                               </div>

                               <div class="row mb-10">
                                   <div class="col-md-12">
                                       <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Guardar</button>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </main>


   <?php footerAdmin($data) ?>