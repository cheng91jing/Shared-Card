-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-28 08:45:45
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
-- 表的结构 `card_user_card`
--

CREATE TABLE `card_user_card` (
  `id` int(11) UNSIGNED NOT NULL,
  `card_number` varchar(11) NOT NULL DEFAULT '' COMMENT '编号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属用户',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员卡类型',
  `status` tinyint(1) DEFAULT '0' COMMENT '普通状态',
  `enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `regular_start` timestamp NULL DEFAULT NULL COMMENT '期限开始',
  `regular_end` timestamp NULL DEFAULT NULL COMMENT '期限结束',
  `open_time` timestamp NULL DEFAULT NULL COMMENT '开卡时间',
  `activating_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '激活状态',
  `activating_code` varchar(6) DEFAULT NULL COMMENT '激活鉴权码',
  `denomination` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面额',
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `card_user_card`
--

INSERT INTO `card_user_card` (`id`, `card_number`, `user_id`, `cat_id`, `status`, `enable`, `regular_start`, `regular_end`, `open_time`, `activating_status`, `activating_code`, `denomination`, `balance`) VALUES
(3, 'D18000003', 3, 2, 1, 1, '2018-08-28 01:48:25', '2020-08-28 01:48:25', '2018-08-25 08:40:42', 1, NULL, '10000.00', '5800.00'),
(23, 'Z18000004', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'CCG0NN', '20000.00', '20000.00'),
(24, 'Z18000024', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'XWVFMN', '20000.00', '20000.00'),
(25, 'Z18000025', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'GHSFAH', '20000.00', '20000.00'),
(26, 'Z18000026', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'HVCAAT', '20000.00', '20000.00'),
(27, 'Z18000027', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'LF1TZF', '20000.00', '20000.00'),
(28, 'Z18000028', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'PG7OKM', '20000.00', '20000.00'),
(29, 'Z18000029', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'KI2H2R', '20000.00', '20000.00'),
(30, 'Z18000030', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'JS3ZCC', '20000.00', '20000.00'),
(31, 'Z18000031', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'ZAGHOD', '20000.00', '20000.00'),
(32, 'Z18000032', 0, 3, 1, 0, NULL, NULL, NULL, 0, 'EVJSFS', '20000.00', '20000.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_user_card`
--
ALTER TABLE `card_user_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_number` (`card_number`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_user_card`
--
ALTER TABLE `card_user_card`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
