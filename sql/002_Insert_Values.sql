-- users data with password = md5('admin')
INSERT INTO `auth_rol` (`rol_desc`) VALUES ('Adminstrador');

INSERT INTO `auth_usuario` (`us_usuario`, `us_password`,us_email,fecha_creacion,us_nombre,us_apellidos,rol_id,pers_id) 
select 'admin', md5('tarazona'),'jmike410@gmail.com',now(),'Joaquin','Tarazona Aguirre',1, 
(select pers_id from auth_personal where percod = '0000154' and codigo = 'DHH');

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id) values 
('Usuario','usuario',1,1,NULL);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id)  
select 'Lista','adm:usuario:lista',1,1,(select recurso_id from sys_recurso where recurso_desc = 'Usuario' and rec_recurso_id is null);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id) values 
('Reportes','reporte',1,1,NULL);

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_desc = 'Usuario' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_desc = 'Reportes' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'adm:usuario:lista' and recurso_tipo = 1),1,'allow';
