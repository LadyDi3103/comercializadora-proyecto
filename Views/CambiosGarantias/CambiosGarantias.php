<?php

headerVshoes($data);

getModal('Modal_producto', $data);


?>


<!-- CAMBIOS Y GARANTIAS -->
<main class="contenedor">
    <div class="contenedor__texto">
        <h1 class="animate__animated animate__fadeInDown">Garantías</h1>
    </div>

    <div class="nosotros">
        <div class="nosotros__contenido">

            <p class="animate__animated animate__zoomIn">
                La devolución deberá solicitarse dentro de los primeros 60 días posteriores a la fecha del pedido.
                Ponte en contacto con nuestro Centro de Atención al Cliente al Teléfono: 55-6577-1520
                Ó envíanos un Correo electrónico a <span class="link-descripcion">vhoes053@gmail.com.</span>
                Para conocer más sobre cambios y garantías consulte el siguiente documento:

                <a class="link-descripcion" href="<?= media() ?>/front/docs/cambios-garantias.pdf" download="cambios-garantias.pdf"> Descargar Cambios y Garantías</a>
            </p>

        </div>
        <img src="<?= media() ?>/front/img/undraw_add_to_cart_vkjp.svg" alt="nosotros" class="nosotros__imagen" />
    </div>
</main>


<!-- FIN CAMBIOS Y GARANTIAS -->



<?php

footerVshoes($data);
?>