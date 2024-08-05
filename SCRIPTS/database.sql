-- Crea la base de datos del sistema de inventario.
CREATE DATABASE IF NOT EXISTS inventario
    CHARACTER SET = 'utf8mb4'
    COLLATE = 'utf8mb4_general_ci';

-- Opera todas las sentencias SQL sobre la base de datos del sistema de inventario.
USE inventario;

-- Crea la tabla de los roles de los usuarios.
CREATE TABLE IF NOT EXISTS `roles` (
    `idRol` INT(2) UNSIGNED NOT NULL,
    `nombre` VARCHAR(25) NOT NULL,
    CONSTRAINT `roles_idRol_primario` PRIMARY KEY(`idRol`),
    CONSTRAINT `roles_nombre_unico` UNIQUE(`nombre`)
);

-- Crea la tabla de los usuarios.
CREATE TABLE IF NOT EXISTS `usuarios` (
    `idUsuario` INT(6) UNSIGNED NOT NULL,
    `correo` VARCHAR(50) NOT NULL,
    `idRol` INT(2) UNSIGNED NOT NULL,
    `nombre` VARCHAR(100) NOT NULL,
    `contrasena` VARCHAR(25) NOT NULL,
    `estatus` INT(1) UNSIGNED NOT NULL,
    CONSTRAINT `usuarios_idUsuario_primario` PRIMARY KEY(`idUsuario`),
    CONSTRAINT `usuarios_correo_unico` UNIQUE(`correo`),
    CONSTRAINT `usuarios_idRol_foraneo` FOREIGN KEY(`idRol`)
        REFERENCES `roles`(`idRol`)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT
);

-- Crea la tabla de los productos.
CREATE TABLE IF NOT EXISTS `productos` (
    `idProducto` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(40) NOT NULL,
    `precio` DECIMAL(16, 2) UNSIGNED NOT NULL,
    `cantidad` SMALLINT(4) UNSIGNED NOT NULL DEFAULT 0,
    `estatus` INT(1) UNSIGNED NOT NULL DEFAULT 1,
    `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `productos_idProducto_primario` PRIMARY KEY(`idProducto`),
    CONSTRAINT `productos_nombre_unico` UNIQUE(`nombre`)
);

-- Crea la tabla de los tipos de movimientos de los productos.
CREATE TABLE IF NOT EXISTS `tipos_movimientos` (
    `idTipoMovimiento` INT(2) UNSIGNED NOT NULL,
    `nombre` VARCHAR(25) NOT NULL,
    CONSTRAINT `tipos_movimientos_idTipoMovimiento_primario` PRIMARY KEY(`idTipoMovimiento`),
    CONSTRAINT `tipos_movimientos_nombre_unico` UNIQUE(`nombre`)
);

-- Crea la tabla de los movimientos de los productos (histórico).
CREATE TABLE IF NOT EXISTS `movimientos` (
    `idMovimiento` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `idProducto` INT(6) UNSIGNED NOT NULL,
    `idTipoMovimiento` INT(2) UNSIGNED NOT NULL,
    `idUsuario` INT(6) UNSIGNED NOT NULL,
    `cantidad` SMALLINT(4) UNSIGNED NOT NULL,
    `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `movimientos_idMovimiento_primario` PRIMARY KEY(`idMovimiento`),
    CONSTRAINT `movimientos_idProducto_foraneo` FOREIGN KEY(`idProducto`)
        REFERENCES `productos`(`idProducto`)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT,
    CONSTRAINT `movimientos_idTipoMovimiento_foraneo` FOREIGN KEY(`idTipoMovimiento`)
        REFERENCES `tipos_movimientos`(`idTipoMovimiento`)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT,
    CONSTRAINT `movimientos_idUsuario_foraneo` FOREIGN KEY(`idUsuario`)
        REFERENCES `usuarios`(`idUsuario`)
        ON DELETE RESTRICT
        ON UPDATE RESTRICT
);

-- Registra los tipos de movimientos de los productos.
INSERT IGNORE INTO `tipos_movimientos`(`idTipoMovimiento`, `nombre`) VALUES
    (1, 'Entrada'),
    (2, 'Salida');

-- Registra los roles de los usuarios.
INSERT IGNORE INTO `roles`(`idRol`, `nombre`) VALUES
    (1, 'Administrador'),
    (2, 'Almacenista');

-- Registra los usuarios.
INSERT IGNORE INTO `usuarios`(`idUsuario`, `correo`, `idRol`, `nombre`, `contrasena`, `estatus`) VALUES
    (1, 'admin@castores.com.mx', 1, 'Usuario Administrador', 'admin', 1),
    (2, 'almacen@castores.com.mx', 2, 'Usuario Almacenista', 'almacen', 1);
