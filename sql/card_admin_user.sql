-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-28 08:45:09
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
-- 表的结构 `card_admin_user`
--

CREATE TABLE `card_admin_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合伙人',
  `identity_id` int(11) NOT NULL DEFAULT '0' COMMENT '身份ID',
  `permission_ids` text COMMENT '权限ID',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `auth_code` varchar(10) NOT NULL COMMENT '鉴权随机字符串',
  `login_code` varchar(10) DEFAULT NULL COMMENT '登录状态鉴权随机字符',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `login_time` timestamp NULL DEFAULT NULL COMMENT '上次登录时间',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '登录IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

--
-- 转存表中的数据 `card_admin_user`
--

INSERT INTO `card_admin_user` (`id`, `username`, `mobile`, `partner_id`, `identity_id`, `permission_ids`, `password`, `auth_code`, `login_code`, `create_time`, `login_time`, `login_ip`) VALUES
(2, 'admin', '18423031505', 0, 0, 'all', '$2y$10$BdRZOOnT6NvpokaORtxpX.r8gPdLMmnvNXDCFSP06cPYCyQvlSjme', '5,24c4fb*v', 'O]JZ+Bh?ro', '2018-08-21 06:22:19', '2018-08-28 01:42:26', '0.0.0.0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_admin_user`
--
ALTER TABLE `card_admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_admin_user`
--
ALTER TABLE `card_admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
