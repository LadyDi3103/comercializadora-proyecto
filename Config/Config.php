<?php  


const BASE_URL = "http://localhost/vshoes";

// Zona Horaria
date_default_timezone_set('America/Mexico_City');

    const DB_HOST = "localhost";        

    const DB_NAME = "vshoes";

    const DB_USER = "root";
    
    const DB_PASSWORD = "";
    const DB_CHARSET ="utf8" ;
    
    // Separadores 

    const SPD = ".";
    const SPM = ",";

    // Simbolos

    const SMONEYAFTER = "$";
    const SMONEYBEFORE = "MXN";

// Email
const NOMBRE_REMITENTE = "V-SHOES";
const EMAIL_REMITENTE = "no-reply@vshoes.space";
const NOMBRE_EMPRESA = "V-SHOES";
const WEB_EMPRESA = "https://v-shoes.online/";
const DESCRIPCION_EMPRESA = "V-SHOES, el mayor comfort.";

const DIRECCION_EMPRESA = "Av. Instituto Tecnológico S/N Colonia. La comunidad C.P 54070, Tlalnepantla de Baz, México";
const TELEFONO_EMPRESA = "55-6577-1520";
const EMAIL_EMPRESA = "vshoes053@gmail.com";
const EMAIL_COPIA = "vshoes053@gmail.com";


const SLIDER_CATEGORIAS = "1,2,3";
const CARDS_CATEGORIAS = "1,2,3";

const KEY = "vallevidal";
const METODOENCRYPT = "AES-128-ECB";

const PRECIOENVIO = 0;


// constantes para consumo de API de PAYPAL

const IDCLIENTE = "";
const SECRET = "";
const URLPL = "https://api-m.sandbox.paypal.com";

const ConexionCurlGet ="";

// DATOS REALES: const URLPL = "https://api-m.paypal.com";


// Datos para status de pedido


const STATUS_PEDIDO = array('Completo', "Aprobado", "Cancelado", "Reembolsado", "Pendiente", "Entregado", "En camino");
const PRODENPAG = 2;


const HASHTAGS = "VSHOES";

const FACEBOOK_EMPRESA = "https://www.facebook.com/Vshoes2021Moda";
const INSTAGRAM_EMPRESA = "";
const TWITTER_EMPRESA = "";
const WHATSAPP_EMPRESA = "+525524715536";
