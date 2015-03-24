-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015 年 03 月 24 日 10:10
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
-- 資料表結構 `classifier`
--

CREATE TABLE IF NOT EXISTS `classifier` (
`id` int(11) NOT NULL,
  `url` varchar(400) DEFAULT NULL,
  `annotated` tinyint(1) DEFAULT NULL,
  `is_case` tinyint(1) DEFAULT NULL,
  `content_len` int(7) DEFAULT NULL,
  `title` text,
  `jurisdiction` char(8) DEFAULT NULL,
  `annotator` char(6) DEFAULT NULL,
  `date` char(10) DEFAULT NULL,
  `createdAt` datetime DEFAULT NULL,
  `updatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `classifier`
--
ALTER TABLE `classifier`
 ADD PRIMARY KEY (`id`), ADD KEY `url` (`url`(255)), ADD KEY `annotated` (`annotated`), ADD KEY `is_case` (`is_case`), ADD KEY `content_len` (`content_len`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `classifier`
--
ALTER TABLE `classifier`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
