-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-23 10:16:11
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
-- 表的结构 `card_partner`
--

CREATE TABLE `card_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属后台用户',
  `partner_type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `partner_cat` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `partner_name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `simply_introduce` varchar(50) DEFAULT NULL COMMENT '简介',
  `detail_introduce` varchar(255) DEFAULT NULL COMMENT '详细介绍',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话',
  PRIMARY KEY (`id`),
  UNIQUE KEY `partner_name` (`partner_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合作人/商家/店铺表';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
