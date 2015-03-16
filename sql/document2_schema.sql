-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生時間： 2015 年 03 月 16 日 16:19
-- 伺服器版本: 5.5.41-0ubuntu0.14.10.1
-- PHP 版本： 5.5.12-2ubuntu4.2

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
-- 資料表結構 `document2`
--

CREATE TABLE IF NOT EXISTS `document2` (
`iddocument2` int(11) NOT NULL,
  `url` longtext,
  `jurisdiction` varchar(100) DEFAULT NULL,
  `content` longtext,
  `title` text,
  `tstamp` int(11) DEFAULT NULL,
  `html_content` longtext
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49693 ;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `document2`
--
ALTER TABLE `document2`
 ADD PRIMARY KEY (`iddocument2`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `document2`
--
ALTER TABLE `document2`
MODIFY `iddocument2` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49693;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
