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
-- Table structure for table `subitems`
--

DROP TABLE IF EXISTS `subitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subitems` (
  `id` int NOT NULL AUTO_INCREMENT,
  `iid` int NOT NULL,
  `sitext` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `subname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `siprice` float NOT NULL,
  `siimportfee` float NOT NULL,
  `transportfee` float NOT NULL,
  `rcid` int NOT NULL,
  `rcverify` int NOT NULL COMMENT '0.pending proving 1.valid 2.prove failed 3.expired 4.not recomment',
  `icid` int NOT NULL,
  `icverify` int NOT NULL COMMENT '0.pending proving 1.valid 2.prove failed 3.expired 4.not recomment',
  `valid` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subitems.iid` (`iid`),
  KEY `subitems.icid` (`icid`),
  KEY `subitems.rcid` (`rcid`),
  CONSTRAINT `subitems.icid` FOREIGN KEY (`icid`) REFERENCES `indexcategories` (`id`),
  CONSTRAINT `subitems.iid` FOREIGN KEY (`iid`) REFERENCES `items` (`id`),
  CONSTRAINT `subitems.rcid` FOREIGN KEY (`rcid`) REFERENCES `recccategories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subitems`
--

LOCK TABLES `subitems` WRITE;
/*!40000 ALTER TABLE `subitems` DISABLE KEYS */;
INSERT INTO `subitems` VALUES (1,1,'KODAK粉色升级数码相机,自动对焦 50MP FHD 1080P 儿童相机,带 16 倍变焦防抖功能,小型相机适合儿童学生儿童青少年女孩男孩,儿童相机带 32GB SD 卡,2 节电池','粉色',400,44.21,50,4,1,8,1,1),(2,1,'KODAK黑色升级数码相机,自动对焦 50MP FHD 1080P 儿童相机,带 16 倍变焦防抖功能,小型相机适合儿童学生儿童青少年女孩男孩,儿童相机带 32GB SD 卡,2 节电池','黑色',399.43,94.88,55,3,1,7,0,1),(3,2,'Kodak PIXPRO FZ55 红色 1600 万像素数码相机 5 倍光学变焦 28 毫米广角 1080P 全高清视频 2.7 英寸液晶摄像头 + 64GB 读卡器 + 保护套 + 记忆钱包 + 三脚架 + 清洁套装','红色',1316.04,322.07,60,2,0,2,1,1),(4,3,'Samsung 三星 计算机内部固态硬盘 4.0 TB 兼容台式机 usb 3.0 向下兼容 MZ-V9P4T0CW','4TB990 PRO',2427.06,248.39,50,1,0,2,0,0),(5,4,'Davids 牙膏 缓解牙齿敏感 通用成人款 5.25盎司(约149克)','薄荷味',192.22,23.49,20,4,1,2,1,1),(6,5,'brother 兄弟 ColAura 彩色照片和标签打印机','VC500W',1254.82,136.12,50,3,1,1,1,1);
/*!40000 ALTER TABLE `subitems` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-21 11:43:46
