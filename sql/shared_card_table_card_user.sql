
CREATE TABLE `card_user` (
  `id` int(11) NOT NULL,
  `mobile` varchar(11) NOT NULL COMMENT '用户手机号',
  `auth_code` varchar(10) NOT NULL COMMENT '鉴权码',
  `login_code` varchar(10) DEFAULT NULL COMMENT '登录码',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '注册时间',
  `login_time` timestamp NULL DEFAULT NULL COMMENT '上次登录时间',
  `login_ip` varchar(15) DEFAULT NULL COMMENT '上次登录IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';
