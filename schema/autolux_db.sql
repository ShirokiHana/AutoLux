-- MySQL dump 10.13  Distrib 26.7.0, for macos26.6 (arm64)
--
-- Host: 127.0.0.1    Database: autolux_db
-- ------------------------------------------------------
-- Server version	26.7.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients` (
  `client_id` int unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `clients_pk` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` (`client_id`, `client_name`, `email`, `phone`, `created_at`) VALUES (1,'Surume','gent.three@example.com','122271312','2026-09-17 21:16:35'),(2,'Dj Octavio','dj.octavio@example.com','122209119','2026-09-17 21:16:35'),(3,'Shiver','inkopolis.support@example.com','124226412','2026-09-17 21:16:35'),(4,'Harmony','harmony.shop@example.com','122883412','2026-09-17 21:16:35'),(5,'Ame','angel@kawaii.com','123456789','2026-09-24 23:02:30'),(6,'Frye Sparks','frye.sparks@example.com','124356789','2026-09-25 18:07:54'),(7,'Sheldon Shell','sheldon.shell@example.com','922491273','2026-09-27 22:32:32'),(8,'Callie Tide','callie.tide@example.com','978456789','2026-09-28 01:01:45'),(9,'Marie Shore','marie.shore@example.com','82773771','2026-09-29 18:17:56');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_item_id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `part_id` int unsigned NOT NULL,
  `quantity` int unsigned NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `installation_done` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_item_id`),
  UNIQUE KEY `uq_order_items_order_part` (`order_id`,`part_id`),
  KEY `idx_order_items_part` (`part_id`),
  CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_part` FOREIGN KEY (`part_id`) REFERENCES `parts` (`part_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `chk_order_items_quantity` CHECK ((`quantity` > 0)),
  CONSTRAINT `chk_order_items_unit_price` CHECK ((`unit_price` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`order_item_id`, `order_id`, `part_id`, `quantity`, `unit_price`, `installation_done`) VALUES (1,1,1,1,12.50,1),(2,1,3,1,64.99,1),(3,1,5,2,9.75,0),(4,2,2,1,18.90,1),(5,2,4,2,89.50,0),(6,2,6,1,119.99,0),(7,4,1,3,12.50,0),(8,4,5,1,9.75,0),(9,5,1,3,12.50,0),(10,5,5,1,9.75,0),(11,6,1,3,12.50,0),(12,6,5,1,9.75,0),(13,7,1,3,12.50,0),(14,7,5,1,9.75,0),(15,8,1,3,12.50,0),(16,8,5,1,9.75,0),(17,8,6,1,119.99,0),(18,9,1,5,12.50,0),(19,9,6,1,119.99,0),(20,10,1,2,12.50,0),(21,10,5,1,9.75,0),(22,10,6,1,119.99,0),(23,11,1,1,12.50,0),(24,12,1,1,12.50,0),(25,13,1,10,12.50,0),(26,14,1,4,12.50,0),(27,14,6,1,119.99,0),(28,14,5,1,9.75,0),(29,15,1,3,12.50,0),(30,16,4,2,89.50,1),(31,16,5,1,9.75,1),(32,17,1,1,12.50,0),(33,18,1,3,12.50,0),(34,19,1,4,12.50,0),(35,20,1,1,12.50,0),(36,21,1,1,12.50,0),(37,22,1,1,12.50,0),(38,23,1,1,12.50,0),(39,24,1,1,12.50,0),(40,25,8,1,24.80,0),(41,26,6,1,119.99,0),(42,27,5,1,9.75,0),(43,28,1,10,12.50,0),(44,29,1,1,12.50,1),(45,30,2,1,18.90,0),(46,31,6,2,119.99,0),(47,32,1,8,12.50,0),(48,32,17,1,13.20,0),(49,32,3,1,64.99,0),(50,33,1,3,12.50,0),(51,34,1,2,12.50,0),(52,34,24,1,69.90,0),(53,35,82,1,28.50,0),(54,36,82,1,28.50,0),(55,37,1,1,12.50,0),(56,38,87,1,35.20,0),(57,39,5,2,9.75,0),(58,39,68,1,64.99,0),(59,40,6,6,119.99,1),(60,41,63,1,209.00,0);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int unsigned NOT NULL,
  `payment_method_id` tinyint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `idx_orders_client` (`client_id`),
  KEY `idx_orders_payment_method` (`payment_method_id`),
  CONSTRAINT `fk_orders_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_orders_payment_method` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`payment_method_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`order_id`, `client_id`, `payment_method_id`, `created_at`) VALUES (1,1,2,'2026-09-17 21:20:10'),(2,2,1,'2026-09-17 21:20:10'),(3,1,2,'2026-09-27 04:34:42'),(4,1,2,'2026-09-27 04:39:52'),(5,1,2,'2026-09-27 04:40:53'),(6,1,2,'2026-09-27 04:41:09'),(7,1,2,'2026-09-27 04:41:32'),(8,1,1,'2026-09-27 04:41:55'),(9,4,3,'2026-09-27 04:53:11'),(10,3,2,'2026-09-27 04:55:17'),(11,3,2,'2026-09-27 04:57:26'),(12,1,2,'2026-09-27 04:57:56'),(13,4,2,'2026-09-27 04:58:30'),(14,1,3,'2026-09-27 04:59:31'),(15,1,2,'2026-09-27 05:00:34'),(16,7,1,'2026-09-27 22:33:20'),(17,1,2,'2026-09-27 23:46:26'),(18,1,2,'2026-09-27 23:47:18'),(19,2,2,'2026-09-28 00:54:29'),(20,8,2,'2026-09-28 01:01:51'),(21,1,2,'2026-09-28 01:07:40'),(22,1,2,'2026-09-28 01:08:58'),(23,1,2,'2026-09-28 01:14:00'),(24,1,2,'2026-09-28 01:14:53'),(25,1,2,'2026-09-28 01:17:48'),(26,4,2,'2026-09-28 01:18:19'),(27,3,1,'2026-09-28 01:19:18'),(28,1,3,'2026-09-28 01:22:50'),(29,1,2,'2026-09-28 01:23:22'),(30,1,3,'2026-09-28 01:24:10'),(31,1,1,'2026-09-28 01:33:52'),(32,9,1,'2026-09-29 18:18:18'),(33,1,1,'2026-10-06 06:00:36'),(34,2,2,'2026-10-16 07:46:47'),(35,2,2,'2026-10-16 07:52:48'),(36,2,2,'2026-10-16 07:53:07'),(37,2,2,'2026-10-16 07:54:50'),(38,2,2,'2026-10-16 07:55:27'),(39,7,2,'2026-10-16 07:57:18'),(40,4,2,'2026-10-16 07:59:45'),(41,2,3,'2026-10-24 17:29:49');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parts` (
  `part_id` int unsigned NOT NULL AUTO_INCREMENT,
  `part_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `part_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`part_id`),
  KEY `idx_autolux_parts_brand` (`brand`),
  KEY `idx_autolux_parts_type` (`part_type`),
  KEY `idx_autolux_parts_price` (`price`),
  CONSTRAINT `chk_autolux_part_price` CHECK ((`price` >= 0))
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts`
--

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` (`part_id`, `part_name`, `brand`, `part_type`, `price`, `stock_quantity`, `created_at`, `updated_at`) VALUES (1,'Oil Filter P9192','Bosch','Filter',12.50,72,'2026-09-17 21:19:54','2026-10-24 14:39:13'),(2,'Air Filter S 0334','Mann-Filter','Filter',18.90,15,'2026-09-17 21:19:54','2026-09-17 21:19:54'),(3,'Front Brake Pads','Brembo','Brakes',64.99,12,'2026-09-17 21:19:54','2026-09-17 21:19:54'),(4,'Rear Brake Discs','Brembo','Brakes',89.50,10,'2026-09-17 21:19:54','2026-10-24 14:38:51'),(5,'H7 Halogen Headlight Bulb','Philips','Lighting',9.75,38,'2026-09-17 21:19:54','2026-10-16 07:57:18'),(6,'12V Car Battery 60Ah','Varta','Battery',119.99,0,'2026-09-17 21:19:54','2026-10-16 07:59:45'),(7,'Cabin Filter R2420','Bosch','Filter',16.40,20,'2026-09-19 04:44:34','2026-09-19 04:44:34'),(8,'Fuel Filter N2045','Bosch','Filter',24.80,18,'2026-09-19 04:44:34','2026-09-19 04:44:34'),(9,'Oil Filter P 3312','Bosch','Filter',11.90,24,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(10,'Air Filter S 0442','Bosch','Filter',19.50,18,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(11,'Cabin Filter R 2510','Mann-Filter','Filter',17.80,20,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(12,'Fuel Filter WK 820','Mann-Filter','Filter',28.40,14,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(13,'Oil Filter OC 593','Mahle','Filter',10.95,30,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(14,'Air Filter LX 2045','Mahle','Filter',22.60,16,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(15,'Cabin Filter LAK 181','Mahle','Filter',24.90,12,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(16,'Fuel Filter KL 228','Mahle','Filter',31.75,10,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(17,'Oil Filter 0986AF0012','Bosch','Filter',13.20,22,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(18,'Air Filter C 35 154','Mann-Filter','Filter',25.30,15,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(19,'Cabin Filter CU 26009','Mann-Filter','Filter',21.50,17,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(20,'Oil Filter LS 923','Purflux','Filter',9.80,28,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(21,'Air Filter A1234','Purflux','Filter',18.75,19,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(22,'Cabin Filter AH 405','Purflux','Filter',16.60,21,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(23,'Fuel Filter CS 701','Purflux','Filter',26.90,13,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(24,'Front Brake Pads P 85 020','Brembo','Brakes',69.90,11,'2026-09-28 20:42:45','2026-10-16 07:46:47'),(25,'Rear Brake Pads P 85 121','Brembo','Brakes',58.50,14,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(26,'Front Brake Discs 09.A047.11','Brembo','Brakes',112.40,8,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(27,'Rear Brake Discs 08.C307.11','Brembo','Brakes',94.75,9,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(28,'Front Brake Pads GDB 1550','TRW','Brakes',62.30,15,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(29,'Rear Brake Pads GDB 1654','TRW','Brakes',54.80,16,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(30,'Front Brake Discs DF 4427','TRW','Brakes',98.60,10,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(31,'Rear Brake Discs DF 4245','TRW','Brakes',82.90,11,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(32,'Front Brake Pads 8DB 355 018','ATE','Brakes',71.20,13,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(33,'Rear Brake Pads 13.0460-2890','ATE','Brakes',60.40,14,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(34,'Front Brake Discs 24.0125-0155','ATE','Brakes',119.90,7,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(35,'Rear Brake Discs 24.0110-0352','ATE','Brakes',87.50,9,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(36,'Brake Fluid DOT 4 1L','Bosch','Brakes',14.95,25,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(37,'Brake Shoe Set GS 8210','TRW','Brakes',48.60,10,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(38,'Brake Wear Sensor GIC 501','Brembo','Brakes',19.90,18,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(39,'H4 Halogen Headlight Bulb','Philips','Lighting',8.90,35,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(40,'H1 Halogen Headlight Bulb','Philips','Lighting',7.80,38,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(41,'H7 RacingVision Bulb','Philips','Lighting',29.95,20,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(42,'W5W LED Bulb Pair','Philips','Lighting',13.50,28,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(43,'P21W Indicator Bulb','Osram','Lighting',4.90,40,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(44,'PY21W Amber Indicator Bulb','Osram','Lighting',5.40,36,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(45,'H7 Night Breaker Bulb','Osram','Lighting',31.80,18,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(46,'H4 Original Bulb','Osram','Lighting',9.50,32,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(47,'D1S Xenon Bulb','Osram','Lighting',74.90,10,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(48,'D2S Xenon Bulb','Philips','Lighting',79.50,9,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(49,'LED Number Plate Light','Bosch','Lighting',18.20,22,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(50,'Rear Light Bulb P21/5W','Bosch','Lighting',6.25,34,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(51,'Fog Light H11 Bulb','Philips','Lighting',15.60,26,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(52,'Interior LED Light Set','Osram','Lighting',22.90,16,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(53,'Side Indicator Light','Valeo','Lighting',17.40,14,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(54,'12V Car Battery 45Ah','Varta','Battery',89.99,10,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(55,'12V Car Battery 52Ah','Varta','Battery',99.99,9,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(56,'12V Car Battery 74Ah','Varta','Battery',139.99,7,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(57,'12V Car Battery 95Ah','Varta','Battery',169.99,5,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(58,'12V AGM Battery 70Ah','Varta','Battery',189.90,6,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(59,'12V EFB Battery 65Ah','Varta','Battery',154.50,7,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(60,'12V Car Battery 44Ah','Bosch','Battery',86.90,11,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(61,'12V Car Battery 60Ah','Bosch','Battery',124.90,8,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(62,'12V Car Battery 72Ah','Bosch','Battery',149.50,7,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(63,'12V AGM Battery 80Ah','Bosch','Battery',209.00,43,'2026-09-28 20:42:45','2026-10-24 17:29:50'),(64,'12V Car Battery 50Ah','Exide','Battery',92.40,10,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(65,'12V Car Battery 65Ah','Exide','Battery',132.75,8,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(66,'12V Car Battery 77Ah','Exide','Battery',158.90,6,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(67,'12V Start-Stop AGM Battery 70Ah','Exide','Battery',195.60,5,'2026-09-28 20:42:45','2026-09-28 20:42:45'),(68,'12V Motorcycle Battery 12Ah','Yuasa','Battery',64.99,11,'2026-09-28 20:42:45','2026-10-16 07:57:18'),(69,'Oil Filter HU 719/7 X','Mann-Filter','Filter',14.20,22,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(70,'Oil Filter OX 188D','Mahle','Filter',13.80,24,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(71,'Oil Filter LS 867B','Purflux','Filter',11.40,26,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(72,'Oil Filter 0 451 103 336','Bosch','Filter',12.95,20,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(73,'Air Filter C 30 005','Mann-Filter','Filter',23.40,16,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(74,'Air Filter LX 1780','Mahle','Filter',21.90,18,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(75,'Air Filter A 1158','Purflux','Filter',17.60,21,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(76,'Air Filter 1 457 433 011','Bosch','Filter',20.50,17,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(77,'Cabin Filter CU 2939','Mann-Filter','Filter',20.30,19,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(78,'Cabin Filter LA 239','Mahle','Filter',19.75,15,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(79,'Cabin Filter AH 389','Purflux','Filter',15.90,23,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(80,'Cabin Filter 1 987 432 547','Bosch','Filter',18.60,18,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(81,'Activated Carbon Cabin Filter CUK 2939','Mann-Filter','Filter',29.90,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(82,'Activated Carbon Cabin Filter LAK 239','Mahle','Filter',28.50,9,'2026-09-28 23:10:05','2026-10-16 07:53:07'),(83,'Fuel Filter WK 842/2','Mann-Filter','Filter',32.40,13,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(84,'Fuel Filter KL 169','Mahle','Filter',29.80,14,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(85,'Fuel Filter FC 702','Purflux','Filter',27.90,15,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(86,'Fuel Filter 0 450 905 273','Bosch','Filter',30.60,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(87,'Diesel Fuel Filter HDF 581','Hengst','Filter',35.20,9,'2026-09-28 23:10:05','2026-10-16 07:55:27'),(88,'Oil Filter E818H D238','Hengst','Filter',15.60,19,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(89,'Front Brake Pads P 85 146','Brembo','Brakes',74.90,11,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(90,'Rear Brake Pads P 85 154','Brembo','Brakes',61.80,13,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(91,'Front Brake Disc Set 09.B436.11','Brembo','Brakes',128.50,7,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(92,'Rear Brake Disc Set 08.A202.11','Brembo','Brakes',102.40,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(93,'Front Brake Pads GDB 1956','TRW','Brakes',66.70,14,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(94,'Rear Brake Pads GDB 2053','TRW','Brakes',57.90,15,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(95,'Front Brake Disc Set DF 7910','TRW','Brakes',107.30,9,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(96,'Rear Brake Disc Set DF 6842','TRW','Brakes',88.60,10,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(97,'Front Brake Pads 13.0470-7258','ATE','Brakes',76.20,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(98,'Rear Brake Pads 13.0460-7201','ATE','Brakes',63.50,13,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(99,'Front Brake Disc Set 24.0128-0173','ATE','Brakes',124.80,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(100,'Rear Brake Disc Set 24.0112-0186','ATE','Brakes',96.20,9,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(101,'Front Brake Pads 573070J','Textar','Brakes',68.90,14,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(102,'Rear Brake Pads 2455401','Textar','Brakes',55.60,16,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(103,'Brake Caliper Front Left','Bosch','Brakes',145.00,5,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(104,'Brake Caliper Front Right','Bosch','Brakes',145.00,5,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(105,'Brake Master Cylinder','TRW','Brakes',98.40,7,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(106,'Rear Brake Drum','Brembo','Brakes',72.90,10,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(107,'Brake Hose Front','ATE','Brakes',18.70,22,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(108,'Electronic Parking Brake Motor','TRW','Brakes',132.50,6,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(109,'H3 Halogen Fog Light Bulb','Osram','Lighting',7.20,34,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(110,'H8 Halogen Fog Light Bulb','Philips','Lighting',14.80,25,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(111,'H9 Halogen Headlight Bulb','Osram','Lighting',16.40,22,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(112,'H11 Night Breaker Bulb','Osram','Lighting',27.50,18,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(113,'HB3 Halogen Bulb','Philips','Lighting',13.90,23,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(114,'HB4 Halogen Bulb','Philips','Lighting',14.20,21,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(115,'D3S Xenon Bulb','Osram','Lighting',84.90,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(116,'D4S Xenon Bulb','Philips','Lighting',82.50,9,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(117,'W21W Signal Bulb','Osram','Lighting',6.80,35,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(118,'R5W Rear Light Bulb','Philips','Lighting',4.60,40,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(119,'C5W Festoon Interior Bulb','Bosch','Lighting',3.95,45,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(120,'T10 LED Bulb Pair','Osram','Lighting',12.90,28,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(121,'H7 LED Retrofit Bulb Set','Philips','Lighting',119.90,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(122,'H4 LED Retrofit Bulb Set','Osram','Lighting',109.50,9,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(123,'LED Daytime Running Light','Valeo','Lighting',48.70,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(124,'Front Fog Light Assembly Left','Valeo','Lighting',76.30,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(125,'Front Fog Light Assembly Right','Valeo','Lighting',76.30,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(126,'Rear Tail Light Assembly Left','Magneti Marelli','Lighting',138.90,6,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(127,'Rear Tail Light Assembly Right','Magneti Marelli','Lighting',138.90,6,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(128,'LED Work Light 12V','Bosch','Lighting',44.50,11,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(129,'12V Car Battery 40Ah','Varta','Battery',82.90,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(130,'12V Car Battery 55Ah','Varta','Battery',108.90,10,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(131,'12V Car Battery 80Ah','Varta','Battery',151.50,7,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(132,'12V Car Battery 100Ah','Varta','Battery',178.90,5,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(133,'12V Start-Stop AGM Battery 95Ah','Varta','Battery',239.90,4,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(134,'12V Car Battery 36Ah','Bosch','Battery',78.50,13,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(135,'12V Car Battery 55Ah','Bosch','Battery',109.90,10,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(136,'12V Car Battery 70Ah','Bosch','Battery',142.90,8,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(137,'12V Car Battery 90Ah','Bosch','Battery',174.50,5,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(138,'12V EFB Battery 75Ah','Bosch','Battery',179.90,6,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(139,'12V Car Battery 40Ah','Exide','Battery',80.40,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(140,'12V Car Battery 55Ah','Exide','Battery',111.60,9,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(141,'12V Car Battery 80Ah','Exide','Battery',162.90,6,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(142,'12V AGM Battery 95Ah','Exide','Battery',229.50,4,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(143,'12V Motorcycle Battery 9Ah','Yuasa','Battery',52.90,15,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(144,'12V Motorcycle Battery 14Ah','Yuasa','Battery',72.40,12,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(145,'12V Motorcycle Battery 18Ah','Yuasa','Battery',89.90,10,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(146,'12V Leisure Battery 75Ah','Varta','Battery',168.50,6,'2026-09-28 23:10:05','2026-09-28 23:10:05'),(147,'12V Leisure Battery 100Ah','Exide','Battery',214.90,7,'2026-09-28 23:10:05','2026-10-12 06:43:54'),(148,'12V Auxiliary Battery 12Ah','Bosch','Battery',58.30,14,'2026-09-28 23:10:05','2026-09-28 23:10:05');
/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `payment_method_id` tinyint unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`payment_method_id`),
  UNIQUE KEY `uq_payment_methods_name` (`method_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` (`payment_method_id`, `method_name`) VALUES (2,'MasterCard'),(3,'MBWay'),(1,'VISA');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_order_sync`
--

DROP TABLE IF EXISTS `supplier_order_sync`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_order_sync` (
  `node_order_id` int NOT NULL,
  `stock_applied_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_synced_at` datetime DEFAULT NULL,
  `sync_error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`node_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_order_sync`
--

LOCK TABLES `supplier_order_sync` WRITE;
/*!40000 ALTER TABLE `supplier_order_sync` DISABLE KEYS */;
INSERT INTO `supplier_order_sync` (`node_order_id`, `stock_applied_at`, `status_synced_at`, `sync_error`) VALUES (75,'2026-10-23 14:15:09',NULL,NULL),(76,'2026-10-23 14:15:18',NULL,NULL),(77,'2026-10-23 14:15:23',NULL,NULL),(78,'2026-10-23 15:12:55',NULL,'<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"utf-8\">\n<title>Error</title>\n</head>\n<body>\n<pre>Cannot PATCH /order/78/status</pre>\n</body>\n</html>'),(79,'2026-10-23 15:13:59',NULL,'<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"utf-8\">\n<title>Error</title>\n</head>\n<body>\n<pre>Cannot PATCH /order/79/status</pre>\n</body>\n</html>'),(80,'2026-10-23 15:14:44','2026-10-23 15:14:44',NULL),(81,'2026-10-23 16:03:50','2026-10-23 16:03:50',NULL),(82,'2026-10-23 16:04:48','2026-10-23 16:04:48',NULL),(83,'2026-10-23 16:04:51','2026-10-23 16:04:51',NULL),(84,'2026-10-24 07:16:43','2026-10-24 07:16:43',NULL),(85,'2026-10-24 07:31:20','2026-10-24 07:31:20',NULL),(86,'2026-10-24 07:31:25','2026-10-24 07:31:25',NULL),(87,'2026-10-24 15:38:51','2026-10-24 15:38:51',NULL),(88,'2026-10-24 15:39:13','2026-10-24 15:39:13',NULL),(89,'2026-10-24 18:29:50','2026-10-24 18:29:50',NULL);
/*!40000 ALTER TABLE `supplier_order_sync` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-24 18:55:08
