-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2014 at 03:31 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `juierp`
--
-- CREATE DATABASE IF NOT EXISTS `juierp` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
-- USE `juierp`;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE IF NOT EXISTS `colors` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`tableIndex`, `name`) VALUES
(1, 'কালো');

-- --------------------------------------------------------

--
-- Table structure for table `factories`
--

CREATE TABLE IF NOT EXISTS `factories` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `factories`
--

INSERT INTO `factories` (`tableIndex`, `name`, `phone`, `email`, `address`) VALUES
(1, 'মামাল', '', '', ''),
(2, 'রফিক', '', '', ''),
(4, 'সরিফ', '', '', ''),
(5, 'কমলা', '', '', ''),
(6, 'জম্লা', '', '', ''),
(7, 'জারিফ', '', '', ''),
(8, 'মামুন', '', '', ''),
(9, 'কাসেম', '', '', ''),
(10, 'হাসেম', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `pid` varchar(255) NOT NULL COMMENT 'only exception to camelcasing, may  not even be an exception between pid and pId, i think pid is less confusing ',
  `descr` varchar(255) NOT NULL,
  `sp` int(11) NOT NULL,
  `cpDoz` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`tableIndex`, `pid`, `descr`, `sp`, `cpDoz`, `qty`, `img`) VALUES
(1, '1-1', 'jama', 0, 0, 0, ''),
(2, '1-2', '', 0, 0, 0, ''),
(3, '1-3', '', 0, 0, 0, ''),
(4, '1-4', '', 0, 0, 0, ''),
(5, '1-5', '', 0, 0, 0, ''),
(6, '1-6', '', 0, 0, 0, ''),
(7, '', '', 0, 0, 0, ''),
(8, '1-7', '', 0, 0, 0, ''),
(9, '1-8', '', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE IF NOT EXISTS `product_categories` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `level1` varchar(255) NOT NULL,
  `level2` varchar(255) NOT NULL,
  `level3` varchar(255) NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories_lvl1`
--

CREATE TABLE IF NOT EXISTS `product_categories_lvl1` (
  `table_index` int(11) NOT NULL AUTO_INCREMENT,
  `lvl1` varchar(255) NOT NULL,
  PRIMARY KEY (`table_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories_lvl2`
--

CREATE TABLE IF NOT EXISTS `product_categories_lvl2` (
  `table_index` int(11) NOT NULL AUTO_INCREMENT,
  `lvl1_index` int(11) NOT NULL,
  `lvl2` varchar(255) NOT NULL,
  PRIMARY KEY (`table_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_categories_lvl3`
--

CREATE TABLE IF NOT EXISTS `product_categories_lvl3` (
  `table_index` int(11) NOT NULL AUTO_INCREMENT,
  `lvl2_index` int(11) NOT NULL,
  `lvl3` varchar(255) NOT NULL,
  PRIMARY KEY (`table_index`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `product_categories_lvl3`
--

INSERT INTO `product_categories_lvl3` (`table_index`, `lvl2_index`, `lvl3`) VALUES
(1, 1, 'wasabi');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rank` varchar(255) NOT NULL,
  `parent` varchar(255) NOT NULL,
  `parentIndex` int(11) NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`tableIndex`, `name`, `rank`, `parent`, `parentIndex`) VALUES
(1, 'জেন্টস', '', 'root', 0),
(2, 'চটি', '', 'জেন্টস', 1),
(3, 'কমলা', '', 'জেন্টস', 1),
(4, 'লেডিস', '', 'root', 0),
(5, 'সু', '', 'root', 0),
(6, 'সু', '', 'root', 0),
(7, 'হলুদ', '', 'কমলা', 3);

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE IF NOT EXISTS `product_colors` (
  `table_index` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(255) NOT NULL,
  PRIMARY KEY (`table_index`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `vendorIndex` int(11) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `memoNo` int(11) NOT NULL,
  `memoKhata` int(11) NOT NULL,
  `rawPrice` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `due` int(11) NOT NULL COMMENT 'cummilative due',
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_log`
--

CREATE TABLE IF NOT EXISTS `purchase_log` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `memoNo` int(11) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `sp` int(11) NOT NULL,
  `cpDoz` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE IF NOT EXISTS `sell` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `vendorIndex` int(11) NOT NULL,
  `vendor` varchar(255) NOT NULL,
  `memoNo` int(11) NOT NULL,
  `memoKhata` int(11) NOT NULL,
  `rawPrice` int(11) NOT NULL,
  `extraCost` int(11) NOT NULL,
  `extraCostDescr` varchar(255) NOT NULL,
  `shippingCost` int(11) NOT NULL,
  `commission` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `totalPrice` int(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `due` int(11) NOT NULL,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sell_log`
--

CREATE TABLE IF NOT EXISTS `sell_log` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(255) NOT NULL,
  `memoNo` int(11) NOT NULL,
  `pid` varchar(255) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `sp` int(11) NOT NULL COMMENT 'the cost price at the time of selling',
  `cpDoz` int(11) NOT NULL COMMENT 'the sp per doz of the time of the selling',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `tableIndex` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(55) NOT NULL,
  `level` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`tableIndex`),
  KEY `tableIndex` (`tableIndex`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `__readme`
--

CREATE TABLE IF NOT EXISTS `__readme` (
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `__readme`
--

INSERT INTO `__readme` (`comments`) VALUES
('all the field names should be camelcased\r\n\r\n*except for the confusing ones\r\n-----------------------------------------\r\n\r\nthe table names should be hyphenated though, as mysql does not support uppercasing in table names');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
