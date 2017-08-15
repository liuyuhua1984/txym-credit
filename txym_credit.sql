/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50717
Source Host           : 127.0.0.1:3306
Source Database       : txym_credit

Target Server Type    : MYSQL
Target Server Version : 50717
File Encoding         : 65001

Date: 2017-08-15 18:29:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for credit_amenu_url
-- ----------------------------
DROP TABLE IF EXISTS `credit_amenu_url`;
CREATE TABLE `credit_amenu_url` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) NOT NULL,
  `menu_url` varchar(255) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_show` tinyint(4) NOT NULL COMMENT '是否在sidebar里出现',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '在线状态，还是下线状态，即可用，不可用。',
  `shortcut_allowed` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许快捷访问',
  `menu_desc` varchar(255) DEFAULT NULL,
  `father_menu` int(11) NOT NULL DEFAULT '0' COMMENT '上一级菜单',
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menu_url` (`menu_url`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='功能链接（菜单链接）';

-- ----------------------------
-- Records of credit_amenu_url
-- ----------------------------
INSERT INTO `credit_amenu_url` VALUES ('1', '首页', '/admin/Index/index', '1', '0', '1', '1', '后台首页', '0');
INSERT INTO `credit_amenu_url` VALUES ('2', '借出账号', '/admin/Aloaner/index', '1', '1', '1', '1', '借出账号', '0');
INSERT INTO `credit_amenu_url` VALUES ('3', '借款账号', '/panel/user_modify.php', '1', '1', '1', '0', '借款账号', '0');
INSERT INTO `credit_amenu_url` VALUES ('4', '借款申请记录', '/panel/user_add.php', '1', '1', '1', '1', '借款申请记录', '0');
INSERT INTO `credit_amenu_url` VALUES ('5', '拒绝申请', '/panel/profile.php', '1', '0', '1', '1', '拒绝申请', '4');
INSERT INTO `credit_amenu_url` VALUES ('6', '同意申请', '/panel/group.php', '1', '0', '1', '0', '同意申请', '4');
INSERT INTO `credit_amenu_url` VALUES ('7', '黑名单', '/panel/groups.php', '1', '1', '1', '1', '黑名单', '0');
INSERT INTO `credit_amenu_url` VALUES ('8', '加入黑名单', '/panel/group_modify.php', '1', '0', '1', '0', '加入黑名单', '7');
INSERT INTO `credit_amenu_url` VALUES ('9', '删除黑名单', '/panel/group_add.php', '1', '0', '1', '1', '删除黑名单', '7');
INSERT INTO `credit_amenu_url` VALUES ('10', '权限管理', '/panel/group_role.php', '1', '1', '1', '1', '用户权限依赖于账号组的权限', '0');
INSERT INTO `credit_amenu_url` VALUES ('11', '菜单模块', '/panel/modules.php', '1', '1', '1', '1', '菜单里的模块', '0');
INSERT INTO `credit_amenu_url` VALUES ('12', '编辑菜单模块', '/panel/module_modify.php', '1', '0', '1', '0', '编辑模块', '11');
INSERT INTO `credit_amenu_url` VALUES ('13', '添加菜单模块', '/panel/module_add.php', '1', '0', '1', '1', '添加菜单模块', '11');
INSERT INTO `credit_amenu_url` VALUES ('14', '功能列表', '/panel/menus.php', '1', '1', '1', '1', '菜单功能及可访问的链接', '0');
INSERT INTO `credit_amenu_url` VALUES ('15', '增加功能', '/panel/menu_add.php', '1', '0', '1', '1', '增加功能', '14');
INSERT INTO `credit_amenu_url` VALUES ('16', '功能修改', '/panel/menu_modify.php', '1', '0', '1', '0', '修改功能', '14');
INSERT INTO `credit_amenu_url` VALUES ('17', '设置模板', '/panel/set.php', '1', '0', '1', '1', '设置模板', '0');
INSERT INTO `credit_amenu_url` VALUES ('18', '便签管理', '/panel/quicknotes.php', '1', '1', '1', '1', 'quick note', '0');
INSERT INTO `credit_amenu_url` VALUES ('19', '菜单链接列表', '/panel/module.php', '1', '0', '1', '0', '显示模块详情及该模块下的菜单', '11');
INSERT INTO `credit_amenu_url` VALUES ('20', '登入', '/login.php', '1', '0', '1', '1', '登入页面', '0');
INSERT INTO `credit_amenu_url` VALUES ('21', '操作记录', '/panel/syslog.php', '1', '1', '1', '1', '用户操作的历史行为', '0');
INSERT INTO `credit_amenu_url` VALUES ('22', '系统信息', '/panel/system.php', '1', '1', '1', '1', '显示系统相关信息', '0');
INSERT INTO `credit_amenu_url` VALUES ('23', 'ajax访问修改快捷菜单', '/ajax/shortcut.php', '1', '0', '1', '0', 'ajax请求', '0');
INSERT INTO `credit_amenu_url` VALUES ('24', '添加便签', '/panel/quicknote_add.php', '1', '0', '1', '1', '添加quicknote的内容', '18');
INSERT INTO `credit_amenu_url` VALUES ('25', '修改便签', '/panel/quicknote_modify.php', '1', '0', '1', '0', '修改quicknote的内容', '18');
INSERT INTO `credit_amenu_url` VALUES ('26', '系统设置', '/panel/setting.php', '1', '0', '1', '0', '系统设置', '0');
INSERT INTO `credit_amenu_url` VALUES ('101', '样例', '/sample/sample.php', '2', '1', '1', '1', '', '0');
INSERT INTO `credit_amenu_url` VALUES ('103', '读取XLS文件', '/sample/read_excel.php', '2', '1', '1', '1', '', '0');

-- ----------------------------
-- Table structure for credit_amodule
-- ----------------------------
DROP TABLE IF EXISTS `credit_amodule`;
CREATE TABLE `credit_amodule` (
  `module_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_url` varchar(128) NOT NULL,
  `module_sort` int(11) unsigned NOT NULL DEFAULT '1',
  `module_desc` varchar(255) DEFAULT NULL,
  `module_icon` varchar(32) DEFAULT 'icon-th' COMMENT '菜单模块图标',
  `online` int(11) NOT NULL DEFAULT '1' COMMENT '模块是否在线',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='菜单模块';

-- ----------------------------
-- Records of credit_amodule
-- ----------------------------
INSERT INTO `credit_amodule` VALUES ('1', '用户管理', '/Index/index.php', '0', '配置OSAdmin的相关功能', 'icon-th', '1');
INSERT INTO `credit_amodule` VALUES ('2', '样例模块', '/panel/index.php', '1', '样例模块', 'icon-leaf', '1');

-- ----------------------------
-- Table structure for credit_aquick_note
-- ----------------------------
DROP TABLE IF EXISTS `credit_aquick_note`;
CREATE TABLE `credit_aquick_note` (
  `note_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'note_id',
  `note_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
  `owner_id` int(10) unsigned NOT NULL COMMENT '谁添加的',
  PRIMARY KEY (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用于显示的quick note';

-- ----------------------------
-- Records of credit_aquick_note
-- ----------------------------
INSERT INTO `credit_aquick_note` VALUES ('6', '孔子说：万能的不是神，是程序员！', '1');
INSERT INTO `credit_aquick_note` VALUES ('7', '听说飞信被渗透了几百台服务器', '1');
INSERT INTO `credit_aquick_note` VALUES ('8', '（yamete）＝不要 ，一般音译为”亚美爹”，正确发音是：亚灭贴', '1');
INSERT INTO `credit_aquick_note` VALUES ('9', '（kimochiii）＝爽死了，一般音译为”可莫其”，正确发音是：克一莫其一一 ', '1');
INSERT INTO `credit_aquick_note` VALUES ('10', '（itai）＝疼 ，一般音译为以太', '1');
INSERT INTO `credit_aquick_note` VALUES ('11', '（iku）＝要出来了 ，一般音译为一库', '1');
INSERT INTO `credit_aquick_note` VALUES ('12', '（soko dame）＝那里……不可以 一般音译：锁扩，打灭', '1');
INSERT INTO `credit_aquick_note` VALUES ('13', '(hatsukashi)＝羞死人了 ，音译：哈次卡西', '1');
INSERT INTO `credit_aquick_note` VALUES ('14', '（atashinookuni）＝到人家的身体里了，音译：啊她西诺喔库你', '1');
INSERT INTO `credit_aquick_note` VALUES ('15', '（mottto mottto）＝还要，还要，再大力点的意思 音译：毛掏 毛掏', '1');
INSERT INTO `credit_aquick_note` VALUES ('20', '这是一条含HTML的便签 <a href=\"http://www.osadmin.org\">osadmin.org</a>', '1');
INSERT INTO `credit_aquick_note` VALUES ('23', '你造吗？quick note可以关掉的，在右上角的我的账号里可以设置的。', '1');
INSERT INTO `credit_aquick_note` VALUES ('24', '你造吗？“功能”其实就是“链接”啦啦，权限控制是根据用户访问的链接来验证的。', '1');
INSERT INTO `credit_aquick_note` VALUES ('25', '你造吗？权限是赋予给账号组的，账号组下的用户拥有相同的权限。', '1');
INSERT INTO `credit_aquick_note` VALUES ('26', 'Hi，你注意到navibar上的+号和-号了吗？', '1');
INSERT INTO `credit_aquick_note` VALUES ('27', '假如世界上只剩下两坨屎，我一定会把热的留给你', '1');
INSERT INTO `credit_aquick_note` VALUES ('28', '你造吗？这页面设计用是bootstrap模板改的', '1');
INSERT INTO `credit_aquick_note` VALUES ('29', '你造吗？这全部都是我一个人开发的，可特么累了', '1');
INSERT INTO `credit_aquick_note` VALUES ('30', '客官有什么建议可以直接在weibo.com上<a target=_blank  href =\"http://weibo.com/osadmin\">@OSAdmin官网</a> 本店服务一定会让客官满意的！亚美爹！', '1');

-- ----------------------------
-- Table structure for credit_asample
-- ----------------------------
DROP TABLE IF EXISTS `credit_asample`;
CREATE TABLE `credit_asample` (
  `sample_id` int(11) NOT NULL,
  `sample_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of credit_asample
-- ----------------------------
INSERT INTO `credit_asample` VALUES ('1', '这是一个样例');

-- ----------------------------
-- Table structure for credit_asystem
-- ----------------------------
DROP TABLE IF EXISTS `credit_asystem`;
CREATE TABLE `credit_asystem` (
  `key_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key_value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='系统配置表';

-- ----------------------------
-- Records of credit_asystem
-- ----------------------------
INSERT INTO `credit_asystem` VALUES ('timezone', '\"Asia/Shanghai\"');

-- ----------------------------
-- Table structure for credit_asys_log
-- ----------------------------
DROP TABLE IF EXISTS `credit_asys_log`;
CREATE TABLE `credit_asys_log` (
  `op_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) NOT NULL,
  `action` varchar(255) NOT NULL,
  `class_name` varchar(255) NOT NULL COMMENT '操作了哪个类的对象',
  `class_obj` varchar(32) NOT NULL COMMENT '操作的对象是谁，可能为对象的ID',
  `result` text NOT NULL COMMENT '操作的结果',
  `op_time` int(11) NOT NULL,
  PRIMARY KEY (`op_id`),
  KEY `op_time` (`op_time`) USING BTREE,
  KEY `class_name` (`class_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='操作日志表';

-- ----------------------------
-- Records of credit_asys_log
-- ----------------------------
INSERT INTO `credit_asys_log` VALUES ('1', 'admin', 'LOGIN', 'User', '', '\"\\u7528\\u6237\\u540d\\u6216\\u5bc6\\u7801\\u9519\\u8bef\"', '1502077441');
INSERT INTO `credit_asys_log` VALUES ('2', 'admin', 'LOGIN', 'User', '1', '{\"IP\":\"127.0.0.1\"}', '1502077462');

-- ----------------------------
-- Table structure for credit_auser
-- ----------------------------
DROP TABLE IF EXISTS `credit_auser`;
CREATE TABLE `credit_auser` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `real_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_desc` varchar(255) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `login_ip` varchar(32) DEFAULT NULL,
  `user_group` int(11) NOT NULL,
  `template` varchar(32) NOT NULL DEFAULT 'default' COMMENT '主题模板',
  `shortcuts` text COMMENT '快捷菜单',
  `show_quicknote` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示quicknote',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='后台用户';

-- ----------------------------
-- Records of credit_auser
-- ----------------------------
INSERT INTO `credit_auser` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'SomewhereYu', '13800138001', 'admin@osadmin.org', '初始的超级管理员!', '1502792041', '1', '127.0.0.1', '1', 'schoolpainting', '2,7,10,11,13,14,18,21,24', '0');
INSERT INTO `credit_auser` VALUES ('26', 'demo', 'e10adc3949ba59abbe56e057f20f883e', 'SomewhereYu', '15812345678', 'yuwenqi@osadmin.org', '默认用户组成员', '1371605873', '1', '127.0.0.1', '2', 'schoolpainting', '', '1');

-- ----------------------------
-- Table structure for credit_auser_group
-- ----------------------------
DROP TABLE IF EXISTS `credit_auser_group`;
CREATE TABLE `credit_auser_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) DEFAULT NULL,
  `group_role` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '初始权限为1,5,17,18,22,23,24,25',
  `owner_id` int(11) DEFAULT NULL COMMENT '创建人ID',
  `group_desc` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='账号组';

-- ----------------------------
-- Records of credit_auser_group
-- ----------------------------
INSERT INTO `credit_auser_group` VALUES ('1', '超级管理员组', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,101,103', '1', '万能的不是神，是程序员');
INSERT INTO `credit_auser_group` VALUES ('2', '默认账号组', '1,5,17,18,20,22,23,24,25,101', '1', '默认账号组');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of credit_borrow_record
-- ----------------------------
INSERT INTO `credit_borrow_record` VALUES ('1', '11', '3', '10', '36', '2017080456569997', '2017-08-04 04:48:24');
INSERT INTO `credit_borrow_record` VALUES ('2', '11', '5', '15', '52', '2017080453559710', '2017-08-04 04:48:53');
INSERT INTO `credit_borrow_record` VALUES ('3', '12', '3', '10', '10', '2017080453541001', '2017-08-04 04:49:57');
INSERT INTO `credit_borrow_record` VALUES ('4', '12', '7', '0', '0', '2017080455505010', '2017-08-04 04:52:55');
INSERT INTO `credit_borrow_record` VALUES ('5', '12', '6', '0', '0', '2017080449535148', '2017-08-04 04:56:49');

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
