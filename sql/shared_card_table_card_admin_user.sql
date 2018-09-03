
CREATE TABLE `card_admin_user` (
  `id` int(11) NOT NULL,
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
  `login_ip` varchar(15) DEFAULT NULL COMMENT '登录IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='后台管理员表';
