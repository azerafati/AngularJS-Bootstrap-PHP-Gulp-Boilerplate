-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: angularboil
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.10.1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `url` varchar(1024) DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `img` varchar(256) DEFAULT NULL,
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `info` text,
  `seodesc` varchar(160) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'دسته ۱','دسته-۱',NULL,1,10,0,NULL,0,NULL,NULL);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `msg` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `level` int(1) unsigned NOT NULL DEFAULT '1',
  `type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_log_user` (`user_id`),
  CONSTRAINT `FK_log_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `depth` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `url` varchar(1024) DEFAULT NULL,
  `parent` int(10) unsigned DEFAULT NULL,
  `sort` int(10) unsigned NOT NULL DEFAULT '0',
  `img` varchar(256) DEFAULT NULL,
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_category_shop_parent_idx` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=912 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'منو ۱',0,'منو-۱',NULL,1,NULL,0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `qty` int(10) unsigned NOT NULL DEFAULT '1',
  `status` int(10) unsigned NOT NULL,
  `currency` varchar(3) NOT NULL,
  `weight` int(10) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `buydate` datetime DEFAULT NULL,
  `cus_info` varchar(2045) DEFAULT NULL,
  `purchase_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `fk_orderitem_order_idx` (`order_id`),
  KEY `fk_orderitem_status` (`status`),
  CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_orderitem_status` FOREIGN KEY (`status`) REFERENCES `order_item_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` VALUES (1,1,'uu',NULL,1000.00,11,1,'IRT',90,1,'2019-07-21 17:41:41',NULL,NULL,0.00),(2,2,'بشقاب قرمز','234',4000.00,1,1,'IRT',500,1,'2019-07-21 16:47:23',NULL,NULL,0.00);
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item_status`
--

DROP TABLE IF EXISTS `order_item_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  `cancel` tinyint(1) NOT NULL DEFAULT '0',
  `sort` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item_status`
--

LOCK TABLES `order_item_status` WRITE;
/*!40000 ALTER TABLE `order_item_status` DISABLE KEYS */;
INSERT INTO `order_item_status` VALUES (1,'در انتظار پرداخت','EF9729',0,1),(2,'پردازش اولیه','73F178',0,2),(3,' واحد ارسال','73B4F1',0,3),(4,'بسته بندی شده','D5EC52',0,4),(5,'ارسال شده','2F54FF',0,5),(6,'کنسل شده','C5BABA',1,6),(7,'عدم موجودی','E42A2A',1,7),(8,'برگشت خورده','C5BABA',0,8),(9,'هدیه','C5BABA',1,8),(10,'ارسال نمونه','C5BABA',1,8);
/*!40000 ALTER TABLE `order_item_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `color` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` VALUES (1,'در انتظار پرداخت','EF9729'),(2,'پرداخت کامل','73F178'),(3,'پرداخت ناقص','73B4F1'),(4,'آماده ارسال','286090'),(5,'ارسال شده','EC52B6'),(6,'آرشیو','A0A0A0'),(7,'پیش فاکتور','ffc107'),(8,'',NULL);
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `code` varchar(7) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `status` int(10) unsigned NOT NULL,
  `address_id` bigint(20) unsigned DEFAULT NULL,
  `post_plan_id` int(10) unsigned NOT NULL DEFAULT '1',
  `pkg_price` decimal(10,2) unsigned NOT NULL,
  `shipment_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `info` varchar(1000) DEFAULT NULL,
  `address_detail` text,
  `address_name` varchar(255) DEFAULT NULL,
  `address_number` varchar(20) DEFAULT NULL,
  `address_city` int(10) unsigned DEFAULT NULL,
  `address_postalcode` varchar(20) DEFAULT NULL,
  `pkg_cost` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `shipment_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_wholesale` tinyint(4) DEFAULT '0',
  `extra_price1` decimal(10,2) DEFAULT '0.00',
  `extra_price2` decimal(10,2) DEFAULT '0.00',
  `extra_price3` decimal(10,2) DEFAULT '0.00',
  `extra_price1_title` varchar(45) DEFAULT NULL,
  `extra_price2_title` varchar(45) DEFAULT NULL,
  `extra_price3_title` varchar(45) DEFAULT NULL,
  `pkg_price_title` varchar(45) DEFAULT NULL,
  `shipment_price_title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_user_user_idx` (`user_id`),
  KEY `fk_orders_status` (`status`),
  CONSTRAINT `fk_orders_user_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'513389','2019-07-21 16:33:42',0.00,0,1,1,NULL,1,0.00,0.00,NULL,NULL,NULL,NULL,NULL,NULL,0.00,0.00,0,0.00,0.00,0.00,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `base` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `wholesale_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `purchase_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `currency` varchar(3) DEFAULT '1',
  `url` varchar(1024) DEFAULT NULL,
  `old_price` decimal(10,2) unsigned DEFAULT NULL,
  `imgs` tinyint(4) DEFAULT '0',
  `v_color` varchar(45) DEFAULT NULL,
  `v_size` varchar(45) DEFAULT NULL,
  `v_length` varchar(45) DEFAULT NULL,
  `rnd` varchar(5) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `hidden` tinyint(4) NOT NULL DEFAULT '0',
  `info` text,
  `sort` int(11) NOT NULL DEFAULT '0',
  `rndurl` varchar(6) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `seodesc` varchar(200) DEFAULT NULL,
  `weight` int(11) DEFAULT '0',
  `stock` int(11) DEFAULT '1',
  `view_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `box_qty` int(11) DEFAULT NULL,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `opening_diameter` decimal(10,2) DEFAULT NULL,
  `box_color` varchar(45) DEFAULT NULL,
  `body_cover` varchar(45) DEFAULT NULL,
  `body_type` varchar(45) DEFAULT NULL,
  `usecase` varchar(45) DEFAULT NULL,
  `suitable_for` varchar(45) DEFAULT NULL,
  `care_tip` varchar(45) DEFAULT NULL,
  `produced_in` varchar(45) DEFAULT NULL,
  `production_status` varchar(45) DEFAULT NULL,
  `is_wholesale` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_product_base_idx` (`base`),
  CONSTRAINT `fk_product_base` FOREIGN KEY (`base`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,NULL,'چراغ های دانلایت LED',2000.00,0.00,0.00,'1','چراغ-های-دانلایت-LED',0.00,1,NULL,NULL,NULL,'u0zo',NULL,0,NULL,0,'ieU','AL- TDQ193WS – 15',1,'',500,1,2,'2019-07-15 18:32:42','2019-07-21 17:47:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'IN_PRODUCTION',0),(2,NULL,'بشقاب قرمز',4000.00,0.00,0.00,'1','بشقاب-قرمز',0.00,1,NULL,NULL,NULL,'u0zo',NULL,0,NULL,0,'tyu','234',1,'',500,1,2,'2019-07-15 18:32:42','2019-07-21 17:47:10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'IN_PRODUCTION',0);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `product_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `point` int(10) unsigned DEFAULT '0',
  `user_group_id` int(10) unsigned DEFAULT '1',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `tel` varchar(45) DEFAULT NULL,
  `cardno` varchar(16) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `staff` tinyint(1) DEFAULT '0',
  `pass` binary(60) DEFAULT NULL,
  `pin` varchar(10) DEFAULT NULL,
  `telegram_id` varchar(15) DEFAULT NULL,
  `info` text,
  `guest` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `rnd_img` varchar(8) DEFAULT NULL,
  `known_as` varchar(1024) DEFAULT NULL,
  `company` varchar(1024) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `tel_UNIQUE` (`tel`),
  KEY `fk_user_usergroup_idx` (`user_group_id`),
  CONSTRAINT `fk_user_user_group` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57743 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'علیرضا','ظرافتی',NULL,0,6,'2015-11-12 09:56:58',NULL,NULL,1,NULL,_binary '$2y$10$iz3QkeGksg3PnApc74ATXuwd3U1KcSij7qc2mSXiCbQyOuFsgK2IW',NULL,NULL,NULL,NULL,'2019-07-21 20:41:18','MALE','r4TowJSA',NULL,NULL,'1987-01-05');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'مشتریان'),(5,'خریداران عمده'),(6,'مدیران');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_permissions`
--

DROP TABLE IF EXISTS `user_group_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group_permissions` (
  `user_group_id` int(10) unsigned NOT NULL,
  `permission` varchar(255) NOT NULL,
  PRIMARY KEY (`user_group_id`,`permission`),
  KEY `fk_user_group_permissions_group_idx` (`user_group_id`),
  CONSTRAINT `fk_user_group_permissions_group` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_permissions`
--

LOCK TABLES `user_group_permissions` WRITE;
/*!40000 ALTER TABLE `user_group_permissions` DISABLE KEYS */;
INSERT INTO `user_group_permissions` VALUES (1,'ADMIN_DASHBOARD'),(6,'ADMIN_DASHBOARD');
/*!40000 ALTER TABLE `user_group_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_session`
--

DROP TABLE IF EXISTS `user_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_session` (
  `cookie` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `cookie_UNIQUE` (`cookie`),
  KEY `fk_user_session_user_idx` (`user_id`),
  CONSTRAINT `fk_user_session_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_session`
--

LOCK TABLES `user_session` WRITE;
/*!40000 ALTER TABLE `user_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-21 20:41:37
