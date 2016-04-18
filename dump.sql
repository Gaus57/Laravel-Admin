/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50541
Source Host           : localhost:3306
Source Database       : admin

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2016-04-14 09:52:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for catalogs
-- ----------------------------
DROP TABLE IF EXISTS `catalogs`;
CREATE TABLE `catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `text` text,
  `class` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(510) NOT NULL DEFAULT '',
  `keywords` varchar(510) NOT NULL DEFAULT '',
  `description` varchar(510) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  `on_main` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of catalogs
-- ----------------------------
INSERT INTO `catalogs` VALUES ('1', '0', 'PlayStation', null, '', 'playstation', 'Playstation', '', '', '1', '1', '0', '2016-03-26 14:23:03', '2016-03-26 14:24:05', null);
INSERT INTO `catalogs` VALUES ('2', '0', 'Xbox', null, '', 'xbox', 'Xbox', '', '', '2', '1', '0', '2016-03-26 14:23:58', '2016-03-26 14:23:58', null);
INSERT INTO `catalogs` VALUES ('3', '0', 'Nintendo', null, '', 'nintendo', 'Nintendo', '', '', '3', '1', '0', '2016-03-26 14:25:13', '2016-03-26 14:25:13', null);
INSERT INTO `catalogs` VALUES ('4', '0', 'PC', null, '', 'pc', 'PC', '', '', '4', '1', '0', '2016-03-26 14:25:20', '2016-03-26 14:25:20', null);

-- ----------------------------
-- Table structure for catalogs_products
-- ----------------------------
DROP TABLE IF EXISTS `catalogs_products`;
CREATE TABLE `catalogs_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `text` text,
  `price` decimal(11,2) NOT NULL DEFAULT '0.00',
  `price_unit` decimal(11,2) NOT NULL DEFAULT '0.00',
  `unit` varchar(30) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `published` int(11) NOT NULL DEFAULT '0',
  `on_main` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(510) NOT NULL DEFAULT '',
  `keywords` varchar(510) NOT NULL,
  `description` varchar(510) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of catalogs_products
-- ----------------------------

-- ----------------------------
-- Table structure for catalogs_products_images
-- ----------------------------
DROP TABLE IF EXISTS `catalogs_products_images`;
CREATE TABLE `catalogs_products_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of catalogs_products_images
-- ----------------------------

-- ----------------------------
-- Table structure for feedbacks
-- ----------------------------
DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `data` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `read_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of feedbacks
-- ----------------------------

-- ----------------------------
-- Table structure for galleries
-- ----------------------------
DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `params` varchar(500) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of galleries
-- ----------------------------

-- ----------------------------
-- Table structure for galleries_items
-- ----------------------------
DROP TABLE IF EXISTS `galleries_items`;
CREATE TABLE `galleries_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  `data` text,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of galleries_items
-- ----------------------------

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `announce` text,
  `text` text,
  `image` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of news
-- ----------------------------

-- ----------------------------
-- Table structure for pages
-- ----------------------------
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `text` text,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(510) NOT NULL DEFAULT '',
  `keywords` varchar(510) NOT NULL DEFAULT '',
  `description` varchar(510) NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  `system` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pages
-- ----------------------------
INSERT INTO `pages` VALUES ('1', '0', 'Главная', '<p>Торговая марка «Интер-Окна» (ТОО «АсИнтерСтрой») является дочерним предприятием российской компании ООО «ИнтерСтрой». Мы работаем с ведущими застройщиками г. Екатеринбурга, Сургута, Ханты-Мансийска. Компания имеет большой опыт работы по изготовлению и монтажу светопрозрачных алюминиевых витражей, входных групп, вентилируемых фасадов.</p>\r\n\r\n<p>Уже более 8ми лет мы успешно занимаемся установкой окон для кирпичных, панельных домов и коттеджей под маркой «Семейные окна». За это время нами реализовано более 10 000 проектов и получено множество текстовых и видео отзывов от благодарных клиентов.</p>\r\n\r\n<p>«Интер-Строй» – динамично развивающаяся компания. Ультра современная Астана поражает не только своей красотой, но и большими возможностями для применения накопленного нами богатого опыта монтажа пластиковых конструкций. Для обеспечения высокого качества работы из Екатеринбурга в Астану приехали только лучшие специалисты: монтажники, мастера по замерам, менеджеры, и конечно, руководство компании. Наши клиенты в Астане могут быть абсолютно уверены в высоком качестве нашей работы на уровне европейских стандартов.</p>\r\n\r\n<p>Немецкий концерн VEKA доверяет изготовление своих окон только самым достойным производителям. В своей работе мы опираемся на производственные мощности лучшего изготовителя окон VEKA Казахстана - компании FEZAPlast (г. Караганда).</p>\r\n\r\n<p>При выборе партнёра, мы лично посетили цеха ведущих производителей и выбрали FEZAPlast за высокую технологичность и следование стандартам VEKA даже в мелочах: от профиля, с мощным замкнутым армированием (толщиной 1,5 мм), до современной фурнитуры и комплектующих, в т.ч. фирменных резиновых уплотнителей.</p>\r\n\r\n<p>Компания «Интер-Окна» гарантирует высокое качество установки окон по международным стандартам и приглашает Вас и Ваших близких за нашими окнами. Почувствуйте настоящий европейский комфорт!</p>\r\n\r\n<p> </p>\r\n\r\n<p>С уважением,</p>\r\n\r\n<p> </p>\r\n\r\n<p>Директор компании ТОО «АсИнтерСтрой»</p>\r\n\r\n<p>Афонин Вячеслав.</p>\r\n', '', 'Игровой магазин', '', '', '1', '1', '1', '2015-09-03 17:06:55', '2016-03-26 14:27:12');
INSERT INTO `pages` VALUES ('2', '1', 'Новости', '', 'news', 'Новости', '', '', '1', '1', '1', '2016-03-26 14:17:33', '2016-03-26 14:17:33');
INSERT INTO `pages` VALUES ('3', '1', 'Каталог', '', 'catalog', 'Каталог', '', '', '0', '1', '1', '2016-03-26 14:18:18', '2016-03-26 14:18:18');
INSERT INTO `pages` VALUES ('4', '1', 'Фотогалерея', '', 'gallery', 'Фотогалерея', '', '', '2', '1', '1', '2016-03-26 14:18:37', '2016-03-26 14:18:37');
INSERT INTO `pages` VALUES ('5', '1', 'О компании', '', 'about', 'О компании', '', '', '3', '1', '0', '2016-03-26 14:19:09', '2016-03-26 14:19:09');
INSERT INTO `pages` VALUES ('6', '1', 'Контакты', '', 'contacts', 'Контакты', '', '', '4', '1', '0', '2016-03-26 14:20:06', '2016-03-26 14:20:06');

-- ----------------------------
-- Table structure for reviews
-- ----------------------------
DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT '',
  `text` text,
  `adress` varchar(255) NOT NULL DEFAULT '',
  `video` varchar(255) NOT NULL DEFAULT '',
  `on_main` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of reviews
-- ----------------------------

-- ----------------------------
-- Table structure for settings
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `params` text NOT NULL,
  `value` text,
  `type` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`,`code`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings
-- ----------------------------

-- ----------------------------
-- Table structure for settings_groups
-- ----------------------------
DROP TABLE IF EXISTS `settings_groups`;
CREATE TABLE `settings_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(52) NOT NULL,
  `description` text,
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of settings_groups
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `remember_token` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `phone` varchar(60) NOT NULL DEFAULT '',
  `role` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'mThN7UAOHvi6rQlWpEhUMb3UgfgdSRVIJmuCpoX0FBQF7MGd4Uddn0px1pP9ayGGVwszhed64ke99uGvE8E5TnRDzCxfdNv0DFAE', 'Администратор', 'oleg@klee.ru', '', '100', '1', '2015-09-01 10:39:10', '2015-08-28 17:49:09', null);
