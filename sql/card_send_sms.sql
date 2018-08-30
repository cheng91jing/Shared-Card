-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-30 11:15:41
-- 服务器版本： 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shared_card`
--

-- --------------------------------------------------------

--
-- 表的结构 `card_send_sms`
--

CREATE TABLE `card_send_sms` (
  `sms_id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `code` varchar(10) DEFAULT NULL COMMENT '验证码',
  `last_time` int(10) NOT NULL DEFAULT '0' COMMENT '最新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信验证码发送';

--
-- 转存表中的数据 `card_send_sms`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_send_sms`
--
ALTER TABLE `card_send_sms`
  ADD PRIMARY KEY (`sms_id`),
  ADD KEY `send_sms_phone_index` (`phone`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_send_sms`
--
ALTER TABLE `card_send_sms`
  MODIFY `sms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
