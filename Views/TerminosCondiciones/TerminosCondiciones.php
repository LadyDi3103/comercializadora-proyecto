<?php

headerVshoes($data);

getModal('Modal_producto', $data);


?>


<!-- TERMINOS Y CONDICIONES -->

<main class="contenedor">
    <div class="contenedor__texto">
        <h1 class="animate__animated animate__fadeInDown">Terminos y Condiciones</h1>
    </div>

    <div class="nosotros">
        <div class="nosotros__contenido">
            <p class="animate__animated animate__zoomIn">
                Recomendamos leer estos Términos y Condiciones, así como consultar nuestro sitio
                periódicamente para estar informado de cualquier cambio. V-SHOES podrá modificar
                periódicamente los Términos y Condiciones, a su entera discreción, de conformidad
                con las nuevas disposiciones legales y prácticas aplicables a las ventas a través
                de las Plataformas. Y ”acepto los Términos y condiciones ", usted acepta estar sujeto
                a los Términos y condiciones de venta vigentes en el momento de realizar el pedido.
                También se considerará que las personas que utilicen o naveguen por la Plataforma,
                sin realizar pedidos, en virtud de dicho uso, han acordado estar vinculadas
                por nuestros Términos y de uso de la Plataforma y nuestro | mx. V-SHOES.com /privacy-policy.html,
                que se incorpora aquí como referencia.
                <a class="link-descripcion" href="<?= media() ?>/front/docs/terminos-condiciones.pdf" download="terminos-condiciones.pdf"> Descargar Terminos y Condiciones</a>
            </p>

        </div>
        <img src="<?= media() ?>/front/img/undraw_accept_terms_4in8.svg" class="nosotros__imagen" />
    </div>
</main>

<!-- FIN TERMINOS Y CONDICIONES -->




<?php

footerVshoes($data);
?>