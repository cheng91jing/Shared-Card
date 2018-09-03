
CREATE TABLE `card_goods` (
  `goods_id` int(11) UNSIGNED NOT NULL,
  `goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '商品名称',
  `partner_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属合作商',
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品分类id',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `goods_number` int(11) NOT NULL DEFAULT '0' COMMENT '商品库存',
  `goods_discount` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否开启商品优惠',
  `discount_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '优惠类型',
  `discount_number` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠额度',
  `goods_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品状态',
  `add_time` timestamp NULL DEFAULT NULL COMMENT '新增时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
