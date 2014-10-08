-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `art_db`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `salt` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `datecreate` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = no confirm , 1 = confirm',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- dump ตาราง `member`
--

INSERT INTO `member` (`id`, `name`, `email`, `salt`, `password`, `address`, `datecreate`, `status`) VALUES
(8, 'xxxxxxxxxxxxxxxxx', 'netticon17@gmail.com', '84F6270CE9D5AB31', '68d51f06015b7ba1af86d6349db11ab71bfa5d49847116484305914c65ff95ad', 'vvcvcvcvcv', '2014-10-01 15:26:31', 1),
(9, 'เน็ทคลับ', 'n@gmail.com', '39E5AD7F10C642B8', '1cf81df3c559e40a6f6e3d8c504194b050f821e106a0d69a97f918172a6eca90', '88/744', '2014-10-06 10:34:27', 1);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` int(5) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `OrderDate` datetime NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(500) NOT NULL,
  `Tel` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  PRIMARY KEY (`OrderID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- dump ตาราง `orders`
--

INSERT INTO `orders` (`OrderID`, `OrderDate`, `Name`, `Address`, `Tel`, `Email`) VALUES
(00001, '2014-10-06 10:10:25', 'xxxxxxxxxxxxxxxxx', '58/779', '', 'netticon17@gmail.com'),
(00002, '2014-10-06 10:13:16', 'xxxxxxxxxxxxxxxxx', '77/889', '', 'netticon17@gmail.com'),
(00003, '2014-10-06 10:15:36', 'xxxxxxxxxxxxxxxxx', 'vvcvcvcvcv', '', 'netticon17@gmail.com'),
(00004, '2014-10-06 10:16:15', 'netkung', '88/774', '', 'netticon17@gmail.com'),
(00005, '2014-10-06 10:20:17', 'เน็ทคุง', '88/796', '', 'netticon17@gmail.com'),
(00006, '2014-10-06 10:23:53', 'xxxxxxxxxxxxxxxxx', 'vvcvcvcvcv', '', 'netticon17@gmail.com'),
(00007, '2014-10-06 10:35:44', 'xxxxxxxxxxxxxxxxx', 'vvcvcvcvcv', '', 'netticon17@gmail.com'),
(00008, '2014-10-06 10:36:56', 'เน็ทคลับ', '88/744', '', 'n@gmail.com');

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `orders_detail`
--

CREATE TABLE IF NOT EXISTS `orders_detail` (
  `DetailID` int(5) NOT NULL AUTO_INCREMENT,
  `OrderID` int(5) unsigned zerofill NOT NULL,
  `ProductID` int(4) NOT NULL,
  `Qty` int(3) NOT NULL,
  PRIMARY KEY (`DetailID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- dump ตาราง `orders_detail`
--

INSERT INTO `orders_detail` (`DetailID`, `OrderID`, `ProductID`, `Qty`) VALUES
(1, 00001, 2, 1),
(2, 00001, 3, 1),
(3, 00001, 1, 1),
(4, 00002, 4, 1),
(5, 00002, 1, 1),
(6, 00002, 2, 2),
(7, 00002, 3, 1),
(8, 00003, 1, 3),
(9, 00003, 4, 1),
(10, 00005, 1, 1),
(11, 00005, 2, 2),
(12, 00005, 4, 1),
(13, 00005, 3, 1),
(14, 00006, 2, 1),
(15, 00006, 3, 2),
(16, 00006, 4, 1),
(17, 00007, 1, 1),
(18, 00007, 2, 1),
(19, 00007, 3, 1),
(20, 00007, 4, 2);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `ProductID` int(4) NOT NULL AUTO_INCREMENT,
  `ProductName` varchar(100) NOT NULL,
  `Price` double NOT NULL,
  `Picture` varchar(100) NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- dump ตาราง `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Price`, `Picture`) VALUES
(1, 'Product 1', 100, '1.jpg'),
(2, 'Product 2', 200, '2.jpg'),
(3, 'Product 3', 300, '3.jpg'),
(4, 'Product 4', 400, '4.jpg');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
