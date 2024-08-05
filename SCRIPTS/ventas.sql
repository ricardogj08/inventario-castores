-- Crea la base de datos del sistema de ventas.
CREATE DATABASE IF NOT EXISTS ventas
    CHARACTER SET = 'utf8mb4'
    COLLATE = 'utf8mb4_general_ci';

-- Opera todas las sentencias SQL sobre la base de datos del sistema de ventas.
USE ventas;

-- Crea la tabla de productos.
CREATE TABLE IF NOT EXISTS `productos` (
    `idProducto` INT(6) UNSIGNED NOT NULL,
    `nombre` VARCHAR(40) NOT NULL,
    `precio` DECIMAL(16, 2) UNSIGNED NOT NULL,
    CONSTRAINT `productos_idProducto_primario` PRIMARY KEY(`idProducto`),
    CONSTRAINT `productos_nombre_unico` UNIQUE(`nombre`)
);

-- Crea la tabla de ventas.
CREATE TABLE IF NOT EXISTS `ventas` (
    `idVenta` INT(6) UNSIGNED NOT NULL,
    `idProducto` INT(6) UNSIGNED NOT NULL,
    `cantidad` INT(6) UNSIGNED NOT NULL,
    CONSTRAINT `ventas_idVenta_primario` PRIMARY KEY(`idVenta`),
    CONSTRAINT `movimientos_idProducto_foraneo` FOREIGN KEY(`idProducto`)
        REFERENCES `productos`(`idProducto`)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
);

-- Registra los productos del ejercicio.
INSERT IGNORE INTO `productos`(`idProducto`, `nombre`, `precio`) VALUES
    (1, 'LAPTOP', 3000),
    (2, 'PC', 4000),
    (3, 'MOUSE', 100),
    (4, 'TECLADO', 150),
    (5, 'MONITOR', 2000),
    (6, 'MICRÓFONO', 350),
    (7, 'AUDÍFONOS', 450);

-- Registra las ventas del ejercicio.
INSERT IGNORE INTO `ventas`(`idVenta`, `idProducto`, `cantidad`) VALUES
    (1, 5, 8),
    (2, 1, 15),
    (3, 6, 13),
    (4, 6, 4),
    (5, 2, 3),
    (6, 5, 1),
    (7, 4, 5),
    (8, 2, 5),
    (9, 6, 2),
    (10, 1, 8);

-- Consulta todos los productos que tengan solo una venta.
SELECT
    productos.idProducto,
    productos.nombre,
    COUNT(ventas.idVenta) AS numeroVentas
FROM productos
INNER JOIN ventas
    ON productos.idProducto = ventas.idProducto
GROUP BY productos.idProducto
HAVING COUNT(ventas.idVenta) = 1
ORDER BY productos.idProducto ASC;

-- Consulta todos los productos y la cantidad total de ventas de cada producto.
SELECT
    productos.idProducto,
    productos.nombre,
    SUM(ventas.cantidad) AS cantidadTotalVentas
FROM productos productos
INNER JOIN ventas
    ON productos.idProducto = ventas.idProducto
GROUP BY productos.idProducto
ORDER BY productos.idProducto ASC;

-- Consulta todo los productos (con o sin ventas) y la suma total ($) vendidas de cada producto.
SELECT
    productos.idProducto,
    productos.nombre,
    productos.precio,
    IFNULL(SUM(ventas.cantidad), 0) AS cantidadTotalVentas,
    (IFNULL(SUM(ventas.cantidad), 0) * productos.precio) AS sumaTotalVentas
FROM productos productos
LEFT JOIN ventas
    ON productos.idProducto = ventas.idProducto
GROUP BY productos.idProducto
ORDER BY productos.idProducto ASC;
