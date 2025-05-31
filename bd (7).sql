-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2025 a las 04:08:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`sql10782242`@`%` PROCEDURE `obtener_usuario_por_email` (IN `correo_input` VARCHAR(100))   BEGIN
    SELECT id_usuario, correo, contraseña, rol
    FROM usuarios
    WHERE correo = correo_input;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_actualizar_categoria` (IN `p_id` INT, IN `p_descripcion` VARCHAR(100))   BEGIN
  UPDATE categorias SET descripcion = p_descripcion WHERE id_categoria = p_id;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_actualizar_cliente` (IN `p_id_cliente` INT, IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(50), IN `p_direccion` VARCHAR(50), IN `p_telefono` VARCHAR(50))   BEGIN
  UPDATE clientes
  SET nombres = p_nombres,
      apellidos = p_apellidos,
      direccion = p_direccion,
      telefono = p_telefono
  WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_actualizar_producto` (IN `p_id_producto` INT, IN `p_descripcion` VARCHAR(255), IN `p_precio` DECIMAL(10,2), IN `p_stock` INT, IN `p_id_categoria` INT, IN `p_id_proveedor` INT)   BEGIN
  UPDATE productos
  SET descripcion = p_descripcion,
      precio = p_precio,
      stock = p_stock,
      id_categoria = p_id_categoria,
      id_proveedor = p_id_proveedor
  WHERE id_producto = p_id_producto;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_actualizar_proveedor` (IN `p_id` INT, IN `p_razonsocial` VARCHAR(100), IN `p_direccion` VARCHAR(150), IN `p_telefono` VARCHAR(20))   BEGIN
  UPDATE proveedores
  SET razonsocial = p_razonsocial,
      direccion = p_direccion,
      telefono = p_telefono
  WHERE id_proveedor = p_id;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_detalle_venta` (IN `p_id_venta` INT)   BEGIN
  SELECT dv.id_producto, p.descripcion, dv.cantidad, p.precio
  FROM detalle_ventas dv
  JOIN productos p ON dv.id_producto = p.id_producto
  WHERE dv.id_venta = p_id_venta;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_eliminar_categoria` (IN `p_id` INT)   BEGIN
  DELETE FROM categorias WHERE id_categoria = p_id;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_eliminar_cliente` (IN `p_id_cliente` INT)   BEGIN
  DELETE FROM clientes WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_eliminar_producto` (IN `p_id_producto` INT)   BEGIN
  DELETE FROM productos WHERE id_producto = p_id_producto;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_eliminar_proveedor` (IN `p_id` INT)   BEGIN
  DELETE FROM proveedores WHERE id_proveedor = p_id;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_insertar_categoria` (IN `p_descripcion` VARCHAR(100))   BEGIN
  INSERT INTO categorias (descripcion) VALUES (p_descripcion);
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_insertar_cliente` (IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(50), IN `p_direccion` VARCHAR(50), IN `p_telefono` VARCHAR(50))   BEGIN
  INSERT INTO clientes (nombres, apellidos, direccion, telefono)
  VALUES (p_nombres, p_apellidos, p_direccion, p_telefono);
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_insertar_producto` (IN `p_descripcion` VARCHAR(255), IN `p_precio` DECIMAL(10,2), IN `p_stock` INT, IN `p_id_categoria` INT, IN `p_id_proveedor` INT)   BEGIN
  INSERT INTO productos (descripcion, precio, stock, id_categoria, id_proveedor)
  VALUES (p_descripcion, p_precio, p_stock, p_id_categoria, p_id_proveedor);
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_insertar_proveedor` (IN `p_razonsocial` VARCHAR(100), IN `p_direccion` VARCHAR(150), IN `p_telefono` VARCHAR(20))   BEGIN
  INSERT INTO proveedores (razonsocial, direccion, telefono)
  VALUES (p_razonsocial, p_direccion, p_telefono);
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_listar_categorias` ()   BEGIN
  SELECT * FROM categorias;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_listar_clientes` ()   BEGIN
  SELECT * FROM clientes;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_listar_productos` ()   BEGIN
  SELECT p.id_producto, p.descripcion, p.precio, p.stock, 
         p.id_categoria, c.descripcion AS categoria,
         p.id_proveedor, pr.razonsocial AS proveedor
  FROM productos p
  JOIN categorias c ON p.id_categoria = c.id_categoria
  JOIN proveedores pr ON p.id_proveedor = pr.id_proveedor;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_listar_proveedores` ()   BEGIN
  SELECT * FROM proveedores;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_nombre_cliente` (IN `p_id_cliente` INT)   BEGIN
  SELECT nombres FROM clientes WHERE id_cliente = p_id_cliente;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_categoria` (IN `p_id` INT)   BEGIN
  SELECT * FROM categorias WHERE id_categoria = p_id;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_clientes_venta` ()   BEGIN
  SELECT id_cliente, CONCAT(nombres, ' ', apellidos) AS nombre_cliente
  FROM clientes;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_id_cliente` (IN `p_nombres` VARCHAR(50), IN `p_apellidos` VARCHAR(50))   BEGIN
  SELECT id_cliente
  FROM clientes
  WHERE nombres = p_nombres AND apellidos = p_apellidos
  LIMIT 1;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_producto` (IN `pid` INT)   BEGIN
  SELECT id_producto, descripcion, precio, stock, id_categoria, id_proveedor
  FROM productos
  WHERE id_producto = pid;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_productos_venta` ()   BEGIN
  SELECT id_producto, descripcion, precio FROM productos;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_producto_por_id` (IN `pid` INT)   BEGIN
  SELECT id_producto, descripcion, precio
  FROM productos
  WHERE id_producto = pid;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_proveedor` (IN `p_id` INT)   BEGIN
  SELECT * FROM proveedores WHERE id_proveedor = p_id;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_obtener_ventas` ()   BEGIN
  SELECT id_venta, fecha, id_cliente
  FROM ventas
  ORDER BY fecha DESC;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_registrar_venta` (IN `p_id_cliente` INT, IN `p_productos` TEXT)   BEGIN
  DECLARE v_id_venta INT;
  DECLARE i INT DEFAULT 0;
  DECLARE n INT;
  DECLARE v_id_producto INT;
  DECLARE v_cantidad INT;

  INSERT INTO ventas(fecha, id_cliente) VALUES (NOW(), p_id_cliente);
  SET v_id_venta = LAST_INSERT_ID();

  SET n = JSON_LENGTH(p_productos);

  WHILE i < n DO
    SET v_id_producto = JSON_UNQUOTE(JSON_EXTRACT(p_productos, CONCAT('$[', i, '].id_producto')));
    SET v_cantidad = JSON_UNQUOTE(JSON_EXTRACT(p_productos, CONCAT('$[', i, '].cantidad')));

    INSERT INTO detalle_ventas(id_venta, id_producto, cantidad)
    VALUES (v_id_venta, v_id_producto, v_cantidad);

    SET i = i + 1;
  END WHILE;
END$$

CREATE DEFINER=`sql10782242`@`%` PROCEDURE `sp_ultima_venta` ()   BEGIN
  SELECT id_venta, fecha, id_cliente
  FROM ventas
  ORDER BY id_venta DESC
  LIMIT 1;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `descripcion`) VALUES
(3, 'Electrónica'),
(5, 'Ropa y accesorios'),
(6, 'Hogar y cocina'),
(7, 'Deportes y fitness'),
(8, 'Juguetes y juegos'),
(9, 'Belleza y cuidado personal'),
(10, 'Computación y tecnología'),
(11, 'Herramientas y ferretería'),
(12, 'Salud y bienestar'),
(13, 'Alimentos y bebidas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombres`, `apellidos`, `direccion`, `telefono`) VALUES
(12, 'jhampi', 'machuca', 'rio negr', '2025'),
(16, 'Luis Fernando', 'Huamán Quispe', 'Av. Los Próceres 123, San Juan de Lurigancho, Lima', '915234567'),
(17, 'María Alejandra', 'Rojas Paredes', 'Jr. Loreto 456, Cusco', '987654321'),
(18, 'José Andrés', 'Cárdenas Ticona', 'Calle Grau 789, Arequipa', '999876543'),
(19, 'Diana Milagros', 'Lévano Sánchez', 'Av. El Sol 101, Trujillo', '912345678'),
(20, 'Carlos Eduardo', 'Mamani Condori', 'Urb. Los Incas Mz. B Lt. 3, Juliaca', '996543210'),
(21, 'Lucía Fernanda', 'Vilca Huanca', 'Av. América Norte 222, Chiclayo', '977888999'),
(22, 'Juan Diego', 'Salazar Chuquimango', 'Calle Ayacucho 303, Huancayo', '994321789'),
(23, 'Katherine Estefany', 'Ramos Ñahui', 'Jr. Junín 150, Puno', '913579246'),
(24, 'Ángel Matías', 'Gutiérrez Apaza', 'Av. Independencia 700, Piura', '998112233');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detventa` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detventa`, `id_venta`, `id_producto`, `cantidad`) VALUES
(27, 26, 17, 1),
(28, 26, 14, 2),
(29, 26, 13, 1),
(30, 26, 10, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `precio` decimal(18,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `descripcion`, `precio`, `stock`, `id_categoria`, `id_proveedor`) VALUES
(7, 'Camiseta Deportiva DryFit', 70.00, 25, 5, 13),
(8, 'Gorra Snapback Urbana', 45.00, 25, 5, 14),
(9, 'Smartphone X200', 1200.00, 10, 3, 11),
(10, 'Auriculares Bluetooth Z5', 50.00, 20, 3, 12),
(11, 'Aceite de Oliva Extra Virgen 1L', 10.01, 50, 13, 11),
(12, 'Café Molido ', 10.00, 50, 13, 11),
(13, 'Set de Ollas Antiadherentes 5 piezas', 250.00, 25, 6, 12),
(14, 'Lámpara LED de Mesa', 80.00, 20, 6, 13),
(15, 'Mancuernas Ajustables 2-10 kg', 180.00, 20, 7, 14),
(16, 'Esterilla Yoga Antideslizante', 90.00, 20, 7, 11),
(17, 'Set de Construcción Bloques 1000 pcs', 120.00, 20, 8, 11),
(18, 'Muñeca Interactiva Smart Doll', 220.00, 50, 8, 12),
(19, 'Crema Facial Hidratante 50ml', 55.00, 100, 9, 13),
(20, 'Set de Maquillaje Profesional', 130.00, 50, 9, 14),
(21, 'Laptop Gamer 16GB RAM', 3200.00, 15, 10, 11),
(22, 'Mouse Inalámbrico Ergonómico', 90.00, 50, 10, 11),
(23, 'Taladro Eléctrico 500W', 350.00, 50, 11, 12),
(24, 'Juego de Llaves Inglesas 10 piezas', 120.00, 50, 11, 14),
(25, 'Tensiómetro Digital de Brazo', 180.00, 50, 12, 13),
(26, 'Multivitamínico 60 cápsulas', 65.00, 50, 12, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `razonsocial` varchar(50) DEFAULT NULL,
  `direccion` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `razonsocial`, `direccion`, `telefono`) VALUES
(6, 'alicorp', 'av. los nogales 890', '343545345'),
(7, 'gesa', 'av. los gamonales 567', '54654658'),
(11, 'Distribuciones López S.A.', 'Av. Arequipa 1234, Lima', '912345678'),
(12, 'Importadora Soluciones Ltda.', 'Jr. Amazonas 567, Cusco', '987654321'),
(13, 'Comercializadora El Sol', 'Calle San Martín 789, Trujillo', '999888777'),
(14, 'Proveedores Industriales S.R.L.', 'Av. Industrial 234, Arequipa', '976543210');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `rol` enum('administrador','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `correo`, `contraseña`, `fecha_registro`, `rol`) VALUES
(1, 'rojasmachucajhanpi@gmail.com', '$2y$10$rUu9yqHMPOZfRNhWYOqb5uwC4usLztrxE1qI2oLCc333mv22g00IK', '2025-05-29 20:35:09', 'administrador'),
(2, 'jhanpi@gmail.com', '$2y$10$X.9p36EprP/U16mgZ4AfeeRr9co5dVZnNm6vhepff0Sq2eddRAUXq', '2025-05-29 21:17:08', 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `fecha`, `id_cliente`) VALUES
(20, '2025-05-29 16:52:20', 12),
(21, '2025-05-29 16:52:53', 12),
(22, '2025-05-29 16:57:25', 12),
(23, '2025-05-29 17:13:52', 12),
(24, '2025-05-29 17:42:23', 12),
(25, '2025-05-29 19:38:19', 12),
(26, '2025-05-29 20:29:23', 12);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detventa`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`(191));

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id_detventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
