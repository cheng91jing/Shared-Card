
CREATE TABLE `card_admin_identity` (
  `identity_id` int(11) NOT NULL,
  `identity_name` varchar(10) NOT NULL COMMENT '身份名称',
  `permission_ids` text COMMENT '权限ID',
  `is_partner` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否商家'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台身份表';
