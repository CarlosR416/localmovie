/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.1.21-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `series` (
	`id` varchar (30),
	`titulo` varchar (180),
	`img` varchar (180),
	`descripcion` varchar (360),
	`temporadas` int (10)
); 
insert into `series` (`id`, `titulo`, `img`, `descripcion`, `temporadas`) values('1415','The walking dead','twd.jpg',NULL,'8');
insert into `series` (`id`, `titulo`, `img`, `descripcion`, `temporadas`) values('1416','Juego de Tronos','juego-de-tronos_d4p4.1200.png',NULL,'8');
