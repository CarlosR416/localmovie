/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.1.21-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `series_capitulos` (
	`id` varchar (30),
	`id_serie` varchar (30),
	`temporada` int (10),
	`nombre` varchar (180),
	`duracion` varchar (30),
	`descripcion` varchar (360),
	`url` varchar (180)
); 
