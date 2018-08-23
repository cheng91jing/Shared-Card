-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-23 10:14:47
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
-- 表的结构 `card_admin_identity`
--

CREATE TABLE `card_admin_identity` (
  `identity_id` int(11) NOT NULL,
  `identity_name` varchar(10) NOT NULL COMMENT '身份名称',
  `permission_ids` text COMMENT '权限ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合伙人'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台身份表';

--
-- 转存表中的数据 `card_admin_identity`
--

INSERT INTO `card_admin_identity` (`identity_id`, `identity_name`, `permission_ids`, `parent_id`, `partner_id`) VALUES
(2, '超级管理员', 'all', 0, 0),
(5, '子管理', 'system|admin/operation|admin/operation/index|admin/parameters|admin/parameters/index|admin/parameters/updateparams', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_admin_identity`
--
ALTER TABLE `card_admin_identity`
  ADD PRIMARY KEY (`identity_id`),
  ADD UNIQUE KEY `identity_name` (`identity_name`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_admin_identity`
--
ALTER TABLE `card_admin_identity`
  MODIFY `identity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
