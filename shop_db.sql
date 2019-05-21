-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: shop_db
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qt` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cart_1_idx` (`user_id`),
  CONSTRAINT `fk_cart_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (6,1,5,8,'2019-05-08 16:12:12','2019-05-10 17:19:05'),(7,1,6,10,'2019-05-08 16:12:15','2019-05-10 16:34:57'),(11,12,6,1,'2019-05-15 10:12:35','2019-05-15 10:12:35'),(12,12,5,2,'2019-05-15 10:12:38','2019-05-15 10:12:38');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `preview` varchar(100) DEFAULT NULL,
  `original_img` varchar(100) DEFAULT NULL,
  `slug` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Plants','img/small_ef784paxjy80cc4w808kk0w4o400oow.jpg','img/Sq1RfAgeoBlC5nFqavAJGE89Bw1OXoOLdhB9rKkk.jpeg','plants',NULL,NULL),(2,'Test category','img/small_mn7hi4kvfjks04wko0ccsww04c4wgks.jpg','img/C6iw8PW0qIPQhZQyrxpsCqOFAVeIajALhkaK381W.jpeg','test-cat-1',NULL,NULL),(3,'Test category 2','img/small_kzqu9dvwu68wcogg8cg4soggsskc8oo.jpg','img/OR0yO0plssYA8fD4dKH1pCVBtREa8gKpDOjPwo91.jpeg','test-cat-2',NULL,NULL),(18,'New category','img/small_95uh54scadk4gcg8wcckswckw88coww.jpg','img/vEL23U4QFtxGq4xWqRiCxTedxcdHEFAgfOawkBHu.jpeg','new-new-2','2019-05-15 15:49:31','2019-05-15 15:49:31'),(21,'1','img/small_cf6ys1rh568ssw4sgk4kk8ckkkc80w4.jpg','img/9FPZKlTAu4gtGoHxHgn34CPv9kDlKvIWGGSHpBAj.jpeg','1','2019-05-16 11:31:55','2019-05-16 11:31:55'),(29,'ddd','img/small_2k2gksm71duscc4koks4kcsgk8o4c84.jpg','img/Ajc7coWnTjALj1vtfzZwxc4uIS4StWpZjOvPoMtD.jpeg','dfdsf','2019-05-16 13:36:40','2019-05-16 13:36:40');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_05_21_101244_create_social_twitter_accounts_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total` int(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_1_idx` (`user_id`),
  CONSTRAINT `fk_orders_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (56,7,556,'1','1',1,'1','assa@mdasd.ru','2019-05-13 17:39:49','2019-05-15 10:53:06'),(57,7,456,'1','1',1,'1','assa@mdasd.ru','2019-05-13 17:40:11','2019-05-16 15:53:06'),(58,7,152,'1','1',1,'1','assa@mdasd.ru','2019-05-14 07:46:38','2019-05-16 13:37:30'),(59,7,152,'1','1',0,'1','assa@mdasd.ru','2019-05-14 10:23:20','2019-05-15 10:53:39'),(97,7,152,'1','1',1,'1','assa@mdasd.ru','2019-05-14 11:03:15','2019-05-15 10:53:33'),(98,7,152,'1','1',0,'1','assa@mdasd.ru','2019-05-14 11:05:07','2019-05-16 13:37:30'),(99,12,456,'1','1',1,'1','assa@mdasd.ru','2019-05-15 09:30:54','2019-05-15 10:53:33'),(100,7,6156,'4545454','gddfdf',0,'namje','name@mail.ru','2019-05-20 12:25:36','2019-05-20 12:25:36'),(101,7,908,'2312413324','sdfdsfdggs',0,'dasd','samokish.viktoria@gmail.com','2019-05-20 12:35:46','2019-05-20 12:35:46'),(102,7,1302,'4232352352','dsgdfsgdfs',1,'fdgg','samokish.viktoria@gmail.com','2019-05-20 12:36:50','2019-05-20 12:39:43'),(103,7,1260,'+380984363000','dsfdf',0,'fdg','samokish.viktoria@gmail.com','2019-05-20 12:46:25','2019-05-20 12:46:25'),(104,7,152,'0984363000','fdsf',1,'dfsd','samokish.viktoria@gmail.com','2019-05-20 12:47:01','2019-05-20 12:47:38'),(105,7,152,'+380984363000','asdsd',0,'Name','samokish.viktoria@gmail.com','2019-05-20 12:52:34','2019-05-20 12:52:34');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `price` int(6) NOT NULL DEFAULT '0',
  `in_stock` int(6) NOT NULL DEFAULT '0',
  `slug` varchar(45) NOT NULL,
  `preview` varchar(100) NOT NULL,
  `original_img` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `promo` tinyint(1) DEFAULT NULL,
  `additional` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Title','Description',450,68,'test-product','img/small_n1m2dakv9a8wo4gskwco0wko4w0ckg8.jpg','img/KANZLT22VbvhI5gtxaBhxCNkix7PlARmTMcSa38Y.jpeg','2019-05-03 15:21:19','2019-05-20 12:25:36',1,NULL),(2,'Product 2','Some description',550,20,'test-product-2','img/small_30gsznszjy68o4s88w84wg4c448g4k8.jpg','img/W1fAcTirV05UE1jGD4ngPvqUoJCPhWH5tPIvDWGs.jpeg','2019-05-03 15:21:19','2019-05-16 16:23:42',0,NULL),(3,'Product 3','Some description',1050,23,'test-product-3','img/small_l6cm1s1p91s8wss0ck0sk44k84ko4ks.jpg','img/cjusRiBtddFEzmkgEM5ZnmFrAd3pud0W4qNMoWCv.jpeg','2019-05-03 15:21:19','2019-05-20 12:36:50',1,NULL),(4,'Title','Description',450,99,'test-product-4','img/small_qi3ezugmzjks84kwo8c4o0s4g8ocg0g.jpg','img/9kWgo2WGFbtXTiKf3nr1b0lk61DzZWVIS4Znb7rl.jpeg','2019-05-03 17:53:16','2019-05-16 16:27:30',0,'{\"height\": \"50\", \"weight\": \"115\"}'),(5,'Promo 1','description',120,18,'promo-1','img/small_qgc8ej16cw04kk4w0owc4g8kkggo8gk.jpg','img/UQYljPE9UUluNps9lR1Ia3zTBZyxulT7zeAkE4ZI.jpeg','2019-05-06 12:05:49','2019-05-16 16:23:43',0,NULL),(6,'Promo 2','description',252,48,'promo-2','img/small_g2s5wboko9skscwgo0o8wk00cg8ggg8.jpg','img/9I1b0Ddk6fpt0PUiZNl3CLdepjMj6ReVksgJGBeZ.jpeg','2019-05-06 12:05:49','2019-05-20 12:46:25',1,NULL),(7,'Promo 3','description',152,89,'promo-3','img/small_agmd8ietsaw4okogow84gsogwssg0c4.jpg','img/ILG4mhHENtGfWog1OOvVESIKyNspD7potC1wP1oV.jpeg','2019-05-06 12:05:49','2019-05-20 12:52:34',1,NULL),(8,'Promo 4','description',152,16,'promo-4','img/small_ogzipe9tdk0kkks8c4w84gog0wo8k0s.jpg','img/qlbyMSIk1dXoGgLKueaRmxmFVjsPeLN8oy1FlwQy.jpeg','2019-05-06 12:05:49','2019-05-16 16:23:43',0,NULL),(9,'Promo 5','description',152,28,'promo-5','img/small_phzlkm66q80wgw488o0gccw80wskosk.jpg','img/Ny60yLSCwS0IysOHSJJ44gRh5krUwoYUCTSjjMcF.jpeg','2019-05-06 12:05:49','2019-05-20 12:47:01',1,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_categories`
--

DROP TABLE IF EXISTS `products_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_products_categories_1_idx` (`category_id`),
  KEY `fk_products_categories_2` (`product_id`),
  CONSTRAINT `fk_products_categories_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_products_categories_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_categories`
--

LOCK TABLES `products_categories` WRITE;
/*!40000 ALTER TABLE `products_categories` DISABLE KEYS */;
INSERT INTO `products_categories` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,1,3,NULL,NULL),(4,2,4,NULL,NULL),(5,2,5,NULL,NULL),(6,2,6,NULL,NULL),(7,3,7,NULL,NULL),(8,3,8,NULL,NULL),(9,3,9,NULL,NULL);
/*!40000 ALTER TABLE `products_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_orders`
--

DROP TABLE IF EXISTS `products_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qt` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_id` (`order_id`),
  KEY `plants_id` (`product_id`),
  CONSTRAINT `products_orders_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_orders`
--

LOCK TABLES `products_orders` WRITE;
/*!40000 ALTER TABLE `products_orders` DISABLE KEYS */;
INSERT INTO `products_orders` VALUES (1,56,5,1,152,'2019-05-13 17:39:49','2019-05-13 17:39:49'),(2,56,6,1,252,'2019-05-13 17:39:49','2019-05-13 17:39:49'),(3,56,7,1,152,'2019-05-13 17:39:49','2019-05-13 17:39:49'),(4,57,8,3,456,'2019-05-13 17:40:11','2019-05-13 17:40:11'),(5,58,9,1,152,'2019-05-14 07:46:38','2019-05-14 07:46:38'),(6,59,9,1,152,'2019-05-14 10:23:20','2019-05-14 10:23:20'),(7,97,8,1,152,'2019-05-14 11:03:15','2019-05-14 11:03:15'),(8,98,9,1,152,'2019-05-14 11:05:07','2019-05-14 11:05:07'),(9,99,9,1,152,'2019-05-15 09:30:54','2019-05-15 09:30:54'),(10,99,8,1,152,'2019-05-15 09:30:54','2019-05-15 09:30:54'),(11,99,7,1,152,'2019-05-15 09:30:54','2019-05-15 09:30:54'),(12,100,1,12,5400,'2019-05-20 12:25:36','2019-05-20 12:25:36'),(13,100,6,3,756,'2019-05-20 12:25:36','2019-05-20 12:25:36'),(14,101,9,1,152,'2019-05-20 12:35:46','2019-05-20 12:35:46'),(15,101,6,3,756,'2019-05-20 12:35:46','2019-05-20 12:35:46'),(16,102,6,1,252,'2019-05-20 12:36:50','2019-05-20 12:36:50'),(17,102,3,1,1050,'2019-05-20 12:36:50','2019-05-20 12:36:50'),(18,103,6,5,1260,'2019-05-20 12:46:25','2019-05-20 12:46:25'),(19,104,9,1,152,'2019-05-20 12:47:01','2019-05-20 12:47:01'),(20,105,7,1,152,'2019-05-20 12:52:34','2019-05-20 12:52:34');
/*!40000 ALTER TABLE `products_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_facebook_accounts`
--

DROP TABLE IF EXISTS `social_facebook_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_facebook_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider_user_id` varchar(100) DEFAULT NULL,
  `provider` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_facebook_accounts`
--

LOCK TABLES `social_facebook_accounts` WRITE;
/*!40000 ALTER TABLE `social_facebook_accounts` DISABLE KEYS */;
INSERT INTO `social_facebook_accounts` VALUES (1,7,'396856127568419','facebook','2019-05-21 05:35:34','2019-05-21 05:35:34');
/*!40000 ALTER TABLE `social_facebook_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_twitter_accounts`
--

DROP TABLE IF EXISTS `social_twitter_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_twitter_accounts` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_twitter_accounts`
--

LOCK TABLES `social_twitter_accounts` WRITE;
/*!40000 ALTER TABLE `social_twitter_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_twitter_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'sidorenko@gmail.com','$2y$10$7ChewzYPE61.qlrBDuwYx.nC8KzUJrykcRKEnLPEWRLMGJv8.hUeS','user','2019-05-07 14:47:57','2019-05-07 14:47:57','jALtVDfUJL5g8M8QIF6AHkzzxCpoEKt3N9RZMjy1L52zxf5S7B5WUS7n4gMB'),(7,'samokish.viktoria@gmail.com','$2y$10$8RKlVW1qc5eqUrjfS8m6ZOFe8l7Gi0J.QSrACJE1ucSlmkKYdtrOC','manager','2019-05-10 08:38:14','2019-05-15 09:30:12','xrDnGbXTQRY6E6C4Lz95Tetu5UVanRsJfAKC7fH7uYdoSktzdVRideajhjGt'),(12,'test2@mail.ru','$2y$10$8ILq00ly/UJznDD7Vtu8MOs.nKmvQBTFdRlHnadtmidDH3AIlpIQ.','admin','2019-05-14 15:57:51','2019-05-14 16:09:02',NULL),(13,'test@mail.ru','$2y$10$Of6KwZfLoBQVH5vm5FWdkuLlMe/dVfpnY73P.u0bm8R4hNhXBxWSK','user','2019-05-14 16:08:31','2019-05-14 16:08:31',NULL);
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

-- Dump completed on 2019-05-21 20:29:40
