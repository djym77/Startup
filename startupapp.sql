CREATE DATABASE  IF NOT EXISTS `startupapp_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `startupapp_db`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: startupapp_db
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actualite` (
  `idactualite` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(45) DEFAULT NULL,
  `text` text,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_publication` datetime DEFAULT NULL,
  `etat` int(11) DEFAULT NULL,
  `administrateur_idadministrateur` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`idactualite`),
  KEY `fk_actualite_administrateur1_idx` (`administrateur_idadministrateur`),
  KEY `fk_actualite_cat_actualite1_idx` (`cat_id`),
  CONSTRAINT `fk_actualite_administrateur1` FOREIGN KEY (`administrateur_idadministrateur`) REFERENCES `administrator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_actualite_cat_actualite1` FOREIGN KEY (`cat_id`) REFERENCES `cat_actualite` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actualite`
--

LOCK TABLES `actualite` WRITE;
/*!40000 ALTER TABLE `actualite` DISABLE KEYS */;
/*!40000 ALTER TABLE `actualite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `profil_admin_idprofil_admin` int(11) NOT NULL,
  `last_connect` datetime DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_administrateur_profil_admin1_idx` (`profil_admin_idprofil_admin`),
  CONSTRAINT `fk_administrateur_profil_admin1` FOREIGN KEY (`profil_admin_idprofil_admin`) REFERENCES `profil_admin` (`idprofil_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrator`
--

LOCK TABLES `administrator` WRITE;
/*!40000 ALTER TABLE `administrator` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analyse`
--

DROP TABLE IF EXISTS `analyse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analyse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(45) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `parution_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_analyse_parution1_idx` (`parution_id`),
  CONSTRAINT `fk_analyse_parution1` FOREIGN KEY (`parution_id`) REFERENCES `parution` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analyse`
--

LOCK TABLES `analyse` WRITE;
/*!40000 ALTER TABLE `analyse` DISABLE KEYS */;
/*!40000 ALTER TABLE `analyse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cat_actualite`
--

DROP TABLE IF EXISTS `cat_actualite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cat_actualite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libele` varchar(100) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cat_actualite`
--

LOCK TABLES `cat_actualite` WRITE;
/*!40000 ALTER TABLE `cat_actualite` DISABLE KEYS */;
/*!40000 ALTER TABLE `cat_actualite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentaire_actualite`
--

DROP TABLE IF EXISTS `commentaire_actualite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire_actualite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire` varchar(3000) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `actualite_idactualite` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_commentaire_actualite_actualite1_idx` (`actualite_idactualite`),
  KEY `fk_commentaire_actualite_user1_idx` (`user_id`),
  CONSTRAINT `fk_commentaire_actualite_actualite1` FOREIGN KEY (`actualite_idactualite`) REFERENCES `actualite` (`idactualite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commentaire_actualite_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire_actualite`
--

LOCK TABLES `commentaire_actualite` WRITE;
/*!40000 ALTER TABLE `commentaire_actualite` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentaire_actualite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commentaire_parution`
--

DROP TABLE IF EXISTS `commentaire_parution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire_parution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `commentaire` varchar(3000) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `parution_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_commentaire_parution1_idx` (`parution_id`),
  KEY `fk_commentaire_user1_idx` (`user_id`),
  CONSTRAINT `fk_commentaire_parution1` FOREIGN KEY (`parution_id`) REFERENCES `parution` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commentaire_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire_parution`
--

LOCK TABLES `commentaire_parution` WRITE;
/*!40000 ALTER TABLE `commentaire_parution` DISABLE KEYS */;
/*!40000 ALTER TABLE `commentaire_parution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenu_publicite`
--

DROP TABLE IF EXISTS `contenu_publicite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contenu_publicite` (
  `id` int(11) NOT NULL,
  `affiche` varchar(225) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `publicite_idpublicite` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contenu_publicite_publicite1_idx` (`publicite_idpublicite`),
  CONSTRAINT `fk_contenu_publicite_publicite1` FOREIGN KEY (`publicite_idpublicite`) REFERENCES `publicite` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenu_publicite`
--

LOCK TABLES `contenu_publicite` WRITE;
/*!40000 ALTER TABLE `contenu_publicite` DISABLE KEYS */;
/*!40000 ALTER TABLE `contenu_publicite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contenu_service`
--

DROP TABLE IF EXISTS `contenu_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contenu_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `theme` varchar(45) DEFAULT NULL,
  `texte` varchar(225) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_contenu_service_service1_idx` (`service_id`),
  CONSTRAINT `fk_contenu_service_service1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contenu_service`
--

LOCK TABLES `contenu_service` WRITE;
/*!40000 ALTER TABLE `contenu_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `contenu_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parution`
--

DROP TABLE IF EXISTS `parution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(45) DEFAULT NULL,
  `contenu` varchar(400) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parution`
--

LOCK TABLES `parution` WRITE;
/*!40000 ALTER TABLE `parution` DISABLE KEYS */;
/*!40000 ALTER TABLE `parution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil_admin`
--

DROP TABLE IF EXISTS `profil_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profil_admin` (
  `idprofil_admin` int(11) NOT NULL,
  `libele` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idprofil_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil_admin`
--

LOCK TABLES `profil_admin` WRITE;
/*!40000 ALTER TABLE `profil_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `profil_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil_user`
--

DROP TABLE IF EXISTS `profil_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profil_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libele` varchar(45) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil_user`
--

LOCK TABLES `profil_user` WRITE;
/*!40000 ALTER TABLE `profil_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `profil_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publicite`
--

DROP TABLE IF EXISTS `publicite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publicite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(45) DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_debut` datetime DEFAULT NULL,
  `description` tinytext,
  `administrator_idadministrateur` int(11) NOT NULL,
  `date_fin` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_publicite_administrator1_idx` (`administrator_idadministrateur`),
  CONSTRAINT `fk_publicite_administrator1` FOREIGN KEY (`administrator_idadministrateur`) REFERENCES `administrator` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publicite`
--

LOCK TABLES `publicite` WRITE;
/*!40000 ALTER TABLE `publicite` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrique_service`
--

DROP TABLE IF EXISTS `rubrique_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rubrique_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `montant` bigint(9) DEFAULT NULL,
  `datedebut` datetime DEFAULT NULL,
  `datefin` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rubrique_service_service1_idx` (`service_id`),
  CONSTRAINT `fk_rubrique_service_service1` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrique_service`
--

LOCK TABLES `rubrique_service` WRITE;
/*!40000 ALTER TABLE `rubrique_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `rubrique_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(45) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `montant` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `souscription`
--

DROP TABLE IF EXISTS `souscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `souscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_expiration` datetime DEFAULT NULL,
  `rubrique_service_idrubrique` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_souscription_user_idx` (`user_id`),
  KEY `fk_souscription_rubrique_service1_idx` (`rubrique_service_idrubrique`),
  CONSTRAINT `fk_souscription_rubrique_service1` FOREIGN KEY (`rubrique_service_idrubrique`) REFERENCES `rubrique_service` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_souscription_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `souscription`
--

LOCK TABLES `souscription` WRITE;
/*!40000 ALTER TABLE `souscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `souscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `profession` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `motPasse` varchar(100) DEFAULT NULL,
  `photo` varchar(45) DEFAULT NULL,
  `typeUser_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `api_key` varchar(45) DEFAULT NULL,
  `last_connect` datetime DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_user_typeUser1_idx` (`typeUser_id`),
  CONSTRAINT `fk_user_typeUser1` FOREIGN KEY (`typeUser_id`) REFERENCES `profil_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'HAMED','OUATTARA','Business Strategy','hamed@ouattara.ci','01020304','halmed','1234','/uploads/avatar/1.jpg',NULL,'2016-11-19 03:53:41','5262fdzf6zgtrnebgr5n52evdscqds5dv',NULL,'2016-11-18',NULL),(2,'HAMED','OUATTARA','Business Strategy','hamed@ouattara.ci','01020304','halmed','1234','/uploads/avatar/1.jpg',NULL,'2016-11-19 04:20:56','5262fdzf6zgtrnebgr5n52evdscqds5dv',NULL,'2016-11-18',NULL),(3,'HAMED','OUATTARA','Business Strategy','hamed@ouattara.ci','01020304','hamed','$2a$10$9ddeb9dac4a313381daa2u8L8/VVOMEjNzfbTGeyNh6F2oeYOKQta','/uploads/avatar/1.jpg',NULL,'2016-11-19 04:33:31','869f03da3a6de3e74f201586d4682189',NULL,'2016-11-18',NULL),(4,'HAMED','OUATTARA','Business Strategy','hamed@ouattara.ci','01020304','hamed','$2a$10$64633ccc0fddaa1c8578cu0pYh5p1162BnY2fuZp2KBBC6IymRgty','',NULL,'2016-11-19 04:40:23','6135d9cf9a7d16f69cfbafeb84c19586',NULL,'2016-11-18',NULL),(5,'HAMED','OUATTARA','Business Strategy','hamed@ouattara.ci','01020304','hamed','$2a$10$6ee268777b318f70b37e2uwuCQUO2R4f7X4Y3lcKhgwDrzC8BUkl2','',NULL,'2016-11-19 04:40:39','401bdded2d8487ff8194f7d13946c6e7',NULL,'2016-11-18',NULL),(6,'HAMED','OUATTARA','','hamed@ouattara.ci','01020304','hamed','$2a$10$28e688373852e1b542ecae8SZ6CJni6SMrXqidSJLfeoYgs7NKtqC','/uploads/avatar/1.jpg',NULL,'2016-11-19 04:41:17','569f69bb9738e3bd8e33ceec5e24ae8c',NULL,'2016-11-18',NULL),(7,'HAMED','OUATTARA','Business Strategy','hamed@ouattara.ci','01020304','hamed','$2a$10$e49d407c511c87f67840cOUzWX7O3cBY/.wYCYj3jx7DNtroLgHuG','/uploads/avatar/1.jpg',NULL,'2016-11-19 04:42:48','b25fd3178da0ea9c80837cd48ed8b810',NULL,'2016-11-18',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'startupapp_db'
--

--
-- Dumping routines for database 'startupapp_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-19  4:44:31
