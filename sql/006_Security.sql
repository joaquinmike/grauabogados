insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id,recurso_css) values 
('Seguridad','seguridad',1,1,NULL,'md-security');

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id)  
select 'Usuarios','admin:seguridad:usuario-lista',1,1,(select recurso_id from sys_recurso where recurso_uri = 'seguridad' and rec_recurso_id is null);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id)  
select 'Roles','admin:seguridad:rol-lista',1,1,(select recurso_id from sys_recurso where recurso_uri = 'seguridad' and rec_recurso_id is null);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id)  
select 'Recursos','admin:seguridad:recurso-lista',1,1,(select recurso_id from sys_recurso where recurso_uri = 'seguridad' and rec_recurso_id is null);

insert into sys_recurso (recurso_desc,recurso_uri,recurso_estado,recurso_tipo,rec_recurso_id)  
select 'Asignar Recurso','admin:seguridad:recurso-asignar',1,1,(select recurso_id from sys_recurso where recurso_uri = 'seguridad' and rec_recurso_id is null);

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'seguridad' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'admin:seguridad:usuario-lista' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'admin:seguridad:rol-lista' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'admin:seguridad:recurso-lista' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'admin:seguridad:recurso-asignar' and recurso_tipo = 1),1,'allow';