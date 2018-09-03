
CREATE TABLE `card_partner` (
  `id` int(11) NOT NULL,
  `partner_type` int(11) NOT NULL DEFAULT '0' COMMENT '类型',
  `partner_cat` int(11) NOT NULL DEFAULT '0' COMMENT '分类',
  `goods_discount` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否可以设置商品优惠',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `partner_name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `simply_introduce` varchar(50) DEFAULT NULL COMMENT '简介',
  `detail_introduce` varchar(255) DEFAULT NULL COMMENT '详细介绍',
  `tel` varchar(20) DEFAULT NULL COMMENT '电话'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合作人/商家/店铺表';
