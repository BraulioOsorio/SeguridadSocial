DROP DATABASE IF EXISTS seguridad_social;

CREATE DATABASE seguridad_social;

USE seguridad_social;


CREATE TABLE usuarios (
    id_usuario INT(11) NOT NULL AUTO_INCREMENT,
    correo VARCHAR(255) NOT NULL,
    nombre_usuario VARCHAR(255) NOT NULL,
    apellido_usuario VARCHAR(255) NOT NULL,
    cargo ENUM('admin','empleado'),
    contrasenia VARCHAR(255) NOT NULL,
    estado_usuario TINYINT(1) DEFAULT 1,
    foto_perfil VARCHAR(255) NULL,
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_usuario),
    UNIQUE KEY (correo)
);

CREATE TABLE empresas (
    id_empresa INT(11) NOT NULL AUTO_INCREMENT,
    nombre_empresa VARCHAR(255) NOT NULL,
    nit VARCHAR(255) NOT NULL,
    direccion_empresa VARCHAR(255) NOT NULL,
    telefono_empresa VARCHAR(255) NOT NULL,
    correo_empresa VARCHAR(255) NOT NULL,
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado_empresa TINYINT(1) DEFAULT 1,
    PRIMARY KEY (id_empresa),
    UNIQUE KEY (nit)
);


CREATE TABLE trabajadores (
    id_trabajador INT(11) NOT NULL AUTO_INCREMENT,
    nombre_trabajador VARCHAR(255) NOT NULL,
    apellido_trabajador VARCHAR(255) NOT NULL,
    documento VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion_trabajador VARCHAR(255) NOT NULL,
    telefono_trabajador VARCHAR(255) NOT NULL,
    correo_trabajador VARCHAR(255) NOT NULL,
    salario FLOAT NOT NULL, 
    id_empresa INT(11) NULL,
    estado_trabajador TINYINT(1) DEFAULT 1,
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_trabajador),
    FOREIGN KEY (id_empresa) REFERENCES empresas (id_empresa)
);

ALTER TABLE `trabajadores` CHANGE `id_empresa` `id_empresa` INT(11) NULL;


CREATE TABLE planes_pago (
    id_plan INT(11) NOT NULL AUTO_INCREMENT,
    nombre_plan VARCHAR(255) NOT NULL,
    tipo VARCHAR(255) NOT NULL,
    porcentaje_salud FLOAT,
    porcentaje_pension FLOAT,
    porcentaje_arl FLOAT,
    estado_plan TINYINT(1) DEFAULT 1,
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_plan)
);

CREATE TABLE pagos_independiente (
    id_pago_in INT(11) NOT NULL AUTO_INCREMENT,
    id_trabajador INT(11) NOT NULL,
    id_plan INT(11) NOT NULL,
    monto_total DECIMAL(50,2) NOT NULL,
    fecha_pago DATE NOT NULL,
    estado_pago TINYINT(1) DEFAULT 0 NOT NULL,
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_pago_in),
    FOREIGN KEY (id_trabajador) REFERENCES trabajadores (id_trabajador),
    FOREIGN KEY (id_plan) REFERENCES planes_pago (id_plan)
);

CREATE TABLE pagos_empresas (
    id_pago_em INT(11) NOT NULL AUTO_INCREMENT,
    id_empresa INT(11) NOT NULL,
    id_plan INT(11) NOT NULL,
    monto_total DECIMAL(50,2) NOT NULL,
    fecha_pago DATE NOT NULL,
    estado_pago TINYINT(1) DEFAULT 0 NOT NULL,
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id_pago_em),
    FOREIGN KEY (id_empresa) REFERENCES empresas (id_empresa),
    FOREIGN KEY (id_plan) REFERENCES planes_pago (id_plan)
);

CREATE TABLE planes_trabajador (
    id_plan_trabajador INT(11) NOT NULL AUTO_INCREMENT,
    id_plan INT(11) NOT NULL,
    id_trabajador INT(11) NOT NULL,
    PRIMARY KEY (id_plan_trabajador),
    FOREIGN KEY (id_plan) REFERENCES planes_pago (id_plan),
    FOREIGN KEY (id_trabajador) REFERENCES trabajadores (id_trabajador)
);

CREATE TABLE recuperar_passw(
    id_recuperar INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(255),
    token VARCHAR(255),
    expiration_time DATETIME,
    fecha_creacion DATETIME NOT NULL,
    FOREIGN KEY (correo) REFERENCES usuarios(correo)
);


INSERT INTO `usuarios` (`id_usuario`, `correo`, `nombre_usuario`, `apellido_usuario`, `cargo`, `contrasenia`, `estado_usuario`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL, 'felipe@gmail.com', 'felipe', 'londono', 'admin', '641924d5a3821bd710f8ad0782d5187b7b337a69bab1161300cfd06d46310db5063bcd143386bc8b0951ced6a061eb8e51c04cddf422facad5c56a696d47bc604aOlNA9QVGYoOpoM/5GhGCDtbwaxpLJAjQ7quYic7jg=', '1', '2023-10-21 18:04:50.000000', NULL), (NULL, 'empleado@gmail.com', 'Yeison', 'Barrancamermeja', 'empleado', 'de7feb65607ab57d8b829540cf2f3c1d1164af4991ade5b00f86d8c10508c648f7369601efad871410b6dc21785a34c385a496199f75f088f3e3d611f87867abzyOmxogMlhTon2FCKV9ecJ6acRMnvEy3OHXlLotI36I=', '1', '2023-10-21 18:04:50.000000', NULL);
INSERT INTO `planes_pago` (`id_plan`, `nombre_plan`, `tipo`, `porcentaje_salud`, `porcentaje_pension`, `porcentaje_arl`, `estado_plan`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL, 'plan empleado', 'A', '40', '40', '40', '1', '2023-10-28 17:58:35.000000', NULL), (NULL, 'Plan Empresa', 'B', '40', '40', '40', '1', '2023-10-28 17:58:35.000000', NULL);

INSERT INTO planes_pago (nombre_plan, tipo, porcentaje_salud, porcentaje_pension, porcentaje_arl, estado_plan, fecha_creacion,fecha_modificacion)
VALUES
  ('Plan Dorado', 'Tipo A', 5.5, 10.0, 1.5, 1, NOW(),NULL),
  ('Plan Plata', 'Tipo B', 6.0, 9.5, 1.2, 1, NOW(),NULL),
  ('Plan Premium', 'Tipo C', 6.2, 9.2, 1.0, 1, NOW(),NULL),
  ('Plan Élite', 'Tipo D', 6.5, 9.0, 0.8, 1, NOW(),NULL),
  ('Plan Básico', 'Tipo E', 5.7, 10.2, 1.3, 1, NOW(),NULL),
  ('Plan Estándar', 'Tipo F', 6.3, 9.7, 1.1, 1, NOW(),NULL),
  ('Plan Familiar', 'Tipo G', 5.8, 10.5, 1.4, 1, NOW(),NULL),
  ('Plan Empresarial', 'Tipo H', 6.4, 9.4, 1.5, 1, NOW(),NULL),
  ('Plan Salud Total', 'Tipo I', 5.9, 10.8, 1.7, 1, NOW(),NULL),
  ('Plan Visionario', 'Tipo J', 6.6, 9.6, 1.6, 1, NOW(),NULL),
  ('Plan Asegura+', 'Tipo K', 5.6, 10.4, 1.9, 1, NOW(),NULL),
  ('Plan Protección', 'Tipo L', 6.7, 9.9, 1.8, 1, NOW(),NULL),
  ('Plan Seguro Total', 'Tipo M', 5.6, 10.7, 1.2, 1, NOW(),NULL),
  ('Plan Vitalidad', 'Tipo N', 6.8, 9.3, 1.3, 1, NOW(),NULL),
  ('Plan Resguarda', 'Tipo O', 5.5, 10.6, 1.4, 1, NOW(),NULL),
  ('Plan Asegurado', 'Tipo P', 6.9, 9.8, 1.5, 1, NOW(),NULL),
  ('Plan Confianza', 'Tipo Q', 5.4, 10.1, 1.6, 1, NOW(),NULL),
  ('Plan Seguro Empresarial', 'Tipo R', 6.2, 9.6, 1.7, 1, NOW(),NULL),
  ('Plan Protege+', 'Tipo S', 5.3, 10.3, 1.8, 1, NOW(),NULL),
  ('Plan Inviolable', 'Tipo T', 6.1, 9.1, 1.9, 1, NOW(),NULL);

INSERT INTO empresas (nombre_empresa, nit, direccion_empresa, telefono_empresa, correo_empresa, fecha_creacion,fecha_modificacion) VALUES
('Coca-Cola', '123456789', '1234 Main St', '5551234567', 'coca_cola@example.com', '2023-09-06 10:00:00',NULL),
('Google', '987654321', '1600 Amphitheatre Pkwy', '5559876543', 'google@example.com', '2023-11-06 10:15:00',NULL),
('Toyota', '456789123', '123 Toyota St', '5554567890', 'toyota@example.com', '2023-01-06 10:30:00',NULL),
('Apple', '555555555', '1 Apple Park Way', '55555555', 'apple@example.com', '2023-11-06 14:45:00',NULL),
('Microsoft', '111111111', '1 Microsoft Way', '5551111111', 'microsoft@example.com', '2023-11-06 15:00:00',NULL),
('Amazon', '222222222', '410 Terry Ave N', '5552222222', 'amazon@example.com', '2023-11-06 15:15:00',NULL),
('Facebook', '333333333', '1 Hacker Way', '5553333333', 'facebook@example.com', '2023-11-06 15:30:00',NULL),
('Tesla', '444444444', '3500 Deer Creek Road', '5554444444', 'tesla@example.com', '2023-11-06 15:45:00',NULL),
('IBM', '555555555I', '1 New Orchard Road', '55555555', 'ibm@example.com', '2023-11-06 16:00:00',NULL),
('Ford', '666666666', 'Dearborn, Michigan', '5556666666', 'ford@example.com', '2023-11-06 16:15:00',NULL),
('Sony', '777777777', '1-7-1 Konan, Minato City', '5557777777', 'sony@example.com', '2023-11-06 16:30:00',NULL),
('Walmart', '888888888', '702 SW 8th St', '5558888888', 'walmart@example.com', '2023-11-06 16:45:00',NULL),
('Samsung', '999999999', '129 Samsung-ro', '5559999999', 'samsung@example.com', '2023-11-06 17:00:00',NULL),
('Volkswagen', '101010101', 'Wolfsburg, Germany', '5551010101', 'volkswagen@example.com', '2023-11-06 17:15:00',NULL),
('Intel', '121212121', '2200 Mission College Blvd', '5551212121', 'intel@example.com', '2023-11-06 17:30:00',NULL),
('HP', '131313131', '1501 Page Mill Road', '5551313131', 'hp@example.com', '2023-11-06 17:45:00',NULL),
('Nestle', '141414141', 'Vevey, Switzerland', '5551414141', 'nestle@example.com', '2023-11-06 18:00:00',NULL),
('McDonalds', '151515151', 'Oak Brook, Illinois', '5551515151', 'mcdonalds@example.com', '2023-11-06 18:15:00',NULL),
('Pfizer', '161616161', 'New York City', '5551616161', 'pfizer@example.com', '2023-11-06 18:30:00',NULL);

INSERT INTO `trabajadores` (`id_trabajador`, `nombre_trabajador`, `apellido_trabajador`, `documento`, `fecha_nacimiento`, `direccion_trabajador`, `telefono_trabajador`, `correo_trabajador`, `salario`, `id_empresa`, `estado_trabajador`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'Winder', 'Roman', '1088360430', '2023-11-10', 'San Antonio 1', '3217046953', 'winderroman3131@gmail.com', 2000000000, 6, 1, '0000-00-00 00:00:00', '2023-11-10 16:17:29'),
(2, 'Juan', 'Perez', '123456789', '1990-01-01', 'Calle 123', '5551234', 'juan@email.com', 50000, 6, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(3, 'Maria', 'Gomez', '987654321', '1985-05-15', 'Avenida 456', '5555678', 'maria@email.com', 60000, 6, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(4, 'Pedro', 'Lopez', '456789012', '1988-08-20', 'Plaza Principal', '5559876', 'pedro@email.com', 55000, 6, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(5, 'Ana', 'Martinez', '789012345', '1992-03-10', 'Callejon 789', '5552345', 'ana@email.com', 70000, 6, 1, '0000-00-00 00:00:00', '2023-11-10 18:02:41'),
(6, 'Carlos', 'Rodriguez', '234567890', '1987-12-05', 'Avenida 012', '5558765', 'carlos@email.com', 65000, 6, 0, '0000-00-00 00:00:00', '2023-11-10 18:05:18'),
(7, 'Laura', 'Lopez', '567890123', '1995-06-25', 'Plaza 345', '5555432', 'laura@email.com', 75000, 6, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(8, 'Miguel', 'Garcia', '012345678', '1993-09-15', 'Calle 678', '5552109', 'miguel@email.com', 60000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(9, 'Isabel', 'Fernandez', '890123456', '1986-04-18', 'Avenida 901', '5551098', 'isabel@email.com', 70000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(10, 'Jorge', 'Hernandez', '345678901', '1991-07-30', 'Calle 234', '5559870', 'jorge@email.com', 65000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(11, 'Sofia', 'Diaz', '678901234', '1989-02-14', 'Plaza 567', '5558760', 'sofia@email.com', 80000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(12, 'Roberto', 'Alvarez', '123789456', '1994-11-08', 'Avenida 890', '5557650', 'roberto@email.com', 75000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(13, 'Elena', 'Sanchez', '456012789', '1997-10-03', 'Calle 345', '5556540', 'elena@email.com', 70000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(14, 'Diego', 'Gutierrez', '789234012', '1984-08-28', 'Plaza 678', '5555430', 'diego@email.com', 60000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(15, 'Luisa', 'Ramirez', '012567890', '1996-05-20', 'Avenida 901', '5554320', 'luisa@email.com', 65000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15'),
(16, 'Raul', 'Torres', '234678901', '1983-12-15', 'Calle 123', '5553210', 'raul@email.com', 70000, NULL, 1, '0000-00-00 00:00:00', '2023-11-10 17:55:15');


INSERT INTO `pagos_independiente` (`id_pago_in`, `id_trabajador`, `id_plan`, `monto_total`, `fecha_pago`, `estado_pago`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL, '13', '19', '10000000', '2023-11-30', '0', '2023-11-24 15:04:05.000000', current_timestamp());
INSERT INTO `planes_pago` (`id_plan`, `nombre_plan`, `tipo`, `porcentaje_salud`, `porcentaje_pension`, `porcentaje_arl`, `estado_plan`, `fecha_creacion`, `fecha_modificacion`) VALUES (NULL, 'Plan definitivo', 'K', '12.6', '16', '0.3', '1', '2023-11-24 18:51:32.000000', current_timestamp());