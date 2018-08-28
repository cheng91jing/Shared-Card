-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018-08-28 08:45:26
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
-- 表的结构 `card_order`
--

CREATE TABLE `card_order` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合作商',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `card_id` int(11) NOT NULL DEFAULT '0' COMMENT '使用会员卡',
  `order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '付款状态',
  `order_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单类型',
  `offline_admin` int(11) NOT NULL DEFAULT '0' COMMENT '线下管理',
  `offline_note` varchar(255) DEFAULT NULL COMMENT '线下备注',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `total_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `cash_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '现金支付',
  `card_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '会员卡支付',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_number` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `pay_time` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '完成/结束时间',
  `buyer_remark` varchar(255) DEFAULT NULL COMMENT '买家备注'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `card_order`
--

INSERT INTO `card_order` (`id`, `order_sn`, `partner_id`, `user_id`, `card_id`, `order_status`, `pay_status`, `order_type`, `offline_admin`, `offline_note`, `goods_id`, `total_money`, `cash_money`, `card_money`, `goods_price`, `goods_number`, `create_time`, `pay_time`, `end_time`, `buyer_remark`) VALUES
(1, '01808282090585269', 1, 3, 3, 1, 1, 0, 2, '住宿', 0, '6000.00', '0.00', '4200.00', '2000.00', 3, '2018-08-28 01:48:25', '2018-08-27 16:00:00', '2018-08-27 16:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_order`
--
ALTER TABLE `card_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_sn` (`order_sn`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `card_order`
--
ALTER TABLE `card_order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
