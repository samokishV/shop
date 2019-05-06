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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) NOT NULL,
  `preview` varchar(45) NOT NULL,
  `original` varchar(45) NOT NULL,
  `slug` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Plants','1.jpg','1.jpg','plants'),(2,'Test category','1.jpg','1.jpg','test-cat-1'),(3,'Test category 2','1.jpg','1.jpg','test-cat-2'),(4,'Test category 3','1.jpg','1.jpg','test-cat-3'),(5,'Test category 4','1.jpg','1.jpg','test-cat-4'),(6,'Test category 5','1.jpg','1.jpg','test-cat-5');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `processed` tinyint(1) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_1_idx` (`user_id`),
  CONSTRAINT `fk_orders_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_category_1_idx` (`product_id`),
  KEY `fk_product_category_2` (`category_id`),
  CONSTRAINT `fk_product_category_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_product_category_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_category`
--

LOCK TABLES `product_category` WRITE;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` VALUES (1,1,1),(2,1,2),(3,1,3),(4,2,4),(5,2,5),(6,2,6),(7,3,7),(8,3,8),(9,3,9);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;
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
  `preview` varchar(45) NOT NULL,
  `original` varchar(45) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
INSERT INTO `products` VALUES (1,'Title','Description',450,10,'test-product','1.jpg','1.jpg','2019-05-03 15:21:19','2019-05-03 15:21:19',NULL,NULL),(2,'Product 2','Some description',550,0,'test-product-2','1.jpg','1.jpg','2019-05-03 15:21:19','2019-05-03 15:21:19',NULL,NULL),(3,'Product 3','Some description',1050,0,'test-product-3','1.jpg','1.jpg','2019-05-03 15:21:19','2019-05-03 15:21:19',NULL,NULL),(4,'Title','Description',450,100,'test-product-4','1.jpg','1.jpg','2019-05-03 17:53:16','2019-05-03 17:53:16',NULL,'{\"height\": 50, \"weight\": \"115 pounds\"}'),(5,'Promo 1','description',152,10,'promo-1','1.jpg','1.jpg','2019-05-06 12:05:49','2019-05-06 12:05:49',1,NULL),(6,'Promo 2','description',252,10,'promo-2','1.jpg','1.jpg','2019-05-06 12:05:49','2019-05-06 12:05:49',1,NULL),(7,'Promo 3','description',152,12,'promo-3','1.jpg','1.jpg','2019-05-06 12:05:49','2019-05-06 12:05:49',1,NULL),(8,'Promo 4','description',152,23,'promo-4','1.jpg','1.jpg','2019-05-06 12:05:49','2019-05-06 12:05:49',1,NULL),(9,'Promo 5','description',152,44,'promo-5','1.jpg','1.jpg','2019-05-06 12:05:49','2019-05-06 12:05:49',1,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_orders`
--

DROP TABLE IF EXISTS `products_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `qt` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_id` (`orders_id`),
  KEY `plants_id` (`products_id`),
  CONSTRAINT `products_orders_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `products_orders_ibfk_2` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_orders`
--

LOCK TABLES `products_orders` WRITE;
/*!40000 ALTER TABLE `products_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `products_orders` ENABLE KEYS */;
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
  `password` varchar(45) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2019-05-06 19:45:20
