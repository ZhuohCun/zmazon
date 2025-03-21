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
-- Table structure for table `subtips`
--

DROP TABLE IF EXISTS `subtips`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subtips` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tid` int DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `valid` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subtips.tid` (`tid`),
  CONSTRAINT `subtips.tid` FOREIGN KEY (`tid`) REFERENCES `tips` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtips`
--

LOCK TABLES `subtips` WRITE;
/*!40000 ALTER TABLE `subtips` DISABLE KEYS */;
INSERT INTO `subtips` VALUES (1,1,'Z马逊海外购商品由Z马逊海外网站出售，适用使用境外网站所在的原销售地的法律、法规、标准、规范和惯例等，因此可能在以下方面区别于在中国境内出售的商品：',1),(2,1,'尺码：如果销售品牌提供了具体的尺码表，请以品牌尺码表为准。',1),(3,1,'电压和电源插座：电子产品可能不支持中国的电压环境、电源插座等规格标准，需配合变压或转换设备等使用。',1),(4,1,'美妆商品保质期：美妆商品的生产日期／保质期标注可能和国内渠道购买的产品有所区别，详见美妆商品购买提示',1),(5,1,'售后服务：Z马逊海外购的商品由境外网站所在的原销售地的品牌商提供售后保修，该等保修和其他售后服务可能不覆盖中国，详情请联系品牌商的售后咨询。',1),(6,1,'标签、手册和说明书：标签、手册和说明书等未译成中文；所载成分、声称、产品描述、参考值和推荐值可能与中国标准或惯例有别。',1),(7,1,'其他：因出售地和使用地人群(特别是儿童、老人和残疾人等)、使用环境、消费场景与习惯不同，可能导致商品不能或不能完全适用于使用目的。',1),(8,2,'根据中国海关的要求，在您购买Z马逊海外购商品时，需要提交订购人的身份证信息（目前仅支持中国居民身份证信息验证）用于清关',1),(9,2,'Z马逊不会以任何理由索要您的银行卡号、验证码等信息。如遇不法分子冒充Z马逊海外购客服向您索取银行账户等信息，请及时通过联系Z马逊海外购客服或报警，敬请提高警惕。',1),(10,3,'Z马逊海外购商品符合海关进出口政策要求，且支持中国除港澳台地区之外的全境配送，但部分偏远地区的配送时间会相应延长，少数商品不支持配送。如果您已成功下单而我们无法为您配送，我们会及时通知您。',1),(11,4,'Z马逊海外购出售的境外商品仅限个人自用，购买行为必须遵循自用、合理数量原则，不得转为其他商业用途，不得再次销售。',1);
/*!40000 ALTER TABLE `subtips` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-21 11:43:49
