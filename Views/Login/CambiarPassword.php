<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Fernanda Vidal Isabel Del Valle">
    <meta name="theme-color" content="#4f0000">



    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">

    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/login.css">


    <title><?= $data['page_title']; ?> </title>
</head>

<body>
    <img class="wave" src="<?= media(); ?>/images/6.png" alt="">
    <div class="contenedor-general">
        <div class="img ">
            <img src="<?= media(); ?>/images/undraw_Online_information_re_erks.svg" alt="" />
        </div>
        <div class="box">
            <div id="loading">
                <div class="">
                    <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
                </div>
            </div>
            <div class="container-forms">
                <div class="login-container">
                    <form action="" name="formCambiarPass" id="formCambiarPass">
                        <input type="hidden" name="idUsuario" id="idUsuario" value="<?= $data['id_persona']; ?>">
                        <input type="hidden" name="txtEmail" id="txtEmail" value="<?= $data['email_persona']; ?>">
                        <input type="hidden" name="txtToken" id="txtToken" value="<?= $data['token']; ?>">
                        <img class="avatar" src="<?= media(); ?>/images/user-svgrepo-com.svg" alt="" />
                        <h2>Cambiar Contraseña</h2>
                        <div class="input-div uno">
                            <div class="i">
                                <i class="fa fa-lock"></i>

                            </div>
                            <div class="div">
                                <h5>Nueva Contraseña</h5>
                                <input class="input" type="password" name="txtPassword" id="txtPassword" required />
                            </div>
                        </div>
                        <div class="input-div dos">
                            <div class="i">
                                <i class="fa fa-lock"></i>
                            </div>
                            <div class="div">
                                <h5>Confirmar Contraseña</h5>
                                <input class="input" type="password" name="txtPasswordConfirmar" id="txtPasswordConfirmar" required />
                            </div>
                        </div>

                        <button class="btn btn-guardar" type="submit">Enviar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script>
        const base_url = "<?= base_url(); ?>"
    </script>
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>

    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>

    <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
</body>

</html>