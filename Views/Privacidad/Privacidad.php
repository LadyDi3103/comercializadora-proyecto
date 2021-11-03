<?php

headerVshoes($data);

getModal('Modal_producto', $data);


?>


<!-- PRIVACIDAD -->

<main class="contenedor">
    <div class="contenedor__texto">
        <h1 class="animate__animated animate__fadeInDown">Privacidad</h1>
    </div>

    <div class="nosotros">
        <div class="nosotros__contenido">

            <p class="animate__animated animate__zoomIn">

                Estimados visitantes del sitio web de V-SHOES México:
                En V-SHOES México entendemos la importancia de hacer un buen uso y cuidado de los datos
                personales de nuestros clientes y visitantes (en adelante los "Titulares"), por lo que
                nos comprometemos a tratar sus datos personales de manera legal y confidencial y de acuerdo
                con las disposiciones legales vigentes.

                Este aviso de privacidad corresponde a la empresa V-SHOES MÉXICO SA DE CV, ubicada en
                Av. Instituto Tecnológico S/N Colonia. La comunidad C.P 54070, Tlalnepantla de Baz, México,
                que es la empresa responsable de la recolección, uso, procesamiento, y proteger los datos
                personales de los Titulares.
                <a class="link-descripcion" href="<?= media() ?>/front/docs/politicas-privacidad.pdf" download="politicas-privacidad.pdf">Descargar Políticas de privacidad</a>
            </p>

        </div>
        <img src="<?= media() ?>/front/img/undraw_secure_login_pdn4.svg" alt="nosotros" class="nosotros__imagen" />
    </div>
</main>


<!-- FIN PRIVACIDAD -->



<?php

footerVshoes($data);
?>