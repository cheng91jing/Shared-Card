create table shared_card.card_hotel
(
  id              int auto_increment
    primary key,
  partner_id      int                    not null
  comment '所属商家ID',
  hotel_name      varchar(50)            null
  comment '酒店名称',
  api_url         varchar(255)           not null
  comment 'API接口地址',
  hotel_key       varchar(255)           not null
  comment '酒店KEY',
  chain_code      varchar(255)           not null
  comment '连锁代码',
  hotel_code_room varchar(255)           not null
  comment '酒店代码(房态)',
  hotel_code_base varchar(255)           null
  comment '酒店代码(基础)',
  status          tinyint(1) default '1' not null
  comment '是否开启预定',
  is_show         tinyint(1) default '1' not null
  comment '是否显示',
  constraint card_hotel_partner_id_uindex
  unique (partner_id)
)
  comment '商家酒店配置'
  engine = InnoDB;
