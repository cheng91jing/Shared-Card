
CREATE TABLE `card_goods_category` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `cat_name` varchar(20) NOT NULL COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类名称',
  `cat_level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分类层级',
  `is_parent` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许新增下级分类',
  `cat_sort` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序号',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
