/*
SQLyog Ultimate v12.4.1 (64 bit)
MySQL - 10.1.21-MariaDB 
*********************************************************************
*/
/*!40101 SET NAMES utf8 */;

create table `peliculas` (
	`id` varchar (30),
	`titulo` varchar (120),
	`img` varchar (180),
	`descripcion` varchar (360),
	`duracion` varchar (30),
	`url` varchar (120)
); 
insert into `peliculas` (`id`, `titulo`, `img`, `descripcion`, `duracion`, `url`) values('10103','New Girl','0465903.jpg-r_1280_720-f_jpg-q_x-xxyxx.jpg','lored','2:00','ju.mp4');
