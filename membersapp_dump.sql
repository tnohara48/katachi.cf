-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: membersapp
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `dat_otoiawase`
--

DROP TABLE IF EXISTS `dat_otoiawase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dat_otoiawase` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `family_name_kanji` varchar(30) NOT NULL,
  `given_name_kanji` varchar(30) NOT NULL,
  `family_name_furi` varchar(30) NOT NULL,
  `given_name_furi` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `mail` varchar(30) NOT NULL,
  `otoiawase` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `note` varchar(30) NOT NULL DEFAULT '一時保存中',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dat_otoiawase`
--

LOCK TABLES `dat_otoiawase` WRITE;
/*!40000 ALTER TABLE `dat_otoiawase` DISABLE KEYS */;
INSERT INTO `dat_otoiawase` VALUES (1,'野原','達夫','','','09036123226','tnohara48@gmail.com','','2018-10-26 02:31:38','2018-10-26 02:31:38','一時保存中'),(2,'野原','達夫','','','9036123226','tnohara48@gmail.com','123','2018-10-29 06:44:45','2018-10-29 06:44:45','一時保存中'),(3,'野原','達夫','','','9036123226','tnohara48@gmail.com','123','2018-10-29 06:45:18','2018-10-29 06:45:18','一時保存中'),(4,'野原','達夫','','','9036123226','tnohara48@gmail.com','ｑｗでｑｗｄｗ','2018-11-01 06:44:34','2018-11-01 06:44:34','一時保存中'),(5,'野原','達夫','のはら','たつお','9036123226','tnohara48@gmail.com','ｑｗでｑｗｄｗ','2018-11-01 06:52:33','2018-11-01 06:52:33','一時保存中'),(6,'野原','達夫','のはら','たつお','9036123226','tnohara@futtotahato.com','ha','2018-11-02 03:26:27','2018-11-02 03:26:27','一時保存中');
/*!40000 ALTER TABLE `dat_otoiawase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diary_members`
--

DROP TABLE IF EXISTS `diary_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diary_members` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `member_name` text NOT NULL,
  `subject1` text NOT NULL,
  `subject2` text NOT NULL,
  `subject3` text NOT NULL,
  `subject4` text NOT NULL,
  `subject5` text NOT NULL,
  `subject6` text NOT NULL,
  `subject7` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_staff` varchar(30) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diary_members`
--

LOCK TABLES `diary_members` WRITE;
/*!40000 ALTER TABLE `diary_members` DISABLE KEYS */;
INSERT INTO `diary_members` VALUES (1,1,'野原達夫','JAVA　３ステップ','本文','問題','むつかしい','つぎの課題が欲しい','テレビ','','2018-11-07 14:39:50','2018-11-07 14:39:50',''),(2,1,'野原達夫','作業','','','','つぎの課題が欲しい','本','','2018-11-07 14:42:07','2018-11-07 14:42:07',''),(3,3,'ねぎ49','JAVA　３ステップ','課題４','クラスがむずかしい','ちゃんと本を読む','つぎの課題が欲しい','テレビ','','2018-11-16 13:48:00','2018-11-16 13:48:00',''),(4,61,'松村沙友里','ももも','questionｑｑ','ℚｑｑｑ','Webｗ','その他','本','','2018-11-20 22:04:56','2018-11-20 22:04:56','');
/*!40000 ALTER TABLE `diary_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qa_history`
--

DROP TABLE IF EXISTS `qa_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qa_history` (
  `code_qa` int(11) NOT NULL AUTO_INCREMENT,
  `member_id_qa` varchar(30) NOT NULL,
  `member_name_qa` varchar(30) NOT NULL,
  `category` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `date_time_q` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_time_a` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answerer` varchar(30) NOT NULL,
  PRIMARY KEY (`code_qa`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qa_history`
--

LOCK TABLES `qa_history` WRITE;
/*!40000 ALTER TABLE `qa_history` DISABLE KEYS */;
INSERT INTO `qa_history` VALUES (1,'3','ねぎ49','JAVA/JAVA試験について','sadasdsa','ｓｓｓｓ','','2018-11-16 14:20:50','2018-11-16 14:20:50','斎藤'),(2,'61','松村沙友里','WEB関連について（HTML/CSS/Javascript）','次の章に進みたい','qqqq','','2018-11-20 21:12:38','2018-11-20 21:12:38','斎藤'),(3,'61','松村沙友里','WEB関連について（HTML/CSS/Javascript）','次の章に進みたい','qqqq','','2018-11-20 21:12:57','2018-11-20 21:12:57','斎藤'),(4,'61','松村沙友里','英語/IT英語について','sadasdsa','111','','2018-11-20 21:22:53','2018-11-20 21:22:53','大橋'),(5,'61','松村沙友里','英語/IT英語について','sadasdsa','qq','','2018-11-20 22:11:41','2018-11-20 22:11:41','山本'),(6,'61','松村沙友里','プログラミング全般について','1１１１１１１１１１１１１１１１１','１１１１１１１１１１１１１１１１１１１','','2018-11-20 22:12:57','2018-11-20 22:12:57','田中'),(7,'61','\"松村沙友里\"','\"英語/IT英語について\"','\"ええええええええええええええええええ\"','\"ええええええええええええええええええええええ\"','','2018-11-21 00:13:00','2018-11-21 00:13:00','\"斎藤\"'),(8,'\"61\"','\"松村沙友里\"','\"JAVA/JAVA試験について\"','\"次の章に進みたい\"','\"秋元真夏\"','','2018-11-21 00:16:32','2018-11-21 00:16:32','\"田中\"'),(9,'\"61\"','\"松村沙友里\"','\"JAVA/JAVA試験について\"','\"sd\"','\"ｓｓｓｓ\"','','2018-11-21 00:23:03','2018-11-21 00:23:03','\"大橋\"'),(10,'\"61\"','\"松村沙友里\"','\"生活全般について\"','\"aa\"','\"秋元真夏\"','','2018-11-21 00:28:03','2018-11-21 00:28:03','\"田中\"'),(11,'\"61\"','\"松村沙友里\"','\"生活全般について\"','\"aa\"','\"秋元真夏\"','','2018-11-21 00:29:57','2018-11-21 00:29:57','\"田中\"'),(12,'\"61\"','\"松村沙友里\"','\"生活全般について\"','\"aa\"','\"秋元真夏\"','','2018-11-21 00:32:01','2018-11-21 00:32:01','\"田中\"'),(13,'\"61\"','\"松村沙友里\"','\"英語/IT英語について\"','\"アクティブ\"','\"ありがとうございます。\"','','2018-11-21 00:35:00','2018-11-21 00:35:00','\"田中\"'),(14,'\"61\"','\"松村沙友里\"','\"WEB関連について（HTML/CSS/Javascript）\"','\"ｓｄｆ\"','\"あああああああああああああああああああああああああああああああああああｆ\"','','2018-11-21 00:38:01','2018-11-21 00:38:01','\"田中\"'),(15,'\"61\"','\"松村沙友里\"','\"プログラミング全般について\"','\"次の章に進みたい\"','\"アクティブあ\"','','2018-11-21 00:41:26','2018-11-21 00:41:26','\"斎藤\"'),(16,'\"61\"','\"松村沙友里\"','\"WEB関連について（HTML/CSS/Javascript）\"','\"あああああああああああああああああああああああああああああああああああ\"','\"ああああああああああああああああああああああああああああああああああああ\"','','2018-11-21 00:53:54','2018-11-21 00:53:54','\"田中\"'),(17,'61','\"松村沙友里\"','\"WEB関連について（HTML/CSS/Javascript）\"','\"ASF\"','\"ASF\"','','2018-11-21 01:12:42','2018-11-21 01:12:42','\"大橋\"'),(18,'61','\"松村沙友里\"','\"英語/IT英語について\"','\"asd\"','\"dddddddddddd\"','','2018-11-21 01:19:10','2018-11-21 01:19:10','\"山本\"'),(19,'61','\"松村沙友里\"','\"英語/IT英語について\"','\"wwwwwwwwwwwwww\"','\"wwwwwwwww\"','','2018-11-21 01:20:14','2018-11-21 01:20:14','\"諏訪\"'),(20,'61','\"松村沙友里\"','\"生活全般について\"','\"wwwwwwwwww\"','\"eeeeeeeeeeeeeeeeeeeeeee\"','','2018-11-21 01:21:55','2018-11-21 01:21:55','\"大橋\"'),(21,'\'61\'','\'松村沙友里\'','\'英語/IT英語について\'','\'dfgsh\'','\'sdhf\'','','2018-11-21 01:52:57','2018-11-21 01:52:57','\'大橋\''),(22,'61','松村沙友里','WEB関連について（HTML/CSS/Javascript）','asd','dfffffffff','','2018-11-21 01:56:02','2018-11-21 01:56:02','大橋'),(23,'61','松村沙友里','WEB関連について（HTML/CSS/Javascript）','asd','dfffffffff','','2018-11-21 01:56:15','2018-11-21 01:56:15','大橋'),(24,'61','松村沙友里','WEB関連について（HTML/CSS/Javascript）','55555555555555555','555555555555555555555','','2018-11-21 01:58:29','2018-11-21 01:58:29','斎藤'),(25,'61','松村沙友里','WEB関連について（HTML/CSS/Javascript）','66666666666666666','66666666666666666666','','2018-11-21 02:04:56','2018-11-21 02:04:56','その他'),(26,'61','松村沙友里','「未来のかたち」について','7777777777777777777','7777777777777777777777','','2018-11-21 02:06:59','2018-11-21 02:06:59','諏訪');
/*!40000 ALTER TABLE `qa_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `is_staff` varchar(30) NOT NULL,
  `login_status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'野原達夫','29f306744d6c7c006eeea75cf4df2583','スタッフ',0,'2018-11-07 14:31:25','2018-11-07 14:43:46'),(2,'','74be16979710d4c4e7c6647856088456','一般利用者',0,'2018-11-15 13:13:45','2018-11-15 13:13:45'),(3,'ねぎ49','1f32aa4c9a1d2ea010adcf2348166a04','一般利用者',0,'2018-11-15 13:13:55','2018-11-15 13:13:55');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-21  3:09:40
