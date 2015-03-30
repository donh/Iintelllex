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
-- 資料表結構 `practictioner`
--

CREATE TABLE IF NOT EXISTS `practictioner` (
`id` int(11) NOT NULL,
  `userId` varchar(11) DEFAULT NULL,
  `jurisdiction` varchar(50) DEFAULT NULL,
  `admissionYear` int(4) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `awardName` varchar(50) DEFAULT NULL,
  `awardYear` int(4) DEFAULT NULL,
  `publicationName` varchar(50) DEFAULT NULL,
  `publicationType` varchar(15) DEFAULT NULL,
  `publicationUrl` varchar(200) DEFAULT NULL,
  `publicationCitation` varchar(400) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `practictioner`
--
ALTER TABLE `practictioner`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `userId` (`userId`), ADD KEY `jurisdiction` (`jurisdiction`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `practictioner`
--
ALTER TABLE `practictioner`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
