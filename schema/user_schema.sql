-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015 年 03 月 30 日 11:40
-- 伺服器版本: 5.5.41-0ubuntu0.14.10.1
-- PHP 版本： 5.5.12-2ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `intelllex`
--

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `account` varchar(50) DEFAULT NULL,
  `type` varchar(11) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `ips` varchar(900) DEFAULT NULL,
  `username` varchar(70) DEFAULT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(60) DEFAULT NULL,
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
  KEY `account` (`account`),
  KEY `email` (`email`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
