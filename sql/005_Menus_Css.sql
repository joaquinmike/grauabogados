alter table sys_recurso add column recurso_css varchar(64) NULL comment 'Css para el menu';

update sys_recurso set recurso_orden = 1,recurso_css = 'md-person',recurso_desc = 'Personal' where
recurso_uri = 'usuario' and rec_recurso_id is null;

update sys_recurso set recurso_orden = 2,recurso_css = 'md-find-in-page' where
recurso_uri = 'reporte' and rec_recurso_id is null;