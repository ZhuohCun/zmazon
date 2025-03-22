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
-- Table structure for table `thirdcategories`
--

DROP TABLE IF EXISTS `thirdcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thirdcategories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `thcname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `thcpic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `scid` int NOT NULL,
  `valid` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `thirdcategories.scid` (`scid`),
  CONSTRAINT `thirdcategories.scid` FOREIGN KEY (`scid`) REFERENCES `subcategories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thirdcategories`
--

LOCK TABLES `thirdcategories` WRITE;
/*!40000 ALTER TABLE `thirdcategories` DISABLE KEYS */;
INSERT INTO `thirdcategories` VALUES (1,'数码相机','assets\\category\\categories\\1\\1\\1.png',1,1),(2,'录像机','assets\\category\\categories\\1\\1\\2.png',1,1),(3,'照片印制机','assets\\category\\categories\\1\\1\\3.png',1,1),(4,'耳机及配件','assets\\category\\categories\\1\\2\\1.png',2,1),(5,'音响喇叭','assets\\category\\categories\\1\\2\\2.png',2,1),(6,'音响线材','assets\\category\\categories\\1\\2\\3.png',2,1),(7,'电视喇叭','assets\\category\\categories\\1\\3\\1.png',3,1),(8,'电视功放','assets\\category\\categories\\1\\3\\2.png',3,1),(9,'手机','assets\\category\\categories\\1\\4\\1.png',4,1),(10,'手机配件','assets\\category\\categories\\1\\4\\2.png',4,1),(11,'笔记本','assets\\category\\categories\\3\\1.png',6,1),(12,'平板电脑','assets\\category\\categories\\3\\2.png',6,1),(13,'路由器交换机','assets\\category\\categories\\3\\3.png',6,1),(14,'电脑配件','assets\\category\\categories\\3\\4.png',6,1),(15,'口腔护理','assets\\category\\categories\\2\\1.png',5,1),(16,'保健生活用品','assets\\category\\categories\\2\\2.png',5,1),(17,'日用清洁用品','assets\\category\\categories\\2\\3.png',5,1),(18,'收录音机','assets\\category\\categories\\1\\2\\4.png',2,1),(19,'电视配件','assets\\category\\categories\\1\\3\\3.png',3,1),(20,'机顶盒配件','assets\\category\\categories\\1\\3\\4.png',3,1);
/*!40000 ALTER TABLE `thirdcategories` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-22 19:29:35
