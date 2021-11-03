   <!-- FOOTER -->
   <footer class="section-footer border-top">
       <div class="container">
           <section class="footer-top padding-y">
               <div class="row">
                   <aside class="col-md">
                       <h6 class="title">Empresa</h6>
                       <ul class="list-unstyled">
                           <li> <a href="<?= base_url() ?>/nosotros">Quiénes somos</a></li>

                       </ul>
                   </aside>
                   <aside class="col-md">
                       <h6 class="title">Políticas</h6>
                       <ul class="list-unstyled">
                           <li>
                               <a href=" <?= base_url() ?>/cambiosGarantias">Cambios y garantías</a>
                           </li>
                           <li><a href=" <?= base_url() ?>/privacidad">Privacidad</a></li>
                           <li>
                               <a href=" <?= base_url() ?>/terminosCondiciones">Términos y condiciones</a>
                           </li>
                       </ul>
                   </aside>
                   <aside class="col-md">
                       <h6 class="title">Contáctanos</h6>
                       <ul class="list-unstyled">
                           <li>
                               <a href="#"> <i class="fa fa-map-marker"></i> <?= DIRECCION_EMPRESA ?> </a>
                           </li>
                           <li>
                               <a href="tel:<?= TELEFONO_EMPRESA ?>"> <i class="fa fa-phone"></i> <?= TELEFONO_EMPRESA ?> </a>
                           </li>
                           <li>
                               <a href="mailto: <?= EMAIL_EMPRESA ?>"> <i class="fa fa-envelope"></i> <?= EMAIL_EMPRESA ?> </a>
                           </li>
                       </ul>
                   </aside>

                   <aside class="col-md">
                       <h6 class="title">Redes Sociales</h6>
                       <ul class="list-unstyled">
                           <li>
                               <a href="<?= FACEBOOK_EMPRESA?>"> <i class="fa fa-facebook"></i> Facebook </a>
                           </li>
                           <li>
                               <a href="<?= TWITTER_EMPRESA?>"> <i class="fa fa-twitter"></i> Twitter </a>
                           </li>
                           <li>
                               <a href="<?= INSTAGRAM_EMPRESA?>"> <i class="fa fa-instagram"></i> Instagram </a>
                           </li>
                           <li>
                               <a href="https://wa.me/<?= WHATSAPP_EMPRESA?>"> <i class="fa fa-whatsapp"></i> WhatsApp </a>
                           </li>
                       </ul>
                   </aside>
               </div>
               <!-- row.// -->
           </section>
           <!-- footer-top.// -->

           <section class="footer-bottom border-top row">
               <div class="col-md-2">
                   <p class="text-muted">&copy 2021</p>
               </div>

               <div class="col-md-2 text-muted">
                   <i class="fa fa-cc-visa"></i>
                   <i class="fa fa-cc-paypal"></i>
                   <i class="fa fa-cc-mastercard"></i>
               </div>
           </section>
       </div>
       <!-- //container -->
   </footer>
   <!-- FIN FOOTER -->

   <script>
       const base_url = "<?= base_url(); ?>";
       const SMONETAFTER = "<?= SMONEYAFTER ?>"
   </script>
   <script src="<?= media(); ?>/js/functions_admin.js"></script>
   <script src="<?= media() ?>/js/functions_login.js"></script>
   <script src="<?= media() ?>/front/js/jquery-2.0.0.min.js" type="text/javascript"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
   <script src="<?= media() ?>/front/js/pushbar.js"></script>
   <!-- JavaScript Bundle with Popper -->
   <script src="<?= media() ?>/front/js/script.js"></script>

   <script src="<?= media() ?>/front/vendor/sweetalert/sweetalert.min.js"></script>
   <script src="<?= media() ?>/front/js/functions.js"></script>

   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

   <!-- jQuery -->

   <script>
       $(".js-show-modal-search").on("click", function() {
           $(".modal-search-header").addClass("show-modal-search");
           $(this).css("opacity", "0");
       });

       $(".js-hide-modal-search").on("click", function() {
           $(".modal-search-header").removeClass("show-modal-search");
           $(".js-show-modal-search").css("opacity", "1");
       });

       $(".container-search-header").on("click", function(e) {
           e.stopPropagation();
       });
   </script>




   </body>

   </html>