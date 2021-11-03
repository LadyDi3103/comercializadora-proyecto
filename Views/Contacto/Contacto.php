<?php

headerVshoes($data);

getModal('Modal_producto', $data);


?>


<!-- INFO NOSOTROS -->

<main class="contenedor">
    <div class="contenedor__texto">
        <h1 class="animate__animated animate__fadeInDown">Contacto</h1>
    </div>

    <div class="nosotros">
        <div class="nosotros__contenido contacto">
            <form id="formContacto">
                <h1 class="animate__animated animate__fadeInDown">
                    Envía tu mensaje
                </h1>

                <div class="">
                    <input class="form-control formtx valid validTexto input-contacto" type="text" id="nombreContacto" name="nombreContacto" placeholder="Ingresa tu nombre completo">

                </div>
                <div class="">
                    <input class="form-control formtx valid validEmail input-contacto" type="email" id="emailContacto" name="emailContacto" placeholder="Ingresa tu correo electrónico">

                </div>

                <div class="">
                    <textarea class="form-control formtx input-contacto" id="mensajeContacto" name="mensajeContacto" placeholder="¿Cómo podemos ayudarte?"></textarea>
                </div>

                <button class="btn-overlay btn-bg">
                    Enviar
                </button>
            </form>

        </div>
        <img src="<?= media() ?>/front/img/undraw_Mail_re_duel.svg" alt=" contacto" class="nosotros__imagen" />
    </div>
</main>



<!-- FIN INFO NOSOTROS -->


<?php

footerVshoes($data);
?>