INSERT INTO sys_recurso
( recurso_desc, recurso_uri, recurso_estado, recurso_tipo, rec_recurso_id, recurso_orden)
select 'Personal', 'application:reporte:personal', 1, 1, 
(select recurso_id from sys_recurso where recurso_uri = 'reporte' and rec_recurso_id is null),NULL;

INSERT INTO sys_recurso
( recurso_desc, recurso_uri, recurso_estado, recurso_tipo, rec_recurso_id, recurso_orden)
select 'Diagrama', 'application:reporte:diagrama', 1, 1, 
(select recurso_id from sys_recurso where recurso_uri = 'reporte' and rec_recurso_id is null),NULL;

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'application:reporte:personal' and recurso_tipo = 1),1,'allow';

insert into sys_rol_recurso (recurso_id,rol_id,rolrec_permiso)
select (select recurso_id from sys_recurso where recurso_uri = 'application:reporte:diagrama' and recurso_tipo = 1),1,'allow';