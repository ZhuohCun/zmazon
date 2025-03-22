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
-- Table structure for table `ordertosubitem`
--

DROP TABLE IF EXISTS `ordertosubitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ordertosubitem` (
  `id` int NOT NULL AUTO_INCREMENT,
  `oid` int NOT NULL,
  `siid` int NOT NULL,
  `quantity` int NOT NULL,
  `siprice` float DEFAULT NULL,
  `siimportfee` float DEFAULT NULL,
  `transportfee` float DEFAULT NULL,
  `valid` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ordertosubitem.oid` (`oid`),
  KEY `ordertosubitem.siid` (`siid`),
  CONSTRAINT `ordertosubitem.oid` FOREIGN KEY (`oid`) REFERENCES `orders` (`id`),
  CONSTRAINT `ordertosubitem.siid` FOREIGN KEY (`siid`) REFERENCES `subitems` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ordertosubitem`
--

LOCK TABLES `ordertosubitem` WRITE;
/*!40000 ALTER TABLE `ordertosubitem` DISABLE KEYS */;
INSERT INTO `ordertosubitem` VALUES (1,1,1,1,400,0,0,1),(2,2,5,1,192.22,20,20,1),(3,3,2,1,399.43,0,0,1),(4,4,2,1,399.43,0,0,1),(5,5,5,1,192.22,23.49,20,1),(6,5,1,2,400,44.21,50,1);
/*!40000 ALTER TABLE `ordertosubitem` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-22 19:29:31
