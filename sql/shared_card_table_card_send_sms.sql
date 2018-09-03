
CREATE TABLE `card_send_sms` (
  `sms_id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(11) NOT NULL COMMENT '手机号',
  `code` varchar(10) DEFAULT NULL COMMENT '验证码',
  `last_time` int(10) NOT NULL DEFAULT '0' COMMENT '最新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='短信验证码发送';
