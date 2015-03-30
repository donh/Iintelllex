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
-- 資料表結構 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
`id` int(11) NOT NULL,
  `userId` varchar(11) DEFAULT NULL,
  `institution` varchar(50) DEFAULT NULL,
  `graduationYear` int(4) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `monthFrom` char(3) DEFAULT NULL,
  `yearFrom` int(4) DEFAULT NULL,
  `monthTo` char(3) DEFAULT NULL,
  `yearTo` int(4) DEFAULT NULL,
  `supervisor` varchar(30) DEFAULT NULL,
  `competitionName` varchar(50) DEFAULT NULL,
  `competitionResult` varchar(200) DEFAULT NULL,
  `publicationName` varchar(50) DEFAULT NULL,
  `publicationType` varchar(15) DEFAULT NULL,
  `publicationUrl` varchar(200) DEFAULT NULL,
  `publicationCitation` varchar(400) DEFAULT NULL,
  `qualification` varchar(25) DEFAULT NULL,
  `qualificationYear` int(4) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `student`
--
ALTER TABLE `student`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `userId` (`userId`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `student`
--
ALTER TABLE `student`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
