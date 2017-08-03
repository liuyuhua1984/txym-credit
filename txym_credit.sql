/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50717
Source Host           : 127.0.0.1:3306
Source Database       : txym_credit

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-08-03 15:37:03
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
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '' COMMENT '借钱人名称',
  `phone` bigint(20) DEFAULT '0' COMMENT '手机号',
  `password` varchar(255) DEFAULT '' COMMENT '密码',
  `sex` tinyint(4) DEFAULT '1' COMMENT '性别,男=1,女=2',
  `address` varchar(255) DEFAULT '' COMMENT '住址',
  `id_card_1` varchar(255) DEFAULT '' COMMENT '身份证号正面地址',
  `id_card_2` varchar(255) DEFAULT '' COMMENT '身份证反面地址',
  `house_licence` varchar(255) DEFAULT '' COMMENT '房产证存入路径',
  `driver_licence` varchar(255) DEFAULT '' COMMENT '驾驶证存储路径',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_borrower
-- ----------------------------
INSERT INTO `credit_borrower` VALUES ('11', 'ew', '18554654210', '110110', '2', '感人肺腑枯萎', '20170802\\5803e1610ef905b3edff8c26acd38cae.png', '20170802\\8a9c3d5c9cb373cf225839e160244070.jpg', '1', '1', 'w@163.com', '2017-08-02 05:02:37');
INSERT INTO `credit_borrower` VALUES ('12', 'w胗', '15212365895', '123456', '2', '脸厅', '20170802\\f9221a7039f6d2f8ff4d11a32583da41.png', '20170802\\58b40e7aed8e5cd27252fab389852394.png', '1', '1', 'sw@163.com', '2017-08-02 05:42:19');
INSERT INTO `credit_borrower` VALUES ('13', '仍', '15213456565', '123456', '1', '脸奇才脸你 欠妥', '20170802\\20b6f76dc1d0f360ca586b5ea5ab227f.png', '20170802\\5b385d6dfe9c4527e4222c97dddd9b52.jpg', '1', '1', '15@163.com', '2017-08-02 06:34:45');
INSERT INTO `credit_borrower` VALUES ('14', 'we33', '15213659856', '123456', '1', 'ewe fsg ', '20170803\\df9ceb3e4a4130f7d4328956d8dbc853.png', '20170803\\56c982f01a5c44449b676217d0eec4c2.png', '1', '1', 'ww@163.com', '2017-08-03 11:01:17');
INSERT INTO `credit_borrower` VALUES ('15', 'da e ', '15214785469', '123456', '1', 'ewq d ', '20170803\\06b6b91a2f2d9f5ebc80e29794e05d38.png', '20170803\\8e77b6ef0f305ef662f27e68e063b67b.png', '1', '1', '44@163.com', '2017-08-03 11:24:58');
INSERT INTO `credit_borrower` VALUES ('16', '脸色脸', '15213658954', '123456', '2', '在脸色我', '20170803\\3101aca0baa5dffe0289b0426b3f778b.jpg', '20170803\\372562f2970cbf87fb09c0e3dbf2e760.jpg', '1', '1', '2@163.com', '2017-08-03 11:31:11');
INSERT INTO `credit_borrower` VALUES ('17', 'we 脸厅', '15217854698', '123456', '2', '脸色枯载', '20170803\\4df90e4fbcbaf4add26b0b5b6e82a608.jpg', '20170803\\590110e86a3bd7909289c41923f8247e.png', '1', '1', '1454@163.com', '2017-08-03 11:37:42');

-- ----------------------------
-- Table structure for credit_borrow_record
-- ----------------------------
DROP TABLE IF EXISTS `credit_borrow_record`;
CREATE TABLE `credit_borrow_record` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
-- Table structure for credit_frequent_contacts
-- ----------------------------
DROP TABLE IF EXISTS `credit_frequent_contacts`;
CREATE TABLE `credit_frequent_contacts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `borrower_id` bigint(20) DEFAULT NULL COMMENT '借钱人id',
  `name` varchar(255) DEFAULT '' COMMENT '姓名',
  `phone` bigint(20) DEFAULT '0' COMMENT '手机号',
  `relation` varchar(255) DEFAULT '' COMMENT '与借钱方的关系',
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `borrower_id` (`borrower_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_frequent_contacts
-- ----------------------------
INSERT INTO `credit_frequent_contacts` VALUES ('15', '11', '脸土木工程厅枯萎棋', '13325245985', '估', '2017-08-02 05:02:38');
INSERT INTO `credit_frequent_contacts` VALUES ('16', '11', '脸枯萎霜花有欠妥李斐莉雪李斐莉雪棋', '15213656894', '脸', '2017-08-02 05:02:38');
INSERT INTO `credit_frequent_contacts` VALUES ('17', '12', '仍在', '15213689565', '脸', '2017-08-02 05:42:19');
INSERT INTO `credit_frequent_contacts` VALUES ('18', '12', '脞', '15213587452', '脸', '2017-08-02 05:42:19');
INSERT INTO `credit_frequent_contacts` VALUES ('19', '13', '有东西', '15213656896', '脸', '2017-08-02 06:34:45');
INSERT INTO `credit_frequent_contacts` VALUES ('20', '13', '脸色 ', '15246589563', '暗淡', '2017-08-02 06:34:45');
INSERT INTO `credit_frequent_contacts` VALUES ('21', '14', '有奇才械茜', '15213545896', '人人', '2017-08-03 11:01:17');
INSERT INTO `credit_frequent_contacts` VALUES ('22', '14', '止干 ', '17784589652', '有人', '2017-08-03 11:01:17');
INSERT INTO `credit_frequent_contacts` VALUES ('23', '15', '仍有人', '18875465239', '9地', '2017-08-03 11:24:59');
INSERT INTO `credit_frequent_contacts` VALUES ('24', '15', '脸5 ', '17874584569', '仍有', '2017-08-03 11:24:59');
INSERT INTO `credit_frequent_contacts` VALUES ('25', '16', '你人4 4 ', '17748546589', '仍的', '2017-08-03 11:31:11');
INSERT INTO `credit_frequent_contacts` VALUES ('26', '16', '和地地', '18845495658', '脸', '2017-08-03 11:31:11');
INSERT INTO `credit_frequent_contacts` VALUES ('27', '17', '脸在工', '13315487965', '人2', '2017-08-03 11:37:43');
INSERT INTO `credit_frequent_contacts` VALUES ('28', '17', '1531254854', '15487856458', '脸3', '2017-08-03 11:37:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_loaner
-- ----------------------------
INSERT INTO `credit_loaner` VALUES ('3', '脸色', '15213432565', '123456', '1', '胸', '100', '1', '大师傅阿斯蒂芬 欠妥李斐莉雪', '1', '2017-08-01 02:03:36');
INSERT INTO `credit_loaner` VALUES ('4', 'dafasdf af', '15312452358', '123456', '1', 'ewq sdaf sadf ', '100', '1', 'dsf afd afa afsd ', '1', '2017-08-01 02:08:56');
INSERT INTO `credit_loaner` VALUES ('5', '要厅棋', '15213432564', '123456', '1', '仍然李斐莉雪棋', '100', '1', '有东西魂牵梦萦基本面', '1', '2017-08-01 02:13:16');
INSERT INTO `credit_loaner` VALUES ('6', '左在防守打法基本面', '15243425689', '123456', '1', '胸枯萎载李斐莉雪基材厅', '100', '1', '在霜期 霜期 棋', '1', '2017-08-01 02:16:03');
INSERT INTO `credit_loaner` VALUES ('7', '姑顶替基本面 ', '15213455698', '123456', '1', '123456', '100', '1', '夺阿斯蒂芬 阿斯蒂芬 棋', '1', '2017-08-01 02:16:48');
INSERT INTO `credit_loaner` VALUES ('8', 'WQ wq SD F', '13523654896', '123456', '1', 'sd fsad f大本营奇才棋某', '100', '1', '模压 柑模压 使用者顶替棋霜期 ', '1', '2017-08-01 02:36:15');
INSERT INTO `credit_loaner` VALUES ('9', '淡粉色阿斯蒂芬地', '15842365128', '123456', '1', '奇才模压模压 械', '100', '1', '左霜期 阿斯蒂芬 ', '1', '2017-08-01 02:39:20');
INSERT INTO `credit_loaner` VALUES ('10', '左载枯萎枯萎基本面棋', '15246589596', '123456', '2', '下富商大贾村压下克林霉素 枯', '100', '1', '大规模在李斐莉雪茜茜', '1', '2017-08-01 02:44:15');
INSERT INTO `credit_loaner` VALUES ('11', '左基载 ', '15845698523', '123456', '2', ' 夺顶替柑栽植顶替 ', '100', '1', '奔发电公司地时代复分工土木工程阿斯蒂芬 ', '1', '2017-08-01 02:45:38');
INSERT INTO `credit_loaner` VALUES ('12', '有东西苛', '15213425698', '123456', '1', '厅霜期 模压霜期 ', '100', '1', '基本面零用苛阿斯蒂芬 ', '1', '2017-08-01 02:47:27');
INSERT INTO `credit_loaner` VALUES ('13', '原貌压下枯干 ', '17785698123', '123456', '2', '标有一概而论枯干 顶替', '100', '1', '克林霉素 枯干 佣兵硅酸顶替', '1', '2017-08-01 02:50:11');
INSERT INTO `credit_loaner` VALUES ('14', '砍大本营', '13256898563', '123456', '2', '大本营在霜期地阿斯蒂芬 ', '100', '1', '左栽棋欠妥顶替 ', '1', '2017-08-01 06:30:46');
INSERT INTO `credit_loaner` VALUES ('15', '砍大本营', '13256898564', '123456', '2', '大本营在霜期地阿斯蒂芬 ', '100', '1', '左栽棋欠妥顶替 ', '1', '2017-08-01 06:34:07');
INSERT INTO `credit_loaner` VALUES ('16', 'dasf sdf a', '17578945638', '123456', '2', '夺茜脸色奇才柑棋寺', '100', '1', '在五块石 震天一概而论', '1', '2017-08-01 07:01:42');
INSERT INTO `credit_loaner` VALUES ('17', '仍我', '13566589565', '123456', '1', '仍顶替', '100', '1', '珠仍', '1', '2017-08-03 11:38:44');

-- ----------------------------
-- Table structure for credit_lona_request
-- ----------------------------
DROP TABLE IF EXISTS `credit_lona_request`;
CREATE TABLE `credit_lona_request` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
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
