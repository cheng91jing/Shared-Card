
CREATE TABLE `card_bill` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作管理员',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型',
  `is_consume` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否支付',
  `amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '金额',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '时间',
  `note` varchar(255) DEFAULT NULL COMMENT '内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
