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

 Date: 11/15/2018 16:30:18 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

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

SET FOREIGN_KEY_CHECKS = 1;
