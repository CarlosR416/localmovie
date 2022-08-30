/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.1.21-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `usuarios` (
	`id` bigint (20),
	`user` varchar (2250),
	`correo` varchar (2250),
	`password` varchar (2250)
); 
insert into `usuarios` (`id`, `user`, `correo`, `password`) values('1','WILLIAM','','1234');
