-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: phpos
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

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
-- Table structure for table `CustomerCategory`
--

DROP TABLE IF EXISTS `CustomerCategory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CustomerCategory` (
  `categoryid` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modby` int(11) DEFAULT NULL,
  `link` int(11) DEFAULT NULL,
  `discount` decimal(3,3) DEFAULT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Allows customer groupings for product pricing options';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CustomerCategory`
--

LOCK TABLES `CustomerCategory` WRITE;
/*!40000 ALTER TABLE `CustomerCategory` DISABLE KEYS */;
/*!40000 ALTER TABLE `CustomerCategory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CustomerInfo`
--

DROP TABLE IF EXISTS `CustomerInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CustomerInfo` (
  `custno` varchar(15) NOT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `mi` varchar(45) DEFAULT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zip` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `contact` varchar(45) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `phone2` varchar(15) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `email2` varchar(45) DEFAULT NULL,
  `mailings` tinyint(4) DEFAULT NULL,
  `privacy` tinyint(4) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `link` varchar(15) DEFAULT NULL,
  `locale` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modby` int(11) DEFAULT NULL,
  PRIMARY KEY (`custno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CustomerInfo`
--

LOCK TABLES `CustomerInfo` WRITE;
/*!40000 ALTER TABLE `CustomerInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `CustomerInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductsInfo`
--

DROP TABLE IF EXISTS `ProductsInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductsInfo` (
  `upc` varchar(15) NOT NULL,
  `code` varchar(25) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `case` int(11) DEFAULT NULL,
  `unit` varchar(45) DEFAULT NULL,
  `vendor` int(11) DEFAULT NULL,
  `vendoralt` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `category2` int(11) DEFAULT NULL,
  `category3` int(11) DEFAULT NULL,
  `category4` int(11) DEFAULT NULL,
  `label1` varchar(15) DEFAULT NULL,
  `label2` varchar(15) DEFAULT NULL,
  `label3` varchar(15) DEFAULT NULL,
  `label4` varchar(15) DEFAULT NULL,
  `variety` varchar(25) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modby` int(11) DEFAULT NULL,
  `active` bit(1) DEFAULT NULL,
  PRIMARY KEY (`upc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductsInfo`
--

LOCK TABLES `ProductsInfo` WRITE;
/*!40000 ALTER TABLE `ProductsInfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductsInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductsPricing`
--

DROP TABLE IF EXISTS `ProductsPricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProductsPricing` (
  `upc` varchar(15) NOT NULL,
  `cost` decimal(10,3) DEFAULT NULL,
  `retail` decimal(10,2) DEFAULT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `groupretail` decimal(10,2) DEFAULT NULL,
  `varietygroup` varchar(45) DEFAULT NULL,
  `startdate` datetime DEFAULT NULL,
  `enddate` datetime DEFAULT NULL,
  `tax` decimal(2,2) DEFAULT NULL,
  `foodstamp` bit(1) DEFAULT NULL,
  `customercategory` int(11) DEFAULT NULL,
  `itemlink` varchar(15) DEFAULT NULL,
  `target_margin` varchar(45) DEFAULT NULL,
  `weighed` bit(1) DEFAULT NULL,
  `tare` decimal(10,3) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modby` int(11) DEFAULT NULL,
  `active` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductsPricing`
--

LOCK TABLES `ProductsPricing` WRITE;
/*!40000 ALTER TABLE `ProductsPricing` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductsPricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenderdetail`
--

DROP TABLE IF EXISTS `tenderdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tenderdetail` (
  `id` int(11) DEFAULT NULL,
  `registerid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `transid` int(11) DEFAULT NULL,
  `tenderid` int(11) DEFAULT NULL,
  `tenderamount` decimal(10,2) DEFAULT NULL,
  `taxtotal` decimal(10,2) DEFAULT NULL,
  `fstotal` decimal(10,2) DEFAULT NULL,
  `transtotal` decimal(10,2) DEFAULT NULL,
  `customercategory` int(11) DEFAULT NULL,
  `custdisctype` int(11) DEFAULT NULL,
  `newtranstotal` decimal(10,2) DEFAULT NULL,
  `authid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenderdetail`
--

LOCK TABLES `tenderdetail` WRITE;
/*!40000 ALTER TABLE `tenderdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tenderdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transdetail`
--

DROP TABLE IF EXISTS `transdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transdetail` (
  `id` int(11) DEFAULT NULL,
  `registerid` int(11) DEFAULT NULL,
  `employeeid` int(11) DEFAULT NULL,
  `lineid` int(11) DEFAULT NULL,
  `transid` int(11) DEFAULT NULL,
  `upc` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `description` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `cost` decimal(10,3) DEFAULT NULL,
  `totalcharge` decimal(10,2) DEFAULT NULL,
  `tax` decimal(5,5) DEFAULT NULL,
  `fs` bit(1) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `customercategory` int(11) DEFAULT NULL,
  `customerdiscount` decimal(5,5) DEFAULT NULL,
  `discount` decimal(5,5) DEFAULT NULL,
  `tare` decimal(5,5) DEFAULT NULL,
  `regularretail` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transdetail`
--

LOCK TABLES `transdetail` WRITE;
/*!40000 ALTER TABLE `transdetail` DISABLE KEYS */;
/*!40000 ALTER TABLE `transdetail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-03 20:50:43
