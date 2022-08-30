/*
SQLyog Ultimate v12.4.1 (32 bit)
MySQL - 10.1.21-MariaDB : Database - routein
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`routein` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `routein`;

/*Table structure for table `categoria_peliculas` */

DROP TABLE IF EXISTS `categoria_peliculas`;

CREATE TABLE `categoria_peliculas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pelicula` varchar(20) DEFAULT NULL,
  `categoria` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `categoria_peliculas` */

insert  into `categoria_peliculas`(`id`,`pelicula`,`categoria`) values 
(1,'10102','1'),
(2,'10103','1'),
(3,'10104','1'),
(4,'10105','4');

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `categorias` */

insert  into `categorias`(`id`,`nombre`) values 
(1,'Accion'),
(2,'Drama'),
(3,'Fantasia'),
(4,'Romance'),
(5,'Miedo');

/*Table structure for table `peliculas` */

DROP TABLE IF EXISTS `peliculas`;

CREATE TABLE `peliculas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) DEFAULT NULL,
  `img` varchar(60) DEFAULT NULL,
  `descripcion` varchar(160) DEFAULT NULL,
  `duracion` varchar(10) DEFAULT NULL,
  `url` varchar(60) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10107 DEFAULT CHARSET=latin1;

/*Data for the table `peliculas` */

insert  into `peliculas`(`id`,`titulo`,`img`,`descripcion`,`duracion`,`url`,`updated_at`,`created_at`) values 
(10102,'Escape room','0465903.jpg-r_1280_720-f_jpg-q_x-xxyxx.jpg','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!','1:39','Escape.room.2019.1080p-dual-lat-cinecalidad.is.mp4',NULL,NULL),
(10103,'Insidious: The Last Key','the_last_key.jpg','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!','1:33','Insidious.the.last.key.2018.1080p-dual-lat-cinecalidad.mp4',NULL,NULL),
(10104,'Ant-Man y la Avispa','poster_resize_192X288.jpg','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!','1:58','Ant-Man_y_la_Avispa.mp4',NULL,NULL),
(10106,'Musica amigos y fiesta','Musica_amigos_y_fiesta.jpg','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!','2:00','vistas/Musica_amigos_y_fiesta.mp4',NULL,NULL);

/*Table structure for table `serie_categoria` */

DROP TABLE IF EXISTS `serie_categoria`;

CREATE TABLE `serie_categoria` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `serie` varchar(20) DEFAULT NULL,
  `categoria` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `serie_categoria` */

/*Table structure for table `series` */

DROP TABLE IF EXISTS `series`;

CREATE TABLE `series` (
  `id` varchar(30) DEFAULT NULL,
  `titulo` varchar(180) DEFAULT NULL,
  `img` varchar(180) DEFAULT NULL,
  `descripcion` varchar(360) DEFAULT NULL,
  `temporadas` int(10) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `series` */

insert  into `series`(`id`,`titulo`,`img`,`descripcion`,`temporadas`,`updated_at`,`created_at`) values 
('1415','The walking dead','twd.jpg',NULL,8,NULL,NULL),
('1416','Juego de Tronos','juego-de-tronos_d4p4.1200.png',NULL,8,NULL,NULL),
('1417','Lucifer','Lucifer.jpg',NULL,3,NULL,NULL),
('1418','vis a vis','vis_a_vis.jpg',NULL,5,NULL,NULL);

/*Table structure for table `series_capitulos` */

DROP TABLE IF EXISTS `series_capitulos`;

CREATE TABLE `series_capitulos` (
  `id` varchar(30) DEFAULT NULL,
  `id_serie` varchar(30) DEFAULT NULL,
  `temporada` int(10) DEFAULT NULL,
  `capitulo` int(10) DEFAULT NULL,
  `nombre` varchar(180) DEFAULT NULL,
  `img` varchar(60) DEFAULT NULL,
  `duracion` varchar(30) DEFAULT NULL,
  `descripcion` varchar(360) DEFAULT NULL,
  `url` varchar(180) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `series_capitulos` */

insert  into `series_capitulos`(`id`,`id_serie`,`temporada`,`capitulo`,`nombre`,`img`,`duracion`,`descripcion`,`url`) values 
('141511','1415',1,1,'Capitulo 1','twd.jpg',NULL,NULL,'the_walking_dead/tem_1/1x01l.MP4'),
('141512','1415',1,2,'Capitulo 2','twd.jpg',NULL,NULL,'the_walking_dead/tem_1/1x02l.MP4'),
('141513','1415',1,3,'Capitulo 3','twd.jpg',NULL,NULL,'the_walking_dead/tem_1/1x03l.MP4'),
('141514','1415',1,4,'Capitulo 4','twd.jpg',NULL,NULL,'the_walking_dead/tem_1/1x04l.MP4'),
('141515','1415',1,5,'Capitulo 5','twd.jpg',NULL,NULL,'the_walking_dead/tem_1/1x05l.MP4'),
('141516','1415',1,6,'Capitulo 6','twd.jpg',NULL,NULL,'the_walking_dead/tem_1/1x06l.MP4'),
('141521','1415',2,1,'Capitulo 1','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x01).MP4'),
('141522','1415',2,2,'Capitulo 2','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x02).MP4'),
('141523','1415',2,3,'Capitulo 3','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x03).MP4'),
('141524','1415',2,4,'Capitulo 4','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x04).MP4'),
('141525','1415',2,5,'Capitulo 5','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x05).MP4'),
('141526','1415',2,6,'Capitulo 6','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x06).MP4'),
('141527','1415',2,7,'Capitulo 7','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x07).MP4'),
('141528','1415',2,8,'Capitulo 8','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x08).MP4'),
('141529','1415',2,9,'Capitulo 9','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x09).MP4'),
('1415210','1415',2,10,'Capitulo 10','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x010).MP4'),
('1415211','1415',2,11,'Capitulo 11','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x011).MP4'),
('1415212','1415',2,12,'Capitulo 12','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x012).MP4'),
('1415213','1415',2,13,'Capitulo 13','twd2.jpg',NULL,NULL,'the_walking_dead/tem_2/TWD(2x013).MP4'),
('141531','1415',3,1,'Capitulo 1','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x01).MP4'),
('141532','1415',3,2,'Capitulo 2','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x02).MP4'),
('141533','1415',3,3,'Capitulo 3','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x03).MP4'),
('141534','1415',3,4,'Capitulo 4','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x04).MP4'),
('141535','1415',3,5,'Capitulo 5','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x05).MP4'),
('141536','1415',3,6,'Capitulo 6','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x06).MP4'),
('141537','1415',3,7,'Capitulo 7','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x07).MP4'),
('141538','1415',3,8,'Capitulo 8','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x08).MP4'),
('141539','1415',3,9,'Capitulo 9','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x09).MP4'),
('1415310','1415',3,10,'Capitulo 10','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x010).MP4'),
('1415311','1415',3,11,'Capitulo 11','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x011).MP4'),
('1415312','1415',3,12,'Capitulo 12','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x012).MP4'),
('1415313','1415',3,13,'Capitulo 13','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x013).MP4'),
('1415314','1415',3,14,'Capitulo 14','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x014).MP4'),
('1415315','1415',3,15,'Capitulo 15','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x015).MP4'),
('1415316','1415',3,16,'Capitulo 16','twd3.jpeg',NULL,NULL,'the_walking_dead/tem_3/TWD(3x016).MP4');

/*Table structure for table `users_logs` */

DROP TABLE IF EXISTS `users_logs`;

CREATE TABLE `users_logs` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(10) DEFAULT NULL,
  `id_rcs` varchar(10) DEFAULT NULL,
  `id_subrcs` varchar(10) DEFAULT NULL,
  `comentario` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

/*Data for the table `users_logs` */

insert  into `users_logs`(`id`,`id_user`,`id_rcs`,`id_subrcs`,`comentario`,`created_at`,`updated_at`) values 
(53,'1','1415','1415316','inicia capitulo series','2020-05-01 20:24:06','2020-05-01 20:24:06'),
(54,'1','1415','141511','inicia capitulo series','2020-05-01 20:25:09','2020-05-01 20:25:09'),
(55,'1','1415','141516','inicia capitulo series','2020-05-01 20:25:13','2020-05-01 20:25:13'),
(56,'1','1415','141521','inicia capitulo series','2020-05-01 20:25:24','2020-05-01 20:25:24'),
(57,'1','1415','141522','inicia capitulo series','2020-05-01 20:26:11','2020-05-01 20:26:11'),
(58,'1','1415','141531','inicia capitulo series','2020-05-05 01:42:20','2020-05-05 01:42:20'),
(59,'2','1415','141511','inicia capitulo series','2020-05-05 01:44:45','2020-05-05 01:44:45'),
(60,'2','1415','141512','inicia capitulo series','2020-05-05 01:46:05','2020-05-05 01:46:05'),
(61,'2','1415','141521','inicia capitulo series','2020-05-05 01:47:49','2020-05-05 01:47:49'),
(62,'1','1415','141511','inicia capitulo series','2020-05-05 02:45:57','2020-05-05 02:45:57'),
(63,'2','1415','141531','inicia capitulo series','2020-05-05 02:46:38','2020-05-05 02:46:38'),
(64,'1','1415','141513','inicia capitulo series','2020-05-05 03:13:07','2020-05-05 03:13:07'),
(65,'1','1415','141514','inicia capitulo series','2020-05-05 03:19:23','2020-05-05 03:19:23');

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admin` int(2) DEFAULT '0',
  `user` varchar(250) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `usuarios` */

insert  into `usuarios`(`id`,`admin`,`user`,`correo`,`password`) values 
(1,1,'SOLUCIONEX','','1234'),
(2,0,'Carlos','','1425'),
(3,0,'Administrador','','1414');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
