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

 Date: 11/15/2018 16:18:40 PM
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
INSERT INTO `sl_admin` VALUES ('23', 'cdsile', '01ac3d95a020811609ceef9ed8336e2e', 'wahson-gong@outlook.com', '思乐管理员', '', '1', '', '0', '2018-11-15 12:10:10', '::1', '0', '1509730011', '0', 'public/uploads/20180702/201807021343565b39bb9c7397a.png', '1', '0', '0');
COMMIT;

-- ----------------------------
--  Table structure for `sl_fenlei`
-- ----------------------------
DROP TABLE IF EXISTS `sl_fenlei`;
CREATE TABLE `sl_fenlei` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_id` char(100) DEFAULT '0' COMMENT '分类id',
  `biaoti` char(100) NOT NULL COMMENT '标题',
  `paixu` int(10) unsigned DEFAULT '1' COMMENT '排序',
  `dtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='sl_fenlei模型主表';

-- ----------------------------
--  Records of `sl_fenlei`
-- ----------------------------
BEGIN;
INSERT INTO `sl_fenlei` VALUES ('1', '0', '分类1', '1', '2018-11-06 17:41:06'), ('2', '0', '分类11', '1', '2018-11-06 17:41:38'), ('3', '1', 'test111', '1', '2018-11-14 23:36:02'), ('11', '0', '123', '1', '2018-11-15 00:58:17');
COMMIT;

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
  `u14` varchar(250) DEFAULT NULL COMMENT '正则严重规则',
  `u15` varchar(250) DEFAULT '文章设置' COMMENT '字段显示分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1371 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_filed`
-- ----------------------------
BEGIN;
INSERT INTO `sl_filed` VALUES ('1365', '108', 'dtime', '添加时间', '', '否', '否', '否', '时间框', 'CURRENT_TIMESTAMP', '80', '2', '否', 'left', '', null, '文章设置'), ('1366', '109', 'class_id', '分类id', '', '否', '否', '否', '文本框', '0', '80', '2', '否', 'left', '', null, '文章设置'), ('1367', '109', 'biaoti', '标题', '', '是', '是', '是', '文本框', '', '160', '3', '否', 'left', '', '无', '文章设置'), ('1368', '109', 'paixu', '排序', '', '否', '否', '否', '数字', '1', '80', '4', '否', 'left', '', null, '文章设置'), ('1369', '109', 'dtime', '添加时间', '', '否', '否', '否', '时间框', 'CURRENT_TIMESTAMP', '80', '5', '否', 'left', '', null, '文章设置'), ('1370', '108', 'xingming', '姓名', '', '是', '是', '否', '文本框', '', '60', '0', '否', '', '', '无', '基础参数');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_log`
-- ----------------------------
BEGIN;
INSERT INTO `sl_log` VALUES ('1', 'cdsile', 'cdsile:登录成功,操作页面:danfeini/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=xpff', '::1', '管理员登录', '2018-11-06 15:31:24', null, null), ('2', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=m5pd', '::1', '管理员登录', '2018-11-06 17:33:10', null, null), ('3', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=9xbw', '::1', '管理员登录', '2018-11-14 23:35:37', null, null), ('4', 'cdsile', 'cdsile:登录成功,操作页面:cms/index.php?route=admin/login/signin&amp;amp;username=cdsile&amp;amp;password=cdsile&amp;amp;vercode=fncg', '::1', '管理员登录', '2018-11-15 00:10:10', null, null);
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
) ENGINE=InnoDB AUTO_INCREMENT=1010 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_menu`
-- ----------------------------
BEGIN;
INSERT INTO `sl_menu` VALUES ('1', '0', '主页', '0', ' ', '显示', '系统', ' layui-icon layui-icon-home', null, ''), ('8', '0', '内容管理', '1', '', '显示', '系统', null, null, ''), ('10', '0', '用户管理', '2', '', '显示', '系统', 'layui-icon layui-icon-user', null, ''), ('12', '0', '系统管理', '4', '', '显示', '系统', 'layui-icon layui-icon-set', null, ''), ('13', '0', '功能拓展', '5', '', '显示', '系统', 'layui-icon layui-icon-senior', '', ''), ('14', '12', '系统日志', '2', '/admin/log/index', '显示', '系统', null, 'log', ''), ('15', '12', '网站配置', '1', '/admin/set', '显示', '系统', null, 'set', ''), ('16', '12', '模型管理', '3', '/admin/table/index', '显示', '系统', null, 'table', ''), ('17', '12', '菜单管理', '4', '/admin/menu/index', '显示', '系统', null, 'menu', ''), ('19', '10', '管理员管理', '0', '/admin/admin/index', '显示', '系统', null, 'admin', ''), ('857', '12', '参数管理', '0', '/admin/parameter/index', '显示', '系统', null, 'parameter', ''), ('976', '10', '管理员权限', '2', '/admin/group/index', '显示', '系统', null, 'group', ''), ('1004', '1', '控制台', '0', '/admin/index/main', '显示', '系统', null, 'index', ''), ('1006', '15', '基础设置', '0', '/admin/set', '显示', null, null, 'set', ''), ('1007', '15', '第三方账号设置', '0', '/admin/set/account', '显示', null, null, 'set', ''), ('1008', '13', '短信发送记录', '0', '/admin/smslog/index', '显示', null, '', 'smslog', ''), ('1009', '1', '网站栏目', '1', '/admin/sort/index?classid=1', '显示', null, null, 'sort', '');
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
) ENGINE=InnoDB AUTO_INCREMENT=3861 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_menu_group`
-- ----------------------------
BEGIN;
INSERT INTO `sl_menu_group` VALUES ('1', '0', '主页', '0', ' ', '显示', '1', 'cdsile', '3844', ' layui-icon layui-icon-home', '', ''), ('1004', '1', '控制台', '0', '/admin/index/main', '显示', '1', 'cdsile', '3845', '', 'index', ''), ('1009', '1', '网站栏目', '1', '/admin/sort/index?classid=1', '显示', '1', 'cdsile', '3846', '', 'sort', ''), ('8', '0', '内容管理', '1', '', '显示', '1', 'cdsile', '3847', '', '', ''), ('10', '0', '用户管理', '2', '', '显示', '1', 'cdsile', '3848', 'layui-icon layui-icon-user', '', ''), ('19', '10', '管理员管理', '0', '/admin/admin/index', '显示', '1', 'cdsile', '3849', '', 'admin', ''), ('976', '10', '管理员权限', '2', '/admin/group/index', '显示', '1', 'cdsile', '3850', '', 'group', ''), ('12', '0', '系统管理', '4', '', '显示', '1', 'cdsile', '3851', 'layui-icon layui-icon-set', '', ''), ('857', '12', '参数管理', '0', '/admin/parameter/index', '显示', '1', 'cdsile', '3852', '', 'parameter', ''), ('15', '12', '网站配置', '1', '/admin/set', '显示', '1', 'cdsile', '3853', '', 'set', ''), ('1006', '15', '基础设置', '0', '/admin/set', '显示', '1', 'cdsile', '3854', '', 'set', ''), ('1007', '15', '第三方账号设置', '0', '/admin/set/account', '显示', '1', 'cdsile', '3855', '', 'set', ''), ('14', '12', '系统日志', '2', '/admin/log/index', '显示', '1', 'cdsile', '3856', '', 'log', ''), ('16', '12', '模型管理', '3', '/admin/table/index', '显示', '1', 'cdsile', '3857', '', 'table', ''), ('17', '12', '菜单管理', '4', '/admin/menu/index', '显示', '1', 'cdsile', '3858', '', 'menu', ''), ('13', '0', '功能拓展', '5', '', '显示', '1', 'cdsile', '3859', 'layui-icon layui-icon-senior', '', ''), ('1008', '13', '短信发送记录', '0', '/admin/smslog/index', '显示', '1', 'cdsile', '3860', '', 'smslog', '');
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
) ENGINE=InnoDB AUTO_INCREMENT=355 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_parameter`
-- ----------------------------
BEGIN;
INSERT INTO `sl_parameter` VALUES ('1', '0', '模型类型', ' ', ' ', '0'), ('2', '1', '表单模型', 'autotable|Sautotable', '', '0'), ('3', '1', '文章模型', 'article|Sarticle', ' ', '0'), ('4', '0', '字段类型', ' ', ' ', '0'), ('6', '4', '文本框', 'char', ' ', '0'), ('7', '4', '文本编辑器', 'mediumtext', ' ', '0'), ('8', '4', '文本域', 'varchar', ' ', '0'), ('9', '4', '时间框', 'timestamp', ' ', '0'), ('10', '4', '单选', 'varchar', ' ', '0'), ('11', '4', '多选', 'varchar', ' ', '0'), ('12', '4', '图片', 'varchar', ' ', '0'), ('13', '4', '组图', 'text', ' ', '0'), ('14', '4', '数字', 'int', ' ', '0'), ('15', '4', '文件', 'varchar', ' ', '0'), ('16', '4', '密码', ' ', ' ', '0'), ('18', '1', '用户模型', 'user|Suser', ' ', '0'), ('58', '4', '联动', ' varchar', ' ', '0'), ('61', '0', '状态', ' ', ' ', '0'), ('62', '61', '待审', ' ', ' ', '0'), ('63', '61', '终审', ' ', ' ', '0'), ('64', '61', '回收站', ' ', ' ', '0'), ('209', '208', 'web_url', 'http://fhj.cdweni.com', ' ', '0'), ('242', '4', '下拉框', ' ', ' ', '0'), ('243', '4', '金额', 'double', ' ', '0'), ('252', '4', '多条记录', ' ', ' ', '0'), ('254', '253', '未支付', ' ', ' ', '0'), ('255', '253', '已支付', ' ', ' ', '0'), ('256', '253', '待发货', ' ', ' ', '0'), ('257', '253', '待收货', ' ', ' ', '0'), ('258', '253', '订单完成', ' ', ' ', '0'), ('259', '253', '退货', ' ', ' ', '0'), ('260', '253', '其他', ' ', ' ', '0'), ('261', '4', '省市县三级联动', ' ', ' ', '0'), ('263', '262', '2018年第1期', ' ', ' ', '1'), ('269', '4', '城市选择器(多选)', ' ', ' ', '0'), ('270', '4', '城市选择器(单选)', ' ', ' ', '0'), ('271', '4', '批量上传', ' ', ' ', '0'), ('324', '4', '单行输入框', '', ' ', '0'), ('325', '0', '字段显示分类', '', ' ', '0'), ('326', '325', '文章设置', '', ' ', '0'), ('327', '325', '文章描述', '', ' ', '2'), ('328', '325', 'SEO设置', '', ' ', '1'), ('329', '325', '基础参数', '', ' ', '3'), ('330', '0', '网站参数', '', ' ', '0'), ('349', '325', '图片设置', '', ' ', '4'), ('354', '1', '分类模型', 'category|Scategory', ' ', '4');
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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=323 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_sort`
-- ----------------------------
BEGIN;
INSERT INTO `sl_sort` VALUES ('1', '0', '网站栏目', ' ', ' ', '0', '/', null, null, null, ''), ('282', '1', '首页', ' ', ' ', '0', '/', null, null, null, ''), ('283', '1', 'VR体验', ' ', ' ', '1', '/vrtiyan', 'VR体验', 'VR体验', 'VR体验', ''), ('284', '1', '设计师', ' ', ' ', '2', '/shejishi', '', '', '', ''), ('285', '1', '产品中心', ' ', ' ', '3', '/chanpinzhongxin', '', '', '', ''), ('286', '1', '定制4.0', ' ', ' ', '4', '/dingzhi', '', '', '', ''), ('287', '1', '招商加盟', ' ', ' ', '5', '/zhaoshangjiameng', '', '', '', ''), ('288', '1', '品牌介绍', ' ', ' ', '6', '/pinpaijieshao', '', '', '', ''), ('289', '1', '客户服务', ' ', ' ', '7', '/kehufuwu/bangzu', '', '', '', ''), ('290', '1', '新闻资讯', ' ', ' ', '8', '/xinwenzixun', '', '', '', ''), ('291', '1', '联系我们', ' ', ' ', '9', '/lianxiwomen', '', '', '', ''), ('292', '285', '黛薇系列', ' ', ' ', '0', '/chanpinzhongxin', '', '', '', ''), ('293', '285', '都市系列', ' ', ' ', '1', '/chanpinzhongxin', '', '', '', ''), ('294', '285', '龙达小镇', ' ', ' ', '3', '/chanpinzhongxin', '', '', '', ''), ('295', '285', '菲尼小屋', ' ', ' ', '2', '/chanpinzhongxin', '', '', '', ''), ('296', '285', '北卡罗纳', ' ', ' ', '0', '/chanpinzhongxin', '', '', '', ''), ('297', '286', '卧室', ' ', ' ', '0', '/dingzhi', '', '', '', ''), ('298', '286', '书房', ' ', ' ', '1', '/dingzhi', '', '', '', ''), ('299', '286', '青少年房', ' ', ' ', '2', '/dingzhi', '', '', '', ''), ('300', '286', '客厅', ' ', ' ', '3', '/dingzhi', '', '', '', ''), ('301', '286', '餐厅', ' ', ' ', '4', '/dingzhi', '', '', '', ''), ('302', '287', '加盟优势', ' ', ' ', '4', '/zhaoshangjiameng', '', '', '', ''), ('303', '287', '加盟政策', ' ', ' ', '1', '/zhaoshangjiameng', '', '', '', ''), ('304', '287', '加盟流程', ' ', ' ', '2', '/zhaoshangjiameng', '', '', '', ''), ('305', '287', '加盟条件', ' ', ' ', '3', '/zhaoshangjiameng', '', '', '', ''), ('306', '287', '加盟动态', ' ', ' ', '0', '/zhaoshangjiameng', '', '', '', ''), ('307', '288', '企业文化', ' ', ' ', '0', '/pinpaijieshao', '', '', '', ''), ('308', '288', '企业介绍', ' ', ' ', '1', '/pinpaijieshao', '', '', '', ''), ('309', '288', '品牌历程', ' ', ' ', '2', '/pinpaijieshao/licheng', '', '', '', ''), ('310', '288', '荣耀资质', ' ', ' ', '3', '/pinpaijieshao/rongyu', '', '', '', ''), ('311', '288', '合作伙伴', ' ', ' ', '4', '/pinpaijieshao/huoban', '', '', '', ''), ('313', '289', '帮助中心', ' ', ' ', '1', '/kehufuwu/bangzu', '', '', '', ''), ('314', '289', '订单查询', ' ', ' ', '2', 'http://www.kuaidi100.com/?from=openv', '', '', '', ''), ('315', '289', '售后服务', ' ', ' ', '3', '/kehufuwu/shouhou', '', '', '', ''), ('316', '289', '投诉建议', ' ', ' ', '4', '/kehufuwu/tousu', '', '', '', ''), ('317', '291', '在线咨询', ' ', ' ', '0', '/lianxiwomen', '', '', '', ''), ('319', '291', '申请加盟', '', ' ', '2', '/kehufuwu/shouhou#liuyan', '', '', '', ''), ('320', '290', '定制攻略', ' ', ' ', '0', '/xinwenzixun', '', '', '', ''), ('321', '290', '行业新闻', ' ', ' ', '1', '/xinwenzixun', '', '', '', ''), ('322', '290', '企业动态', ' ', ' ', '2', '/xinwenzixun', '', '', '', '');
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Records of `sl_table`
-- ----------------------------
BEGIN;
INSERT INTO `sl_table` VALUES ('108', 'sl_yonghu', '用户', '表单模型', 'on', ' ', '/', 'on', 'autotable', 'Sautotable', '0'), ('109', 'sl_fenlei', '分类', '分类模型', 'on', ' ', '/', 'on', 'category', 'Scategory', '0');
COMMIT;

-- ----------------------------
--  Table structure for `sl_yonghu`
-- ----------------------------
DROP TABLE IF EXISTS `sl_yonghu`;
CREATE TABLE `sl_yonghu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `xingming` char(100) NOT NULL COMMENT '姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='sl_yonghu模型主表';

-- ----------------------------
--  Records of `sl_yonghu`
-- ----------------------------
BEGIN;
INSERT INTO `sl_yonghu` VALUES ('6', '2018-11-15 00:56:50', '123'), ('9', '2018-11-15 00:57:57', '123'), ('10', '2018-11-15 00:58:17', '123');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
