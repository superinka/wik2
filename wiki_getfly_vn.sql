/*
Navicat MySQL Data Transfer

Source Server         : DEMO - 253
Source Server Version : 50505
Source Host           : 192.168.1.253:3306
Source Database       : wiki_getfly_vn

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-12-11 16:15:39
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `tb_categories`
-- ----------------------------
DROP TABLE IF EXISTS `tb_categories`;
CREATE TABLE `tb_categories` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_categories
-- ----------------------------
INSERT INTO tb_categories VALUES ('1', 'Tài liệu', 'Các tài liệu chung của phòng Sáng Tạo', '0', 'tai-lieu', null, '1');
INSERT INTO tb_categories VALUES ('3', 'Thông báo chung', '', '0', 'thong-bao-chung', null, '1');

-- ----------------------------
-- Table structure for `tb_comments`
-- ----------------------------
DROP TABLE IF EXISTS `tb_comments`;
CREATE TABLE `tb_comments` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(24) NOT NULL,
  `comment_time` datetime NOT NULL,
  `post_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `ip_address` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_comments
-- ----------------------------
INSERT INTO tb_comments VALUES ('1', '1', '2', '3', '0', '2017-12-11 14:39:53', '13', '1', '1', '192.168.1.13');
INSERT INTO tb_comments VALUES ('2', 'ok', 'ok', 'ok', '0', '2017-12-11 14:41:38', '13', '1', '1', '192.168.1.13');
INSERT INTO tb_comments VALUES ('3', 'ok', 'ok', 'xxxx', '2', '2017-12-11 15:06:45', '13', '1', '1', '192.168.1.13');

-- ----------------------------
-- Table structure for `tb_posts`
-- ----------------------------
DROP TABLE IF EXISTS `tb_posts`;
CREATE TABLE `tb_posts` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category` int(8) NOT NULL,
  `created_by` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publish_time` datetime NOT NULL,
  `publish_year` int(24) NOT NULL,
  `publish_month` int(24) NOT NULL,
  `last_edit` datetime NOT NULL,
  `thumbnail` text COLLATE utf8_unicode_ci NOT NULL,
  `views_count` int(128) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `access` tinyint(2) NOT NULL,
  `post_key` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_posts
-- ----------------------------
INSERT INTO tb_posts VALUES ('12', 'a', '', '3', '1', '', 'a', '2017-12-07 11:26:02', '2017', '12', '2017-12-07 15:56:00', 'c75264ce79065dc49959db1511922f82.jpg', '3', '1', '0', '9fa9b979-e9cc-4ac7-8e6e-27100274bf8a');
INSERT INTO tb_posts VALUES ('13', 'Installing Express', '', '3', '1', '<h2><strong>Installing ExpressInstalling ExpressInstalling ExpressInstalling ExpressInstalling Express</strong></h2>\r\n', 'installing-express', '2017-12-07 15:35:57', '2017', '12', '2017-12-07 15:55:52', 'no-thumbnail.jpg', '3', '1', '0', 'd88bc98f-da4a-45aa-a4fb-085a2ccae26c');

-- ----------------------------
-- Table structure for `tb_posts_relate`
-- ----------------------------
DROP TABLE IF EXISTS `tb_posts_relate`;
CREATE TABLE `tb_posts_relate` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `user_id` int(24) NOT NULL,
  `post_id` int(24) NOT NULL,
  `update_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_posts_relate
-- ----------------------------

-- ----------------------------
-- Table structure for `tb_posts_tags`
-- ----------------------------
DROP TABLE IF EXISTS `tb_posts_tags`;
CREATE TABLE `tb_posts_tags` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `post_id` int(24) NOT NULL,
  `tag_id` int(24) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_posts_tags
-- ----------------------------
INSERT INTO tb_posts_tags VALUES ('50', '12', '3');

-- ----------------------------
-- Table structure for `tb_tags`
-- ----------------------------
DROP TABLE IF EXISTS `tb_tags`;
CREATE TABLE `tb_tags` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_tags
-- ----------------------------
INSERT INTO tb_tags VALUES ('1', 'codeigniter', '2');
INSERT INTO tb_tags VALUES ('2', 'code', '1');
INSERT INTO tb_tags VALUES ('3', 'Ví dụ', '1');
INSERT INTO tb_tags VALUES ('4', '', '0');
INSERT INTO tb_tags VALUES ('5', 'huân', '1');

-- ----------------------------
-- Table structure for `tb_users`
-- ----------------------------
DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE `tb_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gender` tinyint(2) NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pass_word` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `role` tinyint(2) NOT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `activation_date` datetime NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tb_users
-- ----------------------------
INSERT INTO tb_users VALUES ('1', 'Huân', 'Vũ Mạnh', '1', 'thesuperinka@gmail.com', '979030879', 'admin', 'c4ca4238a0b923820dcc509a6f75849b', '1', '', '2017-12-05 00:00:00', '', '1');
INSERT INTO tb_users VALUES ('2', 'A', 'Nguyễn Văn', '1', 'nguyenvana@gmail.com', '123456789', 'nguyenvana', 'c4ca4238a0b923820dcc509a6f75849b', '2', null, '2017-12-05 00:00:00', null, '1');
INSERT INTO tb_users VALUES ('3', 'b', 'nguyenvan', '1', 'nguyevanb@gmail.com', '0', 'nguyenvanb', '25d55ad283aa400af464c76d713c07ad', '2', null, '2017-12-05 13:47:17', null, '1');
INSERT INTO tb_users VALUES ('4', 'c', 'nguyenvan', '1', 'nguyenvanc@gmail.com', '0', 'nguyenvanc', '25d55ad283aa400af464c76d713c07ad', '2', null, '2017-12-05 13:48:22', null, '1');
INSERT INTO tb_users VALUES ('5', 'd', 'nguyenvan', '0', 'nguyenvand@gmail.com', '123456789', 'nguyenvand', 'd41d8cd98f00b204e9800998ecf8427e', '2', null, '2017-12-05 13:50:04', '1dcd0068ff2d7d15033c255424455acf.jpg', '1');
