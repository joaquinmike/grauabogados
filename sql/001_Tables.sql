
CREATE TABLE sessions (
    id char(32) NOT NULL DEFAULT '',
    name varchar(255) NOT NULL,
    modified int(11) DEFAULT NULL,
    lifetime int(11) DEFAULT NULL,
    data text,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
  
CREATE TABLE `auth_rol` (
  `rol_id` INT NOT NULL AUTO_INCREMENT,
  `rol_desc` VARCHAR(64) NULL,
  `rol_estado` INT(11) NULL DEFAULT 1,
  PRIMARY KEY (`rol_id`))
ENGINE = InnoDB;


CREATE TABLE `auth_personal` (
  `pers_id` INT NOT NULL AUTO_INCREMENT,
  `empcod` VARCHAR(3) NOT NULL,
  `percod` VARCHAR(11) NOT NULL,
  `codigo` VARCHAR(11) NULL,
  `tipocod` VARCHAR(4) NULL,
  `nrodoc` VARCHAR(20) NULL,
  `dni` VARCHAR(10) NULL,
  `ruc` VARCHAR(11) NULL,
  `nomcomper` VARCHAR(128) NULL,
  `apepatper` VARCHAR(128) NULL,
  `nombreper` VARCHAR(128) NULL,
  `direccion` VARCHAR(128) NULL,
  `direccion2` VARCHAR(128) NULL,
  `contacto` VARCHAR(128) NULL,
  `calnumero` VARCHAR(20) NULL,
  `relacion` VARCHAR(3) NULL,
  `celularc` VARCHAR(30) NULL,
  `tipoper` VARCHAR(3) NULL,
  `area` VARCHAR(4) NULL,
  `cargo` VARCHAR(4) NULL,
  `telefono` VARCHAR(32) NULL,
  `telefono2` VARCHAR(32) NULL,
  `telefono3` VARCHAR(32) NULL,
  `telefonodirec` VARCHAR(32) NULL,
  `celular` VARCHAR(16) NULL,
  `celular2` VARCHAR(16) NULL,
  `celular3` VARCHAR(16) NULL,
  `email` VARCHAR(64) NULL,
  `email2` VARCHAR(64) NULL,
  `email3` VARCHAR(64) NULL,
  `estado` VARCHAR(1) NULL,
  `fching` DATE NULL,
  `fecnac` DATE NULL,
  PRIMARY KEY (`pers_id`),
  UNIQUE INDEX `percod_UNIQUE` (`percod` ASC))
ENGINE = InnoDB;

CREATE TABLE `auth_usuario` (
  `us_id` INT NOT NULL AUTO_INCREMENT,
  `us_usuario` VARCHAR(32) NOT NULL,
  `us_password` VARCHAR(256) NOT NULL,
  `us_nombre` VARCHAR(256) NULL,
  `us_apellidos` VARCHAR(45) NULL,
  `us_estado` INT(11) NOT NULL DEFAULT 1 COMMENT '0: Inactivo\n1: Activo\n',
  `us_image` VARCHAR(256) NULL,
  `us_email` VARCHAR(128) NULL,
  `fecha_creacion` DATETIME NULL,
  `rol_id` INT NOT NULL,
  `pers_id` INT NOT NULL,
  PRIMARY KEY (`us_id`),
  UNIQUE INDEX `us_usuario_UNIQUE` (`us_usuario` ASC),
  UNIQUE INDEX `us_email_UNIQUE` (`us_email` ASC),
  INDEX `fk_auth_usuario_auth_rol1_idx` (`rol_id` ASC),
  INDEX `fk_auth_usuario_auth_personal1_idx` (`pers_id` ASC),
  CONSTRAINT `fk_auth_usuario_auth_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_auth_usuario_auth_personal1`
    FOREIGN KEY (`pers_id`)
    REFERENCES `auth_personal` (`pers_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `sys_recurso` (
  `recurso_id` INT NOT NULL AUTO_INCREMENT,
  `recurso_desc` VARCHAR(128) NULL,
  `recurso_uri` VARCHAR(256) NULL,
  `recurso_estado` INT(11) NULL COMMENT '0: Desactivado\n1: Activado',
  `recurso_tipo` INT(11) NULL COMMENT '1: Tipo Menu\n2: tipo Recurso',
  `rec_recurso_id` INT NULL,
  PRIMARY KEY (`recurso_id`),
  INDEX `fk_sys_recurso_sys_recurso_idx` (`rec_recurso_id` ASC),
  CONSTRAINT `fk_sys_recurso_sys_recurso`
    FOREIGN KEY (`rec_recurso_id`)
    REFERENCES `sys_recurso` (`recurso_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `sys_rol_recurso` (
  `recurso_id` INT NOT NULL,
  `rol_id` INT NOT NULL,
  `rolrec_permiso` VARCHAR(16) NULL COMMENT 'deny: Denegado allow: permitido',
  `rolrec_estado` VARCHAR(45) NULL DEFAULT '1',
  PRIMARY KEY (`recurso_id`, `rol_id`),
  INDEX `fk_sys_recurso_has_auth_rol_auth_rol1_idx` (`rol_id` ASC),
  INDEX `fk_sys_recurso_has_auth_rol_sys_recurso1_idx` (`recurso_id` ASC),
  CONSTRAINT `fk_sys_recurso_has_auth_rol_sys_recurso1`
    FOREIGN KEY (`recurso_id`)
    REFERENCES `sys_recurso` (`recurso_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sys_recurso_has_auth_rol_auth_rol1`
    FOREIGN KEY (`rol_id`)
    REFERENCES `auth_rol` (`rol_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE VIEW `vauth_usuario_login` AS
select t1.us_id,t1.us_usuario,us_password,us_nombre,us_apellidos, 
us_image,us_email,t2.rol_id,t2.rol_desc,
t3.pers_id,t3.empcod,percod,codigo
from auth_usuario t1
inner join auth_rol t2 on t1.rol_id = t2.rol_id
inner join auth_personal t3 on t1.pers_id = t3.pers_id 
