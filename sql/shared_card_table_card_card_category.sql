
CREATE TABLE `card_card_category` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `cat_name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `period_start` tinyint(1) NOT NULL DEFAULT '0' COMMENT '期限开始类型(0-首次消费/1-开卡日/2-固定时限)',
  `period_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '期限类型',
  `period_number` int(11) NOT NULL DEFAULT '0' COMMENT '期限量',
  `regular_start` timestamp NULL DEFAULT NULL COMMENT '定期开始时间',
  `regular_end` timestamp NULL DEFAULT NULL COMMENT '定期结束时间',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠数量',
  `denomination` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '面额',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `prefix` varchar(4) DEFAULT NULL COMMENT '前缀'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
