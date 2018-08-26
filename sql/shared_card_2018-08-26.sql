# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.22-0ubuntu18.04.1)
# Database: shared_card
# Generation Time: 2018-08-26 14:19:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table card_admin_identity
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_admin_identity`;

CREATE TABLE `card_admin_identity` (
  `identity_id` int(11) NOT NULL AUTO_INCREMENT,
  `identity_name` varchar(10) NOT NULL COMMENT '身份名称',
  `permission_ids` text COMMENT '权限ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合伙人',
  PRIMARY KEY (`identity_id`),
  UNIQUE KEY `identity_name` (`identity_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台身份表';

LOCK TABLES `card_admin_identity` WRITE;
/*!40000 ALTER TABLE `card_admin_identity` DISABLE KEYS */;

INSERT INTO `card_admin_identity` (`identity_id`, `identity_name`, `permission_ids`, `parent_id`, `partner_id`)
VALUES
	(2,'超级管理员','all',0,0),
	(5,'子管理','system|admin/operation|admin/operation/index|admin/parameters|admin/parameters/index|admin/parameters/updateparams',0,0);

/*!40000 ALTER TABLE `card_admin_identity` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_admin_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_admin_user`;

CREATE TABLE `card_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `login_ip` varchar(15) DEFAULT NULL COMMENT '登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员表';

LOCK TABLES `card_admin_user` WRITE;
/*!40000 ALTER TABLE `card_admin_user` DISABLE KEYS */;

INSERT INTO `card_admin_user` (`id`, `username`, `mobile`, `partner_id`, `identity_id`, `permission_ids`, `password`, `auth_code`, `login_code`, `create_time`, `login_time`, `login_ip`)
VALUES
	(2,'admin','18423031505',0,0,'all','$2y$10$BdRZOOnT6NvpokaORtxpX.r8gPdLMmnvNXDCFSP06cPYCyQvlSjme','5,24c4fb*v','7k-G*p-F{}','2018-08-21 06:22:19','2018-08-26 19:08:45','192.168.10.1');

/*!40000 ALTER TABLE `card_admin_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_card_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_card_category`;

CREATE TABLE `card_card_category` (
  `cat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `period_start` tinyint(1) NOT NULL DEFAULT '0',
  `period_type` tinyint(1) NOT NULL DEFAULT '0',
  `period_number` int(11) NOT NULL DEFAULT '0',
  `regular_start` timestamp NULL DEFAULT NULL,
  `regular_end` timestamp NULL DEFAULT NULL,
  `discount_type` tinyint(1) NOT NULL DEFAULT '0',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00',
  `denomination` decimal(10,2) NOT NULL DEFAULT '0.00',
  `image` varchar(255) DEFAULT NULL,
  `prefix` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_card_category` WRITE;
/*!40000 ALTER TABLE `card_card_category` DISABLE KEYS */;

INSERT INTO `card_card_category` (`cat_id`, `cat_name`, `status`, `period_start`, `period_type`, `period_number`, `regular_start`, `regular_end`, `discount_type`, `discount_number`, `denomination`, `image`, `prefix`)
VALUES
	(1,'金卡',1,0,0,12,'2018-09-01 00:00:00','2019-01-02 00:00:00',0,0.10,5000.00,NULL,'G'),
	(2,'钻石卡',1,0,0,24,NULL,NULL,0,0.30,10000.00,NULL,'D'),
	(3,'至尊卡',1,0,0,36,'2018-09-01 00:00:00','2019-09-01 00:00:00',1,300.00,20000.00,NULL,'Z');

/*!40000 ALTER TABLE `card_card_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_order`;

CREATE TABLE `card_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `buyer_remark` varchar(255) DEFAULT NULL COMMENT '买家备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table card_partner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_partner`;

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

LOCK TABLES `card_partner` WRITE;
/*!40000 ALTER TABLE `card_partner` DISABLE KEYS */;

INSERT INTO `card_partner` (`id`, `admin_id`, `partner_type`, `partner_cat`, `status`, `partner_name`, `address`, `create_time`, `simply_introduce`, `detail_introduce`, `tel`)
VALUES
	(1,2,0,0,1,'火星大酒店',NULL,'2018-08-23 14:41:17',NULL,NULL,NULL);

/*!40000 ALTER TABLE `card_partner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_user`;

CREATE TABLE `card_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL COMMENT '用户手机号',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `auth_code` varchar(10) NOT NULL COMMENT '鉴权码',
  `login_code` varchar(10) DEFAULT NULL COMMENT '登录码',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `login_time` timestamp NULL DEFAULT NULL COMMENT '上次登录时间',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '上次登录IP',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

LOCK TABLES `card_user` WRITE;
/*!40000 ALTER TABLE `card_user` DISABLE KEYS */;

INSERT INTO `card_user` (`id`, `mobile`, `password`, `auth_code`, `login_code`, `create_time`, `login_time`, `login_ip`)
VALUES
	(3,'18423031505','$2y$10$oNet9HAx1X4Np8hS9gUPy.vam3VB6LbOIWCctgGcJAfJvuLjVSUxW','myc@q1\\d&r',NULL,'2018-08-23 07:37:24',NULL,NULL),
	(4,'18375991394','$2y$10$bM0a9rLjtmD8ZUHkN8tooeXomKyw2YUkODsluIJRVGjJWUSJAayYO','dpD\"Z}>3-@',NULL,'2018-08-23 12:14:34',NULL,NULL);

/*!40000 ALTER TABLE `card_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_user_card
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_user_card`;

CREATE TABLE `card_user_card` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_number` (`card_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_user_card` WRITE;
/*!40000 ALTER TABLE `card_user_card` DISABLE KEYS */;

INSERT INTO `card_user_card` (`id`, `card_number`, `user_id`, `cat_id`, `status`, `enable`, `regular_start`, `regular_end`, `open_time`, `activating_status`, `activating_code`, `denomination`, `balance`)
VALUES
	(3,'D2018000003',3,2,1,0,NULL,NULL,'2018-08-25 16:40:42',1,NULL,10000.00,10000.00),
	(23,'Z2018000004',0,3,1,0,NULL,NULL,NULL,0,'CCG0NN',20000.00,20000.00),
	(24,'Z2018000024',0,3,1,0,NULL,NULL,NULL,0,'XWVFMN',20000.00,20000.00),
	(25,'Z2018000025',0,3,1,0,NULL,NULL,NULL,0,'GHSFAH',20000.00,20000.00),
	(26,'Z2018000026',0,3,1,0,NULL,NULL,NULL,0,'HVCAAT',20000.00,20000.00),
	(27,'Z2018000027',0,3,1,0,NULL,NULL,NULL,0,'LF1TZF',20000.00,20000.00),
	(28,'Z2018000028',0,3,1,0,NULL,NULL,NULL,0,'PG7OKM',20000.00,20000.00),
	(29,'Z2018000029',0,3,1,0,NULL,NULL,NULL,0,'KI2H2R',20000.00,20000.00),
	(30,'Z2018000030',0,3,1,0,NULL,NULL,NULL,0,'JS3ZCC',20000.00,20000.00),
	(31,'Z2018000031',0,3,1,0,NULL,NULL,NULL,0,'ZAGHOD',20000.00,20000.00),
	(32,'Z2018000032',0,3,1,0,NULL,NULL,NULL,0,'EVJSFS',20000.00,20000.00);

/*!40000 ALTER TABLE `card_user_card` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
