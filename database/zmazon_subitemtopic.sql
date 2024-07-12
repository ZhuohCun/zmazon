-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: zmazon
-- ------------------------------------------------------
-- Server version	8.0.38

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
INSERT INTO `subitemtopic` VALUES (1,1,'assets\\items\\itempic\\1\\1\\1.jpg'),(2,1,'assets\\items\\itempic\\1\\1\\2.jpg'),(3,1,'assets\\items\\itempic\\1\\1\\3.jpg'),(4,1,'assets\\items\\itempic\\1\\1\\4.jpg'),(5,1,'assets\\items\\itempic\\1\\1\\5.jpg'),(6,1,'assets\\items\\itempic\\1\\1\\6.jpg'),(7,2,'assets\\items\\itempic\\1\\2\\1.jpg'),(8,2,'assets\\items\\itempic\\1\\2\\2.jpg'),(9,2,'assets\\items\\itempic\\1\\2\\3.jpg'),(10,2,'assets\\items\\itempic\\1\\2\\4.jpg'),(11,2,'assets\\items\\itempic\\1\\2\\5.jpg'),(12,2,'assets\\items\\itempic\\1\\2\\6.jpg'),(13,2,'assets\\items\\itempic\\1\\2\\7.jpg'),(14,3,'assets\\items\\itempic\\2\\1\\1.jpg'),(15,3,'assets\\items\\itempic\\2\\1\\2.jpg'),(16,3,'assets\\items\\itempic\\2\\1\\3.jpg'),(17,3,'assets\\items\\itempic\\2\\1\\4.jpg'),(18,3,'assets\\items\\itempic\\2\\1\\5.jpg'),(19,3,'assets\\items\\itempic\\2\\1\\6.jpg'),(20,3,'assets\\items\\itempic\\2\\1\\7.jpg'),(21,3,'assets\\items\\itempic\\2\\1\\8.jpg'),(22,3,'assets\\items\\itempic\\2\\1\\9.jpg'),(23,4,'assets\\items\\itempic\\3\\1\\1.jpg'),(24,4,'assets\\items\\itempic\\3\\1\\2.jpg'),(25,4,'assets\\items\\itempic\\3\\1\\3.jpg'),(26,4,'assets\\items\\itempic\\3\\1\\4.jpg'),(27,4,'assets\\items\\itempic\\3\\1\\5.jpg'),(28,4,'assets\\items\\itempic\\3\\1\\6.jpg'),(29,4,'assets\\items\\itempic\\3\\1\\7.jpg'),(30,5,'assets\\items\\itempic\\4\\1\\1.jpg'),(31,5,'assets\\items\\itempic\\4\\1\\2.jpg'),(32,5,'assets\\items\\itempic\\4\\1\\3.jpg'),(33,5,'assets\\items\\itempic\\4\\1\\4.jpg'),(34,5,'assets\\items\\itempic\\4\\1\\5.jpg'),(35,5,'assets\\items\\itempic\\4\\1\\6.jpg'),(36,5,'assets\\items\\itempic\\4\\1\\7.jpg'),(37,6,'assets\\items\\itempic\\5\\1\\1.jpg'),(38,6,'assets\\items\\itempic\\5\\1\\2.jpg'),(39,6,'assets\\items\\itempic\\5\\1\\3.jpg'),(40,6,'assets\\items\\itempic\\5\\1\\4.jpg'),(41,6,'assets\\items\\itempic\\5\\1\\5.jpg'),(42,6,'assets\\items\\itempic\\5\\1\\6.jpg'),(43,6,'assets\\items\\itempic\\5\\1\\7.jpg'),(44,6,'assets\\items\\itempic\\5\\1\\8.jpg'),(45,6,'assets\\items\\itempic\\5\\1\\9.jpg');
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

-- Dump completed on 2024-07-12 22:01:45
