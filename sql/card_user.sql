-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-23 10:16:18
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
-- 表的结构 `card_user`
--

CREATE TABLE `card_user` (
  `id` int(11) NOT NULL,
  `mobile` varchar(11) NOT NULL COMMENT '用户手机号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `auth_code` varchar(10) NOT NULL COMMENT '鉴权码',
  `login_code` varchar(10) DEFAULT NULL COMMENT '登录码',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `login_time` timestamp NULL DEFAULT NULL COMMENT '上次登录时间',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '上次登录IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

--
-- 转存表中的数据 `card_user`
--

INSERT INTO `card_user` (`id`, `mobile`, `password`, `auth_code`, `login_code`, `create_time`, `login_time`, `login_ip`) VALUES
(3, '18423031505', '$2y$10$oNet9HAx1X4Np8hS9gUPy.vam3VB6LbOIWCctgGcJAfJvuLjVSUxW', 'myc@q1\\d&r', NULL, '2018-08-23 07:37:24', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_user`
--
ALTER TABLE `card_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_user`
--
ALTER TABLE `card_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
