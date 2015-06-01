-- users data with password = md5('admin')

INSERT INTO `auth_rol` (`rol_desc`) VALUES ('Adminstrador');

INSERT INTO `auth_personal` (empcod,percod,codigo) VALUES ('001','0000154','DHH');

INSERT INTO `auth_usuario` (`us_usuario`, `us_password`,us_email,fecha_creacion,us_nombre,us_apellidos,rol_id,pers_id) VALUES
('admin', md5('tarazona'),'jmike410@gmail.com',now(),'Joaquin','Tarazona Aguirre',1,1);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id) values 
('Usuario',NULL,1,1,NULL);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id)  
select 'Lista','application:usuario:lista',1,1,(select recurso_id from sys_recurso where recurso_desc = 'Usuario' and recurso_uri is null);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id) values 
('Reportes',NULL,1,1,NULL);

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_desc = 'Usuario' and recurso_uri is null and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_desc = 'Reportes' and recurso_uri is null and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'application:usuario:lista' and recurso_tipo = 1),1,'allow';