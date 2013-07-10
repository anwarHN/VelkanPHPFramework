CREATE DATABASE  IF NOT EXISTS `velkan` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `velkan`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: velkan
-- ------------------------------------------------------
-- Server version	5.1.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `grid_test`
--

DROP TABLE IF EXISTS `grid_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grid_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt_desc` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `numero` double DEFAULT NULL,
  `porcentaje` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Prueba para los grid	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grid_test`
--
-- ORDER BY:  `id`

LOCK TABLES `grid_test` WRITE;
/*!40000 ALTER TABLE `grid_test` DISABLE KEYS */;
INSERT INTO `grid_test` VALUES (1,'Prueba 1','2013-03-29',10,0.5),(2,'Prueba 2','2013-03-30',11,0.11),(3,'Prueba 3','2013-03-30',11,0.5),(4,'Prueba 4','2013-03-31',12,0.12),(5,'Prueba 5','2013-04-01',13,0.8),(6,'Prueba 6','2013-04-02',14,0.14),(7,'Prueba 7','2013-04-03',15,0.15),(8,'Prueba 8','2013-07-20',123,1.23),(9,'Prueba 9','2013-04-11',23,0.5),(10,'Prueba 10','2013-04-10',22,0.22),(11,'Prueba 11','2013-04-10',22,0.22),(12,'Prueba 12','2013-10-27',222,2.22),(13,'Prueba 13','2013-10-27',222,2.22),(14,'Prueba 14','2013-10-27',222,2.22),(15,'Prueba 15','2013-10-27',222,2.22),(16,'Prueba 16','2013-10-27',222,2.22),(17,'Prueba 17','2013-10-27',222,2.22),(18,'Prueba 18','2013-10-27',222,2.22),(19,'Prueba 19','2013-10-27',222,2.22),(20,'Prueba 20','2013-10-27',222,2.22),(21,'Prueba 21','2013-10-27',222,2.22),(22,'Prueba 22','2013-10-27',222,2.22),(23,'Prueba 23','2013-10-27',222,2.22),(24,'Prueba 24','2013-10-27',222,2.22),(25,'Prueba 25','2013-10-27',222,2.22),(26,'Prueba 26','2013-10-27',222,2.22),(27,'Prueba 27','2013-10-27',222,2.22),(28,'Prueba 28','2013-10-27',222,2.22),(29,'Prueba 29','2013-10-27',222,2.22),(30,'Prueba 30','2013-10-27',222,2.22);
/*!40000 ALTER TABLE `grid_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `select_test`
--

DROP TABLE IF EXISTS `select_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `select_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt_desc` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `select_test`
--
-- ORDER BY:  `id`

LOCK TABLES `select_test` WRITE;
/*!40000 ALTER TABLE `select_test` DISABLE KEYS */;
INSERT INTO `select_test` VALUES (1,'Prueba 1'),(2,'Prueba 2'),(3,'Prueba 3'),(4,'Prueba 4');
/*!40000 ALTER TABLE `select_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataview_test`
--

DROP TABLE IF EXISTS `dataview_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataview_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataview_test`
--
-- ORDER BY:  `id`

LOCK TABLES `dataview_test` WRITE;
/*!40000 ALTER TABLE `dataview_test` DISABLE KEYS */;
INSERT INTO `dataview_test` VALUES (1,'Prueba 1','Descripcion 1',NULL),(2,'Prueba 2','Descripcion 2',NULL),(3,'Prueba 3','Descripcion 3',NULL),(4,'Prueba 4','Descripcion 4',NULL),(5,'Prueba 5','Descripcion 5',NULL),(6,'Prueba 6','Descripcion 6',NULL);
/*!40000 ALTER TABLE `dataview_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_test`
--

DROP TABLE IF EXISTS `form_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL,
  `text_area` text COLLATE utf8_spanish_ci,
  `date` date NOT NULL,
  `time` time DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `select` int(11) DEFAULT NULL,
  `select_dependency_1` int(11) NOT NULL,
  `select_dependency_2` int(11) NOT NULL,
  `select_dependency_3` int(11) NOT NULL,
  `option` int(11) DEFAULT NULL,
  `checkbox` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Prueba de un formulario';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_test`
--
-- ORDER BY:  `id`

LOCK TABLES `form_test` WRITE;
/*!40000 ALTER TABLE `form_test` DISABLE KEYS */;
INSERT INTO `form_test` VALUES (102,'ssd','sdsd','0000-00-00',NULL,NULL,1,0,0,0,1,2);
/*!40000 ALTER TABLE `form_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_test`
--

DROP TABLE IF EXISTS `option_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `option_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_test`
--
-- ORDER BY:  `id`

LOCK TABLES `option_test` WRITE;
/*!40000 ALTER TABLE `option_test` DISABLE KEYS */;
INSERT INTO `option_test` VALUES (1,'Option 1'),(2,'Option 2'),(3,'Option 3'),(4,'Option 4'),(5,'Option 5');
/*!40000 ALTER TABLE `option_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `select_test_dependency`
--

DROP TABLE IF EXISTS `select_test_dependency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `select_test_dependency` (
  `id_parent` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`id_parent`),
  KEY `select_test_d_fk1` (`id_parent`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `select_test_dependency`
--
-- ORDER BY:  `id`,`id_parent`

LOCK TABLES `select_test_dependency` WRITE;
/*!40000 ALTER TABLE `select_test_dependency` DISABLE KEYS */;
INSERT INTO `select_test_dependency` VALUES (1,1,'Prueba padre 1 ID 1'),(1,2,'Prueba padre 1 ID 2'),(1,3,'Prueba padre 1 ID 3'),(2,4,'Prueba padre 2 ID 4');
/*!40000 ALTER TABLE `select_test_dependency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `select_test_dependency_2`
--

DROP TABLE IF EXISTS `select_test_dependency_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `select_test_dependency_2` (
  `id_parent_1` int(11) NOT NULL,
  `id_parent_2` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`id_parent_1`,`id_parent_2`),
  KEY `select_test_d_2_fk1` (`id_parent_1`,`id_parent_2`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `select_test_dependency_2`
--
-- ORDER BY:  `id`,`id_parent_1`,`id_parent_2`

LOCK TABLES `select_test_dependency_2` WRITE;
/*!40000 ALTER TABLE `select_test_dependency_2` DISABLE KEYS */;
INSERT INTO `select_test_dependency_2` VALUES (1,1,1,'sadasd'),(1,1,2,'efwegfreg'),(1,2,3,'safdfgtrghj');
/*!40000 ALTER TABLE `select_test_dependency_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) NOT NULL,
  `id_txt_usuario` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `txt_pass` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Tabla de usuarios	';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--
-- ORDER BY:  `id_usuario`

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'velkan','cuconx');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lookup_test`
--

DROP TABLE IF EXISTS `lookup_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lookup_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lookup_test`
--
-- ORDER BY:  `id`

LOCK TABLES `lookup_test` WRITE;
/*!40000 ALTER TABLE `lookup_test` DISABLE KEYS */;
INSERT INTO `lookup_test` VALUES (1,'Prueba 1'),(2,'Prueba 2'),(3,'Prueba 3'),(4,'Prueba 4');
/*!40000 ALTER TABLE `lookup_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'velkan'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-09 20:54:08
