/*
Navicat MySQL Data Transfer

Source Server         : local5.7
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2018-06-19 18:49:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog_article`
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '//文章id',
  `art_title` varchar(100) NOT NULL DEFAULT '' COMMENT '//文章标题',
  `art_tag` varchar(100) NOT NULL DEFAULT '' COMMENT '//关键词',
  `art_description` varchar(255) NOT NULL DEFAULT '' COMMENT '//文章描述',
  `art_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '//缩略图',
  `art_content` text NOT NULL COMMENT '//文章内容',
  `art_time` int(11) NOT NULL DEFAULT '0' COMMENT '//发布时间',
  `art_editor` varchar(50) NOT NULL DEFAULT '' COMMENT '//作者',
  `art_view` int(11) NOT NULL DEFAULT '0' COMMENT '//查看次数',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '//分类id',
  PRIMARY KEY (`art_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='//文章';

-- ----------------------------
-- Records of blog_article
-- ----------------------------
INSERT INTO `blog_article` VALUES ('1', '鹿晗_晓彤', '明星恋爱', '啦啦啦，鹿晗-->晓彤~~~~', 'uploads/20180204172044339.png', '<p>出其不意，攻其不备的热恋呀，多少鹿粉操心呢~~~~</p>', '1517736372', 'pjc', '11', '4');
INSERT INTO `blog_article` VALUES ('2', '春节', '春节大吉', '新年快乐~~~', 'uploads/20180204172747268.png', '<p>又是一年春节啦，又长大了一岁啦，哈哈哈哈，很六~~</p>', '1517736489', 'pjc', '4', '1');
INSERT INTO `blog_article` VALUES ('3', '辽宁舰服役啦', '航母~~', '阔以阔以，中国军事变强大啦~~', 'uploads/20180206094807223.jpg', '<p>辽宁辽宁~~~~~</p>', '1517881725', 'pjc', '4', '5');
INSERT INTO `blog_article` VALUES ('4', '谢娜生了女儿', '谢娜', '谢娜生了女儿，大新闻', 'uploads/20180206123822863.PNG', '<p>大新闻呀，大新闻，张杰不是有闺女啦~~~</p>', '1517891977', 'pjc', '5', '9');
INSERT INTO `blog_article` VALUES ('5', '某某某彩票一百万', '彩票，体育', '中一百万彩票', 'uploads/20180206124014218.png', '<p>某某某买的新年第一注六合彩，就中了一百万，阔以，厉害，~~</p>', '1517892071', 'pjc', '8', '6');
INSERT INTO `blog_article` VALUES ('6', '嘉应某队获得足球比赛第一名', '足球比赛', '嘉应足球参赛队荣获第一名', 'uploads/20180206124152126.png', '<p>某年某月某日，嘉应参加了全国足球比赛，球员们全力以赴，获得了佳绩，斩获了第一名，可喜可贺~~~</p>', '1517892202', 'pjc', '1', '6');
INSERT INTO `blog_article` VALUES ('7', '中兴出新机啦，blade A3', '中兴，手机', '中兴又出新机啦~~~', 'uploads/20180206124415953.png', '<p>中兴又出了一款新的手机啦，A3它的新功能采用了最新的科技技术，手机可用性更加的强，强强~~</p>', '1517892354', 'pjc', '3', '4');
INSERT INTO `blog_article` VALUES ('8', '智能锁又有新花样啦', '智能锁，新花样', '智能锁，新花样，黑科技', 'uploads/20180206124630393.png', '<p>一款智能的，友好的门锁，人们可以通过手机APP开锁，密码开锁，钥匙开锁等等多样开锁方式，让人们不再担忧锁的问题啦。~~~</p>', '1517892518', 'pjc', '28', '1');

-- ----------------------------
-- Table structure for `blog_category`
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '//栏目id',
  `cate_name` varchar(50) NOT NULL DEFAULT '' COMMENT '//分类名称',
  `cate_title` varchar(255) NOT NULL DEFAULT '' COMMENT '//分类说明',
  `cate_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '//关键词',
  `cate_description` varchar(255) NOT NULL DEFAULT '' COMMENT '//描述',
  `cate_view` int(10) NOT NULL DEFAULT '0' COMMENT '//查看次数',
  `cate_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '//排序',
  `cate_pid` int(11) NOT NULL DEFAULT '0' COMMENT '//父级id',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='//文章分类';

-- ----------------------------
-- Records of blog_category
-- ----------------------------
INSERT INTO `blog_category` VALUES ('1', '新闻', '搜集国内外最新的新闻资讯', '', '', '6', '0', '0');
INSERT INTO `blog_category` VALUES ('2', '体育', '发展体育事业，增强国民体质', '体育*体育圈', '发展体育事业，增强国民体质', '2', '2', '0');
INSERT INTO `blog_category` VALUES ('3', '娱乐', '人人都有自己的娱乐圈', '', '', '0', '0', '0');
INSERT INTO `blog_category` VALUES ('4', '热点新闻', '最新新闻热点', '', '', '0', '0', '1');
INSERT INTO `blog_category` VALUES ('5', '军事新闻', '最新军事新闻', '', '', '0', '0', '1');
INSERT INTO `blog_category` VALUES ('6', '体育彩票', '最新体育彩票资讯', '', '', '0', '0', '2');
INSERT INTO `blog_category` VALUES ('7', '乐视体育', '最专业的体育平台', '', '', '0', '0', '2');
INSERT INTO `blog_category` VALUES ('9', '娱乐中心', '收集最新的娱乐动向', '娱乐*娱乐圈', '收集最新的娱乐动向', '0', '3', '3');

-- ----------------------------
-- Table structure for `blog_config`
-- ----------------------------
DROP TABLE IF EXISTS `blog_config`;
CREATE TABLE `blog_config` (
  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_title` varchar(50) NOT NULL DEFAULT '' COMMENT '//标题',
  `conf_name` varchar(50) NOT NULL DEFAULT '' COMMENT '//变量名',
  `conf_content` text NOT NULL COMMENT '//变量值',
  `conf_order` int(11) NOT NULL DEFAULT '0' COMMENT '//排序',
  `conf_tips` varchar(255) NOT NULL DEFAULT '' COMMENT '//描述',
  `field_type` varchar(50) NOT NULL DEFAULT '' COMMENT '//字段类型',
  `field_value` varchar(255) NOT NULL DEFAULT '' COMMENT '//类型值',
  PRIMARY KEY (`conf_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_config
-- ----------------------------
INSERT INTO `blog_config` VALUES ('1', '网站标题', 'web_title', '个人博客', '1', '网站大众化标题', 'input', '');
INSERT INTO `blog_config` VALUES ('2', '网站代码', 'web_count', '<a href=\"#\">百度统计</a>', '2', '网站访问统计', 'textarea', '');
INSERT INTO `blog_config` VALUES ('3', '网站状态', 'web_status', '0', '3', '网站状态开启', 'radio', '1|开启,0|关闭');
INSERT INTO `blog_config` VALUES ('5', '网站辅助标题', 'seo_title', 'PJCFT', '4', '对网站标题的补充说明', 'input', '');
INSERT INTO `blog_config` VALUES ('6', '关键词', 'keywords', '个人博客，博客', '5', '', 'input', '');
INSERT INTO `blog_config` VALUES ('7', '描述', 'description', '寻梦主题的个人博客，优雅、稳重、大气,低调', '6', '', 'input', '');
INSERT INTO `blog_config` VALUES ('8', '备注', 'copyright', 'Design by PJC <a href=\"#\" target=\"_blank\">http://www.xxxx.com(暂无)</a>', '7', '', 'textarea', '');

-- ----------------------------
-- Table structure for `blog_links`
-- ----------------------------
DROP TABLE IF EXISTS `blog_links`;
CREATE TABLE `blog_links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '//名称',
  `link_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '//标题',
  `link_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '//链接',
  `link_order` int(11) NOT NULL DEFAULT '0' COMMENT '//排序',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_links
-- ----------------------------
INSERT INTO `blog_links` VALUES ('1', '百度', '国内百度第一', 'http://www.baidu.com', '1');
INSERT INTO `blog_links` VALUES ('2', '百度一号', '国内百度第一（first）', 'http://www.baidu.com', '2');
INSERT INTO `blog_links` VALUES ('4', '百度', 'baidu', 'http://www.baidu.com', '0');

-- ----------------------------
-- Table structure for `blog_migrations`
-- ----------------------------
DROP TABLE IF EXISTS `blog_migrations`;
CREATE TABLE `blog_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_migrations
-- ----------------------------
INSERT INTO `blog_migrations` VALUES ('2018_02_04_191639_create_links_table', '1');

-- ----------------------------
-- Table structure for `blog_navs`
-- ----------------------------
DROP TABLE IF EXISTS `blog_navs`;
CREATE TABLE `blog_navs` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(50) NOT NULL DEFAULT '' COMMENT '//导航名',
  `nav_alias` varchar(50) NOT NULL DEFAULT '' COMMENT '//别名',
  `nav_url` varchar(255) NOT NULL DEFAULT '' COMMENT '//URL',
  `nav_order` int(11) NOT NULL DEFAULT '0' COMMENT '//排序',
  PRIMARY KEY (`nav_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_navs
-- ----------------------------
INSERT INTO `blog_navs` VALUES ('1', '首页', 'Protal', 'http://blog.hd', '1');
INSERT INTO `blog_navs` VALUES ('4', '关于我', 'About', 'http://', '2');
INSERT INTO `blog_navs` VALUES ('5', '慢生活', 'Life', 'http://', '3');
INSERT INTO `blog_navs` VALUES ('6', '碎言碎语', 'Doing', 'http://', '4');
INSERT INTO `blog_navs` VALUES ('7', '模板分享', 'Share', 'http://', '5');
INSERT INTO `blog_navs` VALUES ('8', '学无止境', 'Learn', 'http://', '6');
INSERT INTO `blog_navs` VALUES ('9', '留言版', 'Gustbook', 'http://', '7');

-- ----------------------------
-- Table structure for `blog_user`
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '//用户id',
  `user_name` varchar(50) NOT NULL DEFAULT '' COMMENT '//用户名',
  `user_pass` varchar(255) NOT NULL DEFAULT '' COMMENT '//密码',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='//管理员';

-- ----------------------------
-- Records of blog_user
-- ----------------------------
INSERT INTO `blog_user` VALUES ('1', 'admin', 'eyJpdiI6IlFqdWQzME5KOTFoZWRtNlwvUVNXZVwvdz09IiwidmFsdWUiOiI0OGxMVXA3QjBRSFpLY0h1VVljaVhRPT0iLCJtYWMiOiJhNDQxMjVkOTk5ZGZkOGE2YzZmMGVmYWJlZWQ2Zjc0OWI0Nzg1MzEyOWEzMGFmN2U4ODY2ZGY2ZjA2Njg2ZWM3In0=');
INSERT INTO `blog_user` VALUES ('2', 'admin123', 'eyJpdiI6InN4MWdsV0hwVTM0MXkrNE1uaGRUOFE9PSIsInZhbHVlIjoiWHQ2WnIxU2U2clB5NEZjaDRyZkNqUT09IiwibWFjIjoiNWJjOWMwY2Q0ZDY2N2JmNzI0ZDFmZDcwYTVhYTc2NDA0YmJlNGNhOGM5OGE4ZDU4NDlkN2EzYjBjZjgyZDE0NCJ9');
INSERT INTO `blog_user` VALUES ('3', 'admin111', 'eyJpdiI6IlFXc2NJRGtkMVhHTU9sc1lTTmFxTXc9PSIsInZhbHVlIjoiR0hRODNpeGo2XC9FUEdtaXd4Sis1elE9PSIsIm1hYyI6ImM1NGFlOTZlMTc3MzNiZTk1MWY4MzE2YjAzNjkzOGI1YmU0MGQ2MzJhODFmYTRhZjUwNjk1ZjU0ZjNlNGUzZjMifQ==');
INSERT INTO `blog_user` VALUES ('6', 'pjccft', 'eyJpdiI6InVNeDh3T3puSXVRbGx0dGNJV3lmU0E9PSIsInZhbHVlIjoiVGhjUHQ1ZmhmeFE5a09HalV6MWl0dz09IiwibWFjIjoiMDBkNjI5NjJmNTQ0NmVhOTZjYWFlMmE2NTA1OTQ2YjQ1MDJlZTFmODc3MjZjMzQ3NzdiNmRhZTczODMxNmE2YiJ9');
