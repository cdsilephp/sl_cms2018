/*
 Navicat MySQL Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : localhost
 Source Database       : sl_cms

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : utf-8

 Date: 01/29/2019 14:50:09 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sl_admin`
-- ----------------------------
DROP TABLE IF EXISTS `sl_admin`;
CREATE TABLE `sl_admin` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `email` varchar(50) NOT NULL COMMENT '电子邮件',
  `nickname` varchar(50) DEFAULT NULL COMMENT '昵称',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态',
  `verify` varchar(32) DEFAULT NULL COMMENT '验证串',
  `isadmin` tinyint(1) unsigned DEFAULT '0' COMMENT '是否为管理员',
  `last_login_time` varchar(250) DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(15) DEFAULT NULL COMMENT '最后登录ip',
  `login_count` mediumint(8) unsigned DEFAULT '0' COMMENT '登录统计',
  `create_time` int(11) unsigned NOT NULL COMMENT '记录创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '记录更新时间',
  `pic` varchar(100) DEFAULT NULL COMMENT '头像',
  `group_id` int(11) DEFAULT NULL,
  `id` int(10) unsigned zerofill DEFAULT NULL,
  `cun_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username_index` (`username`) COMMENT '(null)'
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表';

-- ----------------------------
--  Records of `sl_admin`
-- ----------------------------
BEGIN;
INSERT INTO `sl_admin` VALUES ('23', 'cdsile', '01ac3d95a020811609ceef9ed8336e2e', 'wahson-gong@outlook.com', '思乐管理员', '', '1', '', '0', '2019-01-28 02:30:14', '127.0.0.1', '0', '1509730011', '0', 'public/uploads/20180702/201807021343565b39bb9c7397a.png', '1', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `sl_ceshi`
-- ----------------------------
DROP TABLE IF EXISTS `sl_ceshi`;
CREATE TABLE `sl_ceshi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `xingming` char(100) DEFAULT NULL COMMENT '姓名',
  `test` char(100) NOT NULL COMMENT 'test',
  `test2` char(100) NOT NULL COMMENT 'test2',
  `test3` char(100) NOT NULL COMMENT 'test3',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='sl_ceshi模型主表';

-- ----------------------------
--  Table structure for `sl_filed`
-- ----------------------------
DROP TABLE IF EXISTS `sl_filed`;
CREATE TABLE `sl_filed` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` varchar(50) DEFAULT ' ' COMMENT '模型id',
  `u1` varchar(50) DEFAULT ' ' COMMENT '数据库字段名',
  `u2` varchar(50) DEFAULT ' ' COMMENT '字段名称',
  `u3` varchar(50) DEFAULT ' ' COMMENT '字段提示',
  `u4` varchar(10) DEFAULT '否' COMMENT '是否必填',
  `u5` varchar(10) DEFAULT '否' COMMENT '是否显示',
  `u6` varchar(10) DEFAULT '否' COMMENT '是否检索',
  `u7` varchar(50) DEFAULT '文本框' COMMENT '字段类型',
  `u8` varchar(250) DEFAULT ' ' COMMENT '默认值',
  `u9` varchar(50) DEFAULT '80' COMMENT '列表CSS',
  `u10` int(10) DEFAULT '0' COMMENT '排序',
  `u11` char(50) DEFAULT '否' COMMENT '是否排序',
  `u12` char(50) DEFAULT 'left' COMMENT '所在位置',
  `u13` char(50) DEFAULT '' COMMENT '点击事件',
  `u14` varchar(250) DEFAULT NULL COMMENT '正则验证规则',
  `u15` varchar(250) DEFAULT '基础参数' COMMENT '字段显示分类',
  `u16` char(50) DEFAULT '是' COMMENT '是否导出',
  `u17` char(50) DEFAULT 'all' COMMENT '全局接口访问权限（all,add,edit,del,search）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_filed`
-- ----------------------------
BEGIN;
INSERT INTO `sl_filed` VALUES ('21', '8', 'dtime', '添加时间', '', '否', '否', '否', '时间框', 'CURRENT_TIMESTAMP', '80', '2', '否', 'left', '', null, '基础参数', '是', 'all'), ('22', '8', 'xingming', '姓名', '', '否', '是', '否', '文本框', '', '80', '0', '否', '', '', '无', '基础参数', '是', 'all'), ('23', '8', 'test', 'test', '', '是', '是', '否', '文本框', '', '80', '0', '否', '', '', '无', '基础参数', '是', 'all'), ('24', '8', 'test2', 'test2', '', '是', '是', '否', '文本框', '', '80', '0', '否', '', '', '无', '基础参数', '是', 'edit'), ('25', '8', 'test3', 'test3', '', '是', '是', '否', '文本框', '', '80', '0', '否', '', '', '无', '基础参数', '是', '');
COMMIT;

-- ----------------------------
--  Table structure for `sl_goodsparameter`
-- ----------------------------
DROP TABLE IF EXISTS `sl_goodsparameter`;
CREATE TABLE `sl_goodsparameter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` varchar(10) CHARACTER SET utf8 DEFAULT '0' COMMENT '上级ID',
  `u1` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '规格说明',
  `u2` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '规格',
  `u3` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '图标',
  `u4` tinyint(50) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=371 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_goodsparameter`
-- ----------------------------
BEGIN;
INSERT INTO `sl_goodsparameter` VALUES ('355', '0', '手机', '', ' ', '0'), ('357', '355', '网络', '', ' ', '0'), ('358', '355', '颜色', '', ' ', '1'), ('359', '355', '内存', '', ' ', '2'), ('360', '357', '电信', '', ' ', '0'), ('361', '357', '移动', '', ' ', '1'), ('362', '357', '联通', '', ' ', '2'), ('363', '358', '黑色', '', ' ', '0'), ('364', '358', '白色', '', ' ', '1'), ('365', '359', '32G', '', ' ', '0'), ('366', '359', '64G', '', ' ', '1'), ('367', '359', '128G', '', ' ', '2'), ('370', '0', '其他', '', ' ', '1');
COMMIT;

-- ----------------------------
--  Table structure for `sl_goodsparameter_item`
-- ----------------------------
DROP TABLE IF EXISTS `sl_goodsparameter_item`;
CREATE TABLE `sl_goodsparameter_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goodsparameter_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品规格ID',
  `goodsparameter_name` varchar(100) CHARACTER SET utf8 DEFAULT ' ' COMMENT '商品规格NAME',
  `goodsnumber` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '商品编号',
  `goodsparameter_classid` int(11) DEFAULT NULL COMMENT '规格父级ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_goodsparameter_item`
-- ----------------------------
BEGIN;
INSERT INTO `sl_goodsparameter_item` VALUES ('1', '357', '网络', '2018112345721', '355'), ('2', '358', '颜色', '2018112345721', '355'), ('3', '360', '电信', '2018112345721', '357'), ('4', '361', '移动', '2018112345721', '357'), ('5', '362', '联通', '2018112345721', '357'), ('6', '363', '黑色', '2018112345721', '358'), ('7', '364', '白色', '2018112345721', '358'), ('8', '358', '颜色', '2018112309292', '355'), ('9', '359', '内存', '2018112309292', '355'), ('10', '363', '黑色', '2018112309292', '358'), ('11', '364', '白色', '2018112309292', '358'), ('12', '365', '32G', '2018112309292', '359'), ('13', '366', '64G', '2018112309292', '359'), ('14', '367', '128G', '2018112309292', '359'), ('15', '357', '网络', '2018112313230', '355'), ('16', '358', '颜色', '2018112313230', '355'), ('17', '360', '电信', '2018112313230', '357'), ('18', '361', '移动', '2018112313230', '357'), ('19', '362', '联通', '2018112313230', '357'), ('20', '363', '黑色', '2018112313230', '358'), ('21', '364', '白色', '2018112313230', '358'), ('22', '357', '网络', '2018112347632', '355'), ('23', '358', '颜色', '2018112347632', '355'), ('24', '360', '电信', '2018112347632', '357'), ('25', '361', '移动', '2018112347632', '357'), ('26', '362', '联通', '2018112347632', '357'), ('27', '363', '黑色', '2018112347632', '358'), ('28', '364', '白色', '2018112347632', '358'), ('29', '357', '网络', '2018112331795', '355'), ('30', '358', '颜色', '2018112331795', '355'), ('31', '360', '电信', '2018112331795', '357'), ('32', '361', '移动', '2018112331795', '357'), ('33', '362', '联通', '2018112331795', '357'), ('34', '363', '黑色', '2018112331795', '358'), ('35', '364', '白色', '2018112331795', '358'), ('54', '357', '网络', '2018112375797', '355'), ('55', '358', '颜色', '2018112375797', '355'), ('56', '359', '内存', '2018112375797', '355'), ('57', '360', '电信', '2018112375797', '357'), ('58', '361', '移动', '2018112375797', '357'), ('59', '362', '联通', '2018112375797', '357'), ('60', '363', '黑色', '2018112375797', '358'), ('61', '364', '白色', '2018112375797', '358'), ('62', '365', '32G', '2018112375797', '359'), ('63', '366', '64G', '2018112375797', '359'), ('64', '367', '128G', '2018112375797', '359'), ('78', '357', '网络', '2018112416624', '355'), ('79', '358', '颜色', '2018112416624', '355'), ('80', '360', '电信', '2018112416624', '357'), ('81', '361', '移动', '2018112416624', '357'), ('82', '362', '联通', '2018112416624', '357'), ('83', '363', '黑色', '2018112416624', '358'), ('84', '364', '白色', '2018112416624', '358'), ('89', '357', '网络', '2018112491650', '355'), ('90', '359', '内存', '2018112491650', '355'), ('91', '360', '电信', '2018112491650', '357'), ('92', '361', '移动', '2018112491650', '357'), ('93', '362', '联通', '2018112491650', '357'), ('94', '365', '32G', '2018112491650', '359'), ('95', '367', '128G', '2018112491650', '359');
COMMIT;

-- ----------------------------
--  Table structure for `sl_goodsprice`
-- ----------------------------
DROP TABLE IF EXISTS `sl_goodsprice`;
CREATE TABLE `sl_goodsprice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_number` varchar(100) CHARACTER SET utf8 DEFAULT ' ' COMMENT '商品编号',
  `goodsparameter_names` varchar(100) CHARACTER SET utf8 DEFAULT ' ' COMMENT '商品规格全称',
  `goodsparameter_ids` varchar(100) CHARACTER SET utf8 DEFAULT ' ' COMMENT '商品规格IDs',
  `goods_price` float unsigned NOT NULL DEFAULT '0' COMMENT '商品价格',
  `goods_stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_goodsprice`
-- ----------------------------
BEGIN;
INSERT INTO `sl_goodsprice` VALUES ('7', '2018112309292', '黑色,32G', '363,365', '0', '0'), ('8', '2018112309292', '黑色,64G', '363,366', '0', '0'), ('9', '2018112309292', '黑色,128G', '363,367', '0', '0'), ('10', '2018112309292', '白色,32G', '364,365', '0', '0'), ('11', '2018112309292', '白色,64G', '364,366', '0', '0'), ('12', '2018112309292', '白色,128G', '364,367', '0', '0'), ('13', '2018112313230', '电信,黑色', '360,363', '10', '10'), ('14', '2018112313230', '电信,白色', '360,364', '10', '10'), ('15', '2018112313230', '移动,黑色', '361,363', '10', '10'), ('16', '2018112313230', '移动,白色', '361,364', '10', '10'), ('17', '2018112313230', '联通,黑色', '362,363', '10', '10'), ('18', '2018112313230', '联通,白色', '362,364', '10', '10'), ('25', '2018112347632', '电信,黑色', '360,363', '120', '100'), ('26', '2018112347632', '电信,白色', '360,364', '120', '100'), ('27', '2018112347632', '移动,黑色', '361,363', '120', '100'), ('28', '2018112347632', '移动,白色', '361,364', '120', '100'), ('29', '2018112347632', '联通,黑色', '362,363', '120', '100'), ('30', '2018112347632', '联通,白色', '362,364', '120', '100'), ('31', '2018112331795', '电信,黑色', '360,363', '10', '10'), ('32', '2018112331795', '电信,白色', '360,364', '10', '10'), ('33', '2018112331795', '移动,黑色', '361,363', '10', '10'), ('34', '2018112331795', '移动,白色', '361,364', '10', '10'), ('35', '2018112331795', '联通,黑色', '362,363', '10', '10'), ('36', '2018112331795', '联通,白色', '362,364', '10', '10'), ('43', '2018112375797', '电信,黑色,32G', '360,363,365', '120', '110'), ('44', '2018112375797', '电信,黑色,64G', '360,363,366', '120', '1110'), ('45', '2018112375797', '电信,黑色,128G', '360,363,367', '120', '120'), ('46', '2018112375797', '电信,白色,32G', '360,364,365', '1120', '140'), ('47', '2018112375797', '电信,白色,64G', '360,364,366', '120', '10'), ('48', '2018112375797', '电信,白色,128G', '360,364,367', '120', '10'), ('49', '2018112375797', '移动,黑色,32G', '361,363,365', '120', '10'), ('50', '2018112375797', '移动,黑色,64G', '361,363,366', '120', '10'), ('51', '2018112375797', '移动,黑色,128G', '361,363,367', '120', '10'), ('52', '2018112375797', '移动,白色,32G', '361,364,365', '120', '10'), ('53', '2018112375797', '移动,白色,64G', '361,364,366', '120', '10'), ('54', '2018112375797', '移动,白色,128G', '361,364,367', '120', '10'), ('55', '2018112375797', '联通,黑色,32G', '362,363,365', '120', '10'), ('56', '2018112375797', '联通,黑色,64G', '362,363,366', '120', '10'), ('57', '2018112375797', '联通,黑色,128G', '362,363,367', '120', '10'), ('58', '2018112375797', '联通,白色,32G', '362,364,365', '120', '10'), ('59', '2018112375797', '联通,白色,64G', '362,364,366', '120', '10'), ('60', '2018112375797', '联通,白色,128G', '362,364,367', '120', '10'), ('68', '2018112416624', '电信,黑色', '360,363', '10', '10'), ('69', '2018112416624', '电信,白色', '360,364', '10', '10'), ('70', '2018112416624', '移动,黑色', '361,363', '10', '10'), ('71', '2018112416624', '移动,白色', '361,364', '10', '10'), ('72', '2018112416624', '联通,黑色', '362,363', '10', '10'), ('73', '2018112416624', '联通,白色', '362,364', '10', '10'), ('77', '2018112491650', '电信,32G', '360,365', '10', '100'), ('78', '2018112491650', '电信,128G', '360,367', '10', '100'), ('79', '2018112491650', '移动,32G', '361,365', '10', '100'), ('80', '2018112491650', '移动,128G', '361,367', '10', '100'), ('81', '2018112491650', '联通,32G', '362,365', '10', '100'), ('82', '2018112491650', '联通,128G', '362,367', '10', '100');
COMMIT;

-- ----------------------------
--  Table structure for `sl_group`
-- ----------------------------
DROP TABLE IF EXISTS `sl_group`;
CREATE TABLE `sl_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `zuming` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT '组名',
  `rand` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_group`
-- ----------------------------
BEGIN;
INSERT INTO `sl_group` VALUES ('1', '超级管理员', '1249503663');
COMMIT;

-- ----------------------------
--  Table structure for `sl_log`
-- ----------------------------
DROP TABLE IF EXISTS `sl_log`;
CREATE TABLE `sl_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `u1` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户名',
  `u2` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT '日志说明',
  `u3` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '访问ip',
  `u4` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '日志类型',
  `dtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `yonghuming` char(100) DEFAULT NULL,
  `sql` text COMMENT '执行的sql语句',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_log`
-- ----------------------------
BEGIN;
INSERT INTO `sl_log` VALUES ('1', 'cdsile', 'cdsile:登录成功,操作页面:danfeini/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=xpff', '::1', '管理员登录', '2018-11-06 15:31:24', null, null), ('2', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=m5pd', '::1', '管理员登录', '2018-11-06 17:33:10', null, null), ('3', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=9xbw', '::1', '管理员登录', '2018-11-14 23:35:37', null, null), ('4', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=fncg', '::1', '管理员登录', '2018-11-15 00:10:10', null, null), ('5', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=6xrv', '::1', '管理员登录', '2018-11-16 15:40:27', null, null), ('6', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=atsc', '::1', '管理员登录', '2018-11-16 15:44:37', null, null), ('7', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=2sed', '::1', '管理员登录', '2018-11-17 16:57:35', null, null), ('8', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=nawp', '::1', '管理员登录', '2018-11-18 02:53:07', null, null), ('9', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=d69b', '::1', '管理员登录', '2018-11-23 22:51:23', null, null), ('10', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=7pfc', '::1', '管理员登录', '2018-11-24 01:18:53', null, null), ('11', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=cta3', '::1', '管理员登录', '2018-11-24 01:19:29', null, null), ('12', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin', '127.0.0.1', '管理员登录', '2019-01-22 17:21:52', null, null), ('13', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin', '127.0.0.1', '管理员登录', '2019-01-28 14:16:00', null, null), ('14', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin', '127.0.0.1', '管理员登录', '2019-01-28 14:30:14', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `sl_menu`
-- ----------------------------
DROP TABLE IF EXISTS `sl_menu`;
CREATE TABLE `sl_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` varchar(50) CHARACTER SET utf8 DEFAULT '0' COMMENT '上一级的ID',
  `u1` varchar(250) CHARACTER SET utf8 DEFAULT '栏目名',
  `u2` varchar(250) CHARACTER SET utf8 DEFAULT '0' COMMENT '排序',
  `u3` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT 'url连接地址',
  `u4` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '显示状态',
  `laiyuan` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '添加人',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `u5` varchar(255) DEFAULT NULL COMMENT '控制器名称',
  `u6` varchar(255) DEFAULT '' COMMENT '控制器方法',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_menu`
-- ----------------------------
BEGIN;
INSERT INTO `sl_menu` VALUES ('1', '0', '主页', '0', ' ', '显示', '系统', ' layui-icon layui-icon-home', null, ''), ('8', '0', '内容管理', '1', '', '显示', '系统', null, null, ''), ('10', '0', '用户管理', '2', '', '显示', '系统', 'layui-icon layui-icon-user', null, ''), ('12', '0', '系统管理', '4', '', '显示', '系统', 'layui-icon layui-icon-set', null, ''), ('13', '0', '功能拓展', '5', '', '显示', '系统', 'layui-icon layui-icon-senior', '', ''), ('14', '12', '系统日志', '2', '/admin/log/index', '显示', '系统', null, 'log', ''), ('15', '12', '网站配置', '1', '/admin/set', '显示', '系统', null, 'set', ''), ('16', '12', '模型管理', '3', '/admin/table/index', '显示', '系统', null, 'table', ''), ('17', '12', '菜单管理', '4', '/admin/menu/index', '显示', '系统', null, 'menu', ''), ('19', '10', '管理员管理', '0', '/admin/admin/index', '显示', '系统', null, 'admin', ''), ('857', '12', '参数管理', '0', '/admin/parameter/index', '显示', '系统', null, 'parameter', ''), ('976', '10', '管理员权限', '2', '/admin/group/index', '显示', '系统', null, 'group', ''), ('1004', '1', '控制台', '0', '/admin/index/main', '显示', '系统', null, 'index', ''), ('1006', '15', '基础设置', '0', '/admin/set', '显示', null, null, 'set', ''), ('1007', '15', '第三方账号设置', '0', '/admin/set/account', '显示', null, null, 'set', ''), ('1008', '13', '短信发送记录', '0', '/admin/smslog/index', '显示', null, '', 'smslog', ''), ('1009', '1', '网站栏目', '1', '/admin/sort/index?classid=1', '显示', null, null, 'sort', ''), ('1010', '13', '商品规格管理', '1', '/admin/goodsparameter/index', '显示', null, '', 'goodsparameter', '');
COMMIT;

-- ----------------------------
--  Table structure for `sl_menu_group`
-- ----------------------------
DROP TABLE IF EXISTS `sl_menu_group`;
CREATE TABLE `sl_menu_group` (
  `id` int(10) unsigned NOT NULL,
  `classid` varchar(50) CHARACTER SET utf8 DEFAULT '0' COMMENT '上一级的ID',
  `u1` varchar(250) CHARACTER SET utf8 DEFAULT '栏目名',
  `u2` varchar(250) CHARACTER SET utf8 DEFAULT '0' COMMENT '排序',
  `u3` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT 'url连接地址',
  `u4` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '显示状态',
  `group_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '用户名',
  `laiyuan` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '添加人',
  `col_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `u5` varchar(255) DEFAULT NULL COMMENT '控制器名称',
  `u6` varchar(255) DEFAULT NULL COMMENT '控制器方法',
  PRIMARY KEY (`col_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3879 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_menu_group`
-- ----------------------------
BEGIN;
INSERT INTO `sl_menu_group` VALUES ('1', '0', '主页', '0', ' ', '显示', '1', 'cdsile', '3861', ' layui-icon layui-icon-home', '', ''), ('1004', '1', '控制台', '0', '/admin/index/main', '显示', '1', 'cdsile', '3862', '', 'index', ''), ('1009', '1', '网站栏目', '1', '/admin/sort/index?classid=1', '显示', '1', 'cdsile', '3863', '', 'sort', ''), ('8', '0', '内容管理', '1', '', '显示', '1', 'cdsile', '3864', '', '', ''), ('10', '0', '用户管理', '2', '', '显示', '1', 'cdsile', '3865', 'layui-icon layui-icon-user', '', ''), ('19', '10', '管理员管理', '0', '/admin/admin/index', '显示', '1', 'cdsile', '3866', '', 'admin', ''), ('976', '10', '管理员权限', '2', '/admin/group/index', '显示', '1', 'cdsile', '3867', '', 'group', ''), ('12', '0', '系统管理', '4', '', '显示', '1', 'cdsile', '3868', 'layui-icon layui-icon-set', '', ''), ('857', '12', '参数管理', '0', '/admin/parameter/index', '显示', '1', 'cdsile', '3869', '', 'parameter', ''), ('15', '12', '网站配置', '1', '/admin/set', '显示', '1', 'cdsile', '3870', '', 'set', ''), ('1006', '15', '基础设置', '0', '/admin/set', '显示', '1', 'cdsile', '3871', '', 'set', ''), ('1007', '15', '第三方账号设置', '0', '/admin/set/account', '显示', '1', 'cdsile', '3872', '', 'set', ''), ('14', '12', '系统日志', '2', '/admin/log/index', '显示', '1', 'cdsile', '3873', '', 'log', ''), ('16', '12', '模型管理', '3', '/admin/table/index', '显示', '1', 'cdsile', '3874', '', 'table', ''), ('17', '12', '菜单管理', '4', '/admin/menu/index', '显示', '1', 'cdsile', '3875', '', 'menu', ''), ('13', '0', '功能拓展', '5', '', '显示', '1', 'cdsile', '3876', 'layui-icon layui-icon-senior', '', ''), ('1008', '13', '短信发送记录', '0', '/admin/smslog/index', '显示', '1', 'cdsile', '3877', '', 'smslog', ''), ('1010', '13', '商品规格管理', '1', '/admin/goodsparameter/index', '显示', '1', 'cdsile', '3878', '', 'goodsparameter', '');
COMMIT;

-- ----------------------------
--  Table structure for `sl_parameter`
-- ----------------------------
DROP TABLE IF EXISTS `sl_parameter`;
CREATE TABLE `sl_parameter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` varchar(10) CHARACTER SET utf8 DEFAULT '0' COMMENT '上级ID',
  `u1` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '参数说明',
  `u2` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '参数',
  `u3` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '图标',
  `u4` tinyint(50) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=359 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_parameter`
-- ----------------------------
BEGIN;
INSERT INTO `sl_parameter` VALUES ('1', '0', '模型类型', ' ', ' ', '0'), ('2', '1', '表单模型', 'autotable|Sautotable', '', '0'), ('3', '1', '文章模型', 'article|Sarticle', ' ', '0'), ('4', '0', '字段类型', ' ', ' ', '0'), ('6', '4', '文本框', 'char', ' ', '0'), ('7', '4', '文本编辑器', 'mediumtext', ' ', '0'), ('8', '4', '文本域', 'varchar', ' ', '0'), ('9', '4', '时间框', 'timestamp', ' ', '0'), ('10', '4', '单选', 'varchar', ' ', '0'), ('11', '4', '多选', 'varchar', ' ', '0'), ('12', '4', '图片', 'varchar', ' ', '0'), ('13', '4', '组图', 'text', ' ', '0'), ('14', '4', '数字', 'int', ' ', '0'), ('15', '4', '文件', 'varchar', ' ', '0'), ('16', '4', '密码', ' ', ' ', '0'), ('18', '1', '用户模型', 'user|Suser', ' ', '0'), ('58', '4', '联动', ' varchar', ' ', '0'), ('61', '0', '状态', ' ', ' ', '0'), ('62', '61', '待审', ' ', ' ', '0'), ('63', '61', '终审', ' ', ' ', '0'), ('64', '61', '回收站', ' ', ' ', '0'), ('209', '208', 'web_url', 'http://fhj.cdweni.com', ' ', '0'), ('242', '4', '下拉框', ' ', ' ', '0'), ('243', '4', '金额', 'double', ' ', '0'), ('252', '4', '多条记录', ' ', ' ', '0'), ('254', '253', '未支付', ' ', ' ', '0'), ('255', '253', '已支付', ' ', ' ', '0'), ('256', '253', '待发货', ' ', ' ', '0'), ('257', '253', '待收货', ' ', ' ', '0'), ('258', '253', '订单完成', ' ', ' ', '0'), ('259', '253', '退货', ' ', ' ', '0'), ('260', '253', '其他', ' ', ' ', '0'), ('261', '4', '省市县三级联动', ' ', ' ', '0'), ('263', '262', '2018年第1期', ' ', ' ', '1'), ('269', '4', '城市选择器(多选)', ' ', ' ', '0'), ('270', '4', '城市选择器(单选)', ' ', ' ', '0'), ('271', '4', '批量上传', ' ', ' ', '0'), ('324', '4', '单行输入框', '', ' ', '0'), ('325', '0', '字段显示分类', '', ' ', '0'), ('326', '325', '文章设置', '', ' ', '3'), ('327', '325', '文章描述', '', ' ', '2'), ('328', '325', 'SEO设置', '', ' ', '1'), ('329', '325', '基础参数', '', ' ', '0'), ('330', '0', '网站参数', '', ' ', '0'), ('349', '325', '图片设置', '', ' ', '4'), ('354', '1', '分类模型', 'category|Scategory', ' ', '4'), ('355', '4', '商品规格', 'varchar', ' ', '0'), ('356', '1', '商品模型', 'autotable|Sautotable', ' ', '4'), ('357', '4', '编号', 'char', ' ', '0'), ('358', '4', '商品价格', 'char', ' ', '0');
COMMIT;

-- ----------------------------
--  Table structure for `sl_smslog`
-- ----------------------------
DROP TABLE IF EXISTS `sl_smslog`;
CREATE TABLE `sl_smslog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user` varchar(11) NOT NULL,
  `log` varchar(255) NOT NULL DEFAULT '' COMMENT '日志说明',
  `type` varchar(10) NOT NULL COMMENT '短信类型',
  `dtime` date NOT NULL COMMENT '添加日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records of `sl_smslog`
-- ----------------------------
BEGIN;
INSERT INTO `sl_smslog` VALUES ('24', '18782140263', '2706', '验证码', '2018-11-15'), ('25', '18782140263', '6700', '验证码', '2018-11-15'), ('26', '13320668037', '6710', '验证码', '2018-11-15'), ('27', '13320668037', '6274', '验证码', '2018-11-20'), ('28', '13320668037', '5444', '验证码', '2018-11-20');
COMMIT;

-- ----------------------------
--  Table structure for `sl_sort`
-- ----------------------------
DROP TABLE IF EXISTS `sl_sort`;
CREATE TABLE `sl_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` varchar(10) CHARACTER SET utf8 DEFAULT '0' COMMENT '上级ID',
  `u1` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '参数说明',
  `u2` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '参数',
  `u3` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '图标',
  `u4` tinyint(50) DEFAULT '0' COMMENT '排序',
  `u5` varchar(250) CHARACTER SET utf8 DEFAULT '/' COMMENT '栏目连接',
  `u6` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT 'seo标题',
  `u7` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT 'seo关键词',
  `u8` varchar(250) CHARACTER SET utf8 DEFAULT NULL COMMENT 'seo描述',
  `u9` varchar(250) DEFAULT '' COMMENT '栏目英文名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=294 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_sort`
-- ----------------------------
BEGIN;
INSERT INTO `sl_sort` VALUES ('1', '0', '网站栏目', ' ', ' ', '0', '/', null, null, null, ''), ('282', '1', '首页', ' ', ' ', '0', '/', null, null, null, ''), ('283', '1', 'VR体验', ' ', ' ', '1', '/vrtiyan', 'VR体验', 'VR体验', 'VR体验', ''), ('284', '1', '设计师', ' ', ' ', '2', '/shejishi', '', '', '', ''), ('285', '1', '产品中心', ' ', ' ', '3', '/chanpinzhongxin', '', '', '', ''), ('286', '1', '定制4.0', ' ', ' ', '4', '/dingzhi', '', '', '', ''), ('292', '285', '黛薇系列', ' ', ' ', '0', '/chanpinzhongxin', '', '', '', ''), ('293', '285', '都市系列', ' ', ' ', '1', '/chanpinzhongxin', '', '', '', '');
COMMIT;

-- ----------------------------
--  Table structure for `sl_table`
-- ----------------------------
DROP TABLE IF EXISTS `sl_table`;
CREATE TABLE `sl_table` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `u1` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '数据库表名',
  `u2` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '模型中文名',
  `u3` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '模型类型',
  `u4` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '栏目列表模版',
  `u5` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '栏目内容模版',
  `u6` varchar(250) CHARACTER SET utf8 DEFAULT '/' COMMENT '栏目路径',
  `u7` varchar(250) CHARACTER SET utf8 DEFAULT 'on' COMMENT '是否默认设置 on 开启，off 开启',
  `u8` varchar(250) CHARACTER SET utf8 DEFAULT 'autotable' COMMENT '自定义控制器',
  `u9` varchar(250) CHARACTER SET utf8 DEFAULT 'Sautotable' COMMENT '自定义试图文件夹',
  `u10` int(10) DEFAULT '0' COMMENT '所属栏目ID',
  `u11` char(10) DEFAULT 'off' COMMENT '是否启用接口 on 开启，off 开启',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_table`
-- ----------------------------
BEGIN;
INSERT INTO `sl_table` VALUES ('8', 'sl_ceshi', '测试', '表单模型', 'on', ' ', '/', 'on', 'autotable', 'Sautotable', '0', 'on');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
