

ALTER TABLE `card_admin_identity`
  ADD PRIMARY KEY (`identity_id`),
  ADD UNIQUE KEY `identity_name` (`identity_name`);

ALTER TABLE `card_admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mobile` (`mobile`);

ALTER TABLE `card_bill`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `card_card_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`),
  ADD UNIQUE KEY `prefix` (`prefix`);

ALTER TABLE `card_goods`
  ADD PRIMARY KEY (`goods_id`);

ALTER TABLE `card_goods_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

ALTER TABLE `card_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_sn` (`order_sn`);

ALTER TABLE `card_partner`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `partner_name` (`partner_name`);

ALTER TABLE `card_send_sms`
  ADD PRIMARY KEY (`sms_id`),
  ADD KEY `send_sms_phone_index` (`phone`);

ALTER TABLE `card_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`);

ALTER TABLE `card_user_card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `card_number` (`card_number`);


ALTER TABLE `card_admin_identity`
  MODIFY `identity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `card_admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `card_bill`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `card_card_category`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `card_goods`
  MODIFY `goods_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `card_goods_category`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
ALTER TABLE `card_order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `card_partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `card_send_sms`
  MODIFY `sms_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `card_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `card_user_card`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;