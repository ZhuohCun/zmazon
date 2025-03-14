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
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siid` int NOT NULL,
  `uid` int NOT NULL,
  `quantity` int NOT NULL,
  `chosen` int NOT NULL DEFAULT '0',
  `checked` int NOT NULL DEFAULT '0',
  `valid` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cart.siid` (`siid`),
  KEY `cart.uid` (`uid`),
  CONSTRAINT `cart.siid` FOREIGN KEY (`siid`) REFERENCES `subitems` (`id`),
  CONSTRAINT `cart.uid` FOREIGN KEY (`uid`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,1,1,2,1,1,1),(2,3,1,1,1,0,0),(3,1,2,1,1,1,1),(4,2,2,1,1,1,1),(5,1,4,2,0,0,1),(6,2,4,1,0,0,1),(7,2,5,1,0,0,1),(8,2,1,1,1,1,1),(9,4,2,0,1,0,0),(10,1,7,0,1,0,0),(11,1,1,2,0,0,0),(12,2,1,1,1,1,1),(13,4,1,0,0,0,0),(14,5,1,1,1,1,1),(15,6,1,0,0,0,0),(16,5,1,1,1,1,1),(17,2,1,1,1,1,1),(18,5,1,1,1,1,1),(19,4,1,1,1,1,1),(20,1,1,0,0,0,0),(21,6,1,1,1,0,0),(22,3,1,1,1,1,1),(23,1,1,1,1,1,1),(24,6,1,1,1,1,1),(25,1,1,2,1,1,1),(26,2,1,1,1,1,1),(27,4,1,1,1,0,1),(28,5,1,1,1,1,1),(29,1,1,1,1,0,1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-14 18:06:42
