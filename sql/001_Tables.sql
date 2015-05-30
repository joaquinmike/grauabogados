
CREATE TABLE "sessions" (
    "id"        VARCHAR(32) NOT NULL,
    "name"      VARCHAR(255),
    "modified"  INTEGER,
    "lifetime"  INTEGER,
    "data"      VARCHAR(2500)
);
ALTER TABLE "sessions" ADD CONSTRAINT PK_SESSIONS PRIMARY KEY ("id");
  

CREATE TABLE IF "sys_recurso" (
  "recurso_id" INT NOT NULL AUTO_INCREMENT,
  "recurso_desc" VARCHAR(128) NULL,
  "recurso_uri" VARCHAR(256) NULL,
  "recurso_estado" INT(11) NULL COMMENT '0: Desactivado\n1: Activado',
  "recurso_tipo" INT(11) NULL COMMENT '1: Tipo Menu\n2: tipo Recurso',
  "rec_recurso_id" INT NOT NULL,
  PRIMARY KEY ("recurso_id"),
  INDEX `fk_sys_recurso_sys_recurso_idx` ("rec_recurso_id" ASC),
  CONSTRAINT `fk_sys_recurso_sys_recurso`
    FOREIGN KEY (`rec_recurso_id`)
    REFERENCES `sys_recurso` ("recurso_id")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE "sys_recurso_rol" (
  "recrol_id" INT(11) NOT NULL AUTO_INCREMENT,
  "recurso_id" INT NULL,
  "rol_id" VARCHAR(2) NULL,
  "us_id" VARCHAR(12) NULL,
  "emp_id" VARCHAR(3) NULL,
  "recrol_permiso" VARCHAR(16) NULL,
  INDEX `fk_sys_recurso_has_usu_tip_usu_tip1_idx` ("rol_id" ASC, "us_id" ASC, "emp_id" ASC),
  INDEX `fk_sys_recurso_has_usu_tip_sys_recurso1_idx` ("recurso_id" ASC),
  PRIMARY KEY ("recrol_id"),
  CONSTRAINT `fk_sys_recurso_has_usu_tip_sys_recurso1`
    FOREIGN KEY ("recurso_id")
    REFERENCES`sys_recurso` ("recurso_id")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sys_recurso_has_usu_tip_usu_tip1`
    FOREIGN KEY ("rol_id" , "us_id" , "emp_id")
    REFERENCES "USU_TIP" ("SISCOD" , "USUCOD" , "EMPCOD")
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;