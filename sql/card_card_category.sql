-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-28 08:45:19
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
-- 表的结构 `card_card_category`
--

CREATE TABLE `card_card_category` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `cat_name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `period_start` tinyint(1) NOT NULL DEFAULT '0' COMMENT '期限开始类型(0-首次消费/1-开卡日/2-固定时限)',
  `period_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '期限类型',
  `period_number` int(11) NOT NULL DEFAULT '0' COMMENT '期限量',
  `regular_start` timestamp NULL DEFAULT NULL COMMENT '定期开始时间',
  `regular_end` timestamp NULL DEFAULT NULL COMMENT '定期结束时间',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠数量',
  `denomination` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面额',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `prefix` varchar(4) DEFAULT NULL COMMENT '前缀'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `card_card_category`
--

INSERT INTO `card_card_category` (`cat_id`, `cat_name`, `status`, `period_start`, `period_type`, `period_number`, `regular_start`, `regular_end`, `discount_type`, `discount_number`, `denomination`, `image`, `prefix`) VALUES
(1, '金卡', 1, 0, 0, 12, '2018-08-31 16:00:00', '2019-01-01 16:00:00', 0, '0.10', '5000.00', NULL, 'G'),
(2, '钻石卡', 1, 0, 0, 24, NULL, NULL, 0, '0.30', '10000.00', NULL, 'D'),
(3, '至尊卡', 1, 0, 0, 36, '2018-08-31 16:00:00', '2019-08-31 16:00:00', 1, '300.00', '20000.00', NULL, 'Z');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_card_category`
--
ALTER TABLE `card_card_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`),
  ADD UNIQUE KEY `prefix` (`prefix`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_card_category`
--
ALTER TABLE `card_card_category`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
