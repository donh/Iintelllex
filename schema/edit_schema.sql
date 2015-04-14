-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 建立日期: 2015 年 04 月 15 日 00:11
-- 伺服器版本: 5.5.41-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `intelllex`
--

-- --------------------------------------------------------

--
-- 資料表結構 `edit`
--

CREATE TABLE IF NOT EXISTS `edit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `publications` varchar(1800) DEFAULT NULL,
  `admissions` varchar(80) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `awards` varchar(100) DEFAULT NULL,
  `institution` varchar(50) DEFAULT NULL,
  `graduationYear` int(4) DEFAULT NULL,
  `degree` varchar(20) DEFAULT NULL,
  `works` varchar(500) DEFAULT NULL,
  `competitions` varchar(800) DEFAULT NULL,
  `others` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
