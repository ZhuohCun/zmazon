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
-- Table structure for table `subitemtotext`
--

DROP TABLE IF EXISTS `subitemtotext`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subitemtotext` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siid` int NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `valid` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subitemtotext.siid` (`siid`),
  CONSTRAINT `subitemtotext.siid` FOREIGN KEY (`siid`) REFERENCES `subitems` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subitemtotext`
--

LOCK TABLES `subitemtotext` WRITE;
/*!40000 ALTER TABLE `subitemtotext` DISABLE KEYS */;
INSERT INTO `subitemtotext` VALUES (1,1,'【便携式紧凑型相机】数码相机配有高性能 CMOS 传感器。 它可以拍摄高达5000万像素的照片和录制FHD 1080P视频。 作为一款紧凑型相机,它提供便携性和口袋尺寸标志,随时携带和外出都很容易。',1),(2,1,'【小巧但功能强大】这款袖珍数码相机适合初学者,支持时间戳、16 倍变焦、延时、慢动作、自动对焦、连续拍摄、手电筒、运动检测、面部检测、自拍定时器、网络摄像头、电脑或相机播放。 操作简单,只需完全按下快门按钮即可拍照。',1),(3,1,'【图像传输】您可以毫不费力地将图像从数码相机传输到电脑,只需使用随附的 USB 数据线将相机连接到计算机,它还具有网络摄像头的功能。 我们还包括一张 32GB SD 卡,以确保您有足够的存储空间。',1),(4,1,'【保修和包装清单】我们提供3年保修,如果您有任何问题,可以随时与我们联系。 您可以在包装上查看我们的联系信息。 包装包括 2 个电池、1 x 32GB SD 卡、1 根 USB 数据线、1 x 儿童数码相机、1 x 挂绳和包。',1),(5,1,'【给相机初学者的绝佳礼物】这款数码相机操作简单，非常适合初学者。它也可以用作儿童相机，用于培养6岁以上儿童的摄影兴趣。非常适合圣诞节和感恩节等节日的礼物，非常适合圣诞节和感恩节等节日的礼物，以及生日、毕业典礼和情人节。',1),(6,1,'ASIN: B0D1G85PLK',1),(7,2,'【便携式紧凑型相机】数码相机配有高性能 CMOS 传感器。 它可以拍摄高达5000万像素的照片和录制FHD 1080P视频。 作为一款紧凑型相机,它提供便携性和口袋尺寸标志,随时携带和外出都很容易。',1),(8,2,'【小巧但功能强大】这款袖珍数码相机适合初学者,支持时间戳、16 倍变焦、延时、慢动作、自动对焦、连续拍摄、手电筒、运动检测、面部检测、自拍定时器、网络摄像头、电脑或相机播放。 操作简单,只需完全按下快门按钮即可拍照。',1),(9,2,'【图像传输】您可以毫不费力地将图像从数码相机传输到电脑,只需使用随附的 USB 数据线将相机连接到计算机,它还具有网络摄像头的功能。 我们还包括一张 32GB SD 卡,以确保您有足够的存储空间。',1),(10,2,'【保修和包装清单】我们提供3年保修,如果您有任何问题,可以随时与我们联系。 您可以在包装上查看我们的联系信息。 包装包括 2 个电池、1 x 32GB SD 卡、1 根 USB 数据线、1 x 儿童数码相机、1 x 挂绳和包。',1),(11,2,'【给相机初学者的绝佳礼物】这款数码相机操作简单，非常适合初学者。它也可以用作儿童相机，用于培养6岁以上儿童的摄影兴趣。非常适合圣诞节和感恩节等节日的礼物，非常适合圣诞节和感恩节等节日的礼物，以及生日、毕业典礼和情人节。',1),(12,2,'ASIN: B0D14CH2H8',1),(13,3,'包括:柯达 PIXPRO FZ55 数码相机 + 可充电锂离子电池 + USB 电缆 + AC 适配器 + 手腕带 + 扩展包:64GB 高速卡 + 读卡器 + 存储卡钱包 + 保护套 + 桌面三脚架和清洁包',1),(14,3,'28 毫米广角镜头 - 16MP 1/2.3 英寸 CMOS 传感器',1),(15,3,'5 倍光学变焦镜头 - 2.7 英寸 LCD 屏幕',1),(16,3,'30 fps 全高清1080p 视频录制 - 数字图像稳定',1),(17,3,'内置闪光灯 - 可充电锂离子电池 - 全景模式',1),(18,3,'ASIN: B0CX3P7K3C',1),(19,4,'超高速。 炫酷的胜利:我们的三星 990 PRO Gen 4 带散热器 SSD 可帮助您达到接近大性能*,闪电般的速度和散热器,提高温度控制',1),(20,4,'达到新的水平:Gen4 以更快的传输速度和高性能带宽提升;与 980 PRO 相比,随机性能提高了 55% 以上,可进行重型计算和更快的加载',1),(21,4,'来自世界一指的闪存品牌的快 SSD **:适合各种场合所需的速度;读取和写入速度高达 7450/6900 MB/s*,您将达到 PCIe 4.0***的性能几乎达到佳性能',1),(22,4,'无限制游戏:给自己一些空间,存储容量从 1TB 到 4TB;同步所有保存内容,并在游戏、视频编辑、数据分析等方面发挥卓越作用',1),(23,4,'采用 PS5 制造:超薄集成散热器旨在散热设备以稳定其温度并防止性能问题;兼容 PlayStation 5 和 PCI-SIG D8 标准台式机和笔记本电脑****',1),(24,4,'这是一款动力移动:为您的性能节省电量;获得电源效率,同时体验比 980 PRO*****性能提高高达 50%;它使每一步都更有效,减少功耗',1),(25,4,'释放 990 PRO 的全部潜力:使用三星 Magician 先进而直观的优化工具充分利用您的 SSD ;监控驱动器状况,保护有价值的数据,并接收 990 PRO 带散热器的重要更新',1),(26,4,'世界排名的闪存存储器品牌:体验自 2003 年以来世界品牌的闪存性能和可靠性;所有固件和组件,包括三星世界知名的 DRAM 和 NAND 都在内部生产,质量值得信赖**',1),(27,4,'ASIN: B0CHHFR1LG',1),(28,5,'采用纳米羟基磷灰石(n-HA) - 占牙齿材料97%的成分相同。 我们消除了氟化物,并用这种生物相容性成分取代,以重新矿化牙釉质,减少牙齿敏感性并自然。',1),(29,5,'温和增白 – 微抛光剂温和去除表面污渍,,不会引起过氧化物或其他漂白剂通常会发现的敏感度。 RDA(磨料等级)101,可有效去除牙菌斑和表面污渍,同时对珐琅质进行日常刷牙。 符合 ADA (美国协会)的范围。',1),(30,5,'生物活性敏感缓解 - 大多数敏感牙膏使用硝酸钾()暂时麻木牙齿。 我们使用羟基磷灰石(n-HA)通过再矿化牙釉质和通道(管)来降低敏感度。',1),(31,5,'清洁和的成分 – Davids 仅使用源自植物和地球的优质成分,不含动物副产品(植物)。 无氟,无硫酸盐(无 SLS),EWG 认证。 不含香料、色素或防腐剂。 桦木糖醇用于改善口腔。',1),(32,5,'口腔 – 可恢复的PH平衡,支持口腔的口腔微生物群。 牙菌斑是牙齿的主要敌人,Davids 旨在大力阻止牙菌斑形成,减少现有牙菌斑积聚,同时让您的口腔感觉清新和特别干净。 口腔,您。',1),(33,5,'ASIN: B09JHSVM58',1),(34,6,'没有墨水打印：Brother VC-500W 紧凑型彩色打印机使用 ZINK Zero Ink 技术提供丰富、生动的全彩色，而无需墨水。高质量照片打印所需的所有颜色都嵌入到粘合剂支持的 ZINK 纸中。',1),(35,6,'无限使用的多功能打印：创建和打印标签、照片、贴纸等以装饰、个性化和自定义礼品：从照片项目和派对礼品到各种组织任务、商业项目、家居装饰等。',1),(36,6,'易于连接和使用：Wi-Fi/Wireless Direct 允许您从几乎任何地方进行无线打印，或者直接从智能手机或平板电脑在网络上共享。连接到无线网络时，通过手机进行创建和打印。',1),(37,6,'标签编辑器应用程序让你发挥创意免费的颜色标签编辑器应用程序包括数千个元素，包括框架、字体、艺术品、背景和现成的设计，以及来自 Air Print 功能的应用程序的印刷品，以释放你的创造力。',1),(38,6,'更换 VC-500W 的 CZ 和 CK 卷：VC-500W 使用兄弟 CZ 和 CK 替换卷 CZ-1001、CZ-1002、CZ-1003、CZ-1004、CZ-1005、CK-1000。',1),(39,6,'ASIN: B07KWW7RH6',1);
/*!40000 ALTER TABLE `subitemtotext` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-22 19:29:33
