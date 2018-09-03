
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
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠额度'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
