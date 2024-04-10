-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: localhost    Database: report_db
-- ------------------------------------------------------
-- Server version	5.7.27

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
-- Table structure for table `customermaster`
--

DROP TABLE IF EXISTS `customermaster`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customermaster` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `customer_cd` varchar(6) NOT NULL,
  `customer_name` varchar(45) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customermaster`
--

LOCK TABLES `customermaster` WRITE;
/*!40000 ALTER TABLE `customermaster` DISABLE KEYS */;
INSERT INTO `customermaster` VALUES (2,'000002','アクセンチュア株式会社',NULL,NULL,NULL,'2017-04-05 02:57:43','2017-04-05 02:57:43'),(3,'000003','伊藤忠テクノソリューションズ株式会社','','','','2016-07-07 06:27:14',NULL),(4,'000004','太陽生命保険株式会社',NULL,NULL,NULL,'2017-04-28 00:02:07','2017-04-28 00:02:07'),(5,'000005','日本オフィス･システム株式会社','','','','2016-07-07 06:27:14',NULL),(6,'000006','トライビュー・イノベーション株式会社','','','','2016-07-07 06:27:14',NULL),(7,'000007','株式会社トスコ','','','','2016-07-07 06:27:14',NULL),(8,'000008','株式会社日立ソリューションズ・クリエイト','','','','2016-07-07 06:27:14',NULL),(9,'000009','株式会社スキルウェア','','','','2016-07-07 06:27:14',NULL),(10,'000010','シミックＰＭＳ株式会社',NULL,NULL,NULL,'2017-03-01 06:07:19','2017-03-01 06:07:19'),(11,'000011','株式会社ダイナック','','','','2016-07-07 06:27:14',NULL),(12,'000012','エス・アンド・アイ株式会社','','','','2016-07-07 06:27:14',NULL),(13,'000013','株式会社フォー・クオリア','','','','2016-07-07 06:27:14',NULL),(14,'000014','株式会社アベリオシステムズ','','','','2016-07-07 06:27:14',NULL),(15,'000015','フェアユース株式会社','','','','2016-07-07 06:27:14',NULL),(16,'000016','一般財団法人　 恵済団','','','','2016-07-07 06:27:14',NULL),(17,'000017','株式会社コムカル','','','','2016-07-07 06:27:14',NULL),(18,'000018','アルケー情報株式会社','','','','2016-07-07 06:27:14',NULL),(19,'000019','株式会社ジーアングル','','','','2016-07-07 06:27:14',NULL),(20,'000020','ヴァイタル・インフォメーション株式会社','','','','2016-07-07 06:27:14',NULL),(21,'000021','ソシオ・ダイバシティ株式会社','','','','2016-07-07 06:27:14',NULL),(22,'000022','株式会社 ＩＴクリエイト','','','','2016-07-07 06:27:14',NULL),(23,'000023','株式会社クラウドソース','','','','2016-07-07 06:27:14',NULL),(24,'000024','株式会社ユニバーサルコムピューターシステム','','','','2016-07-07 06:27:14',NULL),(25,'000025','株式会社サイバーミッションズ','','','','2016-07-07 06:27:14',NULL),(26,'000026','株式会社 Ｋ-ＢＩＴ','','','','2016-07-07 06:27:14',NULL),(27,'000027','株式会社アイセック･ジャパン','','','','2016-07-07 06:27:14',NULL),(28,'000028','日本コンピュータ･ダイナミクス株式会社','','','','2016-07-07 06:27:14',NULL),(29,'000029','株式会社情報システム工学','','','','2016-07-07 06:27:14',NULL),(30,'000030','株式会社アーズ','','','','2016-07-07 06:27:14',NULL),(31,'000031','有限会社アール','','','','2016-07-07 06:27:14',NULL),(32,'000032','株式会社シミックＢＳ','','','','2016-07-07 06:27:14',NULL),(33,'000033','アイリスク研究所株式会社','','','','2016-07-07 06:27:14',NULL),(34,'000034','株式会社コーエイ','','','','2016-07-07 06:27:14',NULL),(35,'000035','株式会社フューチャーインフィニティ','','','','2016-07-07 06:27:14',NULL),(36,'000036','株式会社ビット','','','','2016-07-07 06:27:14',NULL),(37,'000037','株式会社シティ・コム','','','','2016-07-07 06:27:14',NULL),(38,'000038','MIRAIT Information Systems','','','','2016-07-07 06:27:14',NULL),(39,'000039','GIC Holdings Pte Ltd','','','','2016-07-07 06:27:14',NULL),(40,'000040','株式会社エンカレッジ','','','','2016-07-07 06:27:14',NULL),(41,'000041','株式会社システムトラスト','','','','2016-07-07 06:27:14',NULL),(42,'000042','デルタ電子株式会社','','','','2016-07-07 06:27:14',NULL),(43,'000043','株式会社オペレーティング・パートナーズ','','','','2016-07-07 06:27:14',NULL),(44,'000044','ジーアイシーテイアンドアール株式会社','','','','2016-07-07 06:27:14',NULL),(46,'000046','株式会社アクティス','','','','2016-07-07 06:27:14',NULL),(47,'000047','株式会社アールアイ','','','','2016-07-07 06:27:14',NULL),(48,'000048','日本機械輸出組合','','','','2016-07-07 06:27:14',NULL),(49,'000049','常磐鋼帯株式会社','','','','2016-07-07 06:27:14',NULL),(50,'000050','株式会社ナゴヤカタン','','','','2016-07-07 06:27:14',NULL),(51,'000051','水野ストレーナー工業株式会社','','','','2016-07-07 06:27:14',NULL),(52,'000052','ゼットエー株式会社','','','','2016-07-07 06:27:14',NULL),(53,'000053','藤田 和夫','','','','2016-07-07 06:27:14',NULL),(54,'000054','株式会社PMLight','','','','2016-07-07 06:27:14',NULL),(55,'000055','株式会社アイコス','','','','2016-07-07 06:27:14',NULL),(56,'000056','アルス株式会社','','','','2016-07-07 06:27:14',NULL),(57,'000057','三和コムテック株式会社','','','','2016-07-07 06:27:14',NULL),(58,'000058','株式会社ECC','','','','2016-07-07 06:27:14',NULL),(59,'000059','株式会社DHI','','','','2016-07-07 06:27:14',NULL),(60,'000060','岩永 智之','','','','2016-07-07 06:27:14',NULL),(61,'000061','株式会社エスペラントシステム','','','','2016-07-07 06:27:14',NULL),(62,'000062','株式会社クラウド・ナイン','','','','2016-07-07 06:27:14',NULL),(63,'000063','大島農機株式会社','','','','2016-07-07 06:27:14',NULL),(64,'000064','株式会社日本ビジネスエンジニアリング','','','','2016-07-07 06:27:14',NULL),(65,'000065','株式会社野村総合研究所','','','','2016-07-07 06:27:14',NULL),(66,'000066','国立大学法人 豊橋技術科学大学','','','','2016-07-07 06:27:14',NULL),(67,'000067','情報技術開発株式会社','','','','2016-07-07 06:27:14',NULL),(68,'000068','ブロケード コミュニケーションズ システムズ株式会社','','','','2016-07-07 06:27:14',NULL),(69,'000069','オーアール・ラボ株式会社','','','','2016-07-07 06:27:14',NULL),(70,'000070','株式会社きくや美粧堂','','','','2016-07-07 06:27:14',NULL),(71,'000071','株式会社ジーエイシージャパン','','','','2016-07-07 06:27:14',NULL),(72,'000072','Littelfuseジャパン合同会社','','','','2016-07-07 06:27:14',NULL),(73,'000073','ジャストウェア株式会社','','','','2016-07-07 06:27:14',NULL),(133,'000074','本社業務','','','','2016-11-04 05:14:35','2016-11-04 05:14:35'),(134,'000134','トッパン・フォームズ株式会社','','','','2017-02-23 00:26:18','2017-02-23 00:26:18'),(135,'000135','メディアサイト株式会社','','','','2017-02-25 17:14:00','2017-02-25 17:14:00'),(136,'999995','新規企業開発','','','','2017-04-07 05:02:34','2017-04-07 05:02:34'),(137,'000075','株式会社日立社会情報サービス',NULL,NULL,NULL,'2018-04-04 02:29:39','2018-04-04 02:29:39'),(138,'999996','営業統括本部業務','','','','2017-04-07 06:07:34','2017-04-07 06:07:34'),(139,'999997','情報システム室業務','','','','2017-04-07 06:07:58','2017-04-07 06:07:58'),(140,'999998','海外事務','','','','2017-04-07 06:08:20','2017-04-07 06:08:20'),(141,'999999','管理本部業務','','','','2017-04-07 06:08:33','2017-04-07 06:08:33'),(142,'000076','KDDI株式会社','','','','2017-04-18 01:02:26','2017-04-18 01:02:26'),(143,'000077','レゾナントシステムズ (株)','','','','2017-04-21 12:46:28','2017-04-21 12:46:28'),(144,'000136','富士通エフ・アイ・ピー株式会社','','','','2017-05-19 01:52:33','2017-05-19 01:52:33'),(145,'000137','株式会社サザビーリーグ','','','','2017-05-21 23:56:21','2017-05-21 23:56:21'),(146,'000138','日立ソリューションズ西日本株式会社','','','','2017-11-22 01:14:12','2017-11-22 01:14:12'),(147,'000139','メイプルシステムズ','','','','2017-12-04 06:31:58','2017-12-04 06:31:58'),(148,'999994','経営企画室','','','','2017-12-12 03:00:02','2017-12-12 03:00:02'),(149,'000140','株式会社TATERU',NULL,'0364470651','〒 150-0001東京都渋谷区神宮前1-5-8-20F / 21F（受付21F）','2018-04-17 05:51:14','2018-04-17 05:51:14'),(150,'000141','テクバン株式会社','','0354188500','〒108-0014\r\n東京都港区芝5丁目33番7号','2018-04-17 05:49:43','2018-04-17 05:49:43'),(151,'000142','株式会社 オフィス エフエイ・コム','','0285411140','〒329-0216 \r\n栃木県小山市楢木293-21 小山南工業団地内','2018-04-17 05:53:01','2018-04-17 05:53:01'),(152,'000143','株式会社日本キャスト','','','','2018-05-30 01:09:17','2018-05-30 01:09:17'),(155,'000146','株式会社エイム・ソフト','','','','2018-07-04 08:53:41','2018-07-04 08:53:41'),(156,'000144','株式会社ワールド情報','','','','2018-07-04 08:54:51','2018-07-04 08:54:51'),(157,'000145','アクサス株式会社','','','','2018-07-04 08:55:08','2018-07-04 08:55:08'),(158,'000147','グローバルビジョンテクノロジー','','','','2018-07-09 01:32:51','2018-07-09 01:32:51'),(159,'000148','情報技術センター','','','','2018-07-09 01:33:09','2018-07-09 01:33:09'),(160,'000149',' ヒューマンテクノロジーズ','','','','2018-07-10 01:35:19','2018-07-10 01:35:19'),(161,'000150','株式会社ハイ・アベイラビリティ・システムズ','','','','2018-08-01 00:42:00','2018-08-01 00:42:00'),(162,'000151','JALインフォテック','','','','2018-08-01 00:42:28','2018-08-01 00:42:28'),(163,'000152','アイテザー','','','','2018-08-06 08:51:21','2018-08-06 08:51:21'),(164,'000153','株式会社NIPPO','','','','2018-08-30 10:25:34','2018-08-30 10:25:34'),(165,'000154','株式会社エー・アンド・ビー・コンピュータ','','','','2018-09-03 04:03:01','2018-09-03 04:03:01'),(166,'000155','株式会社ECS','','','','2018-09-03 04:04:15','2018-09-03 04:04:15'),(167,'000156','Extreme Networks K.K.','','','〒100-0013\r\n東京都千代田区霞が関1-4-2\r\n大同生命霞が関ビル11F','2018-10-09 08:28:36','2018-10-09 08:28:36'),(168,'000157','株式会社A＆B','',' 0363244000','〒107-0062 東京都港区南青山5-13-11パンセビル ２階','2018-10-09 08:32:00','2018-10-09 08:32:00'),(169,'000158','株式会社情報技術センター','','0364537140','〒108-0014\r\n東京都港区芝5-29-14 田町日工ビル 8F','2018-10-09 08:34:56','2018-10-09 08:34:56'),(170,'000159','バリューソフトウェア','','0357775878','〒105-6221 東京都港区愛宕2-5-1\r\n愛宕グリーンヒルズMORIタワー 21階','2018-11-15 08:47:23','2018-11-15 08:47:23'),(171,'160','株式会社 イルミナ','info@erumina.com','05035628055','〒190-0013\r\n東京都立川市富士見町6丁目25－401','2018-11-30 00:58:58','2018-11-30 00:58:58'),(172,'000161','富士ソフト',NULL,'0456508811','〒231-8008　神奈川県横浜市中区桜木町1-1','2018-12-05 00:55:14','2018-12-05 00:55:14'),(173,'000162','キーウェアソリューションズ','92411-koubai@keyware.co.jp','0332906804','東京都世田谷区上北沢５－３７－１８','2019-05-28 01:28:51','2019-05-28 01:28:51'),(174,'383','アークシステム株式会社','','','','2021-08-10 01:09:24','2021-08-10 01:09:24'),(175,'384','株式会社WACUL','','','','2021-08-10 01:09:34','2021-08-10 01:09:34'),(176,'385','ナレッジワークス株式会社','','','','2021-11-23 09:59:28','2021-11-23 09:59:28'),(177,'395','株式会社アドバンス','','','','2022-03-22 04:08:44','2022-03-22 04:08:44');
/*!40000 ALTER TABLE `customermaster` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-04 13:42:48