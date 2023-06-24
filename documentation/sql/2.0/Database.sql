
-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: localhost    Database: pgestao_app
-- ------------------------------------------------------
-- Server version	5.7.39

CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID for the company',
  `name` varchar(128) NOT NULL COMMENT 'Company name',
  `trade` varchar(64) DEFAULT NULL COMMENT 'Trading name of the company',
  `number` bigint(14) NOT NULL COMMENT 'Corporate Tax Payer Registration',
  `expire` date DEFAULT NULL COMMENT 'Expiration date',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date of registration on the system',
  `deleted` datetime DEFAULT NULL,
  `changed` datetime DEFAULT CURRENT_TIMESTAMP,
  `plan` int(11) NOT NULL DEFAULT '3' COMMENT '1 - Time de desenvolvimento\n2 - Trial\n3 - Pago',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `company` VALUES (1,'Pró Gestão','Pró Gestão',4484352000110,'2025-01-01','2023-02-26 14:08:57',NULL,NULL,3),(2,'Demonstração S.A.','Demonstração S.A.',4484352000110,'2025-01-01','2023-02-26 14:08:57',NULL,NULL,3);

--
-- Table structure for table `department`
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_company1_idx` (`company`),
  CONSTRAINT `fk_department_company1` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Table structure for table `menu`
--
CREATE TABLE `menu` (
  `id` int(11) NOT NULL COMMENT 'Unique identity number',
  `name` varchar(128) NOT NULL,
  `label` varchar(45) NOT NULL COMMENT 'Displayed name ',
  `url` varchar(512) DEFAULT '#' COMMENT 'Full electronic address',
  `title` varchar(256) DEFAULT NULL COMMENT 'Title of the link',
  `icon` varchar(45) DEFAULT NULL COMMENT 'Display icon of the Font Awesome Library',
  `parent` int(11) DEFAULT '0' COMMENT 'Parent on the tree',
  `allow` varchar(128) DEFAULT NULL COMMENT 'Roles that has access to the menu, separated by ;',
  `display` tinyint(4) DEFAULT '0' COMMENT 'Show on the menu',
  `order` int(11) DEFAULT NULL COMMENT 'Sequence in the menu',
  `commentary` varchar(512) DEFAULT NULL COMMENT 'Comment about the page',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `menu` VALUES (1,'menuCadastros','Cadastros',NULL,NULL,NULL,NULL,';user;manager;admin;',1,1000,'Grupo de cadastros do sistema'),(2,'menuRelatorios','Relatórios',NULL,NULL,NULL,NULL,';user;manager;admin;',1,2000,'Grupo de cadastros do sistema'),(3,'menuConfiguracao','Configurações',NULL,NULL,NULL,NULL,';manager;admin;',1,9000,'Grupo de cadastros do sistema'),(4,'home','Página inicial',NULL,NULL,NULL,NULL,';guess;user;manager;admin;',NULL,NULL,'Página inicial do sistema'),(5,'login','Login',NULL,NULL,NULL,NULL,';guess;user;manager;admin;',NULL,NULL,'Ação de login'),(6,'logout','Logout',NULL,NULL,NULL,NULL,';guess;user;manager;admin;',NULL,NULL,'Ação de logout'),(7,'data.import','Importador','/data/import','Importadores de dados','ti-cloud-up',3,';manager;admin;',1,9300,NULL),(8,'company.list','Empresas','/company','Lista de empresas','fa-building-o',3,';admin;',1,9100,NULL),(9,'company.form','Cadastro de empresa','/company/form','Formulário de cadastro de empresa',NULL,NULL,';admin;',NULL,NULL,NULL),(10,'company.save','Salvar empresas','/company/save','Ação para salvar empresas',NULL,NULL,';admin;',NULL,NULL,NULL),(11,'company.update','Atualização de empresas','/company/form/[{id}]','Formulário de atualização de empresas',NULL,NULL,';admin;',NULL,NULL,NULL),(12,'users.list','Usuáros','/user','Lista de usuários','fa-unlock-alt',3,';manager;admin;',1,9200,NULL),(13,'users.form','Cadastro de usuários','/users/form','Formulário de cadastro de usuários',NULL,NULL,';manager;admin;',NULL,NULL,NULL),(14,'users.save','Salvar usuário','/user/save','Ação para salvar usuário',NULL,NULL,';manager;admin;',NULL,NULL,NULL),(15,'users.update','Atualizar usuário','/user/form/[{uid}]','Formulário de atualização de usuários',NULL,NULL,';manager;admin;',NULL,NULL,NULL),(16,'users.profile','Perfil de usuário','/profile/{id}','Formuário de perfil de usuário',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(17,'department.list','Departamentos','/department','Lista de departamentos','fa-sitemap',1,';user;manager;admin;\'',1,1100,NULL),(18,'department.form','Cadastro de departamento','/department/form','Formulário de cadastro de departamento',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(19,'department.save','Salvar departamento','/department/save','Ação para salvar departamento',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(20,'department.update','Atualizar departamento','/department/form/[{id}]','Formulário de atualização de departamento',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(21,'role.list','Cargos','/role','Lista de cargos','ti-id-badge',1,';user;manager;admin;\'',1,1200,NULL),(22,'role.form','Cadastro de cargo','/role/form','Formulário de cadastro de cargo',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(23,'role.save','Salvar cargo','/role/save','Ação para salvar cargo',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(24,'role.update','Atualizar cargo','/role/form/[{id}]','Formulário de atualização de cargo',NULL,NULL,';user;manager;admin;\'',NULL,NULL,NULL),(25,'role.bydepartment','Lista de cargos de um departamento','/role/by/department/[{department}]','Webservice que retorna uma lista de cargos por departamento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(26,'process.list','Procedimentos','/process','Lista de procedimentos','fa-check-square-o',1,';user;manager;admin;',1,1300,NULL),(27,'process.form','Cadastro de procedimento','/process/form','Formulário de cadastro de procedimento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(28,'process.save','Salvar procedimento','/process/save','Ação para salvar procedimento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(29,'process.update','Atualizar procedimento','/process/form/[{id}]','Formulário de atualização de procedimento',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(30,'staff.list','Colaboradores','/staff','Lista de colaboradores','fa-users',1,';user;manager;admin;',1,1500,NULL),(31,'staff.form','Cadastro de colaborador','/staff/form','Forulário de cadastro de colaboradores',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(32,'staff.save','Salvar colaborador','/staff/save','Ação para salvar colaboradores',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(33,'staff.update','Atualizar colaborador','/staff/form/[{id}]','Formulário de atualização de colaboradores',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(34,'staff.addskill','Adicionar habilidade','/staff/addskill','Ação para salvar habilidade do colaborador',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(35,'staff.delskill','Remover habilidade','/staff/delskill/[{param}]','Ação para remover habilidade do colaborador',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(36,'staff.status','Atualizar status','/staff/status/[{param}]','Açào para atualizar o status do colaborador',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(37,'matrix.list','Matriz','/matrix','Matriz de polivalência e versatilidade','fa-table',2,';user;manager;admin;',1,NULL,NULL),(38,'matrix.print','Matriz para impressão','/matrix/print','Matriz de polivalência e versatilidade para impressão',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL),(39,'matrix.show','Matriz','/matrix/show','Matriz de polivalência e versatilidade para impressão',NULL,NULL,';user;manager;admin;',NULL,NULL,NULL);

CREATE TABLE `process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `company` int(11) DEFAULT NULL,
  `department` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_process_department1_idx` (`department`),
  CONSTRAINT `fk_process_department1` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `department` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_role_department1_idx` (`department`),
  CONSTRAINT `fk_role_department1` FOREIGN KEY (`department`) REFERENCES `department` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Table structure for table `role_has_process`
--

CREATE TABLE `role_has_process` (
  `role` int(11) NOT NULL,
  `process` int(11) NOT NULL,
  KEY `fk_role_has_process_role1_idx` (`role`),
  KEY `fk_role_has_process_process1_idx` (`process`),
  CONSTRAINT `fk_role_has_process_process1` FOREIGN KEY (`process`) REFERENCES `process` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_has_process_role1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `staff`
--
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL COMMENT 'Name of employee',
  `gender` char(1) DEFAULT NULL COMMENT 'Gender of employee',
  `photo` blob,
  `registration` varchar(15) DEFAULT NULL,
  `shift` varchar(15) DEFAULT NULL,
  `notes` text,
  `status` smallint(1) DEFAULT '1',
  `company` int(11) DEFAULT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_role1_idx` (`role`),
  CONSTRAINT `fk_staff_role1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `staff_know_process`
--
CREATE TABLE `staff_know_process` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `level` smallint(2) DEFAULT '0',
  `coach` varchar(124) DEFAULT NULL,
  `commentary` text,
  `inserted_by_manager` tinyint(4) DEFAULT NULL,
  `process` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_know_process_process1_idx` (`process`),
  KEY `fk_staff_know_process_staff1_idx` (`staff`),
  CONSTRAINT `fk_staff_know_process_process1` FOREIGN KEY (`process`) REFERENCES `process` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_staff_know_process_staff1` FOREIGN KEY (`staff`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `user`
--
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(256) DEFAULT NULL,
  `photo` longblob,
  `status` int(11) DEFAULT NULL COMMENT '0=disabled\n1=okay\n2=need validation\n3=expired',
  `role` varchar(45) DEFAULT NULL,
  `company` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mail_UNIQUE` (`email`),
  KEY `fk_user_company1_idx` (`company`),
  CONSTRAINT `fk_user_company1` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `user` VALUES (1,'Um9kcmlnbw==','cm9kcmlnb0BicnVuZXIubmV0LmJy','e10adc3949ba59abbe56e057f20f883e',NULL,1,'admin',1,'2023-02-27 22:19:30',NULL,NULL);
