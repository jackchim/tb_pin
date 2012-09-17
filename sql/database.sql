
-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_advert`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_advert` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_title` varchar(255) NOT NULL,
  `ad_photo` varchar(255) DEFAULT NULL,
  `ad_url` varchar(255) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `display_order` int(11) DEFAULT '100',
  `ad_position` int(11) DEFAULT NULL,
  PRIMARY KEY (`ad_id`),
  KEY `idx_ad_position` (`ad_position`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_advert`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_album`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `total_share` int(11) NOT NULL DEFAULT '0',
  `total_favorite` int(11) NOT NULL COMMENT '喜欢次数',
  `is_system` int(11) NOT NULL DEFAULT '0',
  `is_show` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`album_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_is_system` (`is_system`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `{dbprefix}tupu_album`
--

INSERT INTO `{dbprefix}tupu_album` (`album_id`, `category_id`, `title`, `create_time`, `update_time`, `user_id`, `cover`, `total_share`, `total_favorite`, `is_system`, `is_show`) VALUES
(1, 5, '系统管理员的专辑', '2012-06-28 20:33:49', 0, 1, 'data/images/album_bg.jpg', 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_category`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name_cn` varchar(80) NOT NULL,
  `category_name_en` varchar(80) NOT NULL,
  `is_system` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `idx_category_name_en` (`category_name_en`),
  KEY `idx_is_system` (`is_system`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `{dbprefix}tupu_category`
--

INSERT INTO `{dbprefix}tupu_category` (`category_id`, `category_name_cn`, `category_name_en`, `is_system`) VALUES
(1, '包包', 'baobao', 0),
(2, '配饰', 'peishi', 0),
(3, '服装', 'fuzhuang', 0),
(4, '鞋子', 'xiezi', 0),
(5, '其它', 'default', 1),
(12, '美妆', 'meizhuang', 0);

-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_comment`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `poster_uid` int(11) NOT NULL COMMENT '评论者id',
  `share_id` int(11) DEFAULT NULL,
  `post_time` varchar(11) NOT NULL DEFAULT '0',
  `poster_nickname` varchar(80) NOT NULL,
  `poster_avatar` varchar(255) DEFAULT NULL,
  `comment` text,
  `is_show` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 默认，1审核通过，2，屏蔽',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否删除，0没有，1删除',
  PRIMARY KEY (`comment_id`),
  KEY `poster_uid` (`poster_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_comment`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_connector`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_connector` (
  `connect_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `social_userid` varchar(100) NOT NULL,
  `vendor` varchar(40) NOT NULL,
  `vendor_info` text NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `username` varchar(80) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `homepage` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `location` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`connect_id`),
  UNIQUE KEY `idx_socialuser` (`social_userid`,`vendor`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_connector`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_favorite_album`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_favorite_album` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_album_id` (`album_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_favorite_album`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_favorite_sharing`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_favorite_sharing` (
  `favorite_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_share_id` (`share_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_favorite_sharing`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_follow`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_follow` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `friend_status` tinyint(4) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  PRIMARY KEY (`follow_id`),
  UNIQUE KEY `idx_noduplicate` (`user_id`,`friend_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_friend_id` (`friend_id`),
  KEY `idx_friend_status` (`friend_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `{dbprefix}tupu_follow`
--

INSERT INTO `{dbprefix}tupu_follow` (`follow_id`, `friend_status`, `user_id`, `friend_id`) VALUES
(1, 1, 4, 4),
(2, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_item`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `intro` text NOT NULL,
  `intro_search` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `share_type` varchar(20) NOT NULL,
  `share_attribute` text,
  `price` float DEFAULT NULL,
  `is_show` tinyint(4) NOT NULL,
  `reference_url` varchar(255) NOT NULL,
  `reference_itemid` varchar(30) DEFAULT NULL,
  `reference_channel` varchar(255) DEFAULT NULL,
  `promotion_url` varchar(255) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_is_show` (`is_show`),
  KEY `idx_referenct` (`reference_channel`,`reference_itemid`),
  FULLTEXT KEY `idx_intro_search` (`intro_search`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_item`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_report`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `port_userid` int(11) NOT NULL,
  `content` text COMMENT '投诉内容',
  `datetime` varchar(32) NOT NULL DEFAULT '',
  `report_type` varchar(12) NOT NULL DEFAULT 'comment' COMMENT '举报或投诉类型,comment是评论类型',
  `is_deal` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未处理',
  PRIMARY KEY (`report_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_report`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_share`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_share` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `poster_id` int(11) NOT NULL,
  `poster_nickname` varchar(80) DEFAULT NULL,
  `original_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `user_nickname` varchar(80) DEFAULT NULL,
  `total_comments` int(11) DEFAULT NULL,
  `total_likes` int(11) DEFAULT NULL,
  `total_forwarding` int(11) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` text,
  `is_del` int(11) NOT NULL,
  PRIMARY KEY (`share_id`),
  KEY `idx_item` (`item_id`),
  KEY `idx_poster_id` (`poster_id`),
  KEY `idx_original_id` (`original_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_album_id` (`album_id`),
  KEY `idx_create_time` (`create_time`),
  KEY `idx_total_comments` (`total_comments`),
  KEY `idx_total_likes` (`total_likes`),
  KEY `idx_total_forwarding` (`total_forwarding`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `{dbprefix}tupu_share`
--


-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_tag`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `tag_group_name_cn` varchar(80) NOT NULL,
  `tag_group_name_en` varchar(80) NOT NULL,
  `tags` text NOT NULL,
  `display_order` int(11) DEFAULT '100',
  PRIMARY KEY (`tag_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_display_order` (`display_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `{dbprefix}tupu_tag`
--

INSERT INTO `{dbprefix}tupu_tag` (`tag_id`, `category_id`, `tag_group_name_cn`, `tag_group_name_en`, `tags`, `display_order`) VALUES
(2, 4, '当季热款', 'hot', '系带,坡跟,铆钉,粗跟,尖头,防水台,拼接,豹纹,流苏,玛丽珍鞋,圆头,方头,厚底,细跟', 100),
(3, 1, '当季热款', 'hot', '编织包,钱包,斜挎包,单肩包,双肩包,手拿包,手提包,复古包,帆布包,水桶包,晚宴包,相机包,信封包', 100),
(18, 1, '当季流行', '0', '撞色,外贸,拼接,豹纹,链条,蝴蝶结,铆钉,水钻,复古,菱形格,代购,甜美', 100),
(6, 3, '当季热款', 'hot', '连衣裙,背心,T恤,衬衫,长裙,吊带裙,西装,开衫,打底衫,雪纺衫,短裙,连体裤,半身裙,短裤,防晒衫,罩衫,小脚裤,背心裙,背带裤,哈伦裤,包臀裙,裙裤', 100),
(8, 2, '当季热款', 'hot', '项链,手表,耳钉,发箍,耳环,手链,钥匙链,细腰带,发圈,墨镜,戒指,发饰,镜框,丝袜,腰带,手镯,字母项链,脚链,腰封,胸针,假领子', 100),
(17, 5, '小物', '0', '遮阳伞,手机壳,马克杯,加湿器,风扇,首饰盒,抱枕,贴纸,玩偶,LOMO,文具,本子,钥匙扣', 100),
(10, 2, '当季流行', 'pop', '发带,袜套,军帽,草帽,吊坠,锁骨链,头巾,假领,草编帽,遮阳帽,宽沿帽,怀表,马术帽', 100),
(11, 2, '热门风格', 'style', '日系,个性,朋克,摇滚,欧美,甜美', 100),
(19, 3, '当季流行', '0', '几何,雪纺,蕾丝,娃娃领,露肩,碎花,透视,纯色,印花,撞色,渐变,豹纹,格子', 100),
(20, 4, '当季流行', '0', '名媛,复古,英伦,甜美,朋克,性感,欧美,日系,优雅', 100),
(21, 12, '功效', '0', '美白,保湿,祛痘,抗敏,遮瑕,祛斑,控油,补水,去黑头,收毛孔,去眼袋', 100),
(22, 12, '护肤', '0', '防晒霜,喷雾,卸妆油,洗面奶,面膜,眼霜,化妆水,面霜,隔离霜,吸油面纸,药妆', 100),
(23, 12, '彩妆', '0', '香水,指甲油,睫毛膏,BB霜,粉饼,蜜粉,口红,腮红,眼影,眉笔,唇彩,眼线膏', 100),
(24, 5, '家居', '0', '书柜,烛台,墙贴,摆件,桌布,落地灯,台灯,时钟,吊灯,吸顶灯,杯子,置物架,香薰,地毯,收纳', 100);

-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_user`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `nickname` varchar(80) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `province` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `bio` varchar(255) NOT NULL,
  `domain` varchar(20) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_follows` int(11) DEFAULT '0',
  `total_followers` int(11) DEFAULT '0',
  `total_shares` int(11) DEFAULT '0',
  `total_albums` int(11) DEFAULT '0',
  `total_favorite_shares` int(11) DEFAULT '0',
  `total_favorite_albums` int(11) DEFAULT '0',
  `total_view` int(9) NOT NULL,
  `view_detail` text NOT NULL,
  `avatar_local` varchar(255) DEFAULT NULL,
  `avatar_remote` varchar(255) DEFAULT NULL,
  `lost_password_key` varchar(40) NOT NULL,
  `lost_password_expire` int(11) NOT NULL,
  `is_social` tinyint(4) NOT NULL DEFAULT '0',
  `user_type` tinyint(4) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `is_forbidden` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户禁言，0，不禁言,1,禁言48小时,2,永久禁言',
  `forbiden_time` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_login` (`email`,`passwd`),
  KEY `idx_nickname` (`nickname`),
  KEY `idx_lost_password_key` (`lost_password_key`),
  KEY `idx_email` (`email`),
  KEY `domain` (`domain`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `{dbprefix}tupu_user`
--

INSERT INTO `{dbprefix}tupu_user` (`user_id`, `email`, `passwd`, `nickname`, `gender`, `province`, `city`, `location`, `bio`, `domain`, `is_active`, `create_time`, `total_follows`, `total_followers`, `total_shares`, `total_albums`, `total_favorite_shares`, `total_favorite_albums`, `total_view`, `view_detail`, `avatar_local`, `avatar_remote`, `lost_password_key`, `lost_password_expire`, `is_social`, `user_type`, `is_deleted`, `is_forbidden`, `forbiden_time`) VALUES
(1, 'admin@admin.com', 'e99a18c428cb38d5f260853678922e03', '系统管理员', NULL, NULL, NULL, NULL, '', '', 1, '2012-06-28 20:33:49', 0, 0, 0, 0, 0, 0, 0, '', 'data/avatars/000/00/00/01_avatar', NULL, '', 0, 0, 3, 0, 0, NULL);

-- {v100} ---

ALTER TABLE `{dbprefix}tupu_album` CHANGE `total_favorite` `total_favorite` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '喜欢次数';
ALTER TABLE `{dbprefix}tupu_item` CHANGE `is_show` `is_show` TINYINT( 4 ) NOT NULL DEFAULT '1';
ALTER TABLE `{dbprefix}tupu_item` CHANGE `reference_url` `reference_url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `{dbprefix}tupu_share` CHANGE `is_del` `is_del` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `{dbprefix}tupu_user` CHANGE `is_active` `is_active` TINYINT( 4 ) NOT NULL DEFAULT '1';
ALTER TABLE `{dbprefix}tupu_user` CHANGE `bio` `bio` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `{dbprefix}tupu_user` CHANGE `domain` `domain` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `{dbprefix}tupu_user` CHANGE `total_view` `total_view` INT( 9 ) NOT NULL DEFAULT '0';
ALTER TABLE `{dbprefix}tupu_user` CHANGE `view_detail` `view_detail` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `{dbprefix}tupu_user` CHANGE `lost_password_key` `lost_password_key` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `{dbprefix}tupu_share` CHANGE `poster_id` `poster_id` INT( 11 ) NULL;
ALTER TABLE `{dbprefix}tupu_share` CHANGE `total_likes` `total_likes` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `{dbprefix}tupu_share` CHANGE `total_comments` `total_comments` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `{dbprefix}tupu_album` CHANGE `update_time` `update_time` INT( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE `{dbprefix}tupu_item` CHANGE `share_type` `share_type` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'image';
ALTER TABLE `{dbprefix}tupu_share` CHANGE `total_forwarding` `total_forwarding` INT( 11 ) NOT NULL DEFAULT '0';


ALTER TABLE `{dbprefix}tupu_user` CHANGE `lost_password_expire` `lost_password_expire` INT( 11 ) NULL;
ALTER TABLE `{dbprefix}tupu_tag` CHANGE `category_id` `category_id` INT( 11 ) NOT NULL DEFAULT '0',
CHANGE `tag_group_name_cn` `tag_group_name_cn` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE `tag_group_name_en` `tag_group_name_en` VARCHAR( 80 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE `tags` `tags` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;
ALTER TABLE `{dbprefix}tupu_report` CHANGE `datetime` `datetime` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0';
ALTER TABLE `{dbprefix}tupu_item` CHANGE `intro_search` `intro_search` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;


-- {v105}--------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_page_view`
--
CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_page_view` (
  `id` bigint(9) NOT NULL AUTO_INCREMENT,
  `page_url` varchar(255) NOT NULL COMMENT '访问页面的url',
  `form_url` varchar(255) NOT NULL COMMENT '来源页面的url',
  `client_ip` char(24) NOT NULL COMMENT '用户ip',
  `u_id` int(9) NOT NULL DEFAULT '0' COMMENT '用户id，id-0游客，id > 0注册用户',
  `view_time` int(11) NOT NULL COMMENT '访问时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='访问记录表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `{dbprefix}tupu_active_user`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_active_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_time` varchar(11) NOT NULL DEFAULT '',
  `uid` int(11) NOT NULL,
  `nickname` varchar(80) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`login_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `{dbprefix}tupu_album` ADD `top` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '置顶操作，已时间为值，倒序排列' AFTER `is_show`;
ALTER TABLE `{dbprefix}tupu_favorite_sharing` ADD `share_time` varchar(11) NOT NULL DEFAULT  '' comment '分享的时间'; 
ALTER TABLE `{dbprefix}tupu_share` add `total_click` int not null default 0 comment '该item点击数';
ALTER TABLE `{dbprefix}tupu_share` add `total_click_taobao` int not null default 0 comment '该item点击到淘宝的点击数';

-- {v110}--------------------------------------------------------


-- {v120}--------------------------------------------------------
--
-- 表的结构 `{dbprefix}tupu_friendlink`
--

CREATE TABLE IF NOT EXISTS `{dbprefix}tupu_friendlink` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `link_title` varchar(64) NOT NULL,
  `link_url` varchar(124) NOT NULL,
  `link_target` char(12) NOT NULL,
  `display_order` int(4) NOT NULL DEFAULT '255',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `{dbprefix}tupu_user` ADD `is_friend_recommend` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT '是否过推荐关注0-可以给用户推荐，1-不推荐用户关注了';
-- {v121}--------------------------------------------------------
ALTER TABLE `{dbprefix}tupu_item` CHANGE `promotion_url` `promotion_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

-- {v130}--------------------------------------------------------
ALTER TABLE `{dbprefix}tupu_item` ADD `image_count` SMALLINT( 2 ) NOT NULL DEFAULT '1' COMMENT '图片数' AFTER `image_path` ,
ADD `is_remote_image` TINYINT NOT NULL DEFAULT '0' COMMENT '是否为远程图片' AFTER `image_count` ;
ALTER TABLE `{dbprefix}tupu_item` CHANGE `image_path` `image_path` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;
ALTER TABLE `{dbprefix}tupu_item` CHANGE `reference_url` `reference_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `promotion_url` `promotion_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

ALTER TABLE `{dbprefix}tupu_page_view` CHANGE `page_url` `page_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '访问页面的url',
CHANGE `form_url` `form_url` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源页面的url';

ALTER TABLE `{dbprefix}tupu_user` CHANGE `gender` `gender` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'none';