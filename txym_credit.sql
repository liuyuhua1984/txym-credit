/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50714
Source Host           : 127.0.0.1:3306
Source Database       : txym_credit

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-07-27 17:55:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for credit_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `credit_admin_role`;
CREATE TABLE `credit_admin_role` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT '' COMMENT '角色名称',
  `role` varchar(255) DEFAULT '' COMMENT '角色',
  `desc` varchar(255) DEFAULT '0' COMMENT '描述',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `account` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_admin_role
-- ----------------------------
INSERT INTO `credit_admin_role` VALUES ('1', '管理员', 'admin', '系统管理员', '2017-07-27 17:42:07');
INSERT INTO `credit_admin_role` VALUES ('2', '客服', 'service', '客服普管理员', '2017-07-27 17:43:17');

-- ----------------------------
-- Table structure for credit_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `credit_admin_user`;
CREATE TABLE `credit_admin_user` (
  `id` bigint(20) NOT NULL,
  `account` varchar(255) DEFAULT '' COMMENT '账号',
  `real_name` varchar(255) DEFAULT '' COMMENT '真实名字',
  `phone` bigint(20) DEFAULT '0' COMMENT '电话',
  `email` varchar(255) DEFAULT '' COMMENT 'email',
  `role` varchar(255) DEFAULT '' COMMENT '角色',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_admin_user
-- ----------------------------

-- ----------------------------
-- Table structure for credit_borrower
-- ----------------------------
DROP TABLE IF EXISTS `credit_borrower`;
CREATE TABLE `credit_borrower` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT '' COMMENT '借钱人名称',
  `phone` bigint(20) DEFAULT '0' COMMENT '手机号',
  `password` varchar(255) DEFAULT '' COMMENT '密码',
  `sex` tinyint(4) DEFAULT '1' COMMENT '性别,男=1,女=2',
  `address` varchar(255) DEFAULT '' COMMENT '住址',
  `id_card_front` varchar(255) DEFAULT '' COMMENT '身份证号正面地址',
  `id_card_back` varchar(255) DEFAULT '' COMMENT '身份证反面地址',
  `house_licence` varchar(255) DEFAULT '' COMMENT '房产证存入路径',
  `driver_licence` varchar(255) DEFAULT '' COMMENT '驾驶证存储路径',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_borrower
-- ----------------------------

-- ----------------------------
-- Table structure for credit_borrow_record
-- ----------------------------
DROP TABLE IF EXISTS `credit_borrow_record`;
CREATE TABLE `credit_borrow_record` (
  `id` bigint(20) NOT NULL,
  `borrow_id` bigint(20) DEFAULT NULL COMMENT '借入者id',
  `loaner_id` bigint(20) DEFAULT NULL COMMENT '借出方id',
  `borrow_money` int(11) DEFAULT '0' COMMENT '借款',
  `borrow_time_limit` int(11) DEFAULT '0' COMMENT '借款时间(天)',
  `order_id` varchar(255) DEFAULT '' COMMENT '订单号',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `borrow_id` (`borrow_id`),
  KEY `loaner_id` (`loaner_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_borrow_record
-- ----------------------------

-- ----------------------------
-- Table structure for credit_frequent contacts
-- ----------------------------
DROP TABLE IF EXISTS `credit_frequent contacts`;
CREATE TABLE `credit_frequent contacts` (
  `id` bigint(20) NOT NULL,
  `borrower_id` bigint(20) DEFAULT NULL COMMENT '借钱人id',
  `name` varchar(255) DEFAULT '' COMMENT '姓名',
  `phone` bigint(20) DEFAULT '0' COMMENT '手机号',
  `relation` varchar(255) DEFAULT '' COMMENT '与借钱方的关系',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `borrower_id` (`borrower_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_frequent contacts
-- ----------------------------

-- ----------------------------
-- Table structure for credit_loaner
-- ----------------------------
DROP TABLE IF EXISTS `credit_loaner`;
CREATE TABLE `credit_loaner` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '出借方姓名',
  `phone` bigint(20) DEFAULT '0' COMMENT '手机号码',
  `password` varchar(255) DEFAULT '' COMMENT '密码',
  `sex` tinyint(4) DEFAULT '1' COMMENT '性别,男=1,女=2',
  `address` varchar(255) DEFAULT '' COMMENT '住址',
  `loan_money` int(11) DEFAULT '0' COMMENT '可借出资金',
  `loan_time_limit` int(11) DEFAULT '0' COMMENT '可借出期限(天)',
  `demand` varchar(512) DEFAULT '' COMMENT '出借人要求',
  `is_show` tinyint(4) DEFAULT '1' COMMENT '是否显示',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_loaner
-- ----------------------------

-- ----------------------------
-- Table structure for credit_lona_request
-- ----------------------------
DROP TABLE IF EXISTS `credit_lona_request`;
CREATE TABLE `credit_lona_request` (
  `id` bigint(20) NOT NULL,
  `borrower_id` bigint(20) DEFAULT '0' COMMENT '借贷人id',
  `loaner_id` bigint(20) DEFAULT '0' COMMENT '出借方id',
  `borrow_money` int(11) DEFAULT '0' COMMENT '申请money',
  `borrow_time_limit` int(11) DEFAULT '0' COMMENT '借钱时间(天)',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '注册时间',
  `agree_flag` tinyint(4) DEFAULT '0' COMMENT '审核标志 1=已审核',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_lona_request
-- ----------------------------
