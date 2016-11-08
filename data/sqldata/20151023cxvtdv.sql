-- ecshop v2.x SQL Dump Program
-- http://www.xjd.test
-- 
-- DATE : 2015-10-23 15:56:45
-- MYSQL SERVER VERSION : 5.5.20-log
-- PHP VERSION : 5.3.10
-- ECShop VERSION : v4_2
-- Vol : 1
DROP TABLE IF EXISTS `ecs_template`;
CREATE TABLE `ecs_template` (
  `filename` varchar(30) NOT NULL DEFAULT '',
  `region` varchar(40) NOT NULL DEFAULT '',
  `library` varchar(40) NOT NULL DEFAULT '',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `number` tinyint(1) unsigned NOT NULL DEFAULT '5',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `theme` varchar(60) NOT NULL DEFAULT '',
  `remarks` varchar(30) NOT NULL DEFAULT '',
  `ext_info` text COMMENT '扩展字段',
  KEY `filename` (`filename`,`region`),
  KEY `theme` (`theme`),
  KEY `remarks` (`remarks`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '0', '1', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"食品\";s:9:\"cat_color\";s:6:\"8ed515\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '1', '2', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"服饰\";s:9:\"cat_color\";s:6:\"ff9229\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('category', '', '/library/recommend_best.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('category', '', '/library/recommend_hot.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('category', '', '/library/recommend_promotion.lbi', '0', '0', '8', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('category', '', '/library/brands.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '6', '7', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"酒水\";s:9:\"cat_color\";s:6:\"84aeff\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '5', '6', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"家纺\";s:9:\"cat_color\";s:6:\"ffb901\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '4', '5', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"家电\";s:9:\"cat_color\";s:6:\"83cfff\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('exchange_list', '积分商城通栏广告', '/library/ad_position.lbi', '0', '49', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('exchange_list', '积分商城banner广告1', '/library/ad_position.lbi', '0', '44', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('exchange_list', '积分商城banner广告2', '/library/ad_position.lbi', '0', '45', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('exchange_list', '积分商城banner广告3', '/library/ad_position.lbi', '0', '46', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('exchange_list', '积分商城banner广告4', '/library/ad_position.lbi', '0', '47', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '3', '4', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"数码\";s:9:\"cat_color\";s:6:\"fe7a65\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '2', '3', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"化妆\";s:9:\"cat_color\";s:6:\"2abff7\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/group_buy.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/auction.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/brands.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('exchange_list', '', '/library/exchange_hot.lbi', '0', '0', '5', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('auction_list', '拍卖列表banner广告1', '/library/ad_position.lbi', '0', '51', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('auction_list', '拍卖列表banner广告2', '/library/ad_position.lbi', '0', '52', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('auction_list', '拍卖列表banner广告3', '/library/ad_position.lbi', '0', '53', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('auction_list', '拍卖列表banner广告4', '/library/ad_position.lbi', '0', '54', '1', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '首页店铺展示右侧广告', '/library/email_list.lbi', '0', '0', '0', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/recommend_new.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/recommend_hot.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/recommend_promotion.lbi', '0', '0', '4', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '', '/library/recommend_best.lbi', '0', '0', '3', '0', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/cat_goods.lbi', '7', '8', '0', '1', '68ecshopcom_360buy', '', 'a:2:{s:10:\"short_name\";s:6:\"母婴\";s:9:\"cat_color\";s:6:\"c87bff\";}');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '商品分类楼层', '/library/brand_goods.lbi', '8', '1', '5', '2', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '首页主广告右侧公告', '/library/cat_articles.lbi', '0', '19', '5', '3', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '首页店铺展示左侧广告', '/library/ad_position.lbi', '0', '6', '0', '4', '68ecshopcom_360buy', '', '');
INSERT INTO `ecs_template` ( `filename`, `region`, `library`, `sort_order`, `id`, `number`, `type`, `theme`, `remarks`, `ext_info` ) VALUES  ('index', '首页店铺展示右侧广告', '/library/ad_position.lbi', '0', '7', '1', '4', '68ecshopcom_360buy', '', '');
-- END ecshop v2.x SQL Dump Program 