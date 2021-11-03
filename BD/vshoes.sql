-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 16-08-2021 a las 21:30:04
-- Versión del servidor: 5.7.31
-- Versión de PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vshoes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_categoria` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen_categoria` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_categoria` int(11) NOT NULL DEFAULT '1',
  `url_categoria` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion_categoria`, `imagen_categoria`, `date_created`, `status_categoria`, `url_categoria`) VALUES
(1, 'Dama', 'Dama', 'img_4bd82ab8a65120caccd22bd4934d1045.jpg', '2021-06-21 11:15:36', 1, 'dama'),
(2, 'Caballeros', 'Caballeros', 'img_1308dde2f892f84b618e85b1cdf8f42c.jpg', '2021-06-21 11:16:28', 1, 'caballeros'),
(3, 'Niños', 'Niños', 'img_1f68a77e39e532b27545e600f3867b96.jpg', '2021-06-21 11:36:37', 1, 'ninos'),
(8, 'Ejemplo', 'ejemplo', 'img_e3da615678b8ebe336b496c97b571bc4.jpg', '2021-07-12 11:54:35', 1, 'ejemplo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

DROP TABLE IF EXISTS `colores`;
CREATE TABLE IF NOT EXISTS `colores` (
  `id_color` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_color` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `status_color` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_color`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id_color`, `nombre_color`, `status_color`) VALUES
(1, 'Café', 1),
(2, 'Rojo', 1),
(3, 'Blanco', 1),
(4, 'prueba', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

DROP TABLE IF EXISTS `detalle_pedido`;
CREATE TABLE IF NOT EXISTS `detalle_pedido` (
  `id_detallePedido` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `color` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `talla` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_detallePedido`),
  KEY `pedido_id` (`pedido_id`),
  KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detallePedido`, `pedido_id`, `producto_id`, `precio`, `cantidad`, `color`, `talla`) VALUES
(1, 5, 1, '1500.00', 1, 'Café', '24'),
(2, 6, 1, '1500.00', 2, 'Café', '24'),
(3, 7, 3, '1200.00', 1, 'Blanco', '28'),
(4, 8, 3, '1200.00', 1, 'Blanco', '24'),
(5, 9, 4, '800.00', 1, 'Café', '24'),
(6, 10, 3, '1200.00', 1, 'Blanco', '24'),
(7, 10, 1, '1500.00', 1, 'Café', '24'),
(8, 11, 3, '1200.00', 2, 'Blanco', '24'),
(9, 12, 2, '500.00', 2, 'Rojo', '24'),
(10, 13, 1, '1500.00', 1, 'Café', '24'),
(11, 14, 3, '1200.00', 1, 'Blanco', '24'),
(12, 15, 1, '1500.00', 1, 'Café', '24'),
(13, 16, 1, '1500.00', 1, 'Café', '24'),
(14, 17, 1, '1500.00', 1, 'Café', '24'),
(15, 17, 2, '500.00', 1, 'Rojo', '24'),
(16, 17, 3, '1200.00', 1, 'Blanco', '24'),
(17, 18, 3, '1200.00', 1, 'Blanco', '24'),
(18, 19, 3, '1200.00', 1, 'Blanco', '24'),
(19, 19, 1, '1500.00', 1, 'Café', '24'),
(20, 19, 2, '500.00', 1, 'Rojo', '24'),
(21, 20, 4, '800.00', 1, 'Café', '24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_producto`
--

DROP TABLE IF EXISTS `detalle_producto`;
CREATE TABLE IF NOT EXISTS `detalle_producto` (
  `id_detalleProducto` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id_detalleProducto`),
  KEY `producto_id` (`producto_id`),
  KEY `talla_id` (`talla_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_temp`
--

DROP TABLE IF EXISTS `detalle_temp`;
CREATE TABLE IF NOT EXISTS `detalle_temp` (
  `id_temp` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `color` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `talla` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `transaccion_id` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_temp`),
  KEY `producto_id` (`producto_id`),
  KEY `persona_id` (`persona_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_producto`
--

DROP TABLE IF EXISTS `imagen_producto`;
CREATE TABLE IF NOT EXISTS `imagen_producto` (
  `id_imagen` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_imagen`),
  KEY `producto_id` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `imagen_producto`
--

INSERT INTO `imagen_producto` (`id_imagen`, `producto_id`, `imagen`) VALUES
(36, 1, 'prcto_e86e1f101870c36ff1c3eb0814899ccf.jpg'),
(37, 1, 'prcto_6f806731ba1afa755d8454b5b898bfb0.jpg'),
(39, 3, 'prcto_5f13fded385531a0c68b2f25baecb774.jpg'),
(42, 2, 'prcto_d7d8d511bee886c5a2a2b83b319aae69.jpg'),
(43, 4, 'prcto_a1007835e7e0088f1f07a92df1021540.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

DROP TABLE IF EXISTS `modulo`;
CREATE TABLE IF NOT EXISTS `modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_modulo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_modulo` text COLLATE utf8_spanish_ci NOT NULL,
  `status_modulo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`id_modulo`, `titulo_modulo`, `descripcion_modulo`, `status_modulo`) VALUES
(1, 'Dashboard', 'Dashboard', 1),
(2, 'Usuarios', 'Usuarios del sistema.', 1),
(3, 'Clientes', 'Clientes de vshoes.', 1),
(4, 'Productos', 'Todos los productos', 1),
(5, 'Proveedores', 'Proveedores', 1),
(6, 'Pedidos', 'Pedidos', 1),
(7, 'Categorias', 'Categorías de zapatos', 1),
(8, 'Tallas', 'Tallas de zapatos', 1),
(9, 'Colores', 'Colores de zapatos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numeros_talla`
--

DROP TABLE IF EXISTS `numeros_talla`;
CREATE TABLE IF NOT EXISTS `numeros_talla` (
  `id_numeroTalla` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `status_talla` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_numeroTalla`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `numeros_talla`
--

INSERT INTO `numeros_talla` (`id_numeroTalla`, `numero`, `status_talla`) VALUES
(1, 24, 1),
(2, 22, 1),
(3, 26, 1),
(4, 30, 1),
(5, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `referencia` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `transaccionP_id` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `datosP` text COLLATE utf8_spanish_ci,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `monto` decimal(11,2) DEFAULT NULL,
  `precio_envio` decimal(10,2) DEFAULT '0.00',
  `direccion` text COLLATE utf8_spanish_ci,
  `tipoPago_id` int(11) DEFAULT NULL,
  `status_pedido` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `persona_id` (`persona_id`),
  KEY `tipoPago_id` (`tipoPago_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `persona_id`, `referencia`, `transaccionP_id`, `datosP`, `fecha`, `monto`, `precio_envio`, `direccion`, `tipoPago_id`, `status_pedido`) VALUES
(4, 6, NULL, '8MM1557182692191F', '{\"id\":\"59C23034U4415901W\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1500.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $1500MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"8MM1557182692191F\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1500.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-03T22:57:04Z\",\"update_time\":\"2021-08-03T22:57:04Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-03T22:45:31Z\",\"update_time\":\"2021-08-03T22:57:04Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/59C23034U4415901W\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-03 18:10:00', '1500.00', '0.00', 'z,x,Tizayuca,x,43816', 1, 'Aprobado'),
(5, 6, NULL, '7RA099867B204711R', '{\"id\":\"20L76428DD101754N\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1500.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $1500MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"7RA099867B204711R\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1500.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-04T00:48:39Z\",\"update_time\":\"2021-08-04T00:48:39Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-04T00:47:37Z\",\"update_time\":\"2021-08-04T00:48:39Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/20L76428DD101754N\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-03 19:48:53', '1500.00', '0.00', 'c,c,c,c,2', 1, 'Aprobado'),
(6, 6, NULL, '3PH30854VN403045D', '{\"id\":\"83855862VL924620H\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"3000.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $3000MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"3PH30854VN403045D\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"3000.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-04T03:42:09Z\",\"update_time\":\"2021-08-04T03:42:09Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-04T03:40:57Z\",\"update_time\":\"2021-08-04T03:42:09Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/83855862VL924620H\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-03 22:42:24', '3000.00', '0.00', 'fuentes,tz,Tizayuca,hgo,43816', 1, 'Aprobado'),
(7, 6, NULL, NULL, NULL, '2021-08-04 13:24:25', '1200.00', '0.00', 'Hidalgo,c,Tizayuca,c,43816', 2, 'Pendiente'),
(8, 6, NULL, NULL, NULL, '2021-08-05 12:16:14', '1200.00', '0.00', 'Fuente De Anteo,FUENTES DE TIZAYUCA,TIZAYUCA,HIDALGO,43816', 2, 'Pendiente'),
(9, 6, NULL, NULL, NULL, '2021-08-05 12:22:49', '800.00', '0.00', 'Hidalgo, C, TIZAYUCA, C, 43816', 2, 'Pendiente'),
(10, 6, NULL, NULL, NULL, '2021-08-05 16:48:16', '2750.00', '0.00', 'Fuente De Anteo, FUENTES DE TIZAYUCA, TIZAYUCA, HIDALGO, 43816', 2, 'Pendiente'),
(11, 6, NULL, NULL, NULL, '2021-08-05 18:26:51', '2450.00', '50.00', 'Hidalgo, C, TIZAYUCA, C, 43816', 2, 'Pendiente'),
(12, 6, '43434333', NULL, NULL, '2021-08-05 20:53:48', '1000.00', '0.00', 'Hidalgo, V, TIZAYUCA, V, 43816', 2, 'En camino'),
(13, 6, NULL, '3PS58485EE303373D', '{\"id\":\"1DL86341J4914941J\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1500.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $1500MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"3PS58485EE303373D\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1500.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-07T04:50:05Z\",\"update_time\":\"2021-08-07T04:50:05Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-07T04:48:37Z\",\"update_time\":\"2021-08-07T04:50:05Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/1DL86341J4914941J\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-06 23:50:41', '1500.00', '0.00', 'Hidalgo, F, TIZAYUCA, F, 43816', 1, 'Reembolsado'),
(14, 1, NULL, '3G130889R5951554P', '{\"id\":\"0LU398550U819200A\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1200.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $1200MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"3G130889R5951554P\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1200.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-08T18:14:22Z\",\"update_time\":\"2021-08-08T18:14:22Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-08T18:13:22Z\",\"update_time\":\"2021-08-08T18:14:22Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/0LU398550U819200A\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-08 13:14:44', '1200.00', '0.00', 'Hidalgo, V, TIZAYUCA, C, 43816', 1, 'Aprobado'),
(15, 1, '234234', NULL, NULL, '2021-08-08 13:24:42', '1500.00', '0.00', 'Hidalgo, V, TIZAYUCA, VV, 43816', 1, 'Aprobado'),
(16, 1, '23232', NULL, NULL, '2021-08-08 13:27:58', '1500.00', '0.00', 'Hidalgo, VD, TIZAYUCA, D, 43816', 1, 'Aprobado'),
(17, 1, '111111111111', NULL, NULL, '2021-08-09 23:24:21', '3200.00', '0.00', 'Hidalgo, PRUEBA, TIZAYUCA, PRUEBA, 43816', 1, 'Entregado'),
(18, 1, NULL, '5F5511036F548234B', '{\"id\":\"6UN55721KX100453B\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1200.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $1200MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"5F5511036F548234B\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"1200.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-10T17:16:19Z\",\"update_time\":\"2021-08-10T17:16:19Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-10T17:11:35Z\",\"update_time\":\"2021-08-10T17:16:19Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/6UN55721KX100453B\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-10 12:16:58', '1200.00', '0.00', 'Hidalgo, A, TIZAYUCA, A, 43816', 1, 'Aprobado'),
(19, 1, NULL, '2JC14132M08671424', '{\"id\":\"3HH008807J360054Y\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"3200.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $3200MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"2JC14132M08671424\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"3200.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-12T21:03:26Z\",\"update_time\":\"2021-08-12T21:03:26Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-12T21:02:40Z\",\"update_time\":\"2021-08-12T21:03:26Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/3HH008807J360054Y\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-12 16:03:29', '3200.00', '0.00', 'Fuente De Anteo, FUENTES DE TIZAYUCA, TIZAYUCA, HIDALGO, 43816', 1, 'Entregado'),
(20, 1, NULL, '4U384591PD9527357', '{\"id\":\"8T208552RX292963D\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"800.00\"},\"payee\":{\"email_address\":\"sb-x0dnz6990305@business.example.com\",\"merchant_id\":\"KDGPS2BCW59U4\"},\"description\":\"Compra realizada en V-SHOES por $800MXN\",\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"John Doe\"},\"address\":{\"address_line_1\":\"Calle Juarez 1\",\"address_line_2\":\"Col. Cuauhtemoc\",\"admin_area_2\":\"Miguel Hidalgo\",\"admin_area_1\":\"Ciudad de Mexico\",\"postal_code\":\"11580\",\"country_code\":\"MX\"}},\"payments\":{\"captures\":[{\"id\":\"4U384591PD9527357\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"MXN\",\"value\":\"800.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2021-08-12T21:14:16Z\",\"update_time\":\"2021-08-12T21:14:16Z\"}]}}],\"payer\":{\"name\":{\"given_name\":\"John\",\"surname\":\"Doe\"},\"email_address\":\"sb-losrp6990029@personal.example.com\",\"payer_id\":\"EQXAPASYH597J\",\"address\":{\"country_code\":\"MX\"}},\"create_time\":\"2021-08-12T21:14:02Z\",\"update_time\":\"2021-08-12T21:14:16Z\",\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/8T208552RX292963D\",\"rel\":\"self\",\"method\":\"GET\"}]}', '2021-08-12 16:14:17', '800.00', '0.00', 'Prueba, PRUEBA, TIZAYUCA, PRUEBA, 43816', 1, 'En camino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `rol_id` int(11) NOT NULL,
  `modulo_id` int(11) NOT NULL,
  `r` int(11) NOT NULL DEFAULT '0',
  `w` int(11) NOT NULL DEFAULT '0',
  `u` int(11) NOT NULL DEFAULT '0',
  `d` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_permiso`),
  KEY `rol_id` (`rol_id`),
  KEY `modulo_id` (`modulo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1371 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `rol_id`, `modulo_id`, `r`, `w`, `u`, `d`) VALUES
(876, 3, 1, 0, 0, 0, 0),
(877, 3, 2, 0, 0, 0, 0),
(878, 3, 3, 1, 1, 1, 1),
(879, 3, 4, 0, 0, 0, 0),
(880, 3, 5, 0, 0, 0, 0),
(881, 3, 6, 1, 1, 1, 1),
(882, 3, 7, 0, 0, 0, 0),
(883, 3, 8, 0, 0, 0, 0),
(884, 3, 9, 0, 0, 0, 0),
(957, 2, 1, 0, 0, 0, 0),
(958, 2, 2, 1, 1, 1, 1),
(959, 2, 3, 0, 0, 0, 0),
(960, 2, 4, 0, 0, 0, 0),
(961, 2, 5, 1, 1, 1, 1),
(962, 2, 6, 0, 0, 0, 0),
(963, 2, 7, 0, 0, 0, 0),
(964, 2, 8, 1, 1, 1, 1),
(965, 2, 9, 1, 0, 0, 0),
(1308, 4, 1, 0, 0, 0, 0),
(1309, 4, 2, 0, 0, 0, 0),
(1310, 4, 3, 0, 0, 0, 0),
(1311, 4, 4, 0, 0, 0, 0),
(1312, 4, 5, 0, 0, 0, 0),
(1313, 4, 6, 1, 0, 0, 0),
(1314, 4, 7, 0, 0, 0, 0),
(1315, 4, 8, 0, 0, 0, 0),
(1316, 4, 9, 0, 0, 0, 0),
(1362, 1, 1, 1, 1, 1, 1),
(1363, 1, 2, 1, 1, 1, 1),
(1364, 1, 3, 1, 1, 1, 1),
(1365, 1, 4, 1, 1, 1, 1),
(1366, 1, 5, 1, 1, 1, 1),
(1367, 1, 6, 1, 1, 1, 1),
(1368, 1, 7, 1, 1, 1, 1),
(1369, 1, 8, 1, 1, 1, 1),
(1370, 1, 9, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `id_persona` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion_persona` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombres` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_persona` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email_persona` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password_persona` varchar(75) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rfc_persona` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion_fiscal` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `token` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `rol_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_persona` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_persona`),
  KEY `rol_id` (`rol_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id_persona`, `identificacion_persona`, `nombres`, `apellidos`, `telefono_persona`, `email_persona`, `password_persona`, `rfc_persona`, `direccion_fiscal`, `token`, `rol_id`, `date_created`, `status_persona`) VALUES
(1, '11111', 'Fernanda', 'Vidal', '5524715536', 'ifervb@gmail.com', 'af257e49a22c193a6644103746041b9b71dfedca8c9cb372af2f0ea62302ceb8', 'VIB950311', 'Hidalgo', '767863ade4d924f1f00d-5aece7e443303b618c25-64c630e8218354dc396b-cd9616ffa3a5520c691f', 1, '2021-05-19 14:02:46', 1),
(2, '22222', 'Isabel', 'Del Valle Jiménez', '55555555', 'isabeldelvalle09@gmail.com', '6159f6dc76c1d82911098c35b25cecd0c0d2ba7fb90d14dcc08693d206e9071a', 'DVJ090596', 'MÃ©xico', '', 1, '2021-06-01 16:07:49', 1),
(3, '33333', 'Empleado', 'Uno', '111111', 'empleadouno@gmail.com', '3b93d2831317320f2f0c951eb9287426ba4349428c36c8a64bcc658a023f505c', NULL, NULL, '72e44495daf16e85f930-0e74a13d35e529a19712-a8b5a10b5afc1ee64abc-319deac4c30378d4b992', 2, '2021-06-01 16:08:49', 1),
(4, '44444', 'Empleado', 'Dos', '22222', 'empleadodos@gmail.com', '72485a8defb7972f5cc4dab7b139e971f996bd56e552907ff2b47a2c8d8916ba', NULL, NULL, NULL, 3, '2021-06-01 16:09:26', 1),
(5, '55555', 'Eduardo', 'Perez', '5524163656', 'ed@gmail.com', '09a31a7001e261ab1e056182a71d3cf57f582ca9a29cff5eb83be0f0549730a9', 'EDP000', 'CDMX', NULL, 4, '2021-06-01 16:10:21', 1),
(6, '1010101010', 'Luz Daniela', 'Blancas', '5536306536', 'danieela.vb@gmail.com', '725270a293b89ab66b851c4746aa20db22701b1eab45f1e568835258f2f3440e', 'VIB002005', 'Hidalgo', NULL, 4, '2021-06-16 15:33:17', 1),
(7, NULL, 'Luz Daniela', 'Blancas', '5536306536', 'danieela@gmail.com', '328f03c09882ca085fd3ba8a1aa417c39909684658d464f34bd925d9a85c7113', NULL, NULL, NULL, 4, '2021-07-28 17:33:59', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

DROP TABLE IF EXISTS `producto`;
CREATE TABLE IF NOT EXISTS `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_producto` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_producto` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_producto` text COLLATE utf8_spanish_ci,
  `precio_producto` decimal(11,2) NOT NULL,
  `stockTotal` int(11) NOT NULL,
  `imagen` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `url_producto` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `proveedor_id` (`proveedor_id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id_producto`, `codigo_producto`, `nombre_producto`, `descripcion_producto`, `precio_producto`, `stockTotal`, `imagen`, `date_created`, `status`, `proveedor_id`, `categoria_id`, `color_id`, `url_producto`) VALUES
(1, '1234546456', 'Mocasines', '<p>Mocasines</p>', '1500.00', 5, '', '2021-06-28 18:27:22', 1, 6, 1, 1, 'mocasines'),
(2, '468943', 'Tenis', '<p>Tenis para ni&ntilde;o.</p>', '500.00', 5, NULL, '2021-06-29 15:31:27', 1, 2, 3, 2, 'tenis'),
(3, '795546', 'Tenis Deportivos', '<p>Tenis deportivos para caballeros.&nbsp;</p> <p>Color Blanco.</p>', '1200.00', 30, NULL, '2021-06-29 16:26:16', 2, 3, 2, 3, 'tenis-deportivos'),
(4, '5684331', 'Tenis Deportivos', '<p>Tenis deportivos para dama</p>', '800.00', 10, NULL, '2021-06-29 16:28:32', 2, 1, 1, 1, 'tenis-deportivos'),
(14, '355345', 'rr', '', '3.00', 3, NULL, '2021-07-05 10:42:08', 0, 1, 1, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE IF NOT EXISTS `proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_proveedor` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono_proveedor` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `email_proveedor` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `status_proveedor` int(11) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id_proveedor`, `nombre_proveedor`, `telefono_proveedor`, `email_proveedor`, `status_proveedor`, `date_created`) VALUES
(1, 'Nike', '554585612', 'nike@nike.com', 1, '2021-06-17 15:28:00'),
(2, 'Vans', '48454545', 'vans@vans.mx', 1, '2021-06-17 16:45:17'),
(3, 'Adidas', '5596784166', 'adidas@adidas.com', 1, '2021-06-17 16:46:53'),
(4, 'Flexi', '5524715536', 'flexi@flexi.com', 1, '2021-06-17 16:47:52'),
(5, 'Levis', '5524156394', 'levis@levis.com', 1, '2021-06-17 18:30:44'),
(6, 'Zapatos', '552789632', 'zap@zap.com', 1, '2021-06-17 18:46:39'),
(8, 'Prueba', '1223', 'prueb@rprueb.com', 0, '2021-06-22 17:35:57'),
(9, 'Pp', '1', 'p@s.com', 0, '2021-06-23 09:06:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reembolso_pedido`
--

DROP TABLE IF EXISTS `reembolso_pedido`;
CREATE TABLE IF NOT EXISTS `reembolso_pedido` (
  `id_reembolso` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `num_transaccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_reembolso` text COLLATE utf8_spanish_ci NOT NULL,
  `obervaciones` text COLLATE utf8_spanish_ci NOT NULL,
  `status_reembolso` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_reembolso`),
  KEY `pedido_id` (`pedido_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `reembolso_pedido`
--

INSERT INTO `reembolso_pedido` (`id_reembolso`, `pedido_id`, `num_transaccion`, `descripcion_reembolso`, `obervaciones`, `status_reembolso`) VALUES
(1, 20, '4U384591PD9527357', 'COMPLETED', '{\"id\":\"99317524L4313643Y\",\"status\":\"COMPLETED\",\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/refunds\\/99317524L4313643Y\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/4U384591PD9527357\",\"rel\":\"up\",\"method\":\"GET\"}]}', 'reembolso prueba'),
(2, 13, '3PS58485EE303373D', 'COMPLETED', '{\"id\":\"2B866282548632900\",\"status\":\"COMPLETED\",\"links\":[{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/refunds\\/2B866282548632900\",\"rel\":\"self\",\"method\":\"GET\"},{\"href\":\"https:\\/\\/api.sandbox.paypal.com\\/v2\\/payments\\/captures\\/3PS58485EE303373D\",\"rel\":\"up\",\"method\":\"GET\"}]}', 'reembolso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion_rol` text COLLATE utf8_spanish_ci NOT NULL,
  `status_rol` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`, `descripcion_rol`, `status_rol`) VALUES
(1, 'Administrador', 'Administrador', 1),
(2, 'Administrador de productos y proveedores', 'Empleado que administra productos y proveedores', 1),
(3, 'Administrador de clientes', 'Empleado que administra clientes', 1),
(4, 'Cliente', 'Clientes de V-Shoes', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

DROP TABLE IF EXISTS `tipo_pago`;
CREATE TABLE IF NOT EXISTS `tipo_pago` (
  `id_tipoPago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `status_tipoPago` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tipoPago`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_tipoPago`, `nombre`, `status_tipoPago`) VALUES
(1, 'Paypal', 1),
(2, 'Tarjeta', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_producto`
--
ALTER TABLE `detalle_producto`
  ADD CONSTRAINT `detalle_producto_ibfk_3` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_producto_ibfk_4` FOREIGN KEY (`talla_id`) REFERENCES `numeros_talla` (`id_numeroTalla`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_temp`
--
ALTER TABLE `detalle_temp`
  ADD CONSTRAINT `detalle_temp_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_temp_ibfk_2` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id_persona`);

--
-- Filtros para la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  ADD CONSTRAINT `imagen_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`tipoPago_id`) REFERENCES `tipo_pago` (`id_tipoPago`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permisos_ibfk_2` FOREIGN KEY (`modulo_id`) REFERENCES `modulo` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedor` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id_color`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reembolso_pedido`
--
ALTER TABLE `reembolso_pedido`
  ADD CONSTRAINT `reembolso_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
