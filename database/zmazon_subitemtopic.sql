-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: zmazon
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `subitemtopic`
--

DROP TABLE IF EXISTS `subitemtopic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subitemtopic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siid` int NOT NULL,
  `pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `valid` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subitemtopic.siid` (`siid`),
  CONSTRAINT `subitemtopic.siid` FOREIGN KEY (`siid`) REFERENCES `subitems` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subitemtopic`
--

LOCK TABLES `subitemtopic` WRITE;
/*!40000 ALTER TABLE `subitemtopic` DISABLE KEYS */;
INSERT INTO `subitemtopic` VALUES (1,1,'assets\\items\\itempic\\1\\1\\1.jpg',1),(2,1,'assets\\items\\itempic\\1\\1\\2.jpg',1),(3,1,'assets\\items\\itempic\\1\\1\\3.jpg',1),(4,1,'assets\\items\\itempic\\1\\1\\4.jpg',1),(5,1,'assets\\items\\itempic\\1\\1\\5.jpg',1),(6,1,'assets\\items\\itempic\\1\\1\\6.jpg',1),(7,2,'assets\\items\\itempic\\1\\2\\1.jpg',1),(8,2,'assets\\items\\itempic\\1\\2\\2.jpg',1),(9,2,'assets\\items\\itempic\\1\\2\\3.jpg',1),(10,2,'assets\\items\\itempic\\1\\2\\4.jpg',1),(11,2,'assets\\items\\itempic\\1\\2\\5.jpg',1),(12,2,'assets\\items\\itempic\\1\\2\\6.jpg',1),(13,2,'assets\\items\\itempic\\1\\2\\7.jpg',1),(14,3,'assets\\items\\itempic\\2\\1\\1.jpg',1),(15,3,'assets\\items\\itempic\\2\\1\\2.jpg',1),(16,3,'assets\\items\\itempic\\2\\1\\3.jpg',1),(17,3,'assets\\items\\itempic\\2\\1\\4.jpg',1),(18,3,'assets\\items\\itempic\\2\\1\\5.jpg',1),(19,3,'assets\\items\\itempic\\2\\1\\6.jpg',1),(20,3,'assets\\items\\itempic\\2\\1\\7.jpg',1),(21,3,'assets\\items\\itempic\\2\\1\\8.jpg',1),(22,3,'assets\\items\\itempic\\2\\1\\9.jpg',1),(23,4,'assets\\items\\itempic\\3\\1\\1.jpg',1),(24,4,'assets\\items\\itempic\\3\\1\\2.jpg',1),(25,4,'assets\\items\\itempic\\3\\1\\3.jpg',1),(26,4,'assets\\items\\itempic\\3\\1\\4.jpg',1),(27,4,'assets\\items\\itempic\\3\\1\\5.jpg',1),(28,4,'assets\\items\\itempic\\3\\1\\6.jpg',1),(29,4,'assets\\items\\itempic\\3\\1\\7.jpg',1),(30,5,'assets\\items\\itempic\\4\\1\\1.jpg',1),(31,5,'assets\\items\\itempic\\4\\1\\2.jpg',1),(32,5,'assets\\items\\itempic\\4\\1\\3.jpg',1),(33,5,'assets\\items\\itempic\\4\\1\\4.jpg',1),(34,5,'assets\\items\\itempic\\4\\1\\5.jpg',1),(35,5,'assets\\items\\itempic\\4\\1\\6.jpg',1),(36,5,'assets\\items\\itempic\\4\\1\\7.jpg',1),(37,6,'assets\\items\\itempic\\5\\1\\1.jpg',1),(38,6,'assets\\items\\itempic\\5\\1\\2.jpg',1),(39,6,'assets\\items\\itempic\\5\\1\\3.jpg',1),(40,6,'assets\\items\\itempic\\5\\1\\4.jpg',1),(41,6,'assets\\items\\itempic\\5\\1\\5.jpg',1),(42,6,'assets\\items\\itempic\\5\\1\\6.jpg',1),(43,6,'assets\\items\\itempic\\5\\1\\7.jpg',1),(44,6,'assets\\items\\itempic\\5\\1\\8.jpg',1),(45,6,'assets\\items\\itempic\\5\\1\\9.jpg',1);
/*!40000 ALTER TABLE `subitemtopic` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-21 11:43:47
