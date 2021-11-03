<?php

headerVshoes($data);

getModal('Modal_producto', $data);


?>


<!-- INFO NOSOTROS -->

<main class="contenedor">
    <div class="contenedor__texto">
        <h1 class="animate__animated animate__fadeInDown">Nosotros</h1>
    </div>

    <div class="nosotros">
        <div class="nosotros__contenido">
            <h2 class="animate__animated animate__fadeInDown">Nuestra historia</h2>
            <p class="animate__animated animate__zoomIn">
                V SHOES es una empresa creada el 19 de marzo de 2021, todo comenzó como
                un proyecto escolar, el propósito de la empresa es brindar productos de
                calidad y máximo confort en calzado para toda la familia, así como también
                ofrecer a los empleados crecimiento laboral y personal, apoyándolos con
                capacitación frecuentemente para un mejor desempeño en su lugar de trabajo,
                somos socialmente responsables con el medio ambiente, ya que contamos con
                una línea de calzado ecológico y campañas de reforestación.
            </p>

        </div>
        <img src="<?= media() ?>/front/img/undraw_Team_page_re_cffb.svg" alt="nosotros" class="nosotros__imagen" />
    </div>
</main>



<!-- FIN INFO NOSOTROS -->


<?php

footerVshoes($data);
?>