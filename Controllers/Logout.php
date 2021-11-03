<?php


class Logout
{

    public function __construct()
    {
        // iniciar sesion
        session_start();
        //   limpiar varables de sesion
        session_unset();
        //   destruir todas las sesiones
        session_destroy();
        //   redireccionar 
        header('location:' . base_url() . '/login');
    }
}
