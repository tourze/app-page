
SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `page_element`
-- ----------------------------
DROP TABLE IF EXISTS `page_element`;
CREATE TABLE `page_element` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'BLOCK ID',
  `entry_id` int(10) NOT NULL COMMENT '页面ID',
  `area` int(10) NOT NULL,
  `order` int(10) NOT NULL,
  `type` int(10) NOT NULL,
  `element` int(10) NOT NULL COMMENT '元素ID',
  `date_created` int(10) NOT NULL COMMENT '添加日期',
  `date_updated` int(10) DEFAULT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`),
  KEY `page_id` (`entry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COMMENT='页面-元素-关系';

-- ----------------------------
--  Records of `page_element`
-- ----------------------------
BEGIN;
INSERT INTO `page_element` VALUES ('7', '11', '1', '1', '1', '5', '0', '0'), ('41', '1', '1', '4', '1', '32', '1382891126', '1399473725');
COMMIT;

-- ----------------------------
--  Table structure for `page_element_content`
-- ----------------------------
DROP TABLE IF EXISTS `page_element_content`;
CREATE TABLE `page_element_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL COMMENT '名称，方便调用',
  `title` varchar(100) DEFAULT NULL COMMENT '一个简短的描述',
  `code` text NOT NULL,
  `markdown` int(1) unsigned NOT NULL DEFAULT '1',
  `twig` int(1) unsigned NOT NULL DEFAULT '1',
  `date_created` int(10) DEFAULT NULL,
  `date_updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `page_element_content`
-- ----------------------------
BEGIN;
INSERT INTO `page_element_content` VALUES ('5', null, '', '# 找不到该页面\n\nThe page could not be found.  You could try going [Home](/) or see our [Products](/products).\n\n{{ XunSec.status(404) }}', '1', '1', null, '1382857189'), ('32', null, '首页-个人简短说明', '<style type=\"text/css\">\n.blocks {\n	width: 800px;\n	margin: 0 auto;\n	margin-top: 50px;\n}\n.block {\n	float: left;\n	width: 180px;\n	height: 180px;\n	margin: 10px;\n	border-radius: 90px;\n	cursor: pointer;\n	background: #eee;\n	-moz-transition: all 0.3s ease;\n	-o-transition: all 0.3s ease;\n	-webkit-transition: all 0.3s ease;\n	-ms-transition: all 0.3s ease;\n	transition: all 0.3s ease;\n}\n.block:hover {\n	width: 190px;\n	height: 190px;\n	margin: 5px;\n	border-radius: 95px;\n}\n.block.text1 {\n	background: #ff5c5e;\n}\n.block.text2 {\n	background: #ffa12d;\n}\n.block.text3 {\n	background: #8fd400;\n}\n.block.text4 {\n	background: #0078c9;\n}\n</style>\n<div class=\"blocks\">\n	<div class=\"block text1\"></div>\n	<div class=\"block\"></div>\n	<div class=\"block text3\"></div>\n	<div class=\"block\"></div>\n\n	<div class=\"block\"></div>\n	<div class=\"block text2\"></div>\n	<div class=\"block\"></div>\n	<div class=\"block text4\"></div>\n</div>', '0', '0', '1382891126', '1399521662');
COMMIT;

-- ----------------------------
--  Table structure for `page_element_request`
-- ----------------------------
DROP TABLE IF EXISTS `page_element_request`;
CREATE TABLE `page_element_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL COMMENT '名称，方便调用啊',
  `title` varchar(100) DEFAULT NULL COMMENT '一个简短的描述',
  `url` text NOT NULL,
  `date_created` int(10) DEFAULT NULL,
  `date_updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `page_element_snippet`
-- ----------------------------
DROP TABLE IF EXISTS `page_element_snippet`;
CREATE TABLE `page_element_snippet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `code` text NOT NULL,
  `markdown` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `twig` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `date_created` int(10) DEFAULT NULL,
  `date_updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `page_element_snippet`
-- ----------------------------
BEGIN;
INSERT INTO `page_element_snippet` VALUES ('1', 'footer', '默认-底部', '<div class=\"container\">\n	<div class=\"inner clearfix\">\n		<ul class=\"text-right inline\">\n			<li class=\"title\">友情链接：</li>\n			<li><a href=\"http://www.bnuzer.com/\" target=\"_blank\">北师大珠海论坛</a></li>\n			<li><a href=\"http://sae.sina.com.cn\" target=\"_blank\">SAE开放平台</a></li>\n		</ul>\n		<p class=\"text-right\">© 2012-2014 转载内容请注明来源 <a href=\"http://www.gdufer.com/\">广金在线</a></p>\n	</div>\n</div>\n', '0', '0', null, '1399529625'), ('3', 'header', '默认-头部', '{{ Page.style(\'bootstrap/css/bootstrap.min.css\') }}\n{{ Page.style(\'bootstrap/css/bootstrap-responsive.min.css\') }}\n{{ Page.style(\'css/style.css\') }}\n{{ Page.style(\'css/style-responsive.css\') }}\n{{ Page.style(\'font-awesome/css/font-awesome.min.css\') }}\n{{ Page.script(\'jquery/jquery-1.7.2.min.js\') }}\n{{ Page.script(\'bootstrap/js/bootstrap.min.js\') }}\n{{ Page.script(\'js/script.js\') }}', '0', '1', null, '1398845912'), ('4', 'dashboard', '默认-仪表盘', '<div class=\"container\">\n	<div class=\"row-fluid\">\n		<div class=\"span4\">\n			<div class=\"col3_content\" markdown=\"1\">\n				#### 产品动态\n				*  [陈晨晨：选择途者，我节省了一半人工](#)\n				*  [我司产品购买人数达500家旅行社](#)\n				*  [XXX网对我司旅行社系统进行专评和测试](#)\n				*  [恭喜XXX旅行社获得我们的第一个测试资格](#)\n				*  [途者信息管理系统DEMO开放测试](http://www.baidu.com)\n			</div>\n		</div>\n		<div class=\"span4\">\n			<div class=\"col3_content\" markdown=\"1\">\n				#### 行业动态\n\n				*  [首个新旅游法合同出台:导游小费列入条款](#)\n				*  [泰国拟将清迈建成会展旅游城市，借此增收](#)\n				*  [台湾与云南进行“候鸟式”旅游合作](#)\n				*  [泰国旅游局首次来兰推介高品质泰国游产品](#)               \n				*  [江州区：吹响旅游业大发展号角](#)\n			</div>\n		</div>\n		<div class=\"span4\">\n			<div class=\"col3_content\" markdown=\"1\">\n				#### 途者优势\n\n				*  15人研发队伍和20名技术支持\n				*  市场覆盖率在南方占20%          \n				*  18小时售后服务和VIP定制服务\n				*  专注安全和稳定，系统100%安全\n				*  商业源码无加密，支持客户自定制\n			</div>\n		</div>\n	</div>\n</div>\n', '0', '0', null, '1399475566'), ('7', 'navigation', '默认-导航', '<div id=\"topnav\" class=\"navbar navbar-fixed-top\">\n	<div class=\"navbar-inner\">\n		<div class=\"container\">\n			<button type=\"button\" class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">\n				<span class=\"icon-bar\"></span>\n				<span class=\"icon-bar\"></span>\n				<span class=\"icon-bar\"></span>\n			</button>\n			<a class=\"brand\" href=\"/\">\n				<img src=\"/media/img/logo-title.png\" alt=\"\" height=\"24\">\n			</a>\n			<div class=\"nav-collapse collapse\">\n				{{ Page.main_nav() }}\n			</div>\n		</div>\n	</div>\n</div>', '0', '1', '1383829722', '1399519115');
COMMIT;

-- ----------------------------
--  Table structure for `page_entry`
-- ----------------------------
DROP TABLE IF EXISTS `page_entry`;
CREATE TABLE `page_entry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `name` varchar(128) NOT NULL,
  `layout_id` int(10) unsigned DEFAULT '0',
  `is_link` tinyint(1) unsigned DEFAULT '0',
  `show_map` tinyint(3) unsigned DEFAULT '1',
  `show_nav` tinyint(3) unsigned DEFAULT '1',
  `title` varchar(256) DEFAULT NULL,
  `metadesc` text,
  `metakw` text,
  `lft` int(10) unsigned DEFAULT NULL,
  `rgt` int(10) unsigned DEFAULT NULL,
  `lvl` int(10) unsigned DEFAULT NULL,
  `scope` int(10) unsigned DEFAULT NULL,
  `date_created` int(10) DEFAULT NULL,
  `date_updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Page-Layout` (`layout_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `page_entry`
-- ----------------------------
BEGIN;
INSERT INTO `page_entry` VALUES ('1', '0', '', '首页', '1', '0', '1', '1', '首页', 'Just For Fun.', 'PHP开发,计算机爱好者', '1', '8', '0', '1', null, '1399521324'), ('11', '1', 'error', '页面不存在', '1', '0', '0', '0', '找不到指定页面', '', '', '6', '7', '1', '1', null, '1399521324'), ('60', '1', 'gduf/mail.html', '校内邮箱', '1', '1', '1', '1', '校内邮箱', null, null, '2', '3', '1', '1', '1399521188', '1399521324'), ('61', '1', 'weibo-post.html', '广金树洞', '1', '1', '1', '1', '广金树洞', null, null, '4', '5', '1', '1', '1399521284', '1399521324');
COMMIT;

-- ----------------------------
--  Table structure for `page_layout`
-- ----------------------------
DROP TABLE IF EXISTS `page_layout`;
CREATE TABLE `page_layout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `desc` varchar(256) DEFAULT NULL,
  `code` text,
  `date_created` int(10) DEFAULT NULL,
  `date_updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `page_layout`
-- ----------------------------
BEGIN;
INSERT INTO `page_layout` VALUES ('1', 'default-one', '默认-单列布局', '默认使用的单页布局', '<div id=\"header\">\n   {{ Page.element(\'snippet\',\'header\') }}\n</div>\n<div id=\"navigation\">\n   {{ Page.element(\'snippet\',\'navigation\') }}\n</div>\n<div id=\"mainbox\" class=\"container\">\n	<div id=\"main-content\" class=\"row-fluid\">\n		<div class=\"span12\">\n			{{ Page.element_area(1,\'Main Column\') }}\n		</div>\n	</div>\n</div>\n<div id=\"footer\">\n   {{ Page.element(\'snippet\',\'footer\') }}\n</div>', null, '1399476073'), ('2', 'article-show', '文章显示布局', '两列的文章显示布局', '<div id=\"header\">\n   {{ Page.element(\'snippet\',\'header\') }}\n</div>\n<div id=\"navigation\">\n   {{ Page.element(\'snippet\',\'navigation\') }}\n</div>\n<div id=\"mainbox\" class=\"container\">\n	<div id=\"main-content\" class=\"row-fluid\">\n		<div id=\"main-content-data\" class=\"span8\">\n			<h1 class=\"text-center\">{{ Page.entry(\'title\') }}</h1>\n			<hr />\n			<div class=\"text-center\">\n				发布时间：{{ Page.entry(\'date_created\') | date(\'Y-m-d H:i\') }}\n			</div>\n			<hr />\n			{{ Page.element_area(1,\'Main Column\') }}\n		</div>\n		<div id=\"main-content-sidebar\" class=\"span4\">\n			{{ Page.element_area(2,\'Side Column\') }}\n			<!-- UY BEGIN -->\n			<div id=\"social-comment-wrapper\" data-spy=\"affix\" data-offset-top=\"80\">\n				<div id=\"uyan_frame\"></div>\n				<script type=\"text/javascript\" src=\"http://v2.uyan.cc/code/uyan.js?uid=1738661\"></script>\n			</div>\n			<!-- UY END -->\n		</div>\n	</div>\n</div>\n<div id=\"footer\">\n   {{ Page.element(\'snippet\',\'footer\') }}\n</div>', null, '1398845969'), ('4', 'blank', '空白页面', '空白页面空白页面空白页面', '<div id=\"header\">\n   {{ Page.element(\'snippet\',\'header\') }}\n</div>\n<div id=\"navigation\">\n   {{ Page.element(\'snippet\',\'navigation\') }}\n</div>\n<div id=\"mainbox\" class=\"container\">\n	<div id=\"main-content\" class=\"row-fluid\">\n		<div class=\"span12\">\n			{{ Page.content() }}\n		</div>\n	</div>\n</div>\n<div id=\"footer\">\n   {{ Page.element(\'snippet\',\'footer\') }}\n</div>', null, '1399477692'), ('6', 'category-show', '文章列表布局', '只显示下级文章，也就是只有一个列表啦', '<div id=\"header\">\n   {{ Page.element(\'snippet\',\'header\') }}\n</div>\n<div id=\"navigation\">\n   {{ Page.element(\'snippet\',\'navigation\') }}\n</div>\n<div id=\"mainbox\" class=\"container\">\n	<div id=\"main-content\" class=\"row-fluid\">\n		<div id=\"main-content-category-left\" class=\"span3\">\n			{{ Page.element_area(4, \'Left\') }}\n		</div>\n		<div id=\"main-content-category\" class=\"span6\">\n			{{ Page.element_area(6, \'Main Top\') }}\n			<ul id=\"main-content-category-list\" class=\"nav\">\n			{% set i = 0 %}\n			{% for item in Page.nav(\'sort=desc\', FALSE) %}\n				{% if i == 0 %}\n				<li class=\"text-center title\"><strong>{{ item.name }}</strong></li>\n				{% else %}\n				<li data-id=\"{{ item.id }}\">\n					<a href=\"{{ url_site(item.url) }}\">\n						{{ item.name }}\n						<span class=\"pull-right muted\">{{ item.date_created | date(\'Y-m-d H:i\') }}</span>\n					</a>\n				</li>\n				{% endif %}\n				{% set i = i+1 %}\n			{% endfor %}\n			</ul>\n			{{ Page.element_area(3, \'Main Bottom\') }}\n		</div>\n		<div id=\"main-content-category-left\" class=\"span3\">\n			{{ Page.element_area(5, \'Right\') }}\n		</div>\n	</div>\n</div>\n<div id=\"footer\">\n   {{ Page.element(\'snippet\',\'footer\') }}\n</div>', '1390640104', '1399477792');
COMMIT;

-- ----------------------------
--  Table structure for `page_redirect`
-- ----------------------------
DROP TABLE IF EXISTS `page_redirect`;
CREATE TABLE `page_redirect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `newurl` varchar(255) NOT NULL,
  `type` enum('301','302') NOT NULL DEFAULT '302',
  `date_created` int(10) DEFAULT NULL,
  `date_updated` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `page_redirect`
-- ----------------------------
BEGIN;
INSERT INTO `page_redirect` VALUES ('1', 'test', 'about', '302', '1399185242', '1399185242');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
