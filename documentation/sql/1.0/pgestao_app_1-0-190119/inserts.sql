#COMPANY
INSERT INTO `company` (`id`,`name`,`trade`,`number`,`expire`,`created`,`deleted`,`changed`) VALUES (null,'Pró Gestão','Pró Gestão',4484352000110,'2025-01-01','0000-00-00 00:00:00',NULL,NULL);
INSERT INTO `company` (`id`,`name`,`trade`,`number`,`expire`,`created`,`deleted`,`changed`) VALUES (null,'Demonstracao S.A.','Demonstracao S.A.',4484352000110,'2025-01-01','0000-00-00 00:00:00',NULL,NULL);

#USERS
INSERT INTO `user` (`uid`,`name`,`email`,`password`,`photo`,`status`,`role`,`company`,`created`,`deleted`,`changed`) VALUES (null,'qunY2fg6OlJCNDFKeUZxQlhMdGZGRT0=','iunY2fjTiAG6TaY90HxRbGSYuPc6OlJCNDFKeUZxQlhMdGZGRT0=','3f75509b223bf62b576179ee29493e7fa990d6cd92989277d1dab04d5f25130e',NULL,1,'admin',1,'2018-11-26 20:11:32',NULL,'2018-11-26 20:11:32');
INSERT INTO `user` (`uid`,`name`,`email`,`password`,`photo`,`status`,`role`,`company`,`created`,`deleted`,`changed`) VALUES (null,'ueLRwv/0l0adTKcy2iA6OlJCNDFKeUZxQlhMdGZGRT0=','meLRwv/0lya9TKcy2iAcbSoHu2GQOjpSQjQxSnlGcUJYTHRmRkU9','22cebd283728bad166ea068666c5dbcd96ec9486a9a72b34bd98e2b9f9ba6b8f',NULL,1,'admin',1,'2018-11-26 20:11:32',NULL,'2018-11-26 20:11:32');
INSERT INTO `user` (`uid`,`name`,`email`,`password`,`photo`,`status`,`role`,`company`,`created`,`deleted`,`changed`) VALUES (null,'r+TH0/PmOjpSQjQxSnlGcUJYTHRmRkU9','j+TH0/PmuBa4W6Eo3j0cYHzSfGXLOjpSQjQxSnlGcUJYTHRmRkU9','3f75509b223bf62b576179ee29493e7fa990d6cd92989277d1dab04d5f25130e',NULL,1,'admin',1,'2018-11-26 20:11:32',NULL,'2018-11-26 20:11:32');
INSERT INTO `user` (`uid`,`name`,`email`,`password`,`photo`,`status`,`role`,`company`,`created`,`deleted`,`changed`) VALUES (null,'r+jY3/jgjBS+/XWfHD06OlJCNDFKeUZxQlhMdGZGRT0=','j+jY39bjnwOsSrMzkTFdbg8+nDo6UkI0MUp5RnFCWEx0ZkZFPQ==','4e09b666a1921760f2f9f5ddad85483095b16340ca65de7c6dbdf87551c5bc1b',NULL,1,'manager',2,'2018-11-26 20:11:32',NULL,'2018-11-26 20:11:32');


#MENU
#Menu
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'','Cadastros','/','Cadastros gerais','',0,';user;manager;admin;',1,100,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'','Configurações','','Configurações do sistema','',0,';manager;admin;',1,9000,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'','Relatórios','/','Relatórios','',0,';user;manager;admin;',1,200,NULL);
#System
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'home','Home','/','Página principal',NULL,0,';guess;user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'login','Login','/login','Página de acesso',NULL,0,';guess;user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'logout','Logout','/logout','Página para sair do sistema',NULL,0,';guess;user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'import','Importador','/import','Importe informacoes para o sistema','ti-cloud-up',2,';manager;admin;',1,25,NULL);
#Company
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'company.list','Empresas','/company','Lista de Empresas','fa-building-o',2,';admin;',1,25,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'company.form','Cadastro de Empresa','/company/form','Cadastro de Empresa',NULL,0,';admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'company.save','Salvar um empresa','/company/save','Salvar um usuário',NULL,0,';admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'company.update','Formulário de atualização de empresa','/company/form/[{uid}]','Formulário de atualização de empresa',NULL,0,';admin;',0,NULL,NULL);
#User
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'users.list','Usuários','/users','Lista de usuários','fa-unlock-alt',2,';manager;admin;',1,9050,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'users.form','Cadastro de usuário','/users/form','Cadastro de usuário',NULL,0,';manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'users.save','Salvar um usuário','/users/save','Salvar um usuário',NULL,0,';manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'users.update','Formulário de atualização de usuário','/users/form/[{uid}]','Formulário de atualização de usuário',NULL,0,';manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'users.profile','Profile','/profile/{id}','Perfil de usuário',NULL,0,';user;manager;admin;',0,NULL,NULL);
#Department
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'department.list','Departamentos','/department','Lista de usuários','fa-sitemap',1,';user;manager;admin;',1,25,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'department.form','Cadastro de departamentos','/department/form','Cadastro de departamentos',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'department.save','Salvar um departamento','/department/save','Salvar um usuário',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'department.update','Formulário de atualização de departamento','/department/form/[{uid}]','Formulário de atualização de departamento',NULL,0,';user;manager;admin;',0,NULL,NULL);
#Role
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'role.list','Funções','/role','Lista de funções','ti-id-badge',1,';user;manager;admin;',1,50,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'role.form','Cadastro de funções','/role/form','Cadastro de funções',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'role.save','Salvar um função','/role/save','Salvar um usuário',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'role.update','Formulário de atualização de função','/role/form/[{uid}]','Formulário de atualização de função',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'role.bydepartment','Webservice que retorna funções por departamento','/role/by/department/[{department}]','Webservice que retorna funções por departamento',NULL,0,';user;manager;admin;',0,NULL,NULL);
#Procedure
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'procedure.list','Procedimentos','/procedure','Lista de procedimentos','fa-check-square-o',1,';user;manager;admin;',1,60,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'procedure.form','Cadastro de Procedimento','/procedure/form','Cadastro de Procedimento',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'procedure.save','Salvar um Procedimento','/procedure/save','Salvar um Procedimento',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'procedure.update','Formulário de atualização de Procedimento','/procedure/form/[{uid}]','Formulário de atualização de procedimentos',NULL,0,';user;manager;admin;',0,NULL,NULL);
#Staff
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.list','Colaboradores','/staff','Lista de colaboradores','fa-users',1,';user;manager;admin;',1,100,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.form','Cadastro de colaboradores','/staff/form','Cadastro de colaboradores',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.save','Salvar um colaborador','/staff/save','Salvar um usuário',NULL,0,';user;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.update','Formulário de atualização de colaborador','/staff/form/[{uid}]','Formulário de atualização de colaborador',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.addskill','Adicionar uma Habilidade','/staff/addskill','Adicionar uma habilidade',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.delskill','Remover uma Habilidade','/staff/delskill/[{param}]','Remover uma habilidade',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'staff.status','Atualização do status do colaborador','/staff/status/[{param}]','Atualização do status do colaborador',NULL,0,';user;manager;admin;',0,NULL,NULL);
#Skill
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'skill.list','Habilidades','/skill','Lista de Habilidades','fa-suitcase',1,';user;manager;admin;',1,75,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'skill.form','Cadastro de Habilidade','/skill/form','Cadastro de Habilidade',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'skill.save','Salvar um Habilidade','/skill/save','Salvar uma habilidade',NULL,0,';user;manager;admin;',0,NULL,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'skill.update','Formulário de atualização de Habilidade','/skill/form/[{uid}]','Formulário de atualização de habilidades',NULL,0,';user;manager;admin;',0,NULL,NULL);
#Matrix
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'matrix.list','Matriz','/matrix','Matriz de polivalência e versatilidade',' fa-table',3,';user;manager;admin;',1,250,NULL);
INSERT INTO `menu` (`id`,`name`,`label`,`url`,`title`,`icon`,`parent`,`allow`,`display`,`order`,`commentary`) VALUES (NULL,'matrix.print','Matriz','/matrix/print','Matriz de polivalência e versatilidade','',3,';user;manager;admin;',0,250,NULL);




DELIMITER //

CREATE FUNCTION mask (unformatted_value BIGINT, format_string CHAR(32))
RETURNS CHAR(32) DETERMINISTIC

BEGIN
# Declare variables
DECLARE input_len TINYINT;
DECLARE output_len TINYINT;
DECLARE temp_char CHAR;

# Initialize variables
SET input_len = LENGTH(unformatted_value);
SET output_len = LENGTH(format_string);

# Construct formated string
WHILE ( output_len > 0 ) DO

SET temp_char = SUBSTR(format_string, output_len, 1);
IF ( temp_char = '#' ) THEN
IF ( input_len > 0 ) THEN
SET format_string = INSERT(format_string, output_len, 1, SUBSTR(unformatted_value, input_len, 1));
SET input_len = input_len - 1;
ELSE
SET format_string = INSERT(format_string, output_len, 1, '0');
END IF;
END IF;

SET output_len = output_len - 1;
END WHILE;

RETURN format_string;
END //

DELIMITER ;
