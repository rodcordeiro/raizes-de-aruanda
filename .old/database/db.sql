-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: id8872570_icnt
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

create database if not exists id8872570_icnt;
use id8872570_icnt;

CREATE USER 'id8872570_cordeiro'@'localhost' IDENTIFIED BY '@C0rdeiro';
GRANT ALL PRIVILEGES ON id8872570_icnt.* TO 'id8872570_cordeiro'@'localhost';

DROP TABLE IF EXISTS `linha`;
CREATE TABLE `linha` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `linha` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `linha` WRITE;
INSERT INTO 
  `linha`
VALUES
  (1,'orixa','Orixa Exu'),
  (2,'orixa','Iansa'),
  (3,'orixa','Iroko'),
  (4,'orixa','Logun-Edé'),
  (5,'orixa','Nanã'),
  (6,'orixa','Obá'),
  (7,'orixa','Ogun'),
  (8,'orixa','Omulu'),
  (9,'orixa','Ossain'),
  (10,'orixa','Oxalá'),
  (11,'orixa','Oxóssi'),
  (12,'orixa','Oxum'),
  (13,'orixa','Oxumarê'),
  (14,'orixa','Xangô'),
  (15,'orixa','Yemanja'),
  (16,'orixa','Yewá'),
  (17,'guia','Bahianos'),
  (18,'guia','Boiadeiros'),
  (19,'guia','Caboclos'),
  (20,'guia','Ciganos'),
  (21,'guia','Exu'),
  (22,'guia','Exu-mirim'),
  (23,'guia','Ibeijada'),
  (24,'guia','Malandro'),
  (25,'guia','Marinheiro'),
  (26,'guia','Pomba-gira'),
  (27,'guia','Preto-velho'),
  (28,'outros','Abertura'),
  (29,'outros','Encerramento'),
  (30,'outros','Defumação'),
  (31,'outros','Bater cabeça');
UNLOCK TABLES;

DROP TABLE IF EXISTS `pontos`;
CREATE TABLE `pontos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ritmo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ponto` mediumtext COLLATE utf8_unicode_ci,
  `linha` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `audio_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `pontos` WRITE;
INSERT INTO `pontos` VALUES 
  (1,'Ijexá','Colhe amendoim, milho e coco\r\nManda preparar o axoxô\r\nArco e flecha em punho, é só bravura\r\nPlanta, roça, agricultura\r\nIansã, Ogum, Agué e Oxalá\r\nBrinca, ginga, corre, reza e cura\r\nPressa o passo, criatura\r\nA mãe-mata céu e ouro chama\r\n\r\nJeje, Ketu e Angola vem te ver\r\nDesfilar teu abebê\r\nVer teu lume, sol e bronze de urucum\r\nDespe o véu, derrama realeza\r\nTece, cresce com riqueza\r\nÊ Logun, Logun!\r\n\r\nCamarão, cebola, azeite e ovo\r\nTempera o feijão do omolocum\r\nLava a alma, sal, mel e candura\r\nLaroiê, dendê, doçura\r\nAjunsum, Bessém, Sobô, Iemanjá\r\nNanã nina flor de formosura\r\nBenze e brinda com fartura\r\nA mãe-água céu e ouro canta\r\n\r\nTodo encanto canta, é só beleza\r\nOuro, amor, azul-turquesa\r\nÉ de sonhos, caçador e pescador\r\nValha-me, perfuma e me arrebata\r\nPelas cascatas e matas\r\nÊ Logun, Logun arô!\r\n\r\nLossi, Lossi!\r\nDança, filho de Tobossi!\r\nOlha quanta flor eu trouxe\r\nPra embalar teu Ijexá!\r\nFará, Logun!\r\nCaça, filho de Otulu!\r\nPai maior, que é Olorum\r\nTrouxe axé pro teu ofá!\r\n','Logun-Edé','Chamada','5f0113b1ceaa3daacebcb6427506af39.mp3','Ponto de Logun Edé - Festa para Logun Edé')
  ;
UNLOCK TABLES;
