/*
Navicat MySQL Data Transfer

Source Server         : local5.7
Source Server Version : 50720
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50720
File Encoding         : 65001

Date: 2018-06-19 23:00:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tp_admin`
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '管理员名称',
  `password` char(32) NOT NULL COMMENT '管理员密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `tp_admin` VALUES ('4', 'CT', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `tp_admin` VALUES ('5', 'FTlove', 'e10adc3949ba59abbe56e057f20f883e');

-- ----------------------------
-- Table structure for `tp_article`
-- ----------------------------
DROP TABLE IF EXISTS `tp_article`;
CREATE TABLE `tp_article` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(60) NOT NULL COMMENT '文件标题',
  `author` varchar(30) NOT NULL COMMENT '文章作者',
  `desc` varchar(255) NOT NULL COMMENT '文章简介',
  `keywords` varchar(255) NOT NULL COMMENT '文章关键词',
  `content` text NOT NULL COMMENT '文章内容',
  `pic` varchar(100) NOT NULL COMMENT '缩略图',
  `click` int(10) NOT NULL DEFAULT '0' COMMENT '点击数',
  `state` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:不推荐 1:推荐',
  `time` int(10) NOT NULL COMMENT '发布时间',
  `cateid` mediumint(9) NOT NULL COMMENT '所属栏目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_article
-- ----------------------------
INSERT INTO `tp_article` VALUES ('4', '123解析 写同花顺', '昌昌', '饿啊和欧谢', '12341345', '<p>12312312诶嘿从而撒诶和哦草 黑车车很给力诶胡搜额U型类型二还痛留学写一个<br/></p>', '/uploads/20170801\\64db6b0f4bb07c7c84750c8fcabd4c8c.PNG', '27', '1', '1501577051', '5');
INSERT INTO `tp_article` VALUES ('2', '百度1123', 'pjc', '151516', 'pjc', '<p>得分<br/></p>', '/uploads/20170801\\a8a832597164f3d0e92148bdb19869e0.jpg', '10', '1', '1501570924', '5');
INSERT INTO `tp_article` VALUES ('3', '百度1', '昌昌', '诶下仅此而已hi我IC吃哦', '及诶话我', '<p>诶系统会次斜体谢谢诶饿了地图搜艾海提挥洒都会佛为何<br/></p>', '/uploads/20170801\\79bcfd6c345553d994b3193f4347c757.png', '4', '1', '1501570982', '5');
INSERT INTO `tp_article` VALUES ('5', 'what the fuck', '123', '分接欧文', 'djfsojf', '<p>是滴粉底乳引入黄金分割红烧豆腐横杆<br/></p>', '', '3', '0', '1501647739', '5');
INSERT INTO `tp_article` VALUES ('6', '361', '123123', '', 'djfsojf', '<p>160494191651<br/></p>', '', '3', '0', '1501655957', '5');
INSERT INTO `tp_article` VALUES ('7', '测试', '123123', '是大范围', '测试,英文,数学', '<p>6419549845616</p><p><br/></p>', '', '0', '0', '1501655984', '5');
INSERT INTO `tp_article` VALUES ('8', '123123', '123', '', '123123', '<p>儿童版区<br/></p>', '', '2', '0', '1501656156', '5');
INSERT INTO `tp_article` VALUES ('9', 'qwee', '', '', 'ff', '<p>无的瑞芬太尼·<br/></p>', '', '0', '0', '1501656190', '5');
INSERT INTO `tp_article` VALUES ('10', 'qeqcs1', '昌昌', '佛网线哦诶下了联系横行了来写喜爱', '哦我西鞥', '<p>胜多负少从V型·写欧星给爱心类型哈吃了呢概述<br/></p>', '', '1', '0', '1501656206', '5');
INSERT INTO `tp_article` VALUES ('11', 'sdfsw1ascs', '昌昌', '我伺候过', '凤婷', '<p>阿尔法闻风丧胆发送·写好吧内些</p><p><br/></p>', '', '0', '0', '1501656224', '5');
INSERT INTO `tp_article` VALUES ('12', '是地方去玩uikyt1', '昌昌', '武汉擦示可U型可噶巨额', '给我好想偶尔会', '<p>撒大范围VB如何华为耦合犀利哥和我爱狗狗博柏拉图<br/></p>', '', '13', '0', '1501656245', '5');

-- ----------------------------
-- Table structure for `tp_cate`
-- ----------------------------
DROP TABLE IF EXISTS `tp_cate`;
CREATE TABLE `tp_cate` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '栏目id',
  `catename` varchar(30) NOT NULL COMMENT '栏目名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_cate
-- ----------------------------
INSERT INTO `tp_cate` VALUES ('1', 'FT');
INSERT INTO `tp_cate` VALUES ('3', '服装');
INSERT INTO `tp_cate` VALUES ('5', '数码');
INSERT INTO `tp_cate` VALUES ('10', '杂志');
INSERT INTO `tp_cate` VALUES ('12', '游戏');
INSERT INTO `tp_cate` VALUES ('13', '视频');

-- ----------------------------
-- Table structure for `tp_links`
-- ----------------------------
DROP TABLE IF EXISTS `tp_links`;
CREATE TABLE `tp_links` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT '链接id',
  `title` varchar(30) NOT NULL COMMENT '链接标题',
  `url` varchar(60) NOT NULL COMMENT '链接地址',
  `desc` varchar(255) NOT NULL COMMENT '链接说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_links
-- ----------------------------
INSERT INTO `tp_links` VALUES ('1', '百度', 'http://www.baidu.com', '百度网');
INSERT INTO `tp_links` VALUES ('3', '360', 'http://www.360.cn', '');
INSERT INTO `tp_links` VALUES ('4', '搜狗', 'http://123.sogou.com', '搜狗网');
INSERT INTO `tp_links` VALUES ('5', '优酷视频', 'http://www.youku.com/', '优酷视频网');
INSERT INTO `tp_links` VALUES ('6', '淘宝', 'http://www.taobao.com/', '淘宝网');
INSERT INTO `tp_links` VALUES ('7', '天猫', 'http://www.tmall.com', '天猫购物网');

-- ----------------------------
-- Table structure for `tp_tags`
-- ----------------------------
DROP TABLE IF EXISTS `tp_tags`;
CREATE TABLE `tp_tags` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'tag标签id',
  `tagname` varchar(30) NOT NULL COMMENT 'tag标签名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_tags
-- ----------------------------
INSERT INTO `tp_tags` VALUES ('1', '奇闻趣事');
INSERT INTO `tp_tags` VALUES ('2', '生活妙招');
INSERT INTO `tp_tags` VALUES ('3', '星座');
INSERT INTO `tp_tags` VALUES ('4', '亲子');
INSERT INTO `tp_tags` VALUES ('5', '汽车');
INSERT INTO `tp_tags` VALUES ('6', '宠物');
