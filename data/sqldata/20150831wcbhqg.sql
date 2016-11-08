-- ecshop v2.x SQL Dump Program
-- http://www.xjd.test
-- 
-- DATE : 2015-08-31 15:32:39
-- MYSQL SERVER VERSION : 5.5.20-log
-- PHP VERSION : 5.3.10
-- ECShop VERSION : v4_1
-- Vol : 1
DROP TABLE IF EXISTS `ecs_pickup_point`;
CREATE TABLE `ecs_pickup_point` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `supplier_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '店铺标识',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ecs_pickup_point` ( `id`, `shop_name`, `address`, `phone`, `contact`, `province_id`, `city_id`, `district_id`, `supplier_id` ) VALUES  ('1', '云海超市', '河北大街西段', '15216766661', '倪庆洋', '10', '145', '1194', '0');
-- END ecshop v2.x SQL Dump Program 