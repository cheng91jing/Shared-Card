# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.22-0ubuntu18.04.1)
# Database: shared_card
# Generation Time: 2018-09-02 12:53:27 +0000
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
  `is_partner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否商家',
  PRIMARY KEY (`identity_id`),
  UNIQUE KEY `identity_name` (`identity_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台身份表';

LOCK TABLES `card_admin_identity` WRITE;
/*!40000 ALTER TABLE `card_admin_identity` DISABLE KEYS */;

INSERT INTO `card_admin_identity` (`identity_id`, `identity_name`, `permission_ids`, `is_partner`)
VALUES
	(2,'超级管理员','all',0),
	(5,'子管理','system|admin/operation|admin/operation/index|admin/parameters|admin/parameters/index|admin/parameters/updateparams',0),
	(6,'商家管理员',NULL,1);

/*!40000 ALTER TABLE `card_admin_identity` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_admin_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_admin_user`;

CREATE TABLE `card_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL COMMENT '用户名',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合作商',
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
	(2,'admin','18423031505',1,2,'','$2y$10$BdRZOOnT6NvpokaORtxpX.r8gPdLMmnvNXDCFSP06cPYCyQvlSjme','5,24c4fb*v','!l<Uw.37J\'','2018-08-21 06:22:19','2018-09-02 16:45:04','192.168.10.1'),
	(3,'chengjing','18375991394',0,6,'','$2y$10$nFvRpxstuYTqwcIgIV6Vt.lmwK9G6qouFsVqiYUiM.lifVEyqDbYG','&k{D(k%+Zx',NULL,'2018-09-01 04:42:10',NULL,NULL);

/*!40000 ALTER TABLE `card_admin_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_bill
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_bill`;

CREATE TABLE `card_bill` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作管理员',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `is_consume` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `note` varchar(255) DEFAULT NULL COMMENT '内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_bill` WRITE;
/*!40000 ALTER TABLE `card_bill` DISABLE KEYS */;

INSERT INTO `card_bill` (`id`, `user_id`, `admin_id`, `type`, `is_consume`, `amount`, `add_time`, `note`)
VALUES
	(1,5,2,0,1,1400.00,1535856724,'订单付款 - 订单号：01809025672406812：现金：0；余额：1400');

/*!40000 ALTER TABLE `card_bill` ENABLE KEYS */;
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
	(1,'金卡',1,0,0,12,'2018-09-01 00:00:00','2019-01-02 00:00:00',0,0.10,5000.00,'/static/img/center/card_gold.png','G'),
	(2,'钻石卡',1,0,0,24,NULL,NULL,0,0.30,10000.00,'/static/img/center/card_diamond.png','D'),
	(3,'至尊卡',1,0,0,36,'2018-09-01 00:00:00','2019-09-01 00:00:00',1,300.00,20000.00,'/static/img/center/card_platinum.png','Z');

/*!40000 ALTER TABLE `card_card_category` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_goods
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_goods`;

CREATE TABLE `card_goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合作商',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_number` int(11) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `goods_discount` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启商品优惠',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠额度',
  `goods_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '新增时间',
  PRIMARY KEY (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_goods` WRITE;
/*!40000 ALTER TABLE `card_goods` DISABLE KEYS */;

INSERT INTO `card_goods` (`goods_id`, `goods_name`, `partner_id`, `cat_id`, `goods_price`, `goods_number`, `goods_discount`, `discount_type`, `discount_number`, `goods_status`, `add_time`)
VALUES
	(1,'海鲜大餐',1,6,1000.00,0,0,0,0.00,1,'2018-09-02 20:24:50'),
	(2,'海洋饭店',1,3,600.00,0,0,0,0.20,1,'2018-09-02 20:52:16'),
	(3,'海鲜大餐',1,6,1000.00,0,1,0,0.10,1,'2018-09-02 20:51:36');

/*!40000 ALTER TABLE `card_goods` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_goods_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_goods_category`;

CREATE TABLE `card_goods_category` (
  `cat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类名称',
  `cat_level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分类层级',
  `is_parent` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许新增下级分类',
  `cat_sort` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序号',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  PRIMARY KEY (`cat_id`),
  UNIQUE KEY `cat_name` (`cat_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_goods_category` WRITE;
/*!40000 ALTER TABLE `card_goods_category` DISABLE KEYS */;

INSERT INTO `card_goods_category` (`cat_id`, `cat_name`, `parent_id`, `cat_level`, `is_parent`, `cat_sort`, `is_show`)
VALUES
	(1,'酒店',0,1,1,1,1),
	(2,'租车',0,1,1,3,1),
	(3,'饭店',0,1,1,2,1),
	(4,'住宿',1,2,1,1,1),
	(5,'餐饮',1,2,1,2,1),
	(6,'汤锅',5,3,0,1,1),
	(7,'时租',2,2,1,2,1),
	(8,'日租',2,2,1,1,1);

/*!40000 ALTER TABLE `card_goods_category` ENABLE KEYS */;
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
  `discount_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠额度',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_number` int(11) NOT NULL DEFAULT '0' COMMENT '商品数量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `pay_time` timestamp NULL DEFAULT NULL COMMENT '支付时间',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '完成/结束时间',
  `buyer_remark` varchar(255) DEFAULT NULL COMMENT '买家备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_order` WRITE;
/*!40000 ALTER TABLE `card_order` DISABLE KEYS */;

INSERT INTO `card_order` (`id`, `order_sn`, `partner_id`, `user_id`, `card_id`, `order_status`, `pay_status`, `order_type`, `offline_admin`, `offline_note`, `goods_id`, `total_money`, `cash_money`, `card_money`, `discount_money`, `discount_type`, `discount_number`, `goods_price`, `goods_number`, `create_time`, `pay_time`, `end_time`, `buyer_remark`)
VALUES
	(6,'01808277395735802',1,5,3,1,1,0,2,'住宿',0,10000.00,0.00,7000.00,0.00,0,0.00,5000.00,2,'2018-08-27 20:45:57','2018-08-27 00:00:00','2018-08-27 00:00:00',NULL),
	(7,'01809025657907705',1,5,3,1,1,0,2,'租车',0,1000.00,0.00,700.00,300.00,0,0.30,500.00,2,'2018-09-02 10:49:39','2018-09-02 10:49:39','2018-09-02 10:49:39',NULL),
	(8,'01809025672406812',1,5,3,1,1,0,2,'住宿',0,2000.00,0.00,1400.00,600.00,0,0.30,1000.00,2,'2018-09-02 10:52:04','2018-09-02 10:52:04','2018-09-02 10:52:04',NULL);

/*!40000 ALTER TABLE `card_order` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_partner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_partner`;

CREATE TABLE `card_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `partner_type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `partner_cat` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `goods_discount` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可以设置商品优惠',
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

INSERT INTO `card_partner` (`id`, `partner_type`, `partner_cat`, `goods_discount`, `status`, `partner_name`, `address`, `create_time`, `simply_introduce`, `detail_introduce`, `tel`)
VALUES
	(1,0,0,1,1,'火星大酒店',NULL,'2018-08-23 14:41:17',NULL,NULL,NULL);

/*!40000 ALTER TABLE `card_partner` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_send_sms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_send_sms`;

CREATE TABLE `card_send_sms` (
  `sms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `code` varchar(10) DEFAULT NULL COMMENT '验证码',
  `last_time` int(10) NOT NULL DEFAULT '0' COMMENT '最新时间',
  PRIMARY KEY (`sms_id`),
  KEY `send_sms_phone_index` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信验证码发送';

LOCK TABLES `card_send_sms` WRITE;
/*!40000 ALTER TABLE `card_send_sms` DISABLE KEYS */;

INSERT INTO `card_send_sms` (`sms_id`, `phone`, `code`, `last_time`)
VALUES
	(2,'18423031505','',1535765621);

/*!40000 ALTER TABLE `card_send_sms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table card_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `card_user`;

CREATE TABLE `card_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL COMMENT '用户手机号',
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

INSERT INTO `card_user` (`id`, `mobile`, `auth_code`, `login_code`, `create_time`, `login_time`, `login_ip`)
VALUES
	(4,'18375991394','dpD\"Z}>3-@',NULL,'2018-08-23 12:14:34',NULL,NULL),
	(5,'18423031505','7vn1yu$g2D','zVt6(o8168','2018-08-30 13:41:41','2018-09-01 09:34:02','192.168.10.1');

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
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠额度',
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_number` (`card_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `card_user_card` WRITE;
/*!40000 ALTER TABLE `card_user_card` DISABLE KEYS */;

INSERT INTO `card_user_card` (`id`, `card_number`, `user_id`, `cat_id`, `status`, `enable`, `regular_start`, `regular_end`, `open_time`, `activating_status`, `activating_code`, `denomination`, `balance`, `discount_type`, `discount_number`)
VALUES
	(3,'D18000003',5,2,1,1,'2018-08-27 20:28:38','2020-08-27 20:28:38','2018-08-25 16:40:42',1,'CAHASV',10000.00,900.00,0,0.30),
	(23,'Z18000004',0,3,1,0,NULL,NULL,NULL,0,'CCG0NN',20000.00,20000.00,0,0.00),
	(24,'Z18000024',0,3,1,0,NULL,NULL,NULL,0,'XWVFMN',20000.00,20000.00,0,0.00),
	(25,'Z18000025',0,3,1,0,NULL,NULL,NULL,0,'GHSFAH',20000.00,20000.00,0,0.00),
	(26,'Z18000026',0,3,1,0,NULL,NULL,NULL,0,'HVCAAT',20000.00,20000.00,0,0.00),
	(27,'Z18000027',0,3,1,0,NULL,NULL,NULL,0,'LF1TZF',20000.00,20000.00,0,0.00),
	(28,'Z18000028',0,3,1,0,NULL,NULL,NULL,0,'PG7OKM',20000.00,20000.00,0,0.00),
	(29,'Z18000029',0,3,1,0,NULL,NULL,NULL,0,'KI2H2R',20000.00,20000.00,0,0.00),
	(30,'Z18000030',0,3,1,0,NULL,NULL,NULL,0,'JS3ZCC',20000.00,20000.00,0,0.00),
	(31,'Z18000031',0,3,1,0,NULL,NULL,NULL,0,'ZAGHOD',20000.00,20000.00,0,0.00),
	(32,'Z18000032',0,3,1,0,NULL,NULL,NULL,0,'EVJSFS',20000.00,20000.00,0,0.00);

/*!40000 ALTER TABLE `card_user_card` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
