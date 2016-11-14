-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Окт 16 2016 г., 13:45
-- Версия сервера: 5.5.49-cll-lve
-- Версия PHP: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `rlestate`
--

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_assets`
--

CREATE TABLE IF NOT EXISTS `h0qwo_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int(10) unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=80 ;

--
-- Дамп данных таблицы `h0qwo_assets`
--

INSERT INTO `h0qwo_assets` (`id`, `parent_id`, `lft`, `rgt`, `level`, `name`, `title`, `rules`) VALUES
(1, 0, 0, 99, 0, 'root.1', 'Root Asset', '{"core.login.site":{"6":1,"2":1},"core.login.admin":{"6":1},"core.login.offline":{"6":1},"core.admin":{"8":1},"core.manage":{"7":1},"core.create":{"6":1,"3":1},"core.delete":{"6":1},"core.edit":{"6":1,"4":1},"core.edit.state":{"6":1,"5":1},"core.edit.own":{"6":1,"3":1}}'),
(2, 1, 1, 2, 1, 'com_admin', 'com_admin', '{}'),
(3, 1, 3, 6, 1, 'com_banners', 'com_banners', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(4, 1, 7, 8, 1, 'com_cache', 'com_cache', '{"core.admin":{"7":1},"core.manage":{"7":1}}'),
(5, 1, 9, 10, 1, 'com_checkin', 'com_checkin', '{"core.admin":{"7":1},"core.manage":{"7":1}}'),
(6, 1, 11, 12, 1, 'com_config', 'com_config', '{}'),
(7, 1, 13, 16, 1, 'com_contact', 'com_contact', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(8, 1, 17, 34, 1, 'com_content', 'com_content', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}'),
(9, 1, 35, 36, 1, 'com_cpanel', 'com_cpanel', '{}'),
(10, 1, 37, 38, 1, 'com_installer', 'com_installer', '{"core.admin":[],"core.manage":{"7":0},"core.delete":{"7":0},"core.edit.state":{"7":0}}'),
(11, 1, 39, 40, 1, 'com_languages', 'com_languages', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(12, 1, 41, 42, 1, 'com_login', 'com_login', '{}'),
(13, 1, 43, 44, 1, 'com_mailto', 'com_mailto', '{}'),
(14, 1, 45, 46, 1, 'com_massmail', 'com_massmail', '{}'),
(15, 1, 47, 48, 1, 'com_media', 'com_media', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":{"5":1}}'),
(16, 1, 49, 50, 1, 'com_menus', 'com_menus', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(17, 1, 51, 52, 1, 'com_messages', 'com_messages', '{"core.admin":{"7":1},"core.manage":{"7":1}}'),
(18, 1, 53, 62, 1, 'com_modules', 'com_modules', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(19, 1, 63, 66, 1, 'com_newsfeeds', 'com_newsfeeds', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(20, 1, 67, 68, 1, 'com_plugins', 'com_plugins', '{"core.admin":{"7":1},"core.manage":[],"core.edit":[],"core.edit.state":[]}'),
(21, 1, 69, 70, 1, 'com_redirect', 'com_redirect', '{"core.admin":{"7":1},"core.manage":[]}'),
(22, 1, 71, 72, 1, 'com_search', 'com_search', '{"core.admin":{"7":1},"core.manage":{"6":1}}'),
(23, 1, 73, 74, 1, 'com_templates', 'com_templates', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(24, 1, 75, 78, 1, 'com_users', 'com_users', '{"core.admin":{"7":1},"core.manage":[],"core.create":[],"core.delete":[],"core.edit":[],"core.edit.own":{"6":1},"core.edit.state":[]}'),
(26, 1, 79, 80, 1, 'com_wrapper', 'com_wrapper', '{}'),
(27, 8, 18, 19, 2, 'com_content.category.2', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(28, 3, 4, 5, 2, 'com_banners.category.3', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(29, 7, 14, 15, 2, 'com_contact.category.4', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(30, 19, 64, 65, 2, 'com_newsfeeds.category.5', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(32, 24, 76, 77, 1, 'com_users.category.7', 'Uncategorised', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[]}'),
(33, 1, 81, 82, 1, 'com_finder', 'com_finder', '{"core.admin":{"7":1},"core.manage":{"6":1}}'),
(35, 8, 20, 23, 2, 'com_content.category.9', 'Blog', '{"core.create":[],"core.delete":[],"core.edit":[],"core.edit.state":[],"core.edit.own":[]}'),
(41, 1, 83, 84, 1, 'com_users.category.10', 'Uncategorised', ''),
(42, 1, 85, 86, 1, 'com_joomlaupdate', 'com_joomlaupdate', '{"core.admin":[],"core.manage":[],"core.delete":[],"core.edit.state":[]}'),
(44, 1, 87, 88, 1, 'com_tags', 'com_tags', '{"core.admin":{"8":1},"core.manage":{"7":1},"core.create":{"6":1,"3":1},"core.delete":{"6":1},"core.edit":{"6":1,"4":1},"core.edit.state":{"6":1,"5":1}}'),
(45, 1, 89, 90, 1, 'com_contenthistory', 'com_contenthistory', '{}'),
(46, 1, 91, 92, 1, 'com_ajax', 'com_ajax', '{}'),
(47, 1, 93, 94, 1, 'com_postinstall', 'com_postinstall', '{}'),
(48, 8, 24, 25, 2, 'com_content.category.10', 'Rental of property', '{}'),
(50, 8, 26, 27, 2, 'com_content.category.11', 'Mortgage', '{}'),
(52, 8, 28, 31, 2, 'com_content.category.12', 'The property', '{}'),
(53, 52, 29, 30, 3, 'com_content.category.13', 'Country estate', '{}'),
(55, 1, 95, 96, 1, 'com_sppagebuilder', 'SP Page Builder', '{}'),
(56, 18, 54, 55, 2, 'com_modules.module.93', 'SP Page Builder', '{}'),
(57, 18, 56, 57, 2, 'com_modules.module.94', 'SP Page Builder Admin Menu', '{}'),
(58, 18, 58, 59, 2, 'com_modules.module.95', 'JSitemap module', '{}'),
(59, 18, 60, 61, 2, 'com_modules.module.96', 'JSitemap Quickicons', '{}'),
(60, 1, 97, 98, 1, 'com_jmap', 'JMap', '{}'),
(71, 8, 32, 33, 2, 'com_content.category.14', 'Resellers', '{}'),
(79, 35, 21, 22, 3, 'com_content.article.27', 'Когда новостройка почти построена, есть ли риск при покупке?', '{"core.admin":{"7":1},"core.manage":{"6":1},"core.create":{"3":1},"core.delete":[],"core.edit":{"4":1},"core.edit.state":{"5":1},"core.edit.own":[]}');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_associations`
--

CREATE TABLE IF NOT EXISTS `h0qwo_associations` (
  `id` int(11) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_banners`
--

CREATE TABLE IF NOT EXISTS `h0qwo_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT '0',
  `impmade` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `clickurl` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custombannercode` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`(100)),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_banner_clients`
--

CREATE TABLE IF NOT EXISTS `h0qwo_banner_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extrainfo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `own_prefix` tinyint(4) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT '-1',
  `track_clicks` tinyint(4) NOT NULL DEFAULT '-1',
  `track_impressions` tinyint(4) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_banner_tracks`
--

CREATE TABLE IF NOT EXISTS `h0qwo_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_categories`
--

CREATE TABLE IF NOT EXISTS `h0qwo_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`(100)),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `h0qwo_categories`
--

INSERT INTO `h0qwo_categories` (`id`, `asset_id`, `parent_id`, `lft`, `rgt`, `level`, `path`, `extension`, `title`, `alias`, `note`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `params`, `metadesc`, `metakey`, `metadata`, `created_user_id`, `created_time`, `modified_user_id`, `modified_time`, `hits`, `language`, `version`) VALUES
(1, 0, 0, 0, 23, 0, '', 'system', 'ROOT', 'root', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{}', '', '', '', 528, '2011-01-01 00:00:01', 0, '0000-00-00 00:00:00', 0, '*', 1),
(2, 27, 1, 1, 2, 1, 'uncategorised', 'com_content', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":"","image_alt":""}', '', '', '{"author":"","robots":""}', 528, '2011-01-01 00:00:01', 528, '2016-04-24 12:50:01', 0, '*', 1),
(3, 28, 1, 3, 4, 1, 'uncategorised', 'com_banners', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":"","foobar":""}', '', '', '{"page_title":"","author":"","robots":""}', 528, '2011-01-01 00:00:01', 0, '0000-00-00 00:00:00', 0, '*', 1),
(4, 29, 1, 5, 6, 1, 'uncategorised', 'com_contact', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 528, '2011-01-01 00:00:01', 0, '0000-00-00 00:00:00', 0, '*', 1),
(5, 30, 1, 7, 8, 1, 'uncategorised', 'com_newsfeeds', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 528, '2011-01-01 00:00:01', 0, '0000-00-00 00:00:00', 0, '*', 1),
(7, 32, 1, 9, 10, 1, 'uncategorised', 'com_users', 'Uncategorised', 'uncategorised', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"target":"","image":""}', '', '', '{"page_title":"","author":"","robots":""}', 528, '2011-01-01 00:00:01', 0, '0000-00-00 00:00:00', 0, '*', 1),
(9, 35, 1, 11, 12, 1, 'blog', 'com_content', 'Blog', 'blog', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":""}', '', '', '{"author":"","robots":""}', 528, '2011-01-01 00:00:01', 0, '0000-00-00 00:00:00', 0, '*', 1),
(10, 48, 1, 13, 14, 1, 'rental-of-property', 'com_content', 'Rental of property', 'rental-of-property', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":"","image_alt":""}', '', '', '{"author":"","robots":""}', 528, '2016-04-10 07:26:14', 528, '2016-04-12 10:41:10', 0, '*', 1),
(11, 50, 1, 15, 16, 1, 'mortgage', 'com_content', 'Mortgage', 'mortgage', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":"","image_alt":""}', '', '', '{"author":"","robots":""}', 528, '2016-04-10 07:45:17', 528, '2016-04-13 11:22:34', 0, '*', 1),
(12, 52, 1, 17, 20, 1, 'the-property', 'com_content', 'The property', 'the-property', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":"","image_alt":""}', '', '', '{"author":"","robots":""}', 528, '2016-04-10 12:05:38', 0, '2016-04-10 12:05:38', 0, '*', 1),
(13, 53, 12, 18, 19, 2, 'the-property/country-estate', 'com_content', 'Country estate', 'country-estate', '', '', 1, 0, '0000-00-00 00:00:00', 1, '{"category_layout":"","image":"","image_alt":""}', '', '', '{"author":"","robots":""}', 528, '2016-04-10 12:06:39', 528, '2016-04-10 12:12:09', 0, '*', 1),
(14, 71, 1, 21, 22, 1, 'resellers', 'com_content', 'Resellers', 'resellers', '', '', 1, 528, '2016-04-15 08:21:05', 1, '{"category_layout":"","image":"","image_alt":""}', '', '', '{"author":"","robots":""}', 528, '2016-04-15 07:55:18', 0, '2016-04-15 07:55:18', 0, '*', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_contact_details`
--

CREATE TABLE IF NOT EXISTS `h0qwo_contact_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `con_position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `suburb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misc` mediumtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_con` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `catid` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `webpage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortname2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sortname3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_content`
--

CREATE TABLE IF NOT EXISTS `h0qwo_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `h0qwo_content`
--

INSERT INTO `h0qwo_content` (`id`, `asset_id`, `title`, `alias`, `introtext`, `fulltext`, `state`, `catid`, `created`, `created_by`, `created_by_alias`, `modified`, `modified_by`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `images`, `urls`, `attribs`, `version`, `ordering`, `metakey`, `metadesc`, `access`, `hits`, `metadata`, `featured`, `language`, `xreference`) VALUES
(27, 79, 'Когда новостройка почти построена, есть ли риск при покупке?', 'kogda-novostrojka-pochti-postroena-est-li-risk-pri-pokupke', '<p style="text-align: justify;"><strong>Интервью на тему «Риски на последних стадиях строительства новостройки»</strong>.</p>\r\n', '\r\n<p style="text-align: justify;"><strong>Вопрос: <i>«</i></strong><i>С приближением стройки к завершению риски уменьшаются, но все-таки не исчезают совсем. С какими рисками может столкнуться дольщик, приобретая квартиру на финальных стадиях строительства (возведение последних этажей, внутренняя отделка и т.п.)»<span id="more-407"></span></i></p>\r\n<p style="text-align: justify;"><b>Ответ:</b> Полагаем, что риск приобретения жилья с юридическим дефектом можно назвать самым опасным. Например, по завершению строительства жилого дома органы власти выдают разрешение на ввод объекта в эксплуатацию. Отсутствие этого документа является препятствием для признания дома и помещений в нём объектами недвижимости. Другими словами, дольщику оформить квартиру в собственность будет проблематично.</p>\r\n<p style="text-align: justify;"><b> </b></p>\r\n<p style="text-align: justify;"><b>В.: </b><i>«Сохраняются ли на финальных стадиях строительства риски недостроя и долгостроя? Или сегодня (в силу 214 закона и др. законодательных актов) такие случаи практически невозможны?»</i></p>\r\n<p style="text-align: justify;"><b>О.:</b> На практике риск недостроя или долгостроя сохраняется всегда. Такие неблагоприятные последствия зависят от состояния экономики в целом или компании – застройщика в частности. Экономику трудно загнать в тиски законодательного регулирования.  Федеральный закон от 30.12.2004 №214-ФЗ «Об участии в долевом строительстве многоквартирных домов и иных объектов недвижимости…» ввёл правила, которые установили законные схемы привлечения денежных средств на стадии строительства, прописали порядок действий и ответственность для застройщика, разрешили другие вопросы. Тем не менее, закон не спасает от экономических затруднений и банкротства.</p>\r\n<p style="text-align: justify;"> <i>«Какие риски есть при покупке квартиры в уже достроенном, но не сданном доме? А какие риски сохраняются в том случае, когда дом уже сдан?»</i></p>\r\n<p style="text-align: justify;">В обоих случаях основные риски связаны с юридическими дефектами. Только в случае  покупки квартиры в достроенном, но не сданном доме проблем может быть больше. Начиная от промедления с оформлением права собственности покупателей на квартиру, заканчивая сносом здания как самовольной постройки.</p>\r\n<p style="text-align: justify;"> </p>\r\n<p style="text-align: justify;"><b>В.:</b> <i>«Как дольщик может нивилировать указанные риски на финальном этапе строительства, на этапе сдачи дома и после сдачи? Может ли помочь страхование финансовых рисков или пока это не очень работающий механизм?»</i></p>\r\n<p style="text-align: justify;"><b>О.:</b> У кого в жизни наступал страховой случай, тот знает, как в России можно получить деньги от страховых компаний! На наш взгляд механизмы добровольного страхования рисков, что действуют сегодня, не снизили риски недостроя или долгостроя. С 1 января 2014 года появится механизм взаимного страхования ответственности застройщиков – вот это может быть интересно с точки зрения повышения защищенности граждан.</p>\r\n<p style="text-align: justify;"> </p>\r\n<p style="text-align: justify;"><b>В.:</b> <i>«На что стоит обращать внимание, чтобы избежать неприятных сюрпризов?»</i></p>\r\n<p style="text-align: justify;"><b>О.:</b> Наш совет  — пригласите на ознакомление с документами и сделку по приобретения квартиры в новостройке юриста, ну или риэлтора. Найти юриста, который действительно специализируется на недвижимости трудно, но возможно.</p>\r\n<p style="text-align: justify;"> </p>\r\n<p style="text-align: justify;"><b>В.:</b> <i>«Что делать дольщику, если события развиваются по неприятному сценарию и он все-таки столкнулся с указанными рисками?»</i></p>\r\n<p style="text-align: justify;"><b>О.: </b>Мы рекомендуем дольщику в случае наступления негативной ситуации при строительстве жилья проконсультироваться с юристом, который специализируется на рынке недвижимости.</p>\r\n<p style="text-align: justify;"> </p>\r\n<p style="text-align: justify;"><b>В.:</b> <i>«Стоит ли обращаться в суд? И реально ли решить дело в свою пользу в суде?»</i></p>\r\n<p class="MsoNormal"> </p>\r\n<p style="text-align: justify;"><b>О.: </b>Суд может быть эффективным, а иногда — единственным способом защиты нарушенных прав или законных интересов дольщиков. Несмотря на то, что граждане сегодня с недоверием относятся к властным институтам, мы из практики знаем, что суды реально могут помочь. Так, например, суды признавали право собственности на квартиру, когда у граждан на руках имелись предварительные договора купли-продажи.  С юридической точки зрения это были неоднозначные решения, но людям они помогали вчера. Помогают и сегодня.</p>', 1, 9, '2016-07-06 13:43:44', 528, '', '2016-07-14 08:03:48', 528, 0, '0000-00-00 00:00:00', '2016-07-06 13:43:44', '0000-00-00 00:00:00', '{"image_intro":"images\\/06-07-2016\\/article2\\/novos.jpg","float_intro":"","image_intro_alt":"","image_intro_caption":"","image_fulltext":"images\\/06-07-2016\\/article2\\/novos.jpg","float_fulltext":"","image_fulltext_alt":"","image_fulltext_caption":""}', '{"urla":false,"urlatext":"","targeta":"","urlb":false,"urlbtext":"","targetb":"","urlc":false,"urlctext":"","targetc":""}', '{"show_title":"","link_titles":"","show_tags":"","show_intro":"","info_block_position":"","info_block_show_title":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_vote":"","show_hits":"","show_noauth":"","urls_position":"","alternative_readmore":"","article_layout":"","show_publishing_options":"","show_article_options":"","show_urls_images_backend":"","show_urls_images_frontend":"","spfeatured_image":"","post_format":"standard","gallery":"","audio":"","video":"","link_title":"","link_url":"","quote_text":"","quote_author":"","post_status":""}', 9, 0, '', '', 1, 70, '{"robots":"","author":"","rights":"","xreference":""}', 1, '*', '');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_contentitem_tag_map`
--

CREATE TABLE IF NOT EXISTS `h0qwo_contentitem_tag_map` (
  `type_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_content_id` int(10) unsigned NOT NULL COMMENT 'PK from the core content table',
  `content_item_id` int(11) NOT NULL COMMENT 'PK from the content type table',
  `tag_id` int(10) unsigned NOT NULL COMMENT 'PK from the tag table',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date of most recent save for this tag-item',
  `type_id` mediumint(8) NOT NULL COMMENT 'PK from the content_type table',
  UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`content_item_id`,`tag_id`),
  KEY `idx_tag_type` (`tag_id`,`type_id`),
  KEY `idx_date_id` (`tag_date`,`tag_id`),
  KEY `idx_core_content_id` (`core_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps items from content tables to tags';

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_content_frontpage`
--

CREATE TABLE IF NOT EXISTS `h0qwo_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `h0qwo_content_frontpage`
--

INSERT INTO `h0qwo_content_frontpage` (`content_id`, `ordering`) VALUES
(7, 6),
(8, 20),
(9, 19),
(10, 18),
(11, 17),
(12, 16),
(13, 15),
(14, 14),
(15, 13),
(16, 12),
(17, 11),
(18, 10),
(19, 9),
(20, 8),
(21, 7),
(22, 21),
(23, 5),
(24, 4),
(25, 3),
(26, 2),
(27, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_content_rating`
--

CREATE TABLE IF NOT EXISTS `h0qwo_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT '0',
  `rating_sum` int(10) unsigned NOT NULL DEFAULT '0',
  `rating_count` int(10) unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_content_types`
--

CREATE TABLE IF NOT EXISTS `h0qwo_content_types` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_mappings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `router` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON string for com_contenthistory options',
  PRIMARY KEY (`type_id`),
  KEY `idx_alias` (`type_alias`(100))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `h0qwo_content_types`
--

INSERT INTO `h0qwo_content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`) VALUES
(1, 'Article', 'com_content.article', '{"special":{"dbtable":"#__content","key":"id","type":"Content","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"state","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"introtext", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"attribs", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"urls", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"xreference", "asset_id":"asset_id"}, "special":{"fulltext":"fulltext"}}', 'ContentHelperRoute::getArticleRoute', '{"formFile":"administrator\\/components\\/com_content\\/models\\/forms\\/article.xml", "hideFields":["asset_id","checked_out","checked_out_time","version"],"ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time", "version", "hits"],"convertToInt":["publish_up", "publish_down", "featured", "ordering"],"displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"} ]}'),
(2, 'Contact', 'com_contact.contact', '{"special":{"dbtable":"#__contact_details","key":"id","type":"Contact","prefix":"ContactTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"name","core_state":"published","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"address", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"params", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"image", "core_urls":"webpage", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"xreference", "asset_id":"null"}, "special":{"con_position":"con_position","suburb":"suburb","state":"state","country":"country","postcode":"postcode","telephone":"telephone","fax":"fax","misc":"misc","email_to":"email_to","default_con":"default_con","user_id":"user_id","mobile":"mobile","sortname1":"sortname1","sortname2":"sortname2","sortname3":"sortname3"}}', 'ContactHelperRoute::getContactRoute', '{"formFile":"administrator\\/components\\/com_contact\\/models\\/forms\\/contact.xml","hideFields":["default_con","checked_out","checked_out_time","version","xreference"],"ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time", "version", "hits"],"convertToInt":["publish_up", "publish_down", "featured", "ordering"], "displayLookup":[ {"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"} ] }'),
(3, 'Newsfeed', 'com_newsfeeds.newsfeed', '{"special":{"dbtable":"#__newsfeeds","key":"id","type":"Newsfeed","prefix":"NewsfeedsTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"name","core_state":"published","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"description", "core_hits":"hits","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"params", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"link", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"xreference", "asset_id":"null"}, "special":{"numarticles":"numarticles","cache_time":"cache_time","rtl":"rtl"}}', 'NewsfeedsHelperRoute::getNewsfeedRoute', '{"formFile":"administrator\\/components\\/com_newsfeeds\\/models\\/forms\\/newsfeed.xml","hideFields":["asset_id","checked_out","checked_out_time","version"],"ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time", "version", "hits"],"convertToInt":["publish_up", "publish_down", "featured", "ordering"],"displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"} ]}'),
(4, 'User', 'com_users.user', '{"special":{"dbtable":"#__users","key":"id","type":"User","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"name","core_state":"null","core_alias":"username","core_created_time":"registerdate","core_modified_time":"lastvisitDate","core_body":"null", "core_hits":"null","core_publish_up":"null","core_publish_down":"null","access":"null", "core_params":"params", "core_featured":"null", "core_metadata":"null", "core_language":"null", "core_images":"null", "core_urls":"null", "core_version":"null", "core_ordering":"null", "core_metakey":"null", "core_metadesc":"null", "core_catid":"null", "core_xreference":"null", "asset_id":"null"}, "special":{}}', 'UsersHelperRoute::getUserRoute', ''),
(5, 'Article Category', 'com_content.category', '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}', 'ContentHelperRoute::getCategoryRoute', '{"formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'),
(6, 'Contact Category', 'com_contact.category', '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}', 'ContactHelperRoute::getCategoryRoute', '{"formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'),
(7, 'Newsfeeds Category', 'com_newsfeeds.category', '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}', 'NewsfeedsHelperRoute::getCategoryRoute', '{"formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'),
(8, 'Tag', 'com_tags.tag', '{"special":{"dbtable":"#__tags","key":"tag_id","type":"Tag","prefix":"TagsTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"featured", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"urls", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"null", "core_xreference":"null", "asset_id":"null"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path"}}', 'TagsHelperRoute::getTagRoute', '{"formFile":"administrator\\/components\\/com_tags\\/models\\/forms\\/tag.xml", "hideFields":["checked_out","checked_out_time","version", "lft", "rgt", "level", "path", "urls", "publish_up", "publish_down"],"ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}, {"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"}, {"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'),
(9, 'Banner', 'com_banners.banner', '{"special":{"dbtable":"#__banners","key":"id","type":"Banner","prefix":"BannersTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"name","core_state":"published","core_alias":"alias","core_created_time":"created","core_modified_time":"modified","core_body":"description", "core_hits":"null","core_publish_up":"publish_up","core_publish_down":"publish_down","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"images", "core_urls":"link", "core_version":"version", "core_ordering":"ordering", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"catid", "core_xreference":"null", "asset_id":"null"}, "special":{"imptotal":"imptotal", "impmade":"impmade", "clicks":"clicks", "clickurl":"clickurl", "custombannercode":"custombannercode", "cid":"cid", "purchase_type":"purchase_type", "track_impressions":"track_impressions", "track_clicks":"track_clicks"}}', '', '{"formFile":"administrator\\/components\\/com_banners\\/models\\/forms\\/banner.xml", "hideFields":["checked_out","checked_out_time","version", "reset"],"ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time", "version", "imptotal", "impmade", "reset"], "convertToInt":["publish_up", "publish_down", "ordering"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}, {"sourceColumn":"cid","targetTable":"#__banner_clients","targetColumn":"id","displayColumn":"name"}, {"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"} ]}'),
(10, 'Banners Category', 'com_banners.category', '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special": {"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}', '', '{"formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'),
(11, 'Banner Client', 'com_banners.client', '{"special":{"dbtable":"#__banner_clients","key":"id","type":"Client","prefix":"BannersTable"}}', '', '', '', '{"formFile":"administrator\\/components\\/com_banners\\/models\\/forms\\/client.xml", "hideFields":["checked_out","checked_out_time"], "ignoreChanges":["checked_out", "checked_out_time"], "convertToInt":[], "displayLookup":[]}'),
(12, 'User Notes', 'com_users.note', '{"special":{"dbtable":"#__user_notes","key":"id","type":"Note","prefix":"UsersTable"}}', '', '', '', '{"formFile":"administrator\\/components\\/com_users\\/models\\/forms\\/note.xml", "hideFields":["checked_out","checked_out_time", "publish_up", "publish_down"],"ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"],"displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}, {"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}, {"sourceColumn":"user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}, {"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'),
(13, 'User Notes Category', 'com_users.category', '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}', '', '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}', '', '{"formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml", "hideFields":["checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}, {"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_core_log_searches`
--

CREATE TABLE IF NOT EXISTS `h0qwo_core_log_searches` (
  `search_term` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hits` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_extensions`
--

CREATE TABLE IF NOT EXISTS `h0qwo_extensions` (
  `extension_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  `access` int(10) unsigned NOT NULL DEFAULT '1',
  `protected` tinyint(3) NOT NULL DEFAULT '0',
  `manifest_cache` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT '0',
  `state` int(11) DEFAULT '0',
  PRIMARY KEY (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10015 ;

--
-- Дамп данных таблицы `h0qwo_extensions`
--

INSERT INTO `h0qwo_extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `system_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) VALUES
(1, 'com_mailto', 'component', 'com_mailto', '', 0, 1, 1, 1, '{"name":"com_mailto","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_MAILTO_XML_DESCRIPTION","group":"","filename":"mailto"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(2, 'com_wrapper', 'component', 'com_wrapper', '', 0, 1, 1, 1, '{"name":"com_wrapper","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.\\n\\t","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_WRAPPER_XML_DESCRIPTION","group":"","filename":"wrapper"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(3, 'com_admin', 'component', 'com_admin', '', 1, 1, 1, 1, '{"name":"com_admin","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_ADMIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(4, 'com_banners', 'component', 'com_banners', '', 1, 1, 1, 0, '{"name":"com_banners","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_BANNERS_XML_DESCRIPTION","group":"","filename":"banners"}', '{"purchase_type":"3","track_impressions":"0","track_clicks":"0","metakey_prefix":"","save_history":"1","history_limit":10}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(5, 'com_cache', 'component', 'com_cache', '', 1, 1, 1, 1, '{"name":"com_cache","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CACHE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(6, 'com_categories', 'component', 'com_categories', '', 1, 1, 1, 1, '{"name":"com_categories","type":"component","creationDate":"December 2007","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CATEGORIES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(7, 'com_checkin', 'component', 'com_checkin', '', 1, 1, 1, 1, '{"name":"com_checkin","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CHECKIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(8, 'com_contact', 'component', 'com_contact', '', 1, 1, 1, 0, '{"name":"com_contact","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CONTACT_XML_DESCRIPTION","group":"","filename":"contact"}', '{"show_contact_category":"hide","save_history":"1","history_limit":10,"show_contact_list":"0","presentation_style":"sliders","show_name":"1","show_position":"1","show_email":"0","show_street_address":"1","show_suburb":"1","show_state":"1","show_postcode":"1","show_country":"1","show_telephone":"1","show_mobile":"1","show_fax":"1","show_webpage":"1","show_misc":"1","show_image":"1","image":"","allow_vcard":"0","show_articles":"0","show_profile":"0","show_links":"0","linka_name":"","linkb_name":"","linkc_name":"","linkd_name":"","linke_name":"","contact_icons":"0","icon_address":"","icon_email":"","icon_telephone":"","icon_mobile":"","icon_fax":"","icon_misc":"","show_headings":"1","show_position_headings":"1","show_email_headings":"0","show_telephone_headings":"1","show_mobile_headings":"0","show_fax_headings":"0","allow_vcard_headings":"0","show_suburb_headings":"1","show_state_headings":"1","show_country_headings":"1","show_email_form":"1","show_email_copy":"1","banned_email":"","banned_subject":"","banned_text":"","validate_session":"1","custom_reply":"0","redirect":"","show_category_crumb":"0","metakey":"","metadesc":"","robots":"","author":"","rights":"","xreference":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(9, 'com_cpanel', 'component', 'com_cpanel', '', 1, 1, 1, 1, '{"name":"com_cpanel","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CPANEL_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10, 'com_installer', 'component', 'com_installer', '', 1, 1, 1, 1, '{"name":"com_installer","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_INSTALLER_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(11, 'com_languages', 'component', 'com_languages', '', 1, 1, 1, 1, '{"name":"com_languages","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_LANGUAGES_XML_DESCRIPTION","group":""}', '{"administrator":"en-GB","site":"ru-RU"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(12, 'com_login', 'component', 'com_login', '', 1, 1, 1, 1, '{"name":"com_login","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_LOGIN_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(13, 'com_media', 'component', 'com_media', '', 1, 1, 0, 1, '{"name":"com_media","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_MEDIA_XML_DESCRIPTION","group":"","filename":"media"}', '{"upload_extensions":"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS","upload_maxsize":"10","file_path":"images","image_path":"images","restrict_uploads":"1","allowed_media_usergroup":"3","check_mime":"1","image_extensions":"bmp,gif,jpg,png","ignore_extensions":"","upload_mime":"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/x-shockwave-flash,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip","upload_mime_illegal":"text\\/html"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(14, 'com_menus', 'component', 'com_menus', '', 1, 1, 1, 1, '{"name":"com_menus","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_MENUS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(15, 'com_messages', 'component', 'com_messages', '', 1, 1, 1, 1, '{"name":"com_messages","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_MESSAGES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(16, 'com_modules', 'component', 'com_modules', '', 1, 1, 1, 1, '{"name":"com_modules","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_MODULES_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(17, 'com_newsfeeds', 'component', 'com_newsfeeds', '', 1, 1, 1, 0, '{"name":"com_newsfeeds","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_NEWSFEEDS_XML_DESCRIPTION","group":"","filename":"newsfeeds"}', '{"newsfeed_layout":"_:default","save_history":"1","history_limit":5,"show_feed_image":"1","show_feed_description":"1","show_item_description":"1","feed_character_count":"0","feed_display_order":"des","float_first":"right","float_second":"right","show_tags":"1","category_layout":"_:default","show_category_title":"1","show_description":"1","show_description_image":"1","maxLevel":"-1","show_empty_categories":"0","show_subcat_desc":"1","show_cat_items":"1","show_cat_tags":"1","show_base_description":"1","maxLevelcat":"-1","show_empty_categories_cat":"0","show_subcat_desc_cat":"1","show_cat_items_cat":"1","filter_field":"1","show_pagination_limit":"1","show_headings":"1","show_articles":"0","show_link":"1","show_pagination":"1","show_pagination_results":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(18, 'com_plugins', 'component', 'com_plugins', '', 1, 1, 1, 1, '{"name":"com_plugins","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_PLUGINS_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(19, 'com_search', 'component', 'com_search', '', 1, 1, 1, 0, '{"name":"com_search","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_SEARCH_XML_DESCRIPTION","group":"","filename":"search"}', '{"enabled":"0","show_date":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(20, 'com_templates', 'component', 'com_templates', '', 1, 1, 1, 1, '{"name":"com_templates","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_TEMPLATES_XML_DESCRIPTION","group":""}', '{"template_positions_display":"1","upload_limit":"2","image_formats":"gif,bmp,jpg,jpeg,png","source_formats":"txt,less,ini,xml,js,php,css","font_formats":"woff,ttf,otf","compressed_formats":"zip"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(22, 'com_content', 'component', 'com_content', '', 1, 1, 0, 1, '{"name":"com_content","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CONTENT_XML_DESCRIPTION","group":"","filename":"content"}', '{"article_layout":"_:default","show_title":"1","link_titles":"1","show_intro":"1","info_block_position":"0","show_category":"1","link_category":"1","show_parent_category":"0","link_parent_category":"0","show_author":"0","link_author":"0","show_create_date":"0","show_modify_date":"0","show_publish_date":"1","show_item_navigation":"1","show_vote":"0","show_readmore":"1","show_readmore_title":"1","readmore_limit":"100","show_tags":"1","show_icons":"1","show_print_icon":"1","show_email_icon":"1","show_hits":"1","show_noauth":"0","urls_position":"0","show_publishing_options":"1","show_article_options":"1","save_history":"1","history_limit":10,"show_urls_images_frontend":"0","show_urls_images_backend":"1","targeta":0,"targetb":0,"targetc":0,"float_intro":"left","float_fulltext":"left","category_layout":"_:blog","show_category_heading_title_text":"1","show_category_title":"0","show_description":"0","show_description_image":"0","maxLevel":"1","show_empty_categories":"0","show_no_articles":"1","show_subcat_desc":"1","show_cat_num_articles":"0","show_cat_tags":"1","show_base_description":"1","maxLevelcat":"-1","show_empty_categories_cat":"0","show_subcat_desc_cat":"1","show_cat_num_articles_cat":"1","num_leading_articles":"1","num_intro_articles":"4","num_columns":"2","num_links":"4","multi_column_order":"0","show_subcategory_content":"0","show_pagination_limit":"1","filter_field":"hide","show_headings":"1","list_show_date":"0","date_format":"","list_show_hits":"1","list_show_author":"1","orderby_pri":"order","orderby_sec":"rdate","order_date":"published","show_pagination":"2","show_pagination_results":"1","show_featured":"show","show_feed_link":"1","feed_summary":"0","feed_show_readmore":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(23, 'com_config', 'component', 'com_config', '', 1, 1, 0, 1, '{"name":"com_config","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_CONFIG_XML_DESCRIPTION","group":""}', '{"filters":{"1":{"filter_type":"NH","filter_tags":"","filter_attributes":""},"9":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"6":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"7":{"filter_type":"NONE","filter_tags":"","filter_attributes":""},"2":{"filter_type":"NH","filter_tags":"","filter_attributes":""},"3":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"4":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"5":{"filter_type":"BL","filter_tags":"","filter_attributes":""},"8":{"filter_type":"NONE","filter_tags":"","filter_attributes":""}}}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(24, 'com_redirect', 'component', 'com_redirect', '', 1, 1, 0, 1, '{"name":"com_redirect","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_REDIRECT_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(25, 'com_users', 'component', 'com_users', '', 1, 1, 0, 1, '{"name":"com_users","type":"component","creationDate":"April 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_USERS_XML_DESCRIPTION","group":"","filename":"users"}', '{"allowUserRegistration":"0","new_usertype":"2","guest_usergroup":"9","sendpassword":"1","useractivation":"1","mail_to_admin":"0","captcha":"","frontend_userparams":"1","site_language":"0","change_login_name":"0","reset_count":"10","reset_time":"1","minimum_length":"4","minimum_integers":"0","minimum_symbols":"0","minimum_uppercase":"0","save_history":"1","history_limit":5,"mailSubjectPrefix":"","mailBodySuffix":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(27, 'com_finder', 'component', 'com_finder', '', 1, 1, 0, 0, '{"name":"com_finder","type":"component","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"COM_FINDER_XML_DESCRIPTION","group":"","filename":"finder"}', '{"show_description":"1","description_length":255,"allow_empty_query":"0","show_url":"1","show_advanced":"1","expand_advanced":"0","show_date_filters":"0","highlight_terms":"1","opensearch_name":"","opensearch_description":"","batch_size":"50","memory_table_limit":30000,"title_multiplier":"1.7","text_multiplier":"0.7","meta_multiplier":"1.2","path_multiplier":"2.0","misc_multiplier":"0.3","stemmer":"snowball"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(28, 'com_joomlaupdate', 'component', 'com_joomlaupdate', '', 1, 1, 0, 1, '{"name":"com_joomlaupdate","type":"component","creationDate":"February 2012","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"COM_JOOMLAUPDATE_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(29, 'com_tags', 'component', 'com_tags', '', 1, 1, 1, 1, '{"name":"com_tags","type":"component","creationDate":"December 2013","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.1.0","description":"COM_TAGS_XML_DESCRIPTION","group":"","filename":"tags"}', '{"tag_layout":"_:default","save_history":"1","history_limit":5,"show_tag_title":"0","tag_list_show_tag_image":"0","tag_list_show_tag_description":"0","tag_list_image":"","show_tag_num_items":"0","tag_list_orderby":"title","tag_list_orderby_direction":"ASC","show_headings":"0","tag_list_show_date":"0","tag_list_show_item_image":"0","tag_list_show_item_description":"0","tag_list_item_maximum_characters":0,"return_any_or_all":"1","include_children":"0","maximum":200,"tag_list_language_filter":"all","tags_layout":"_:default","all_tags_orderby":"title","all_tags_orderby_direction":"ASC","all_tags_show_tag_image":"0","all_tags_show_tag_descripion":"0","all_tags_tag_maximum_characters":20,"all_tags_show_tag_hits":"0","filter_field":"1","show_pagination_limit":"1","show_pagination":"2","show_pagination_results":"1","tag_field_ajax_mode":"1","show_feed_link":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(30, 'com_contenthistory', 'component', 'com_contenthistory', '', 1, 1, 1, 0, '{"name":"com_contenthistory","type":"component","creationDate":"May 2013","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.2.0","description":"COM_CONTENTHISTORY_XML_DESCRIPTION","group":"","filename":"contenthistory"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(31, 'com_ajax', 'component', 'com_ajax', '', 1, 1, 1, 1, '{"name":"com_ajax","type":"component","creationDate":"August 2013","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.2.0","description":"COM_AJAX_XML_DESCRIPTION","group":"","filename":"ajax"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(32, 'com_postinstall', 'component', 'com_postinstall', '', 1, 1, 1, 1, '{"name":"com_postinstall","type":"component","creationDate":"September 2013","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.2.0","description":"COM_POSTINSTALL_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(102, 'phputf8', 'library', 'phputf8', '', 0, 1, 1, 1, '{"name":"phputf8","type":"library","creationDate":"2006","author":"Harry Fuecks","copyright":"Copyright various authors","authorEmail":"hfuecks@gmail.com","authorUrl":"http:\\/\\/sourceforge.net\\/projects\\/phputf8","version":"0.5","description":"LIB_PHPUTF8_XML_DESCRIPTION","group":"","filename":"phputf8"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(103, 'Joomla! Platform', 'library', 'joomla', '', 0, 1, 1, 1, '{"name":"Joomla! Platform","type":"library","creationDate":"2008","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"https:\\/\\/www.joomla.org","version":"13.1","description":"LIB_JOOMLA_XML_DESCRIPTION","group":"","filename":"joomla"}', '{"mediaversion":"5a9e8aabc5d451d5c70394ac591f33dd"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(104, 'IDNA Convert', 'library', 'idna_convert', '', 0, 1, 1, 1, '{"name":"IDNA Convert","type":"library","creationDate":"2004","author":"phlyLabs","copyright":"2004-2011 phlyLabs Berlin, http:\\/\\/phlylabs.de","authorEmail":"phlymail@phlylabs.de","authorUrl":"http:\\/\\/phlylabs.de","version":"0.8.0","description":"LIB_IDNA_XML_DESCRIPTION","group":"","filename":"idna_convert"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(105, 'FOF', 'library', 'fof', '', 0, 1, 1, 1, '{"name":"FOF","type":"library","creationDate":"2015-04-22 13:15:32","author":"Nicholas K. Dionysopoulos \\/ Akeeba Ltd","copyright":"(C)2011-2015 Nicholas K. Dionysopoulos","authorEmail":"nicholas@akeebabackup.com","authorUrl":"https:\\/\\/www.akeebabackup.com","version":"2.4.3","description":"LIB_FOF_XML_DESCRIPTION","group":"","filename":"fof"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(106, 'PHPass', 'library', 'phpass', '', 0, 1, 1, 1, '{"name":"PHPass","type":"library","creationDate":"2004-2006","author":"Solar Designer","copyright":"","authorEmail":"solar@openwall.com","authorUrl":"http:\\/\\/www.openwall.com\\/phpass\\/","version":"0.3","description":"LIB_PHPASS_XML_DESCRIPTION","group":"","filename":"phpass"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(200, 'mod_articles_archive', 'module', 'mod_articles_archive', '', 0, 1, 1, 0, '{"name":"mod_articles_archive","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_ARTICLES_ARCHIVE_XML_DESCRIPTION","group":"","filename":"mod_articles_archive"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(201, 'mod_articles_latest', 'module', 'mod_articles_latest', '', 0, 1, 1, 0, '{"name":"mod_articles_latest","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_LATEST_NEWS_XML_DESCRIPTION","group":"","filename":"mod_articles_latest"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(202, 'mod_articles_popular', 'module', 'mod_articles_popular', '', 0, 1, 1, 0, '{"name":"mod_articles_popular","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_POPULAR_XML_DESCRIPTION","group":"","filename":"mod_articles_popular"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(203, 'mod_banners', 'module', 'mod_banners', '', 0, 1, 1, 0, '{"name":"mod_banners","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_BANNERS_XML_DESCRIPTION","group":"","filename":"mod_banners"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(204, 'mod_breadcrumbs', 'module', 'mod_breadcrumbs', '', 0, 1, 1, 1, '{"name":"mod_breadcrumbs","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_BREADCRUMBS_XML_DESCRIPTION","group":"","filename":"mod_breadcrumbs"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(205, 'mod_custom', 'module', 'mod_custom', '', 0, 1, 1, 1, '{"name":"mod_custom","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_CUSTOM_XML_DESCRIPTION","group":"","filename":"mod_custom"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(206, 'mod_feed', 'module', 'mod_feed', '', 0, 1, 1, 0, '{"name":"mod_feed","type":"module","creationDate":"July 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_FEED_XML_DESCRIPTION","group":"","filename":"mod_feed"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(207, 'mod_footer', 'module', 'mod_footer', '', 0, 1, 1, 0, '{"name":"mod_footer","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_FOOTER_XML_DESCRIPTION","group":"","filename":"mod_footer"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(208, 'mod_login', 'module', 'mod_login', '', 0, 1, 1, 1, '{"name":"mod_login","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_LOGIN_XML_DESCRIPTION","group":"","filename":"mod_login"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(209, 'mod_menu', 'module', 'mod_menu', '', 0, 1, 1, 1, '{"name":"mod_menu","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_MENU_XML_DESCRIPTION","group":"","filename":"mod_menu"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(210, 'mod_articles_news', 'module', 'mod_articles_news', '', 0, 1, 1, 0, '{"name":"mod_articles_news","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_ARTICLES_NEWS_XML_DESCRIPTION","group":"","filename":"mod_articles_news"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(211, 'mod_random_image', 'module', 'mod_random_image', '', 0, 1, 1, 0, '{"name":"mod_random_image","type":"module","creationDate":"July 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_RANDOM_IMAGE_XML_DESCRIPTION","group":"","filename":"mod_random_image"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(212, 'mod_related_items', 'module', 'mod_related_items', '', 0, 1, 1, 0, '{"name":"mod_related_items","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_RELATED_XML_DESCRIPTION","group":"","filename":"mod_related_items"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(213, 'mod_search', 'module', 'mod_search', '', 0, 1, 1, 0, '{"name":"mod_search","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_SEARCH_XML_DESCRIPTION","group":"","filename":"mod_search"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(214, 'mod_stats', 'module', 'mod_stats', '', 0, 1, 1, 0, '{"name":"mod_stats","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_STATS_XML_DESCRIPTION","group":"","filename":"mod_stats"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(215, 'mod_syndicate', 'module', 'mod_syndicate', '', 0, 1, 1, 1, '{"name":"mod_syndicate","type":"module","creationDate":"May 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_SYNDICATE_XML_DESCRIPTION","group":"","filename":"mod_syndicate"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(216, 'mod_users_latest', 'module', 'mod_users_latest', '', 0, 1, 1, 0, '{"name":"mod_users_latest","type":"module","creationDate":"December 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_USERS_LATEST_XML_DESCRIPTION","group":"","filename":"mod_users_latest"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(218, 'mod_whosonline', 'module', 'mod_whosonline', '', 0, 1, 1, 0, '{"name":"mod_whosonline","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_WHOSONLINE_XML_DESCRIPTION","group":"","filename":"mod_whosonline"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(219, 'mod_wrapper', 'module', 'mod_wrapper', '', 0, 1, 1, 0, '{"name":"mod_wrapper","type":"module","creationDate":"October 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_WRAPPER_XML_DESCRIPTION","group":"","filename":"mod_wrapper"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(220, 'mod_articles_category', 'module', 'mod_articles_category', '', 0, 1, 1, 0, '{"name":"mod_articles_category","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_ARTICLES_CATEGORY_XML_DESCRIPTION","group":"","filename":"mod_articles_category"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(221, 'mod_articles_categories', 'module', 'mod_articles_categories', '', 0, 1, 1, 0, '{"name":"mod_articles_categories","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_ARTICLES_CATEGORIES_XML_DESCRIPTION","group":"","filename":"mod_articles_categories"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(222, 'mod_languages', 'module', 'mod_languages', '', 0, 1, 1, 1, '{"name":"mod_languages","type":"module","creationDate":"February 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.5.0","description":"MOD_LANGUAGES_XML_DESCRIPTION","group":"","filename":"mod_languages"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(223, 'mod_finder', 'module', 'mod_finder', '', 0, 1, 0, 0, '{"name":"mod_finder","type":"module","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_FINDER_XML_DESCRIPTION","group":"","filename":"mod_finder"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(300, 'mod_custom', 'module', 'mod_custom', '', 1, 1, 1, 1, '{"name":"mod_custom","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_CUSTOM_XML_DESCRIPTION","group":"","filename":"mod_custom"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(301, 'mod_feed', 'module', 'mod_feed', '', 1, 1, 1, 0, '{"name":"mod_feed","type":"module","creationDate":"July 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_FEED_XML_DESCRIPTION","group":"","filename":"mod_feed"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(302, 'mod_latest', 'module', 'mod_latest', '', 1, 1, 1, 0, '{"name":"mod_latest","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_LATEST_XML_DESCRIPTION","group":"","filename":"mod_latest"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(303, 'mod_logged', 'module', 'mod_logged', '', 1, 1, 1, 0, '{"name":"mod_logged","type":"module","creationDate":"January 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_LOGGED_XML_DESCRIPTION","group":"","filename":"mod_logged"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(304, 'mod_login', 'module', 'mod_login', '', 1, 1, 1, 1, '{"name":"mod_login","type":"module","creationDate":"March 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_LOGIN_XML_DESCRIPTION","group":"","filename":"mod_login"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(305, 'mod_menu', 'module', 'mod_menu', '', 1, 1, 1, 0, '{"name":"mod_menu","type":"module","creationDate":"March 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_MENU_XML_DESCRIPTION","group":"","filename":"mod_menu"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(307, 'mod_popular', 'module', 'mod_popular', '', 1, 1, 1, 0, '{"name":"mod_popular","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_POPULAR_XML_DESCRIPTION","group":"","filename":"mod_popular"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(308, 'mod_quickicon', 'module', 'mod_quickicon', '', 1, 1, 1, 1, '{"name":"mod_quickicon","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_QUICKICON_XML_DESCRIPTION","group":"","filename":"mod_quickicon"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(309, 'mod_status', 'module', 'mod_status', '', 1, 1, 1, 0, '{"name":"mod_status","type":"module","creationDate":"Feb 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_STATUS_XML_DESCRIPTION","group":"","filename":"mod_status"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(310, 'mod_submenu', 'module', 'mod_submenu', '', 1, 1, 1, 0, '{"name":"mod_submenu","type":"module","creationDate":"Feb 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_SUBMENU_XML_DESCRIPTION","group":"","filename":"mod_submenu"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(311, 'mod_title', 'module', 'mod_title', '', 1, 1, 1, 0, '{"name":"mod_title","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_TITLE_XML_DESCRIPTION","group":"","filename":"mod_title"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(312, 'mod_toolbar', 'module', 'mod_toolbar', '', 1, 1, 1, 1, '{"name":"mod_toolbar","type":"module","creationDate":"Nov 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_TOOLBAR_XML_DESCRIPTION","group":"","filename":"mod_toolbar"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(313, 'mod_multilangstatus', 'module', 'mod_multilangstatus', '', 1, 1, 1, 0, '{"name":"mod_multilangstatus","type":"module","creationDate":"September 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_MULTILANGSTATUS_XML_DESCRIPTION","group":"","filename":"mod_multilangstatus"}', '{"cache":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(314, 'mod_version', 'module', 'mod_version', '', 1, 1, 1, 0, '{"name":"mod_version","type":"module","creationDate":"January 2012","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_VERSION_XML_DESCRIPTION","group":"","filename":"mod_version"}', '{"format":"short","product":"1","cache":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(315, 'mod_stats_admin', 'module', 'mod_stats_admin', '', 1, 1, 1, 0, '{"name":"mod_stats_admin","type":"module","creationDate":"July 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"MOD_STATS_XML_DESCRIPTION","group":"","filename":"mod_stats_admin"}', '{"serverinfo":"0","siteinfo":"0","counter":"0","increase":"0","cache":"1","cache_time":"900","cachemode":"static"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(316, 'mod_tags_popular', 'module', 'mod_tags_popular', '', 0, 1, 1, 0, '{"name":"mod_tags_popular","type":"module","creationDate":"January 2013","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.1.0","description":"MOD_TAGS_POPULAR_XML_DESCRIPTION","group":"","filename":"mod_tags_popular"}', '{"maximum":"5","timeframe":"alltime","owncache":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(317, 'mod_tags_similar', 'module', 'mod_tags_similar', '', 0, 1, 1, 0, '{"name":"mod_tags_similar","type":"module","creationDate":"January 2013","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.1.0","description":"MOD_TAGS_SIMILAR_XML_DESCRIPTION","group":"","filename":"mod_tags_similar"}', '{"maximum":"5","matchtype":"any","owncache":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(400, 'plg_authentication_gmail', 'plugin', 'gmail', 'authentication', 0, 0, 1, 0, '{"name":"plg_authentication_gmail","type":"plugin","creationDate":"February 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_GMAIL_XML_DESCRIPTION","group":"","filename":"gmail"}', '{"applysuffix":"0","suffix":"","verifypeer":"1","user_blacklist":""}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(401, 'plg_authentication_joomla', 'plugin', 'joomla', 'authentication', 0, 1, 1, 1, '{"name":"plg_authentication_joomla","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_AUTH_JOOMLA_XML_DESCRIPTION","group":"","filename":"joomla"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(402, 'plg_authentication_ldap', 'plugin', 'ldap', 'authentication', 0, 0, 1, 0, '{"name":"plg_authentication_ldap","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_LDAP_XML_DESCRIPTION","group":"","filename":"ldap"}', '{"host":"","port":"389","use_ldapV3":"0","negotiate_tls":"0","no_referrals":"0","auth_method":"bind","base_dn":"","search_string":"","users_dn":"","username":"admin","password":"bobby7","ldap_fullname":"fullName","ldap_email":"mail","ldap_uid":"uid"}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(403, 'plg_content_contact', 'plugin', 'contact', 'content', 0, 1, 1, 0, '{"name":"plg_content_contact","type":"plugin","creationDate":"January 2014","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.2.2","description":"PLG_CONTENT_CONTACT_XML_DESCRIPTION","group":"","filename":"contact"}', '', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(404, 'plg_content_emailcloak', 'plugin', 'emailcloak', 'content', 0, 1, 1, 0, '{"name":"plg_content_emailcloak","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_CONTENT_EMAILCLOAK_XML_DESCRIPTION","group":"","filename":"emailcloak"}', '{"mode":"1"}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(406, 'plg_content_loadmodule', 'plugin', 'loadmodule', 'content', 0, 1, 1, 0, '{"name":"plg_content_loadmodule","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_LOADMODULE_XML_DESCRIPTION","group":"","filename":"loadmodule"}', '{"style":"xhtml"}', '', '', 0, '2011-09-18 15:22:50', 0, 0),
(407, 'plg_content_pagebreak', 'plugin', 'pagebreak', 'content', 0, 1, 1, 0, '{"name":"plg_content_pagebreak","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_CONTENT_PAGEBREAK_XML_DESCRIPTION","group":"","filename":"pagebreak"}', '{"title":"1","multipage_toc":"1","showall":"1"}', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(408, 'plg_content_pagenavigation', 'plugin', 'pagenavigation', 'content', 0, 1, 1, 0, '{"name":"plg_content_pagenavigation","type":"plugin","creationDate":"January 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_PAGENAVIGATION_XML_DESCRIPTION","group":"","filename":"pagenavigation"}', '{"position":"1"}', '', '', 0, '0000-00-00 00:00:00', 5, 0),
(409, 'plg_content_vote', 'plugin', 'vote', 'content', 0, 1, 1, 0, '{"name":"plg_content_vote","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_VOTE_XML_DESCRIPTION","group":"","filename":"vote"}', '', '', '', 0, '0000-00-00 00:00:00', 6, 0),
(410, 'plg_editors_codemirror', 'plugin', 'codemirror', 'editors', 0, 1, 1, 1, '{"name":"plg_editors_codemirror","type":"plugin","creationDate":"28 March 2011","author":"Marijn Haverbeke","copyright":"Copyright (C) 2014 by Marijn Haverbeke <marijnh@gmail.com> and others","authorEmail":"marijnh@gmail.com","authorUrl":"http:\\/\\/codemirror.net\\/","version":"5.15.2","description":"PLG_CODEMIRROR_XML_DESCRIPTION","group":"","filename":"codemirror"}', '{"lineNumbers":"1","lineWrapping":"1","matchTags":"1","matchBrackets":"1","marker-gutter":"1","autoCloseTags":"1","autoCloseBrackets":"1","autoFocus":"1","theme":"default","tabmode":"indent"}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(411, 'plg_editors_none', 'plugin', 'none', 'editors', 0, 1, 1, 1, '{"name":"plg_editors_none","type":"plugin","creationDate":"September 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_NONE_XML_DESCRIPTION","group":"","filename":"none"}', '', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(412, 'plg_editors_tinymce', 'plugin', 'tinymce', 'editors', 0, 1, 1, 0, '{"name":"plg_editors_tinymce","type":"plugin","creationDate":"2005-2016","author":"Ephox Corporation","copyright":"Ephox Corporation","authorEmail":"N\\/A","authorUrl":"http:\\/\\/www.tinymce.com","version":"4.3.12","description":"PLG_TINY_XML_DESCRIPTION","group":"","filename":"tinymce"}', '{"mode":"1","skin":"0","mobile":"0","entity_encoding":"raw","lang_mode":"1","text_direction":"ltr","content_css":"1","content_css_custom":"","relative_urls":"1","newlines":"0","invalid_elements":"script,applet,iframe","extended_elements":"","html_height":"550","html_width":"750","resizing":"1","element_path":"1","fonts":"1","paste":"1","searchreplace":"1","insertdate":"1","colors":"1","table":"1","smilies":"1","hr":"1","link":"1","media":"1","print":"1","directionality":"1","fullscreen":"1","alignment":"1","visualchars":"1","visualblocks":"1","nonbreaking":"1","template":"1","blockquote":"1","wordcount":"1","advlist":"1","autosave":"1","contextmenu":"1","inlinepopups":"1","custom_plugin":"","custom_button":""}', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(413, 'plg_editors-xtd_article', 'plugin', 'article', 'editors-xtd', 0, 1, 1, 0, '{"name":"plg_editors-xtd_article","type":"plugin","creationDate":"October 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_ARTICLE_XML_DESCRIPTION","group":"","filename":"article"}', '', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(414, 'plg_editors-xtd_image', 'plugin', 'image', 'editors-xtd', 0, 1, 1, 0, '{"name":"plg_editors-xtd_image","type":"plugin","creationDate":"August 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_IMAGE_XML_DESCRIPTION","group":"","filename":"image"}', '', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(415, 'plg_editors-xtd_pagebreak', 'plugin', 'pagebreak', 'editors-xtd', 0, 1, 1, 0, '{"name":"plg_editors-xtd_pagebreak","type":"plugin","creationDate":"August 2004","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_EDITORSXTD_PAGEBREAK_XML_DESCRIPTION","group":"","filename":"pagebreak"}', '', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(416, 'plg_editors-xtd_readmore', 'plugin', 'readmore', 'editors-xtd', 0, 1, 1, 0, '{"name":"plg_editors-xtd_readmore","type":"plugin","creationDate":"March 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_READMORE_XML_DESCRIPTION","group":"","filename":"readmore"}', '', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(417, 'plg_search_categories', 'plugin', 'categories', 'search', 0, 1, 1, 0, '{"name":"plg_search_categories","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SEARCH_CATEGORIES_XML_DESCRIPTION","group":"","filename":"categories"}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0);
INSERT INTO `h0qwo_extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `system_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) VALUES
(418, 'plg_search_contacts', 'plugin', 'contacts', 'search', 0, 1, 1, 0, '{"name":"plg_search_contacts","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SEARCH_CONTACTS_XML_DESCRIPTION","group":"","filename":"contacts"}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(419, 'plg_search_content', 'plugin', 'content', 'search', 0, 1, 1, 0, '{"name":"plg_search_content","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SEARCH_CONTENT_XML_DESCRIPTION","group":"","filename":"content"}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(420, 'plg_search_newsfeeds', 'plugin', 'newsfeeds', 'search', 0, 1, 1, 0, '{"name":"plg_search_newsfeeds","type":"plugin","creationDate":"November 2005","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SEARCH_NEWSFEEDS_XML_DESCRIPTION","group":"","filename":"newsfeeds"}', '{"search_limit":"50","search_content":"1","search_archived":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(422, 'plg_system_languagefilter', 'plugin', 'languagefilter', 'system', 0, 0, 1, 1, '{"name":"plg_system_languagefilter","type":"plugin","creationDate":"July 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SYSTEM_LANGUAGEFILTER_XML_DESCRIPTION","group":"","filename":"languagefilter"}', '', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(423, 'plg_system_p3p', 'plugin', 'p3p', 'system', 0, 0, 1, 0, '{"name":"plg_system_p3p","type":"plugin","creationDate":"September 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_P3P_XML_DESCRIPTION","group":"","filename":"p3p"}', '{"headers":"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(424, 'plg_system_cache', 'plugin', 'cache', 'system', 0, 0, 1, 1, '{"name":"plg_system_cache","type":"plugin","creationDate":"February 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_CACHE_XML_DESCRIPTION","group":"","filename":"cache"}', '{"browsercache":"0","cachetime":"15"}', '', '', 0, '0000-00-00 00:00:00', 9, 0),
(425, 'plg_system_debug', 'plugin', 'debug', 'system', 0, 1, 1, 0, '{"name":"plg_system_debug","type":"plugin","creationDate":"December 2006","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_DEBUG_XML_DESCRIPTION","group":"","filename":"debug"}', '{"profile":"1","queries":"1","memory":"1","language_files":"1","language_strings":"1","strip-first":"1","strip-prefix":"","strip-suffix":""}', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(426, 'plg_system_log', 'plugin', 'log', 'system', 0, 1, 1, 1, '{"name":"plg_system_log","type":"plugin","creationDate":"April 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_LOG_XML_DESCRIPTION","group":"","filename":"log"}', '', '', '', 0, '0000-00-00 00:00:00', 5, 0),
(427, 'plg_system_redirect', 'plugin', 'redirect', 'system', 0, 0, 1, 1, '{"name":"plg_system_redirect","type":"plugin","creationDate":"April 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SYSTEM_REDIRECT_XML_DESCRIPTION","group":"","filename":"redirect"}', '', '', '', 0, '0000-00-00 00:00:00', 6, 0),
(428, 'plg_system_remember', 'plugin', 'remember', 'system', 0, 1, 1, 1, '{"name":"plg_system_remember","type":"plugin","creationDate":"April 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_REMEMBER_XML_DESCRIPTION","group":"","filename":"remember"}', '', '', '', 0, '0000-00-00 00:00:00', 7, 0),
(429, 'plg_system_sef', 'plugin', 'sef', 'system', 0, 1, 1, 0, '{"name":"plg_system_sef","type":"plugin","creationDate":"December 2007","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SEF_XML_DESCRIPTION","group":"","filename":"sef"}', '', '', '', 0, '0000-00-00 00:00:00', 8, 0),
(430, 'plg_system_logout', 'plugin', 'logout', 'system', 0, 1, 1, 1, '{"name":"plg_system_logout","type":"plugin","creationDate":"April 2009","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SYSTEM_LOGOUT_XML_DESCRIPTION","group":"","filename":"logout"}', '', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(431, 'plg_user_contactcreator', 'plugin', 'contactcreator', 'user', 0, 0, 1, 0, '{"name":"plg_user_contactcreator","type":"plugin","creationDate":"August 2009","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_CONTACTCREATOR_XML_DESCRIPTION","group":"","filename":"contactcreator"}', '{"autowebpage":"","category":"34","autopublish":"0"}', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(432, 'plg_user_joomla', 'plugin', 'joomla', 'user', 0, 1, 1, 0, '{"name":"plg_user_joomla","type":"plugin","creationDate":"December 2006","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_USER_JOOMLA_XML_DESCRIPTION","group":"","filename":"joomla"}', '{"autoregister":"1","mail_to_user":"1","forceLogout":"1"}', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(433, 'plg_user_profile', 'plugin', 'profile', 'user', 0, 0, 1, 0, '{"name":"plg_user_profile","type":"plugin","creationDate":"January 2008","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_USER_PROFILE_XML_DESCRIPTION","group":"","filename":"profile"}', '{"register-require_address1":"1","register-require_address2":"1","register-require_city":"1","register-require_region":"1","register-require_country":"1","register-require_postal_code":"1","register-require_phone":"1","register-require_website":"1","register-require_favoritebook":"1","register-require_aboutme":"1","register-require_tos":"1","register-require_dob":"1","profile-require_address1":"1","profile-require_address2":"1","profile-require_city":"1","profile-require_region":"1","profile-require_country":"1","profile-require_postal_code":"1","profile-require_phone":"1","profile-require_website":"1","profile-require_favoritebook":"1","profile-require_aboutme":"1","profile-require_tos":"1","profile-require_dob":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(434, 'plg_extension_joomla', 'plugin', 'joomla', 'extension', 0, 1, 1, 1, '{"name":"plg_extension_joomla","type":"plugin","creationDate":"May 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_EXTENSION_JOOMLA_XML_DESCRIPTION","group":"","filename":"joomla"}', '', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(435, 'plg_content_joomla', 'plugin', 'joomla', 'content', 0, 1, 1, 0, '{"name":"plg_content_joomla","type":"plugin","creationDate":"November 2010","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_CONTENT_JOOMLA_XML_DESCRIPTION","group":"","filename":"joomla"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(436, 'plg_system_languagecode', 'plugin', 'languagecode', 'system', 0, 0, 1, 0, '{"name":"plg_system_languagecode","type":"plugin","creationDate":"November 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SYSTEM_LANGUAGECODE_XML_DESCRIPTION","group":"","filename":"languagecode"}', '', '', '', 0, '0000-00-00 00:00:00', 10, 0),
(437, 'plg_quickicon_joomlaupdate', 'plugin', 'joomlaupdate', 'quickicon', 0, 1, 1, 1, '{"name":"plg_quickicon_joomlaupdate","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_QUICKICON_JOOMLAUPDATE_XML_DESCRIPTION","group":"","filename":"joomlaupdate"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(438, 'plg_quickicon_extensionupdate', 'plugin', 'extensionupdate', 'quickicon', 0, 1, 1, 1, '{"name":"plg_quickicon_extensionupdate","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_QUICKICON_EXTENSIONUPDATE_XML_DESCRIPTION","group":"","filename":"extensionupdate"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(439, 'plg_captcha_recaptcha', 'plugin', 'recaptcha', 'captcha', 0, 0, 1, 0, '{"name":"plg_captcha_recaptcha","type":"plugin","creationDate":"December 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.4.0","description":"PLG_CAPTCHA_RECAPTCHA_XML_DESCRIPTION","group":"","filename":"recaptcha"}', '{"public_key":"","private_key":"","theme":"clean"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(440, 'plg_system_highlight', 'plugin', 'highlight', 'system', 0, 1, 1, 0, '{"name":"plg_system_highlight","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SYSTEM_HIGHLIGHT_XML_DESCRIPTION","group":"","filename":"highlight"}', '', '', '', 0, '0000-00-00 00:00:00', 7, 0),
(441, 'plg_content_finder', 'plugin', 'finder', 'content', 0, 0, 1, 0, '{"name":"plg_content_finder","type":"plugin","creationDate":"December 2011","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_CONTENT_FINDER_XML_DESCRIPTION","group":"","filename":"finder"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(442, 'plg_finder_categories', 'plugin', 'categories', 'finder', 0, 1, 1, 0, '{"name":"plg_finder_categories","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_FINDER_CATEGORIES_XML_DESCRIPTION","group":"","filename":"categories"}', '', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(443, 'plg_finder_contacts', 'plugin', 'contacts', 'finder', 0, 1, 1, 0, '{"name":"plg_finder_contacts","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_FINDER_CONTACTS_XML_DESCRIPTION","group":"","filename":"contacts"}', '', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(444, 'plg_finder_content', 'plugin', 'content', 'finder', 0, 1, 1, 0, '{"name":"plg_finder_content","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_FINDER_CONTENT_XML_DESCRIPTION","group":"","filename":"content"}', '', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(445, 'plg_finder_newsfeeds', 'plugin', 'newsfeeds', 'finder', 0, 1, 1, 0, '{"name":"plg_finder_newsfeeds","type":"plugin","creationDate":"August 2011","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_FINDER_NEWSFEEDS_XML_DESCRIPTION","group":"","filename":"newsfeeds"}', '', '', '', 0, '0000-00-00 00:00:00', 4, 0),
(447, 'plg_finder_tags', 'plugin', 'tags', 'finder', 0, 1, 1, 0, '{"name":"plg_finder_tags","type":"plugin","creationDate":"February 2013","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_FINDER_TAGS_XML_DESCRIPTION","group":"","filename":"tags"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(448, 'plg_twofactorauth_totp', 'plugin', 'totp', 'twofactorauth', 0, 0, 1, 0, '{"name":"plg_twofactorauth_totp","type":"plugin","creationDate":"August 2013","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.2.0","description":"PLG_TWOFACTORAUTH_TOTP_XML_DESCRIPTION","group":"","filename":"totp"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(449, 'plg_authentication_cookie', 'plugin', 'cookie', 'authentication', 0, 1, 1, 0, '{"name":"plg_authentication_cookie","type":"plugin","creationDate":"July 2013","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_AUTH_COOKIE_XML_DESCRIPTION","group":"","filename":"cookie"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(450, 'plg_twofactorauth_yubikey', 'plugin', 'yubikey', 'twofactorauth', 0, 0, 1, 0, '{"name":"plg_twofactorauth_yubikey","type":"plugin","creationDate":"September 2013","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.2.0","description":"PLG_TWOFACTORAUTH_YUBIKEY_XML_DESCRIPTION","group":"","filename":"yubikey"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(451, 'plg_search_tags', 'plugin', 'tags', 'search', 0, 1, 1, 0, '{"name":"plg_search_tags","type":"plugin","creationDate":"March 2014","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.0.0","description":"PLG_SEARCH_TAGS_XML_DESCRIPTION","group":"","filename":"tags"}', '{"search_limit":"50","show_tagged_items":"1"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(452, 'plg_system_updatenotification', 'plugin', 'updatenotification', 'system', 0, 1, 1, 0, '{"name":"plg_system_updatenotification","type":"plugin","creationDate":"May 2015","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.5.0","description":"PLG_SYSTEM_UPDATENOTIFICATION_XML_DESCRIPTION","group":"","filename":"updatenotification"}', '{"lastrun":1476627101}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(453, 'plg_editors-xtd_module', 'plugin', 'module', 'editors-xtd', 0, 1, 1, 0, '{"name":"plg_editors-xtd_module","type":"plugin","creationDate":"October 2015","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.5.0","description":"PLG_MODULE_XML_DESCRIPTION","group":"","filename":"module"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(454, 'plg_system_stats', 'plugin', 'stats', 'system', 0, 1, 1, 0, '{"name":"plg_system_stats","type":"plugin","creationDate":"November 2013","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.5.0","description":"PLG_SYSTEM_STATS_XML_DESCRIPTION","group":"","filename":"stats"}', '{"mode":3,"lastrun":"","unique_id":"f41989027489c7605c111db4767151af80e7dddb","interval":12}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(455, 'plg_installer_packageinstaller', 'plugin', 'packageinstaller', 'installer', 0, 1, 1, 1, '{"name":"plg_installer_packageinstaller","type":"plugin","creationDate":"May 2016","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"PLG_INSTALLER_PACKAGEINSTALLER_PLUGIN_XML_DESCRIPTION","group":"","filename":"packageinstaller"}', '', '', '', 0, '0000-00-00 00:00:00', 1, 0),
(456, 'PLG_INSTALLER_FOLDERINSTALLER', 'plugin', 'folderinstaller', 'installer', 0, 1, 1, 1, '{"name":"PLG_INSTALLER_FOLDERINSTALLER","type":"plugin","creationDate":"May 2016","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"PLG_INSTALLER_FOLDERINSTALLER_PLUGIN_XML_DESCRIPTION","group":"","filename":"folderinstaller"}', '', '', '', 0, '0000-00-00 00:00:00', 2, 0),
(457, 'PLG_INSTALLER_URLINSTALLER', 'plugin', 'urlinstaller', 'installer', 0, 1, 1, 1, '{"name":"PLG_INSTALLER_URLINSTALLER","type":"plugin","creationDate":"May 2016","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"PLG_INSTALLER_URLINSTALLER_PLUGIN_XML_DESCRIPTION","group":"","filename":"urlinstaller"}', '', '', '', 0, '0000-00-00 00:00:00', 3, 0),
(503, 'beez3', 'template', 'beez3', '', 0, 1, 1, 0, '{"name":"beez3","type":"template","creationDate":"25 November 2009","author":"Angie Radtke","copyright":"Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.","authorEmail":"a.radtke@derauftritt.de","authorUrl":"http:\\/\\/www.der-auftritt.de","version":"3.1.0","description":"TPL_BEEZ3_XML_DESCRIPTION","group":"","filename":"templateDetails"}', '{"wrapperSmall":"53","wrapperLarge":"72","sitetitle":"","sitedescription":"","navposition":"center","templatecolor":"nature"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(504, 'hathor', 'template', 'hathor', '', 1, 1, 1, 0, '{"name":"hathor","type":"template","creationDate":"May 2010","author":"Andrea Tarr","copyright":"Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"","version":"3.0.0","description":"TPL_HATHOR_XML_DESCRIPTION","group":"","filename":"templateDetails"}', '{"showSiteName":"0","colourChoice":"0","boldText":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(506, 'protostar', 'template', 'protostar', '', 0, 1, 1, 0, '{"name":"protostar","type":"template","creationDate":"4\\/30\\/2012","author":"Kyle Ledbetter","copyright":"Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"","version":"1.0","description":"TPL_PROTOSTAR_XML_DESCRIPTION","group":"","filename":"templateDetails"}', '{"templateColor":"","logoFile":"","googleFont":"1","googleFontName":"Open+Sans","fluidContainer":"0"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(507, 'isis', 'template', 'isis', '', 1, 1, 1, 0, '{"name":"isis","type":"template","creationDate":"3\\/30\\/2012","author":"Kyle Ledbetter","copyright":"Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"","version":"1.0","description":"TPL_ISIS_XML_DESCRIPTION","group":"","filename":"templateDetails"}', '{"templateColor":"","logoFile":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(600, 'English (en-GB)', 'language', 'en-GB', '', 0, 1, 1, 1, '{"name":"English (en-GB)","type":"language","creationDate":"July 2016","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"en-GB site language","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(601, 'English (en-GB)', 'language', 'en-GB', '', 1, 1, 1, 1, '{"name":"English (en-GB)","type":"language","creationDate":"July 2016","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"en-GB administrator language","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(700, 'files_joomla', 'file', 'joomla', '', 0, 1, 1, 1, '{"name":"files_joomla","type":"file","creationDate":"July 2016","author":"Joomla! Project","copyright":"(C) 2005 - 2016 Open Source Matters. All rights reserved","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0","description":"FILES_JOOMLA_XML_DESCRIPTION","group":""}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(802, 'English (en-GB) Language Pack', 'package', 'pkg_en-GB', '', 0, 1, 1, 1, '{"name":"English (en-GB) Language Pack","type":"package","creationDate":"July 2016","author":"Joomla! Project","copyright":"Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.","authorEmail":"admin@joomla.org","authorUrl":"www.joomla.org","version":"3.6.0.1","description":"en-GB language pack","group":"","filename":"pkg_en-GB"}', '', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10001, 'Helix3 - Ajax', 'plugin', 'helix3', 'ajax', 0, 1, 1, 0, '{"name":"Helix3 - Ajax","type":"plugin","creationDate":"Jan 2015","author":"JoomShaper.com","copyright":"Copyright (C) 2010 - 2015 JoomShaper. All rights reserved.","authorEmail":"support@joomshaper.com","authorUrl":"www.joomshaper.com","version":"1.2","description":"Helix3 Framework - Joomla Template Framework by JoomShaper","group":"","filename":"helix3"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10002, 'System - Helix3 Framework', 'plugin', 'helix3', 'system', 0, 1, 1, 0, '{"name":"System - Helix3 Framework","type":"plugin","creationDate":"Jan 2015","author":"JoomShaper.com","copyright":"Copyright (C) 2010 - 2015 JoomShaper. All rights reserved.","authorEmail":"support@joomshaper.com","authorUrl":"www.joomshaper.com","version":"1.2","description":"Helix3 Framework - Joomla Template Framework by JoomShaper","group":"","filename":"helix3"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10003, 'shaper_helix3', 'template', 'shaper_helix3', '', 0, 1, 1, 0, '{"name":"shaper_helix3","type":"template","creationDate":"Jan 2015","author":"JoomShaper.com","copyright":"Copyright (C) 2010 - 2015 JoomShaper.com. All rights reserved.","authorEmail":"support@joomshaper.com","authorUrl":"http:\\/\\/www.joomshaper.com","version":"1.2","description":"Shaper Helix3 - Starter Template of Helix3 framework","group":"","filename":"templateDetails"}', '{"sticky_header":"1","boxed_layout":"0","logo_type":"image","logo_position":"logo","body_bg_repeat":"inherit","body_bg_size":"inherit","body_bg_attachment":"inherit","body_bg_position":"0 0","enabled_copyright":"1","copyright_position":"footer1","copyright":"\\u00a9 2015 Your Company. All Rights Reserved. Designed By JoomShaper","show_social_icons":"1","social_position":"top1","enable_contactinfo":"1","contact_position":"top2","contact_phone":"+228 872 4444","contact_email":"contact@email.com","comingsoon_mode":"0","comingsoon_title":"Coming Soon Title","comingsoon_date":"5-10-2018","comingsoon_content":"Coming soon content","preset":"preset1","preset1_bg":"#ffffff","preset1_text":"#000000","preset1_major":"#26aae1","preset2_bg":"#ffffff","preset2_text":"#000000","preset2_major":"#3d449a","preset3_bg":"#ffffff","preset3_text":"#000000","preset3_major":"#2bb673","preset4_bg":"#ffffff","preset4_text":"#000000","preset4_major":"#eb4947","menu":"mainmenu","menu_type":"mega_offcanvas","menu_animation":"menu-fade","enable_body_font":"1","body_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"300\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h1_font":"1","h1_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"800\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h2_font":"1","h2_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"600\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h3_font":"1","h3_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"regular\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h4_font":"1","h4_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"regular\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h5_font":"1","h5_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"600\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h6_font":"1","h6_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"600\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_navigation_font":"0","enable_custom_font":"0","compress_css":"0","compress_js":"0","lessoption":"0","show_post_format":"1","commenting_engine":"disabled","disqus_devmode":"0","intensedebate_acc":"","fb_width":"500","fb_cpp":"10","comments_count":"0","social_share":"1","image_small":"0","image_small_size":"100X100","image_thumbnail":"1","image_thumbnail_size":"200X200","image_medium":"0","image_medium_size":"300X300","image_large":"0","image_large_size":"600X600","blog_list_image":"default"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10004, 'SP Page Builder', 'component', 'com_sppagebuilder', '', 1, 1, 0, 0, '{"name":"SP Page Builder","type":"component","creationDate":"Sep 2014","author":"JoomShaper","copyright":"Copyright @ 2010 - 2016 JoomShaper. All rights reserved.","authorEmail":"support@joomshaper.com","authorUrl":"http:\\/\\/www.joomshaper.com","version":"1.0.8","description":"Most powerful drag and drop page builder for Joomla 3.4 or later.","group":"","filename":"sppagebuilder"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10005, 'mod_sppagebuilder_icons', 'module', 'mod_sppagebuilder_icons', '', 1, 1, 2, 0, '{"name":"mod_sppagebuilder_icons","type":"module","creationDate":"August 2014","author":"JoomShaper","copyright":"Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.","authorEmail":"support@joomshaper.com","authorUrl":"www.joomshaper.com","version":"1.0.2","description":"MOD_SPPAGEBUILDER_ICONS_XML_DESCRIPTION","group":"","filename":"mod_sppagebuilder_icons"}', '[]', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10006, 'mod_sppagebuilder_admin_menu', 'module', 'mod_sppagebuilder_admin_menu', '', 1, 1, 2, 0, '{"name":"mod_sppagebuilder_admin_menu","type":"module","creationDate":"August 2014","author":"JoomShaper","copyright":"Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.","authorEmail":"support@joomshaper.com","authorUrl":"www.joomshaper.com","version":"1.0.2","description":"MOD_SPPAGEBUILDER_MENU_XML_DESCRIPTION","group":"","filename":"mod_sppagebuilder_admin_menu"}', '[]', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10007, 'JMap', 'component', 'com_jmap', '', 1, 1, 0, 0, '{"name":"JMap","type":"component","creationDate":"July 2015","author":"Joomla! Extensions Store","copyright":"Copyright (C) 2015 - Joomla! Extensions Store. All Rights Reserved.","authorEmail":"info@storejextensions.org","authorUrl":"http:\\/\\/storejextensions.org","version":"3.5","description":"COM_JMAP_INFO_MESSAGES","group":"","filename":"jmap"}', '{"show_title":"1","title_type":"maintitle","defaulttitle":"","headerlevel":"1","classdiv":"sitemap","show_pagebreaks":"0","opentarget":"_self","include_external_links":"1","unique_pagination":"1","sitemap_html_template":"","show_icons":"1","animated":"1","animate_speed":"200","minheight_root_folders":"35","minheight_sub_folders":"30","minheight_leaf":"20","minwidth_columns":"120","font_size_boxes":"12","root_folders_color":"#F60","root_folders_border_color":"#943B00","root_folders_text_color":"#FFF","sub_folders_color":"#99CDFF","sub_folders_border_color":"#11416F","sub_folders_text_color":"#11416F","leaf_folders_color":"#EBEBEB","leaf_folders_border_color":"#6E6E6E","leaf_folders_text_color":"#505050","connections_color":"#CCC","expand_iconset":"square-blue","draggable_sitemap":"0","show_expanded":"0","expand_location":"location","column_sitemap":"0","column_maxnum":"3","multilevel_categories":"0","enable_view_cache":"0","lifetime_view_cache":"1","enable_precaching":"0","precaching_limit_xml":"5000","precaching_limit_images":"50","split_sitemap":"0","split_chunks":"50000","splitting_hardcoded_rootnode":"1","gnews_publication_name":"","gnews_limit_recent":"0","gnews_limit_valid_days":"2","gnews_genres":["Blog"],"imagetitle_processor":"title|alt","max_images_requests":"50","regex_images_crawler":"advanced","fake_images_processor":"0","lazyload_images_processor":"0","sh404sef_multilanguage":"0","rss_channel_name":"","rss_channel_description":"","rss_channel_image":"","rss_webmaster_name":"","rss_webmaster_email":"","rss_channel_excludewords":"","geositemap_enabled":"0","geositemap_address":"","geositemap_name":"","geositemap_author":"","geositemap_description":"","include_archived":"0","multiple_content_sources":"0","disable_acl":"enabled","showalways_language_dropdown":"","lists_limit_pagination":"10","selectable_limit_pagination":"10","seostats_custom_link":"","seostats_enabled":"1","linksanalyzer_workingmode":"1","linksanalyzer_indexing_analysis":"1","linksanalyzer_serp_numresults":"10","linksanalyzer_remove_separators":"1","linksanalyzer_remove_slashes":"2","autoping":"0","default_autoping":"0","sitemap_links_sef":"0","sitemap_links_forceformat":"0","sitemap_links_random":"0","append_livesite":"1","custom_sitemap_domain":"","custom_http_port":"","resources_limit_management":"1","socket_mode":"dns","site_itemid":"","includejquery":"1","enable_debug":"0","ga_domain":"","wm_domain":"","ga_api_key":"","ga_client_id":"","ga_client_secret":""}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10008, 'System - JSitemap utilities', 'plugin', 'jmap', 'system', 0, 1, 1, 0, '{"name":"System - JSitemap utilities","type":"plugin","creationDate":"July 2015","author":"Joomla! Extensions Store","copyright":"Copyright (C) 2015 - Joomla! Extensions Store. All Rights Reserved.","authorEmail":"info@storejextensions.org","authorUrl":"http:\\/\\/storejextensions.org","version":"3.5","description":"JSitemap utilities plugin","group":"","filename":"jmap"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10009, 'Content - JSitemap Pingomatic', 'plugin', 'pingomatic', 'content', 0, 1, 1, 0, '{"name":"Content - JSitemap Pingomatic","type":"plugin","creationDate":"July 2015","author":"Joomla! Extensions Store","copyright":"Copyright (C) 2015 - Joomla! Extensions Store. All Rights Reserved.","authorEmail":"info@storejextensions.org","authorUrl":"http:\\/\\/storejextensions.org","version":"3.5","description":"JSitemap Pingomatic plugin","group":"","filename":"pingomatic"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10010, 'JSitemap module', 'module', 'mod_jmap', '', 0, 1, 0, 0, '{"name":"JSitemap module","type":"module","creationDate":"July 2015","author":"Joomla! Extensions Store","copyright":"Copyright (C) 2015 - Joomla! Extensions Store. All Rights Reserved.","authorEmail":"info@storejextensions.org","authorUrl":"http:\\/\\/storejextensions.org","version":"3.5","description":"JSitemap Module","group":"","filename":"mod_jmap"}', '{"scrolling":"auto","width":"100%","height":"200","height_auto":"1","sitemap_html_template":"","show_icons":"","show_expanded":"","expand_location":"","column_sitemap":"","column_maxnum":"","multilevel_categories":"","cache":"1","cache_time":"900","cachemode":"static"}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10011, 'JSitemap Quickicons', 'module', 'mod_jmapquickicon', '', 1, 1, 2, 0, '{"name":"JSitemap Quickicons","type":"module","creationDate":"July 2015","author":"Joomla! Extensions Store","copyright":"Copyright (C) 2015 - Joomla! Extensions Store. All Rights Reserved.","authorEmail":"info@storejextensions.org","authorUrl":"http:\\/\\/storejextensions.org","version":"3.5","description":"JSitemap Quickicons module","group":"","filename":"mod_jmapquickicon"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10012, 'Russian', 'language', 'ru-RU', '', 0, 1, 0, 0, '{"name":"Russian","type":"language","creationDate":"2016-04-01","author":"Russian Translation Team","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved","authorEmail":"smart@joomlaportal.ru","authorUrl":"www.joomlaportal.ru","version":"3.5.0.6","description":"Russian language pack (site) for Joomla! 3.5.0","group":"","filename":"install"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10013, '', 'language', 'ru-RU', '', 1, 1, 0, 0, '{"name":"\\u0420\\u0443\\u0441\\u0441\\u043a\\u0438\\u0439 (\\u0420\\u043e\\u0441\\u0441\\u0438\\u044f)","type":"language","creationDate":"2016-04-01","author":"Russian Translation Team","copyright":"Copyright (C) 2005 - 2016 Open Source Matters. All rights reserved.","authorEmail":"smart@joomlaportal.ru","authorUrl":"www.joomlaportal.ru","version":"3.5.0.6","description":"Russian language pack (administrator) for Joomla! 3.5.0","group":"","filename":"install"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0),
(10014, 'Russian (ru-RU) Language Pack', 'package', 'pkg_ru-RU', '', 0, 1, 1, 0, '{"name":"Russian (ru-RU) Language Pack","type":"package","creationDate":"2016-04-01","author":"Russian Translation Team","copyright":"","authorEmail":"smart@joomlaportal.ru","authorUrl":"www.joomlaportal.ru","version":"3.5.0.6","description":"Russian (ru-RU) language pack for Joomla","group":"","filename":"pkg_ru-RU"}', '{}', '', '', 0, '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_filters`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_filters` (
  `filter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  `created_by_alias` varchar(255) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `map_count` int(10) unsigned NOT NULL DEFAULT '0',
  `data` text NOT NULL,
  `params` mediumtext,
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `title` varchar(400) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `indexdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `md5sum` varchar(32) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `state` int(5) DEFAULT '1',
  `access` int(5) DEFAULT '0',
  `language` varchar(8) NOT NULL,
  `publish_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL DEFAULT '0',
  `sale_price` double unsigned NOT NULL DEFAULT '0',
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`(100)),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms0`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms0` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms1`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms1` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms2`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms2` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms3`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms3` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms4`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms4` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms5`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms5` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms6`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms6` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms7`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms7` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms8`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms8` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_terms9`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_terms9` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_termsa`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_termsa` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_termsb`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_termsb` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_termsc`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_termsc` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_termsd`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_termsd` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_termse`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_termse` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_links_termsf`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_links_termsf` (
  `link_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_taxonomy`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_taxonomy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `access` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `h0qwo_finder_taxonomy`
--

INSERT INTO `h0qwo_finder_taxonomy` (`id`, `parent_id`, `title`, `state`, `access`, `ordering`) VALUES
(1, 0, 'ROOT', 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_taxonomy_map`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_taxonomy_map` (
  `link_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_terms`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_terms` (
  `term_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '0',
  `soundex` varchar(75) NOT NULL,
  `links` int(10) NOT NULL DEFAULT '0',
  `language` char(3) NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_terms_common`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_terms_common` (
  `term` varchar(75) NOT NULL,
  `language` varchar(3) NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `h0qwo_finder_terms_common`
--

INSERT INTO `h0qwo_finder_terms_common` (`term`, `language`) VALUES
('a', 'en'),
('about', 'en'),
('after', 'en'),
('ago', 'en'),
('all', 'en'),
('am', 'en'),
('an', 'en'),
('and', 'en'),
('ani', 'en'),
('any', 'en'),
('are', 'en'),
('aren''t', 'en'),
('as', 'en'),
('at', 'en'),
('be', 'en'),
('but', 'en'),
('by', 'en'),
('for', 'en'),
('from', 'en'),
('get', 'en'),
('go', 'en'),
('how', 'en'),
('if', 'en'),
('in', 'en'),
('into', 'en'),
('is', 'en'),
('isn''t', 'en'),
('it', 'en'),
('its', 'en'),
('me', 'en'),
('more', 'en'),
('most', 'en'),
('must', 'en'),
('my', 'en'),
('new', 'en'),
('no', 'en'),
('none', 'en'),
('not', 'en'),
('noth', 'en'),
('nothing', 'en'),
('of', 'en'),
('off', 'en'),
('often', 'en'),
('old', 'en'),
('on', 'en'),
('onc', 'en'),
('once', 'en'),
('onli', 'en'),
('only', 'en'),
('or', 'en'),
('other', 'en'),
('our', 'en'),
('ours', 'en'),
('out', 'en'),
('over', 'en'),
('page', 'en'),
('she', 'en'),
('should', 'en'),
('small', 'en'),
('so', 'en'),
('some', 'en'),
('than', 'en'),
('thank', 'en'),
('that', 'en'),
('the', 'en'),
('their', 'en'),
('theirs', 'en'),
('them', 'en'),
('then', 'en'),
('there', 'en'),
('these', 'en'),
('they', 'en'),
('this', 'en'),
('those', 'en'),
('thus', 'en'),
('time', 'en'),
('times', 'en'),
('to', 'en'),
('too', 'en'),
('true', 'en'),
('under', 'en'),
('until', 'en'),
('up', 'en'),
('upon', 'en'),
('use', 'en'),
('user', 'en'),
('users', 'en'),
('veri', 'en'),
('version', 'en'),
('very', 'en'),
('via', 'en'),
('want', 'en'),
('was', 'en'),
('way', 'en'),
('were', 'en'),
('what', 'en'),
('when', 'en'),
('where', 'en'),
('whi', 'en'),
('which', 'en'),
('who', 'en'),
('whom', 'en'),
('whose', 'en'),
('why', 'en'),
('wide', 'en'),
('will', 'en'),
('with', 'en'),
('within', 'en'),
('without', 'en'),
('would', 'en'),
('yes', 'en'),
('yet', 'en'),
('you', 'en'),
('your', 'en'),
('yours', 'en');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_tokens`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_tokens` (
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '1',
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `language` char(3) NOT NULL DEFAULT '',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_tokens_aggregate`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_tokens_aggregate` (
  `term_id` int(10) unsigned NOT NULL,
  `map_suffix` char(1) NOT NULL,
  `term` varchar(75) NOT NULL,
  `stem` varchar(75) NOT NULL,
  `common` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  `language` char(3) NOT NULL DEFAULT '',
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_finder_types`
--

CREATE TABLE IF NOT EXISTS `h0qwo_finder_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `mime` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `sqlquery` text,
  `sqlquery_managed` text,
  `params` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `h0qwo_jmap`
--

INSERT INTO `h0qwo_jmap` (`id`, `type`, `name`, `description`, `checked_out`, `checked_out_time`, `published`, `ordering`, `sqlquery`, `sqlquery_managed`, `params`) VALUES
(1, 'content', 'Content', 'Default contents source', 0, '0000-00-00 00:00:00', 1, 1, '', '', ''),
(2, 'menu', 'Main Menu', 'The main menu for the site', 0, '0000-00-00 00:00:00', 1, 2, NULL, NULL, ''),
(3, 'menu', 'Author Menu', '', 0, '0000-00-00 00:00:00', 1, 3, NULL, NULL, ''),
(4, 'menu', 'Bottom Menu', '', 0, '0000-00-00 00:00:00', 1, 4, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_cats_priorities`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_cats_priorities` (
  `id` int(11) NOT NULL,
  `priority` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_datasets`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_datasets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `sources` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_dss_relations`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_dss_relations` (
  `datasetid` int(11) NOT NULL,
  `datasourceid` int(11) NOT NULL,
  PRIMARY KEY (`datasetid`,`datasourceid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_google`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_google` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_menu_priorities`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_menu_priorities` (
  `id` int(11) NOT NULL,
  `priority` char(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_metainfo`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_metainfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `linkurl` varchar(600) NOT NULL,
  `meta_title` text,
  `meta_desc` text,
  `meta_image` varchar(255) DEFAULT NULL,
  `robots` varchar(255) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `linkurl` (`linkurl`(255)),
  KEY `robots` (`robots`),
  KEY `published` (`published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_jmap_pingomatic`
--

CREATE TABLE IF NOT EXISTS `h0qwo_jmap_pingomatic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `blogurl` varchar(255) NOT NULL,
  `rssurl` varchar(255) DEFAULT NULL,
  `services` text NOT NULL,
  `lastping` datetime DEFAULT NULL,
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_languages`
--

CREATE TABLE IF NOT EXISTS `h0qwo_languages` (
  `lang_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `lang_code` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_native` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sef` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sitename` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `published` int(11) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_image` (`image`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_access` (`access`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `h0qwo_languages`
--

INSERT INTO `h0qwo_languages` (`lang_id`, `asset_id`, `lang_code`, `title`, `title_native`, `sef`, `image`, `description`, `metakey`, `metadesc`, `sitename`, `published`, `access`, `ordering`) VALUES
(1, 0, 'en-GB', 'English (UK)', 'English (UK)', 'en', 'en', '', '', '', '', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_menu`
--

CREATE TABLE IF NOT EXISTS `h0qwo_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `access` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `home` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`(100),`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_path` (`path`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=120 ;

--
-- Дамп данных таблицы `h0qwo_menu`
--

INSERT INTO `h0qwo_menu` (`id`, `menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) VALUES
(1, '', 'Menu_Item_Root', 'root', '', '', '', '', 1, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, 69, 0, '*', 0),
(2, 'menu', 'com_banners', 'Banners', '', 'Banners', 'index.php?option=com_banners', 'component', 0, 1, 1, 4, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners', 0, '', 1, 10, 0, '*', 1),
(3, 'menu', 'com_banners', 'Banners', '', 'Banners/Banners', 'index.php?option=com_banners', 'component', 0, 2, 2, 4, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners', 0, '', 2, 3, 0, '*', 1),
(4, 'menu', 'com_banners_categories', 'Categories', '', 'Banners/Categories', 'index.php?option=com_categories&extension=com_banners', 'component', 0, 2, 2, 6, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-cat', 0, '', 4, 5, 0, '*', 1),
(5, 'menu', 'com_banners_clients', 'Clients', '', 'Banners/Clients', 'index.php?option=com_banners&view=clients', 'component', 0, 2, 2, 4, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-clients', 0, '', 6, 7, 0, '*', 1),
(6, 'menu', 'com_banners_tracks', 'Tracks', '', 'Banners/Tracks', 'index.php?option=com_banners&view=tracks', 'component', 0, 2, 2, 4, 0, '0000-00-00 00:00:00', 0, 0, 'class:banners-tracks', 0, '', 8, 9, 0, '*', 1),
(7, 'menu', 'com_contact', 'Contacts', '', 'Contacts', 'index.php?option=com_contact', 'component', 0, 1, 1, 8, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact', 0, '', 35, 40, 0, '*', 1),
(8, 'menu', 'com_contact', 'Contacts', '', 'Contacts/Contacts', 'index.php?option=com_contact', 'component', 0, 7, 2, 8, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact', 0, '', 36, 37, 0, '*', 1),
(9, 'menu', 'com_contact_categories', 'Categories', '', 'Contacts/Categories', 'index.php?option=com_categories&extension=com_contact', 'component', 0, 7, 2, 6, 0, '0000-00-00 00:00:00', 0, 0, 'class:contact-cat', 0, '', 38, 39, 0, '*', 1),
(10, 'menu', 'com_messages', 'Messaging', '', 'Messaging', 'index.php?option=com_messages', 'component', 0, 1, 1, 15, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages', 0, '', 41, 44, 0, '*', 1),
(11, 'menu', 'com_messages_add', 'New Private Message', '', 'Messaging/New Private Message', 'index.php?option=com_messages&task=message.add', 'component', 0, 10, 2, 15, 0, '0000-00-00 00:00:00', 0, 0, 'class:messages-add', 0, '', 42, 43, 0, '*', 1),
(13, 'menu', 'com_newsfeeds', 'News Feeds', '', 'News Feeds', 'index.php?option=com_newsfeeds', 'component', 0, 1, 1, 17, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds', 0, '', 45, 50, 0, '*', 1),
(14, 'menu', 'com_newsfeeds_feeds', 'Feeds', '', 'News Feeds/Feeds', 'index.php?option=com_newsfeeds', 'component', 0, 13, 2, 17, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds', 0, '', 46, 47, 0, '*', 1),
(15, 'menu', 'com_newsfeeds_categories', 'Categories', '', 'News Feeds/Categories', 'index.php?option=com_categories&extension=com_newsfeeds', 'component', 0, 13, 2, 6, 0, '0000-00-00 00:00:00', 0, 0, 'class:newsfeeds-cat', 0, '', 48, 49, 0, '*', 1),
(16, 'menu', 'com_redirect', 'Redirect', '', 'Redirect', 'index.php?option=com_redirect', 'component', 0, 1, 1, 24, 0, '0000-00-00 00:00:00', 0, 0, 'class:redirect', 0, '', 57, 58, 0, '*', 1),
(17, 'menu', 'com_search', 'Basic Search', '', 'Basic Search', 'index.php?option=com_search', 'component', 0, 1, 1, 19, 0, '0000-00-00 00:00:00', 0, 0, 'class:search', 0, '', 53, 54, 0, '*', 1),
(21, 'menu', 'com_finder', 'Smart Search', '', 'Smart Search', 'index.php?option=com_finder', 'component', 0, 1, 1, 27, 0, '0000-00-00 00:00:00', 0, 0, 'class:finder', 0, '', 51, 52, 0, '*', 1),
(22, 'menu', 'com_joomlaupdate', 'Joomla! Update', '', 'Joomla! Update', 'index.php?option=com_joomlaupdate', 'component', 0, 1, 1, 28, 0, '0000-00-00 00:00:00', 0, 0, 'class:joomlaupdate', 0, '', 55, 56, 0, '*', 1),
(101, 'mainmenu', 'Home', 'home', '', 'home', 'index.php?option=com_content&view=featured', 'component', 1, 1, 1, 22, 0, '0000-00-00 00:00:00', 0, 1, ' ', 0, '{"featured_categories":[""],"layout_type":"blog","num_leading_articles":"1","num_intro_articles":"4","num_columns":"2","num_links":"4","multi_column_order":"0","orderby_pri":"none","orderby_sec":"rdate","order_date":"published","show_pagination":"2","show_pagination_results":"1","show_title":"","link_titles":"","show_intro":"","info_block_position":"","show_category":"0","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"0","show_item_navigation":"","show_vote":"","show_readmore":"","show_readmore_title":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"0","show_tags":"","show_noauth":"","show_feed_link":"1","feed_summary":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"menu_show":1,"page_title":"","show_page_heading":"0","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"menulayout":"{\\"width\\":600,\\"menuItem\\":1,\\"menuAlign\\":\\"right\\",\\"layout\\":[{\\"type\\":\\"row\\",\\"attr\\":[{\\"type\\":\\"column\\",\\"colGrid\\":12,\\"menuParentId\\":\\"101\\",\\"moduleId\\":\\"\\"}]}]}","megamenu":"0","showmenutitle":"1","icon":"","class":"","enable_page_title":"0","page_title_alt":"","page_subtitle":"","page_title_bg_color":"","page_title_bg_image":""}', 11, 12, 1, '*', 0),
(102, 'bottommenu', 'Author Login', 'login', '', 'login', 'index.php?option=com_users&view=login', 'component', 1, 1, 1, 25, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"login_redirect_url":"index.php?Itemid=101","logindescription_show":"1","login_description":"","login_image":"","logout_redirect_url":"","logoutdescription_show":"1","logout_description":"","logout_image":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 59, 60, 0, '*', 0),
(103, 'authormenu', 'Change Password', 'change-password', '', 'change-password', 'index.php?option=com_users&view=profile&layout=edit', 'component', 1, 1, 1, 25, 0, '0000-00-00 00:00:00', 0, 2, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 31, 32, 0, '*', 0),
(104, 'authormenu', 'Create a Post', 'create-a-post', '', 'create-a-post', 'index.php?option=com_content&view=form&layout=edit', 'component', 1, 1, 1, 22, 0, '0000-00-00 00:00:00', 0, 3, '', 0, '{"enable_category":"1","catid":"9","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 21, 22, 0, '*', 0),
(106, 'authormenu', 'Site Administrator', '2012-01-04-15-46-42', '', '2012-01-04-15-46-42', 'administrator', 'url', 1, 1, 1, 0, 0, '0000-00-00 00:00:00', 1, 3, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1}', 29, 30, 0, '*', 0),
(107, 'authormenu', 'Log out', 'log-out', '', 'log-out', 'index.php?option=com_users&view=login', 'component', 1, 1, 1, 25, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"login_redirect_url":"","logindescription_show":"1","login_description":"","login_image":"","logout_redirect_url":"","logoutdescription_show":"1","logout_description":"","logout_image":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 33, 34, 0, '*', 0),
(108, 'mainmenu', 'Mortage', 'about', '', 'about', 'index.php?option=com_content&view=category&layout=blog&id=11', 'component', 0, 1, 1, 22, 0, '0000-00-00 00:00:00', 0, 1, ' ', 0, '{"layout_type":"blog","show_category_heading_title_text":"","show_category_title":"","show_description":"","show_description_image":"","maxLevel":"","show_empty_categories":"","show_no_articles":"","show_subcat_desc":"","show_cat_num_articles":"","show_cat_tags":"","page_subheading":"","num_leading_articles":"","num_intro_articles":"","num_columns":"","num_links":"","multi_column_order":"","show_subcategory_content":"","orderby_pri":"","orderby_sec":"","order_date":"","show_pagination":"","show_pagination_results":"","show_featured":"","show_title":"","link_titles":"","show_intro":"","info_block_position":"0","show_category":"0","link_category":"0","show_parent_category":"","link_parent_category":"","show_author":"0","link_author":"","show_create_date":"0","show_modify_date":"","show_publish_date":"0","show_item_navigation":"","show_vote":"","show_readmore":"","show_readmore_title":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"0","show_tags":"","show_noauth":"","show_feed_link":"","feed_summary":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"menu_show":1,"page_title":"","show_page_heading":"0","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 15, 16, 0, '*', 0),
(109, 'authormenu', 'Working on Your Site', 'working-on-your-site', '', 'working-on-your-site', 'index.php?option=com_content&view=article&id=2', 'component', 1, 1, 1, 22, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"show_title":"","link_titles":"","show_intro":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_noauth":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 23, 28, 0, '*', 0),
(111, 'menu', 'com_tags', 'com-tags', '', 'com-tags', 'index.php?option=com_tags', 'component', 0, 1, 1, 29, 0, '0000-00-00 00:00:00', 0, 1, 'class:tags', 0, '', 61, 62, 0, '', 1),
(112, 'main', 'com_postinstall', 'Post-installation messages', '', 'Post-installation messages', 'index.php?option=com_postinstall', 'component', 0, 1, 1, 32, 0, '0000-00-00 00:00:00', 0, 1, 'class:postinstall', 0, '', 63, 64, 0, '*', 1),
(113, 'authormenu', 'Site Settings', 'site-settings', '', 'working-on-your-site/site-settings', 'index.php?option=com_config&view=config&controller=config.display.config', 'component', 1, 109, 2, 23, 0, '0000-00-00 00:00:00', 0, 6, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 24, 25, 0, '*', 0),
(114, 'authormenu', 'Template Settings', 'template-settings', '', 'working-on-your-site/template-settings', 'index.php?option=com_config&view=templates&controller=config.display.templates', 'component', 1, 109, 2, 23, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 26, 27, 0, '*', 0),
(115, 'mainmenu', 'Author Login', 'author-login', '', 'author-login', 'index.php?option=com_users&view=login', 'component', 0, 1, 1, 25, 0, '0000-00-00 00:00:00', 0, 1, '', 0, '{"login_redirect_url":"","logindescription_show":"1","login_description":"","login_image":"","logout_redirect_url":"","logoutdescription_show":"1","logout_description":"","logout_image":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"page_title":"","show_page_heading":0,"page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0}', 19, 20, 0, '*', 0),
(116, 'main', 'COM_SPPAGEBUILDER', 'com-sppagebuilder', '', 'com-sppagebuilder', 'index.php?option=com_sppagebuilder', 'component', 0, 1, 1, 10004, 0, '0000-00-00 00:00:00', 0, 1, 'class:component', 0, '{}', 65, 66, 0, '', 1),
(117, 'main', 'JMAP', 'jmap', '', 'jmap', 'index.php?option=com_jmap', 'component', 0, 1, 1, 10007, 0, '0000-00-00 00:00:00', 0, 1, 'class:jmap-16x16', 0, '{}', 67, 68, 0, '', 1),
(118, 'mainmenu', 'The property', 'the-property', '', 'the-property', 'index.php?option=com_content&view=category&layout=blog&id=12', 'component', 0, 1, 1, 22, 0, '0000-00-00 00:00:00', 0, 1, ' ', 0, '{"layout_type":"blog","show_category_heading_title_text":"","show_category_title":"","show_description":"","show_description_image":"","maxLevel":"","show_empty_categories":"","show_no_articles":"","show_subcat_desc":"","show_cat_num_articles":"","show_cat_tags":"","page_subheading":"","num_leading_articles":"","num_intro_articles":"","num_columns":"","num_links":"","multi_column_order":"","show_subcategory_content":"","orderby_pri":"","orderby_sec":"","order_date":"","show_pagination":"","show_pagination_results":"","show_featured":"","show_title":"","link_titles":"","show_intro":"","info_block_position":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_readmore":"","show_readmore_title":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_tags":"","show_noauth":"","show_feed_link":"","feed_summary":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"menu_show":1,"page_title":"","show_page_heading":"","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"dropdown_position":"right","showmenutitle":"1","icon":"","class":"","enable_page_title":"0","page_title_alt":"","page_subtitle":"","page_title_bg_color":"","page_title_bg_image":""}', 17, 18, 0, '*', 0),
(119, 'mainmenu', 'Rental of property', 'rental-of-property', '', 'rental-of-property', 'index.php?option=com_content&view=category&layout=blog&id=10', 'component', 1, 1, 1, 22, 0, '0000-00-00 00:00:00', 0, 1, ' ', 0, '{"layout_type":"blog","show_category_heading_title_text":"","show_category_title":"","show_description":"","show_description_image":"","maxLevel":"","show_empty_categories":"","show_no_articles":"","show_subcat_desc":"","show_cat_num_articles":"","show_cat_tags":"","page_subheading":"","num_leading_articles":"","num_intro_articles":"","num_columns":"","num_links":"","multi_column_order":"","show_subcategory_content":"","orderby_pri":"","orderby_sec":"","order_date":"","show_pagination":"","show_pagination_results":"","show_featured":"","show_title":"","link_titles":"","show_intro":"","info_block_position":"","show_category":"","link_category":"","show_parent_category":"","link_parent_category":"","show_author":"","link_author":"","show_create_date":"","show_modify_date":"","show_publish_date":"","show_item_navigation":"","show_vote":"","show_readmore":"","show_readmore_title":"","show_icons":"","show_print_icon":"","show_email_icon":"","show_hits":"","show_tags":"","show_noauth":"","show_feed_link":"","feed_summary":"","menu-anchor_title":"","menu-anchor_css":"","menu_image":"","menu_text":1,"menu_show":1,"page_title":"","show_page_heading":"","page_heading":"","pageclass_sfx":"","menu-meta_description":"","menu-meta_keywords":"","robots":"","secure":0,"dropdown_position":"right","showmenutitle":"1","icon":"","class":"","enable_page_title":"0","page_title_alt":"","page_subtitle":"","page_title_bg_color":"","page_title_bg_image":""}', 13, 14, 0, '*', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_menu_types`
--

CREATE TABLE IF NOT EXISTS `h0qwo_menu_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(11) NOT NULL,
  `menutype` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `h0qwo_menu_types`
--

INSERT INTO `h0qwo_menu_types` (`id`, `asset_id`, `menutype`, `title`, `description`) VALUES
(1, 0, 'mainmenu', 'Main Menu', 'The main menu for the site'),
(2, 0, 'authormenu', 'Author Menu', ''),
(3, 0, 'bottommenu', 'Bottom Menu', '');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_messages`
--

CREATE TABLE IF NOT EXISTS `h0qwo_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id_to` int(10) unsigned NOT NULL DEFAULT '0',
  `folder_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_messages_cfg`
--

CREATE TABLE IF NOT EXISTS `h0qwo_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cfg_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_modules`
--

CREATE TABLE IF NOT EXISTS `h0qwo_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `position` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=97 ;

--
-- Дамп данных таблицы `h0qwo_modules`
--

INSERT INTO `h0qwo_modules` (`id`, `asset_id`, `title`, `note`, `content`, `ordering`, `position`, `checked_out`, `checked_out_time`, `publish_up`, `publish_down`, `published`, `module`, `access`, `showtitle`, `params`, `client_id`, `language`) VALUES
(1, 0, 'Main Menu', '', '', 1, 'position-1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 1, 0, '{"menutype":"mainmenu","base":"","startLevel":"1","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":" nav-pills","window_open":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(2, 0, 'Login', '', '', 1, 'login', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_login', 1, 1, '', 1, '*'),
(3, 0, 'Popular Articles', '', '', 1, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_popular', 3, 1, '{"count":"5","catid":"","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","module_tag":"div","bootstrap_size":"6","header_tag":"h3","header_class":"","style":"0"}', 1, '*'),
(4, 0, 'Recently Added Articles', '', '', 2, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_latest', 3, 1, '{"count":"5","ordering":"c_dsc","catid":"","user_id":"0","layout":"_:default","moduleclass_sfx":"","cache":"0","module_tag":"div","bootstrap_size":"6","header_tag":"h3","header_class":"","style":"0"}', 1, '*'),
(8, 0, 'Toolbar', '', '', 1, 'toolbar', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_toolbar', 3, 1, '', 1, '*'),
(9, 0, 'Quick Icons', '', '', 1, 'icon', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_quickicon', 3, 1, '', 1, '*'),
(10, 0, 'Logged-in Users', '', '', 3, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_logged', 3, 1, '{"count":"5","name":"1","layout":"_:default","moduleclass_sfx":"","cache":"0","module_tag":"div","bootstrap_size":"6","header_tag":"h3","header_class":"","style":"0"}', 1, '*'),
(12, 0, 'Admin Menu', '', '', 1, 'menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 3, 1, '{"layout":"","moduleclass_sfx":"","shownew":"1","showhelp":"1","cache":"0"}', 1, '*'),
(13, 0, 'Admin Submenu', '', '', 1, 'submenu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_submenu', 3, 1, '', 1, '*'),
(14, 0, 'User Status', '', '', 2, 'status', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_status', 3, 1, '', 1, '*'),
(15, 0, 'Title', '', '', 1, 'title', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_title', 3, 1, '', 1, '*'),
(16, 0, 'Login Form', '', '', 7, 'position-7', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_login', 1, 1, '{"greeting":"1","name":"0"}', 0, '*'),
(17, 0, 'Breadcrumbs', '', '', 1, 'position-2', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_breadcrumbs', 1, 1, '{"moduleclass_sfx":"","showHome":"1","homeText":"","showComponent":"1","separator":"","cache":"1","cache_time":"900","cachemode":"itemid"}', 0, '*'),
(79, 0, 'Multilanguage status', '', '', 1, 'status', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_multilangstatus', 3, 1, '{"layout":"_:default","moduleclass_sfx":"","cache":"0"}', 1, '*'),
(80, 0, 'Author Menu', '', '', 1, 'position-1', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 3, 0, '{"menutype":"authormenu","base":"","startLevel":"1","endLevel":"0","showAllChildren":"1","tag_id":"","class_sfx":" nav-pills","window_open":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(82, 0, 'Syndication', '', '', 6, 'position-7', 528, '2016-04-13 07:33:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_syndicate', 1, 0, '{"display_text":1,"text":"My Blog","format":"rss","layout":"_:default","moduleclass_sfx":"","cache":"0"}', 0, '*'),
(83, 0, 'Archived Articles', '', '', 4, 'position-7', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_articles_archive', 1, 1, '{"count":"10","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(84, 0, 'Most Read Posts', '', '', 5, 'position-7', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_articles_popular', 1, 1, '{"catid":["9"],"count":"5","show_front":"1","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static"}', 0, '*'),
(85, 0, 'Older Posts', '', '', 2, 'position-7', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_articles_category', 1, 1, '{"mode":"normal","show_on_article_page":"0","show_front":"show","count":"6","category_filtering_type":"1","catid":["9"],"show_child_category_articles":"0","levels":"1","author_filtering_type":"1","created_by":[""],"author_alias_filtering_type":"1","created_by_alias":[""],"excluded_articles":"","date_filtering":"off","date_field":"a.created","start_date_range":"","end_date_range":"","relative_date":"30","article_ordering":"a.created","article_ordering_direction":"DESC","article_grouping":"none","article_grouping_direction":"krsort","month_year_format":"F Y","item_heading":"5","link_titles":"1","show_date":"0","show_date_field":"created","show_date_format":"Y-m-d H:i:s","show_category":"0","show_hits":"0","show_author":"0","show_introtext":"0","introtext_limit":"100","show_readmore":"0","show_readmore_title":"1","readmore_limit":"15","layout":"_:default","moduleclass_sfx":"","owncache":"1","cache_time":"900","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(86, 0, 'Bottom Menu', '', '', 1, 'footer', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_menu', 1, 0, '{"menutype":"bottommenu","base":"","startLevel":"1","endLevel":"0","showAllChildren":"0","tag_id":"","class_sfx":"","window_open":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(87, 0, 'Search', '', '', 1, 'position-0', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_search', 1, 1, '{"label":"","width":"20","text":"","button":"","button_pos":"right","imagebutton":"","button_text":"","opensearch":"1","opensearch_title":"","set_itemid":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"itemid"}', 0, '*'),
(88, 0, 'Image', '', '<p><img src="images/headers/raindrops.jpg" alt="" /></p>', 1, 'position-3', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_custom', 1, 0, '{"prepare_content":"1","backgroundimage":"","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(89, 0, 'Popular Tags', '', '', 1, 'position-7', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_tags_popular', 1, 1, '{"maximum":"8","timeframe":"alltime","order_value":"count","order_direction":"1","display_count":0,"no_results_text":"0","minsize":1,"maxsize":2,"layout":"_:default","moduleclass_sfx":"","owncache":"1","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(90, 0, 'Similar Items', '', '', 0, '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_tags_similar', 1, 1, '{"maximum":"5","matchtype":"any","layout":"_:default","moduleclass_sfx":"","owncache":"1","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 0, '*'),
(91, 0, 'Site Information', '', '', 4, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_stats_admin', 6, 1, '{"serverinfo":"1","siteinfo":"1","counter":"0","increase":"0","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","cachemode":"static","module_tag":"div","bootstrap_size":"6","header_tag":"h3","header_class":"","style":"0"}', 1, '*'),
(92, 0, 'Release News', '', '', 1, 'postinstall', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_feed', 1, 1, '{"rssurl":"https:\\/\\/www.joomla.org\\/announcements\\/release-news.feed","rssrtl":"0","rsstitle":"1","rssdesc":"1","rssimage":"1","rssitems":"3","rssitemdesc":"1","word_count":"0","layout":"_:default","moduleclass_sfx":"","cache":"1","cache_time":"900","module_tag":"div","bootstrap_size":"0","header_tag":"h3","header_class":"","style":"0"}', 1, '*'),
(93, 56, 'SP Page Builder', '', '', 0, 'cpanel', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_sppagebuilder_icons', 1, 1, '', 1, '*'),
(94, 57, 'SP Page Builder Admin Menu', '', '', 1, 'menu', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_sppagebuilder_admin_menu', 1, 1, '', 1, '*'),
(95, 58, 'JSitemap module', '', '', 0, '', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 'mod_jmap', 1, 1, '', 0, '*'),
(96, 59, 'JSitemap Quickicons', '', '', 99, 'icon', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 'mod_jmapquickicon', 1, 1, '', 1, '*');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_modules_menu`
--

CREATE TABLE IF NOT EXISTS `h0qwo_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `menuid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `h0qwo_modules_menu`
--

INSERT INTO `h0qwo_modules_menu` (`moduleid`, `menuid`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(12, 0),
(13, 0),
(14, 0),
(15, 0),
(16, 0),
(17, 0),
(79, 0),
(80, 0),
(82, 0),
(83, 0),
(84, 0),
(85, 0),
(86, 0),
(87, 0),
(88, 0),
(89, 0),
(90, 0),
(91, 0),
(92, 0),
(93, 0),
(94, 0),
(96, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_newsfeeds`
--

CREATE TABLE IF NOT EXISTS `h0qwo_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `link` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int(10) unsigned NOT NULL DEFAULT '1',
  `cache_time` int(10) unsigned NOT NULL DEFAULT '3600',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rtl` tinyint(4) NOT NULL DEFAULT '0',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_overrider`
--

CREATE TABLE IF NOT EXISTS `h0qwo_overrider` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `constant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `string` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_postinstall_messages`
--

CREATE TABLE IF NOT EXISTS `h0qwo_postinstall_messages` (
  `postinstall_message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `extension_id` bigint(20) NOT NULL DEFAULT '700' COMMENT 'FK to #__extensions',
  `title_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Lang key for the title',
  `description_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Lang key for description',
  `action_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language_extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'com_postinstall' COMMENT 'Extension holding lang keys',
  `language_client_id` tinyint(3) NOT NULL DEFAULT '1',
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link' COMMENT 'Message type - message, link, action',
  `action_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'RAD URI to the PHP file containing action method',
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Action method name or URL',
  `condition_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAD URI to file holding display condition method',
  `condition_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display condition method, must return boolean',
  `version_introduced` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3.2.0' COMMENT 'Version when this message was introduced',
  `enabled` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`postinstall_message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `h0qwo_postinstall_messages`
--

INSERT INTO `h0qwo_postinstall_messages` (`postinstall_message_id`, `extension_id`, `title_key`, `description_key`, `action_key`, `language_extension`, `language_client_id`, `type`, `action_file`, `action`, `condition_file`, `condition_method`, `version_introduced`, `enabled`) VALUES
(1, 700, 'PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_TITLE', 'PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_BODY', 'PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_ACTION', 'plg_twofactorauth_totp', 1, 'action', 'site://plugins/twofactorauth/totp/postinstall/actions.php', 'twofactorauth_postinstall_action', 'site://plugins/twofactorauth/totp/postinstall/actions.php', 'twofactorauth_postinstall_condition', '3.2.0', 1),
(2, 700, 'COM_CPANEL_WELCOME_BEGINNERS_TITLE', 'COM_CPANEL_WELCOME_BEGINNERS_MESSAGE', '', 'com_cpanel', 1, 'message', '', '', '', '', '3.2.0', 1),
(3, 700, 'COM_CPANEL_MSG_STATS_COLLECTION_TITLE', 'COM_CPANEL_MSG_STATS_COLLECTION_BODY', '', 'com_cpanel', 1, 'message', '', '', 'admin://components/com_admin/postinstall/statscollection.php', 'admin_postinstall_statscollection_condition', '3.5.0', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_redirect_links`
--

CREATE TABLE IF NOT EXISTS `h0qwo_redirect_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `header` smallint(3) NOT NULL DEFAULT '301',
  PRIMARY KEY (`id`),
  KEY `idx_old_url` (`old_url`(100)),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_schemas`
--

CREATE TABLE IF NOT EXISTS `h0qwo_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`extension_id`,`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `h0qwo_schemas`
--

INSERT INTO `h0qwo_schemas` (`extension_id`, `version_id`) VALUES
(700, '3.6.0-2016-06-05'),
(10004, '1.0.8-2016-01-20');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_session`
--

CREATE TABLE IF NOT EXISTS `h0qwo_session` (
  `session_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `guest` tinyint(4) unsigned DEFAULT '1',
  `time` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `data` mediumtext COLLATE utf8mb4_unicode_ci,
  `userid` int(11) DEFAULT '0',
  `username` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `h0qwo_session`
--

INSERT INTO `h0qwo_session` (`session_id`, `client_id`, `guest`, `time`, `data`, `userid`, `username`) VALUES
('3c6719752255630cd73c40dd44132848', 0, 1, '1476643733', NULL, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_spmedia`
--

CREATE TABLE IF NOT EXISTS `h0qwo_spmedia` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  `caption` varchar(2048) NOT NULL,
  `description` mediumtext NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'image',
  `extension` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_sppagebuilder`
--

CREATE TABLE IF NOT EXISTS `h0qwo_sppagebuilder` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `text` mediumtext NOT NULL,
  `published` tinyint(3) NOT NULL DEFAULT '1',
  `catid` int(10) NOT NULL DEFAULT '0',
  `access` int(10) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` bigint(20) NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` bigint(20) NOT NULL DEFAULT '0',
  `og_title` varchar(255) NOT NULL,
  `og_image` varchar(255) NOT NULL,
  `og_description` varchar(255) NOT NULL,
  `page_layout` varchar(55) DEFAULT NULL,
  `language` char(7) NOT NULL,
  `hits` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_tags`
--

CREATE TABLE IF NOT EXISTS `h0qwo_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL DEFAULT '0',
  `rgt` int(11) NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) unsigned NOT NULL DEFAULT '1',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tag_idx` (`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`(100)),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `h0qwo_tags`
--

INSERT INTO `h0qwo_tags` (`id`, `parent_id`, `lft`, `rgt`, `level`, `path`, `title`, `alias`, `note`, `description`, `published`, `checked_out`, `checked_out_time`, `access`, `params`, `metadesc`, `metakey`, `metadata`, `created_user_id`, `created_time`, `created_by_alias`, `modified_user_id`, `modified_time`, `images`, `urls`, `hits`, `language`, `version`, `publish_up`, `publish_down`) VALUES
(1, 0, 0, 1, 0, '', 'ROOT', 'root', '', '', 1, 0, '0000-00-00 00:00:00', 1, '', '', '', '', 528, '2011-01-01 00:00:01', '', 0, '0000-00-00 00:00:00', '', '', 0, '*', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_template_styles`
--

CREATE TABLE IF NOT EXISTS `h0qwo_template_styles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `home` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_home` (`home`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `h0qwo_template_styles`
--

INSERT INTO `h0qwo_template_styles` (`id`, `template`, `client_id`, `home`, `title`, `params`) VALUES
(4, 'beez3', 0, '0', 'Beez3 - Default', '{"wrapperSmall":"53","wrapperLarge":"72","logo":"images\\/joomla_black.png","sitetitle":"Joomla!","sitedescription":"Open Source Content Management","navposition":"left","templatecolor":"personal","html5":"0"}'),
(5, 'hathor', 1, '0', 'Hathor - Default', '{"showSiteName":"0","colourChoice":"","boldText":"0"}'),
(7, 'protostar', 0, '0', 'protostar - Default', '{"templateColor":"","logoFile":"","googleFont":"1","googleFontName":"Open+Sans","fluidContainer":"0"}'),
(8, 'isis', 1, '1', 'isis - Default', '{"templateColor":"","logoFile":""}'),
(9, 'shaper_helix3', 0, '1', 'shaper_helix3 - Default', '{"sticky_header":"0","favicon":"","boxed_layout":"0","logo_type":"image","logo_position":"logo","logo_image":"","logo_image_2x":"","mobile_logo":"","logo_text":"","logo_slogan":"","body_bg_image":"","body_bg_repeat":"inherit","body_bg_size":"inherit","body_bg_attachment":"inherit","body_bg_position":"0 0","enabled_copyright":"1","copyright_position":"footer1","copyright":"\\u00a9 2016 rlestate.ru All Rights Reserved. Designed By Mixas","show_social_icons":"1","social_position":"top1","facebook":"","twitter":"","googleplus":"","pinterest":"","linkedin":"","dribbble":"","behance":"","youtube":"","flickr":"","skype":"","vk":"","enable_contactinfo":"0","contact_position":"top2","contact_phone":"+228 872 4444","contact_email":"contact@email.com","comingsoon_mode":"0","comingsoon_title":"Coming Soon Title","comingsoon_date":"05-10-2018","comingsoon_content":"Coming soon content","preset":"preset3","preset1_bg":"#ffffff","preset1_text":"#000000","preset1_major":"#26aae1","preset2_bg":"#ffffff","preset2_text":"#000000","preset2_major":"#3d449a","preset3_bg":"#ffffff","preset3_text":"#000000","preset3_major":"#2bb673","preset4_bg":"#ffffff","preset4_text":"#000000","preset4_major":"#eb4947","layoutlist":"default.json","layout":"[{\\"type\\":\\"row\\",\\"layout\\":\\"66\\",\\"settings\\":{\\"bg_color\\":\\"#f02222\\",\\"bg_image\\":\\"images\\/powered_by.png\\",\\"text_color\\":\\"#ffffff\\",\\"xs_hidden\\":0,\\"ms_hidden\\":0,\\"md_hidden\\":0,\\"bg_repeat\\":\\"no-repeat\\",\\"bg_img_size\\":\\"cover\\",\\"bg_position\\":\\"contain\\",\\"custom_class\\":\\"\\",\\"fluidrow\\":0,\\"margin\\":\\"\\",\\"padding\\":\\"\\",\\"hidden_md\\":0,\\"hidden_sm\\":0,\\"hidden_xs\\":0,\\"link_hover_color\\":\\"\\",\\"link_color\\":\\"\\",\\"background_position\\":\\"0 0\\",\\"background_attachment\\":\\"fixed\\",\\"background_size\\":\\"cover\\",\\"background_repeat\\":\\"no-repeat\\",\\"background_image\\":\\"\\",\\"color\\":\\"#999999\\",\\"background_color\\":\\"#f5f5f5\\",\\"name\\":\\"Top Bar\\"},\\"attr\\":[{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-6\\",\\"settings\\":{\\"column_type\\":0,\\"name\\":\\"top1\\",\\"custom_class\\":\\"\\",\\"md_hidden\\":0,\\"ms_hidden\\":0,\\"xs_hidden\\":0,\\"sortableitem\\":\\"[object Object]\\"}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-6\\",\\"settings\\":{\\"custom_class\\":\\"\\",\\"md_hidden\\":0,\\"ms_hidden\\":0,\\"xs_hidden\\":0,\\"name\\":\\"top2\\",\\"sortableitem\\":\\"[object Object]\\",\\"column_type\\":0}}]},{\\"type\\":\\"row\\",\\"layout\\":\\"39\\",\\"settings\\":{\\"custom_class\\":\\"\\",\\"fluidrow\\":0,\\"margin\\":\\"\\",\\"padding\\":\\"\\",\\"hidden_md\\":0,\\"hidden_sm\\":0,\\"hidden_xs\\":0,\\"link_hover_color\\":\\"\\",\\"link_color\\":\\"\\",\\"background_image\\":\\"\\",\\"color\\":\\"\\",\\"background_color\\":\\"\\",\\"name\\":\\"Header\\"},\\"attr\\":[{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"md_hidden\\":0,\\"ms_hidden\\":0,\\"xs_hidden\\":0,\\"custom_class\\":\\"\\",\\"xs_col\\":\\"col-xs-8\\",\\"sm_col\\":\\"\\",\\"hidden_md\\":0,\\"hidden_sm\\":0,\\"hidden_xs\\":0,\\"name\\":\\"logo\\",\\"column_type\\":0}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-9\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"custom_class\\":\\"\\",\\"md_hidden\\":0,\\"ms_hidden\\":0,\\"xs_hidden\\":0,\\"name\\":\\"menu\\",\\"column_type\\":0,\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"sm_col\\":\\"\\",\\"xs_col\\":\\"col-xs-4\\"}}]},{\\"type\\":\\"row\\",\\"layout\\":12,\\"settings\\":{\\"name\\":\\"Page Title\\",\\"background_color\\":\\"\\",\\"color\\":\\"\\",\\"background_image\\":\\"\\",\\"link_color\\":\\"\\",\\"link_hover_color\\":\\"\\",\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"padding\\":\\"\\",\\"margin\\":\\"\\",\\"fluidrow\\":1,\\"custom_class\\":\\"\\"},\\"attr\\":[{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-12\\",\\"settings\\":{\\"column_type\\":0,\\"name\\":\\"title\\",\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"sm_col\\":\\"\\",\\"xs_col\\":\\"\\",\\"custom_class\\":\\"\\"}}]},{\\"type\\":\\"row\\",\\"layout\\":\\"363\\",\\"settings\\":{\\"name\\":\\"Main Body\\",\\"bg_color\\":\\"\\",\\"bg_image\\":\\"\\",\\"text_color\\":\\"\\",\\"link_color\\":\\"\\",\\"link_hover_color\\":\\"\\",\\"xs_hidden\\":0,\\"ms_hidden\\":0,\\"md_hidden\\":0,\\"custom_class\\":\\"\\"},\\"attr\\":[{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"custom_class\\":\\"custom-class\\",\\"md_hidden\\":0,\\"ms_hidden\\":0,\\"xs_hidden\\":0,\\"name\\":\\"left\\",\\"column_type\\":0}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-6\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"xs_hidden\\":0,\\"ms_hidden\\":0,\\"md_hidden\\":0,\\"custom_class\\":\\"\\",\\"name\\":\\"\\",\\"column_type\\":1}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"column_type\\":0,\\"name\\":\\"right\\",\\"xs_hidden\\":0,\\"ms_hidden\\":0,\\"md_hidden\\":0,\\"custom_class\\":\\"class2\\"}}]},{\\"type\\":\\"row\\",\\"layout\\":\\"3333\\",\\"settings\\":{\\"custom_class\\":\\"\\",\\"fluidrow\\":0,\\"margin\\":\\"\\",\\"padding\\":\\"100px 0px\\",\\"hidden_md\\":0,\\"hidden_sm\\":0,\\"hidden_xs\\":0,\\"link_hover_color\\":\\"\\",\\"link_color\\":\\"\\",\\"background_image\\":\\"\\",\\"color\\":\\"\\",\\"background_color\\":\\"#f5f5f5\\",\\"name\\":\\"Bottom\\"},\\"attr\\":[{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3 column-active\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"custom_class\\":\\"\\",\\"xs_col\\":\\"\\",\\"sm_col\\":\\"col-sm-6\\",\\"hidden_md\\":0,\\"hidden_sm\\":0,\\"hidden_xs\\":0,\\"name\\":\\"bottom1\\",\\"column_type\\":0}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3\\",\\"settings\\":{\\"column_type\\":0,\\"name\\":\\"bottom2\\",\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"sm_col\\":\\"col-sm-6\\",\\"xs_col\\":\\"\\",\\"custom_class\\":\\"\\"}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3\\",\\"settings\\":{\\"column_type\\":0,\\"name\\":\\"bottom3\\",\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"sm_col\\":\\"col-sm-6\\",\\"xs_col\\":\\"\\",\\"custom_class\\":\\"\\"}},{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-3\\",\\"settings\\":{\\"column_type\\":0,\\"name\\":\\"bottom4\\",\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"sm_col\\":\\"col-sm-6\\",\\"xs_col\\":\\"\\",\\"custom_class\\":\\"\\"}}]},{\\"type\\":\\"row\\",\\"layout\\":12,\\"settings\\":{\\"name\\":\\"Footer\\",\\"bg_color\\":\\"\\",\\"bg_image\\":\\"\\",\\"text_color\\":\\"\\",\\"link_color\\":\\"\\",\\"link_hover_color\\":\\"\\",\\"xs_hidden\\":0,\\"ms_hidden\\":0,\\"md_hidden\\":0,\\"custom_class\\":\\"\\"},\\"attr\\":[{\\"type\\":\\"sp_col\\",\\"className\\":\\"layout-column col-sm-12\\",\\"settings\\":{\\"sortableitem\\":\\"[object Object]\\",\\"custom_class\\":\\"\\",\\"md_hidden\\":0,\\"ms_hidden\\":0,\\"xs_hidden\\":0,\\"name\\":\\"footer1\\",\\"column_type\\":0,\\"hidden_xs\\":0,\\"hidden_sm\\":0,\\"hidden_md\\":0,\\"sm_col\\":\\"\\",\\"xs_col\\":\\"\\"}}]}]","menu":"mainmenu","menu_type":"mega_offcanvas","dropdown_width":"","menu_animation":"menu-fade","enable_body_font":"1","body_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"300\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h1_font":"1","h1_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"800\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h2_font":"1","h2_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"600\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h3_font":"1","h3_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"regular\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h4_font":"1","h4_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"regular\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h5_font":"1","h5_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"600\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_h6_font":"1","h6_font":"{\\"fontFamily\\":\\"Open Sans\\",\\"fontWeight\\":\\"600\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_navigation_font":"0","navigation_font":"{\\"fontFamily\\":\\"ABeeZee\\",\\"fontWeight\\":\\"regular\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","enable_custom_font":"0","custom_font":"{\\"fontFamily\\":\\"ABeeZee\\",\\"fontWeight\\":\\"regular\\",\\"fontSubset\\":\\"latin\\",\\"fontSize\\":\\"\\"}","custom_font_selectors":"","before_head":"","before_body":"","custom_css":"","custom_js":"","compress_css":"0","compress_js":"0","exclude_js":"","lessoption":"0","show_post_format":"1","commenting_engine":"disabled","disqus_subdomain":"","disqus_devmode":"0","intensedebate_acc":"","fb_appID":"","fb_width":"500","fb_cpp":"10","comments_count":"0","social_share":"1","image_small":"0","image_small_size":"100X100","image_thumbnail":"1","image_thumbnail_size":"200X200","image_medium":"0","image_medium_size":"300X300","image_large":"0","image_large_size":"600X600","blog_list_image":"default"}');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_ucm_base`
--

CREATE TABLE IF NOT EXISTS `h0qwo_ucm_base` (
  `ucm_id` int(10) unsigned NOT NULL,
  `ucm_item_id` int(10) NOT NULL,
  `ucm_type_id` int(11) NOT NULL,
  `ucm_language_id` int(11) NOT NULL,
  PRIMARY KEY (`ucm_id`),
  KEY `idx_ucm_item_id` (`ucm_item_id`),
  KEY `idx_ucm_type_id` (`ucm_type_id`),
  KEY `idx_ucm_language_id` (`ucm_language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_ucm_content`
--

CREATE TABLE IF NOT EXISTS `h0qwo_ucm_content` (
  `core_content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `core_type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'FK to the content types table',
  `core_title` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `core_body` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_state` tinyint(1) NOT NULL DEFAULT '0',
  `core_checked_out_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_checked_out_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `core_access` int(10) unsigned NOT NULL DEFAULT '0',
  `core_params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_featured` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `core_metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded metadata properties.',
  `core_created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `core_created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_modified_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Most recent user that modified',
  `core_modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_publish_up` datetime NOT NULL,
  `core_publish_down` datetime NOT NULL,
  `core_content_item_id` int(10) unsigned DEFAULT NULL COMMENT 'ID from the individual type table',
  `asset_id` int(10) unsigned DEFAULT NULL COMMENT 'FK to the #__assets table.',
  `core_images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_hits` int(10) unsigned NOT NULL DEFAULT '0',
  `core_version` int(10) unsigned NOT NULL DEFAULT '1',
  `core_ordering` int(11) NOT NULL DEFAULT '0',
  `core_metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `core_catid` int(10) unsigned NOT NULL DEFAULT '0',
  `core_xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `core_type_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`core_content_id`),
  KEY `tag_idx` (`core_state`,`core_access`),
  KEY `idx_access` (`core_access`),
  KEY `idx_alias` (`core_alias`(100)),
  KEY `idx_language` (`core_language`),
  KEY `idx_title` (`core_title`(100)),
  KEY `idx_modified_time` (`core_modified_time`),
  KEY `idx_created_time` (`core_created_time`),
  KEY `idx_content_type` (`core_type_alias`(100)),
  KEY `idx_core_modified_user_id` (`core_modified_user_id`),
  KEY `idx_core_checked_out_user_id` (`core_checked_out_user_id`),
  KEY `idx_core_created_user_id` (`core_created_user_id`),
  KEY `idx_core_type_id` (`core_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contains core content data in name spaced fields' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_ucm_history`
--

CREATE TABLE IF NOT EXISTS `h0qwo_ucm_history` (
  `version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ucm_item_id` int(10) unsigned NOT NULL,
  `ucm_type_id` int(10) unsigned NOT NULL,
  `version_note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Optional version name',
  `save_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `character_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Number of characters in this version.',
  `sha1_hash` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SHA1 hash of the version_data column.',
  `version_data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'json-encoded string of version data',
  `keep_forever` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=auto delete; 1=keep',
  PRIMARY KEY (`version_id`),
  KEY `idx_ucm_item_id` (`ucm_type_id`,`ucm_item_id`),
  KEY `idx_save_date` (`save_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=88 ;

--
-- Дамп данных таблицы `h0qwo_ucm_history`
--

INSERT INTO `h0qwo_ucm_history` (`version_id`, `ucm_item_id`, `ucm_type_id`, `version_note`, `save_date`, `editor_user_id`, `character_count`, `sha1_hash`, `version_data`, `keep_forever`) VALUES
(1, 10, 5, '', '2016-04-10 07:26:14', 528, 574, 'f95c4b7aa20ffa7659057ac104720e8311bf2c45', '{"id":10,"asset_id":48,"parent_id":"1","lft":"13","rgt":14,"level":1,"path":null,"extension":"com_content","title":"Rental of property","alias":"rental-of-property","note":"","description":"","published":"1","checked_out":null,"checked_out_time":null,"access":"1","params":"{\\"category_layout\\":\\"\\",\\"image\\":\\"\\",\\"image_alt\\":\\"\\"}","metadesc":"","metakey":"","metadata":"{\\"author\\":\\"\\",\\"robots\\":\\"\\"}","created_user_id":"528","created_time":"2016-04-10 07:26:14","modified_user_id":null,"modified_time":"2016-04-10 07:26:14","hits":"0","language":"*","version":null}', 0),
(3, 11, 5, '', '2016-04-10 07:45:17', 528, 554, 'cdd5bc2e89276167fa406b68a13f7d64b0c189cb', '{"id":11,"asset_id":50,"parent_id":"1","lft":"15","rgt":16,"level":1,"path":null,"extension":"com_content","title":"Mortgage","alias":"mortgage","note":"","description":"","published":"1","checked_out":null,"checked_out_time":null,"access":"1","params":"{\\"category_layout\\":\\"\\",\\"image\\":\\"\\",\\"image_alt\\":\\"\\"}","metadesc":"","metakey":"","metadata":"{\\"author\\":\\"\\",\\"robots\\":\\"\\"}","created_user_id":"528","created_time":"2016-04-10 07:45:17","modified_user_id":null,"modified_time":"2016-04-10 07:45:17","hits":"0","language":"*","version":null}', 0),
(5, 12, 5, '', '2016-04-10 12:05:38', 528, 562, 'cf00fa403e85f0e30edff2c6d4b125bedea96fc2', '{"id":12,"asset_id":52,"parent_id":"1","lft":"17","rgt":18,"level":1,"path":null,"extension":"com_content","title":"The property","alias":"the-property","note":"","description":"","published":"1","checked_out":null,"checked_out_time":null,"access":"1","params":"{\\"category_layout\\":\\"\\",\\"image\\":\\"\\",\\"image_alt\\":\\"\\"}","metadesc":"","metakey":"","metadata":"{\\"author\\":\\"\\",\\"robots\\":\\"\\"}","created_user_id":"528","created_time":"2016-04-10 12:05:38","modified_user_id":null,"modified_time":"2016-04-10 12:05:38","hits":"0","language":"*","version":null}', 0),
(6, 13, 5, '', '2016-04-10 12:06:39', 528, 567, '572fd04ecc7d137ccac6834063f2fcfd7127dd0c', '{"id":13,"asset_id":53,"parent_id":"12","lft":"18","rgt":19,"level":2,"path":null,"extension":"com_content","title":"Country estate","alias":"country-estate","note":"","description":"","published":"1","checked_out":null,"checked_out_time":null,"access":"1","params":"{\\"category_layout\\":\\"\\",\\"image\\":\\"\\",\\"image_alt\\":\\"\\"}","metadesc":"","metakey":"","metadata":"{\\"author\\":\\"\\",\\"robots\\":\\"\\"}","created_user_id":"528","created_time":"2016-04-10 12:06:39","modified_user_id":null,"modified_time":"2016-04-10 12:06:39","hits":"0","language":"*","version":null}', 0),
(55, 14, 5, '', '2016-04-15 07:55:18', 528, 556, '587339d24476d1089bfb5e12a9b1e1b2ac997c72', '{"id":14,"asset_id":71,"parent_id":"1","lft":"21","rgt":22,"level":1,"path":null,"extension":"com_content","title":"Resellers","alias":"resellers","note":"","description":"","published":"1","checked_out":null,"checked_out_time":null,"access":"1","params":"{\\"category_layout\\":\\"\\",\\"image\\":\\"\\",\\"image_alt\\":\\"\\"}","metadesc":"","metakey":"","metadata":"{\\"author\\":\\"\\",\\"robots\\":\\"\\"}","created_user_id":"528","created_time":"2016-04-15 07:55:18","modified_user_id":null,"modified_time":"2016-04-15 07:55:18","hits":"0","language":"*","version":null}', 0),
(65, 2, 5, '', '2016-04-24 12:49:55', 528, 596, '5c701a8bfc395246ff7d3420ed21c46c50b8e754', '{"id":2,"asset_id":"27","parent_id":"1","lft":"1","rgt":"2","level":"1","path":"uncategorised","extension":"com_content","title":"Uncategorised","alias":"uncategorised","note":"","description":"","published":"1","checked_out":"528","checked_out_time":"2016-04-24 12:49:50","access":"1","params":"{\\"category_layout\\":\\"\\",\\"image\\":\\"\\",\\"image_alt\\":\\"\\"}","metadesc":"","metakey":"","metadata":"{\\"author\\":\\"\\",\\"robots\\":\\"\\"}","created_user_id":"528","created_time":"2011-01-01 00:00:01","modified_user_id":"528","modified_time":"2016-04-24 12:49:55","hits":"0","language":"*","version":"1"}', 0),
(78, 27, 1, '', '2016-07-06 13:43:44', 528, 16758, 'c4f7c988a00d01b54f253595c231d74f0900c229', '{"id":27,"asset_id":79,"title":"Expensive Cities of America","alias":"expensive-cities-of-america","introtext":"<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\">The twice yearly report of <span class=\\"apple-converted-space\\"><span style=\\"background: white;\\">\\u00a0<\\/span><\\/span><a href=\\"http:\\/\\/www.eiu.com\\/\\"><span style=\\"color: windowtext; background: white; text-decoration: none;\\">Economist Intelligence Unit<\\/span><\\/a><span style=\\"background: white;\\">''s (EIU) highlights<span class=\\"apple-converted-space\\">\\u00a0<\\/span>most expensive cities of the world. Among 50 cities, 11 US cities are represented. <\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The annual report compares hundreds of individual prices, such as utility bills, household supplies, food, drink, clothing, education, transports, \\u00a0recreational and other costs.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">These costs make cost of living -\\u00a0 the amount of money needed for a certain level of living. Cost of living can be a significant factor in personal wealth accumulation because a smaller salary can go further in a city where it doesn''t cost a lot to get by, while a large salary can seem insufficient in an expensive city.<\\/span><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\"><br \\/> <br \\/> <span style=\\"background: white;\\">Tottaly more\\u00a0 than 50,000 individual prices are collected in each survey round and surveys are updated each June and December.<\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The survey itself is a purpose-built internet tool. It helps human resources and finance managers calculate cost-of-living allowances and build compensation packages for expatriates and business travelers. All cities are compared to a base city of New York, which has an index set at 100. Once the reference point has been established, the Price Index value of every other city in the database is calculated by comparing their cost of living to the cost of living in New York. The survey has more than 30 year of hostory.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">Here you can find most expensive cities of USA.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">11. Miami, Florida<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">49th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">77<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 2\\" src=\\"06-07-2016\\/article2\\/image001.jpg\\" alt=\\"http:\\/\\/media.local10.com\\/weather\\/icons\\/wx_98.jpg\\" width=\\"645\\" height=\\"196\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">10. Honolulu, Hawaii (TIE)<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">46th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 3\\" src=\\"06-07-2016\\/article2\\/image002.jpg\\" alt=\\"http:\\/\\/www.charterflightgroup.com\\/wp-content\\/uploads\\/2012\\/12\\/honolulu.jpeg\\" width=\\"600\\" height=\\"350\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">9. Pittsburgh, Pennsylvania (TIE)<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">47th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 4\\" src=\\"06-07-2016\\/article2\\/image003.jpg\\" alt=\\"https:\\/\\/www.antiagingcostarica.com\\/wp-content\\/uploads\\/2014\\/12\\/Pittsburgh-Pennsylvania-014.jpg\\" width=\\"646\\" height=\\"444\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">8. Seattle, Washington<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">42nd\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:<span class=\\"apple-converted-space\\">\\u00a0<\\/span><strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">80<\\/span><\\/strong><\\/span> <img id=\\"Picture 5\\" src=\\"06-07-2016\\/article2\\/image004.jpg\\" alt=\\"http:\\/\\/aipnw.com\\/wp-content\\/uploads\\/sites\\/3\\/2015\\/06\\/seattle-public-adjusters-ai.jpg\\" width=\\"630\\" height=\\"300\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">7. San Francisco, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">34th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">82<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 6\\" src=\\"06-07-2016\\/article2\\/image005.jpg\\" alt=\\"http:\\/\\/healthpsychology.ucsf.edu\\/sites\\/healthpsychology.ucsf.edu\\/files\\/wysiwyg\\/GGBridge%20at%20dusk.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">6. Houston, Texas<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">31st\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">83<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 7\\" src=\\"06-07-2016\\/article2\\/image006.jpg\\" alt=\\"http:\\/\\/www.lennar.com\\/images\\/com\\/images\\/new-homes\\/18\\/28\\/mhi\\/1210SKYLINEBAYOU.jpg\\" width=\\"646\\" height=\\"291\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">5. Washington, DC<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">26th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">86<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 8\\" src=\\"06-07-2016\\/article2\\/image007.jpg\\" alt=\\"http:\\/\\/i.huffpost.com\\/gen\\/1790723\\/images\\/o-WASHINGTON-DC-AERIAL-facebook.jpg\\" width=\\"646\\" height=\\"323\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">4. Minneapolis, Minnesota<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">24th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">87<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 9\\" src=\\"06-07-2016\\/article2\\/image008.jpg\\" alt=\\"http:\\/\\/www.findyourspot.com\\/sites\\/all\\/images\\/fys\\/city\\/photos\\/Minneapolis-Minnesota-1_photo.jpg\\" width=\\"460\\" height=\\"325\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">3. Chicago, Illinois<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">21st most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">88<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 10\\" src=\\"06-07-2016\\/article2\\/image009.jpg\\" alt=\\"https:\\/\\/www.bleuribbonkitchen.com\\/content\\/images\\/uploaded\\/BRK%20city%20images_CHI.jpg\\" width=\\"646\\" height=\\"305\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">2. Los Angeles, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">8th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">99<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 11\\" src=\\"06-07-2016\\/article2\\/image010.jpg\\" alt=\\"http:\\/\\/lkncambodia.com\\/userfiles\\/image\\/upload\\/Night-Los-Angeles-California-USA.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"text-indent: -36.0pt; line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 54.0pt;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">1.<span style=\\"font: 7.0pt ''Times New Roman'';\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0 <\\/span><\\/span><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">New York, New York<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">7th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">100<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 15\\" src=\\"06-07-2016\\/article2\\/image011.jpg\\" alt=\\"https:\\/\\/www.burgessyachts.com\\/media\\/adminforms\\/locations\\/n\\/e\\/new_york_1.jpg\\" width=\\"646\\" height=\\"429\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">Follow us and find more useful information on \\u00a0real estate issues. <\\/span><\\/strong><\\/p>","fulltext":"","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-06 13:43:44","modified_by":null,"checked_out":null,"checked_out_time":null,"publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/image001.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":1,"ordering":null,"metakey":"","metadesc":"","access":"1","hits":null,"metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0),
(79, 27, 1, '', '2016-07-06 13:44:22', 528, 16819, '0e4cecf2cc966be214848bb549740762bb119d55', '{"id":27,"asset_id":"79","title":"Expensive Cities of America","alias":"expensive-cities-of-america","introtext":"<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\">The twice yearly report of <span class=\\"apple-converted-space\\"><span style=\\"background: white;\\">\\u00a0<\\/span><\\/span><a href=\\"http:\\/\\/www.eiu.com\\/\\"><span style=\\"color: windowtext; background: white; text-decoration: none;\\">Economist Intelligence Unit<\\/span><\\/a><span style=\\"background: white;\\">''s (EIU) highlights<span class=\\"apple-converted-space\\">\\u00a0<\\/span>most expensive cities of the world. Among 50 cities, 11 US cities are represented. <\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The annual report compares hundreds of individual prices, such as utility bills, household supplies, food, drink, clothing, education, transports, \\u00a0recreational and other costs.<\\/span><\\/p>\\r\\n","fulltext":"\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">These costs make cost of living -\\u00a0 the amount of money needed for a certain level of living. Cost of living can be a significant factor in personal wealth accumulation because a smaller salary can go further in a city where it doesn''t cost a lot to get by, while a large salary can seem insufficient in an expensive city.<\\/span><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\"><br \\/> <br \\/> <span style=\\"background: white;\\">Tottaly more\\u00a0 than 50,000 individual prices are collected in each survey round and surveys are updated each June and December.<\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The survey itself is a purpose-built internet tool. It helps human resources and finance managers calculate cost-of-living allowances and build compensation packages for expatriates and business travelers. All cities are compared to a base city of New York, which has an index set at 100. Once the reference point has been established, the Price Index value of every other city in the database is calculated by comparing their cost of living to the cost of living in New York. The survey has more than 30 year of hostory.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">Here you can find most expensive cities of USA.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">11. Miami, Florida<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">49th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">77<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 2\\" src=\\"06-07-2016\\/article2\\/image001.jpg\\" alt=\\"http:\\/\\/media.local10.com\\/weather\\/icons\\/wx_98.jpg\\" width=\\"645\\" height=\\"196\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">10. Honolulu, Hawaii (TIE)<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">46th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 3\\" src=\\"06-07-2016\\/article2\\/image002.jpg\\" alt=\\"http:\\/\\/www.charterflightgroup.com\\/wp-content\\/uploads\\/2012\\/12\\/honolulu.jpeg\\" width=\\"600\\" height=\\"350\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">9. Pittsburgh, Pennsylvania (TIE)<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">47th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 4\\" src=\\"06-07-2016\\/article2\\/image003.jpg\\" alt=\\"https:\\/\\/www.antiagingcostarica.com\\/wp-content\\/uploads\\/2014\\/12\\/Pittsburgh-Pennsylvania-014.jpg\\" width=\\"646\\" height=\\"444\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">8. Seattle, Washington<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">42nd\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:<span class=\\"apple-converted-space\\">\\u00a0<\\/span><strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">80<\\/span><\\/strong><\\/span> <img id=\\"Picture 5\\" src=\\"06-07-2016\\/article2\\/image004.jpg\\" alt=\\"http:\\/\\/aipnw.com\\/wp-content\\/uploads\\/sites\\/3\\/2015\\/06\\/seattle-public-adjusters-ai.jpg\\" width=\\"630\\" height=\\"300\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">7. San Francisco, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">34th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">82<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 6\\" src=\\"06-07-2016\\/article2\\/image005.jpg\\" alt=\\"http:\\/\\/healthpsychology.ucsf.edu\\/sites\\/healthpsychology.ucsf.edu\\/files\\/wysiwyg\\/GGBridge%20at%20dusk.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">6. Houston, Texas<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">31st\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">83<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 7\\" src=\\"06-07-2016\\/article2\\/image006.jpg\\" alt=\\"http:\\/\\/www.lennar.com\\/images\\/com\\/images\\/new-homes\\/18\\/28\\/mhi\\/1210SKYLINEBAYOU.jpg\\" width=\\"646\\" height=\\"291\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">5. Washington, DC<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">26th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">86<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 8\\" src=\\"06-07-2016\\/article2\\/image007.jpg\\" alt=\\"http:\\/\\/i.huffpost.com\\/gen\\/1790723\\/images\\/o-WASHINGTON-DC-AERIAL-facebook.jpg\\" width=\\"646\\" height=\\"323\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">4. Minneapolis, Minnesota<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">24th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">87<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 9\\" src=\\"06-07-2016\\/article2\\/image008.jpg\\" alt=\\"http:\\/\\/www.findyourspot.com\\/sites\\/all\\/images\\/fys\\/city\\/photos\\/Minneapolis-Minnesota-1_photo.jpg\\" width=\\"460\\" height=\\"325\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">3. Chicago, Illinois<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">21st most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">88<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 10\\" src=\\"06-07-2016\\/article2\\/image009.jpg\\" alt=\\"https:\\/\\/www.bleuribbonkitchen.com\\/content\\/images\\/uploaded\\/BRK%20city%20images_CHI.jpg\\" width=\\"646\\" height=\\"305\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">2. Los Angeles, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">8th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">99<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 11\\" src=\\"06-07-2016\\/article2\\/image010.jpg\\" alt=\\"http:\\/\\/lkncambodia.com\\/userfiles\\/image\\/upload\\/Night-Los-Angeles-California-USA.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"text-indent: -36.0pt; line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 54.0pt;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">1.<span style=\\"font: 7.0pt ''Times New Roman'';\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0 <\\/span><\\/span><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">New York, New York<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">7th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">100<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 15\\" src=\\"06-07-2016\\/article2\\/image011.jpg\\" alt=\\"https:\\/\\/www.burgessyachts.com\\/media\\/adminforms\\/locations\\/n\\/e\\/new_york_1.jpg\\" width=\\"646\\" height=\\"429\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">Follow us and find more useful information on \\u00a0real estate issues. <\\/span><\\/strong><\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-06 13:44:22","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-06 13:44:06","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/image001.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":2,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"0","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0);
INSERT INTO `h0qwo_ucm_history` (`version_id`, `ucm_item_id`, `ucm_type_id`, `version_note`, `save_date`, `editor_user_id`, `character_count`, `sha1_hash`, `version_data`, `keep_forever`) VALUES
(80, 27, 1, '', '2016-07-06 13:50:03', 528, 16907, 'c5fc32536cdc3b7cd900f4dedb455257ccf56ffd', '{"id":27,"asset_id":"79","title":"Expensive Cities of America","alias":"expensive-cities-of-america","introtext":"<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\">The twice yearly report of <span class=\\"apple-converted-space\\"><span style=\\"background: white;\\">\\u00a0<\\/span><\\/span><a href=\\"http:\\/\\/www.eiu.com\\/\\"><span style=\\"color: windowtext; background: white; text-decoration: none;\\">Economist Intelligence Unit<\\/span><\\/a><span style=\\"background: white;\\">''s (EIU) highlights<span class=\\"apple-converted-space\\">\\u00a0<\\/span>most expensive cities of the world. Among 50 cities, 11 US cities are represented. <\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The annual report compares hundreds of individual prices, such as utility bills, household supplies, food, drink, clothing, education, transports, \\u00a0recreational and other costs.<\\/span><\\/p>\\r\\n","fulltext":"\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">These costs make cost of living -\\u00a0 the amount of money needed for a certain level of living. Cost of living can be a significant factor in personal wealth accumulation because a smaller salary can go further in a city where it doesn''t cost a lot to get by, while a large salary can seem insufficient in an expensive city.<\\/span><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\"><br \\/> <br \\/> <span style=\\"background: white;\\">Tottaly more\\u00a0 than 50,000 individual prices are collected in each survey round and surveys are updated each June and December.<\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The survey itself is a purpose-built internet tool. It helps human resources and finance managers calculate cost-of-living allowances and build compensation packages for expatriates and business travelers. All cities are compared to a base city of New York, which has an index set at 100. Once the reference point has been established, the Price Index value of every other city in the database is calculated by comparing their cost of living to the cost of living in New York. The survey has more than 30 year of hostory.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">Here you can find most expensive cities of USA.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">11. Miami, Florida<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">49th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">77<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 2\\" src=\\"images\\/06-07-2016\\/article2\\/image001.jpg\\" alt=\\"http:\\/\\/media.local10.com\\/weather\\/icons\\/wx_98.jpg\\" width=\\"645\\" height=\\"196\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">10. Honolulu, Hawaii (TIE)<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">46th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 3\\" src=\\"images\\/06-07-2016\\/article2\\/image002.jpg\\" alt=\\"http:\\/\\/www.charterflightgroup.com\\/wp-content\\/uploads\\/2012\\/12\\/honolulu.jpeg\\" width=\\"600\\" height=\\"350\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">9. Pittsburgh, Pennsylvania (TIE)<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">47th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 4\\" src=\\"images\\/06-07-2016\\/article2\\/image003.jpg\\" alt=\\"https:\\/\\/www.antiagingcostarica.com\\/wp-content\\/uploads\\/2014\\/12\\/Pittsburgh-Pennsylvania-014.jpg\\" width=\\"646\\" height=\\"444\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">8. Seattle, Washington<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">42nd\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:<span class=\\"apple-converted-space\\">\\u00a0<\\/span><strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">80<\\/span><\\/strong><\\/span> <img id=\\"Picture 5\\" src=\\"images\\/06-07-2016\\/article2\\/image004.jpg\\" alt=\\"http:\\/\\/aipnw.com\\/wp-content\\/uploads\\/sites\\/3\\/2015\\/06\\/seattle-public-adjusters-ai.jpg\\" width=\\"630\\" height=\\"300\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">7. San Francisco, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">34th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">82<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 6\\" src=\\"images\\/06-07-2016\\/article2\\/image005.jpg\\" alt=\\"http:\\/\\/healthpsychology.ucsf.edu\\/sites\\/healthpsychology.ucsf.edu\\/files\\/wysiwyg\\/GGBridge%20at%20dusk.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">6. Houston, Texas<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">31st\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">83<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 7\\" src=\\"images\\/06-07-2016\\/article2\\/image006.jpg\\" alt=\\"http:\\/\\/www.lennar.com\\/images\\/com\\/images\\/new-homes\\/18\\/28\\/mhi\\/1210SKYLINEBAYOU.jpg\\" width=\\"646\\" height=\\"291\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">5. Washington, DC<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">26th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">86<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 8\\" src=\\"images\\/06-07-2016\\/article2\\/image007.jpg\\" alt=\\"http:\\/\\/i.huffpost.com\\/gen\\/1790723\\/images\\/o-WASHINGTON-DC-AERIAL-facebook.jpg\\" width=\\"646\\" height=\\"323\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">4. Minneapolis, Minnesota<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">24th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">87<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 9\\" src=\\"images\\/06-07-2016\\/article2\\/image008.jpg\\" alt=\\"http:\\/\\/www.findyourspot.com\\/sites\\/all\\/images\\/fys\\/city\\/photos\\/Minneapolis-Minnesota-1_photo.jpg\\" width=\\"460\\" height=\\"325\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">3. Chicago, Illinois<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">21st most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">88<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 10\\" src=\\"images\\/06-07-2016\\/article2\\/image009.jpg\\" alt=\\"https:\\/\\/www.bleuribbonkitchen.com\\/content\\/images\\/uploaded\\/BRK%20city%20images_CHI.jpg\\" width=\\"646\\" height=\\"305\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">2. Los Angeles, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">8th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">99<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 11\\" src=\\"images\\/06-07-2016\\/article2\\/image010.jpg\\" alt=\\"http:\\/\\/lkncambodia.com\\/userfiles\\/image\\/upload\\/Night-Los-Angeles-California-USA.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"text-indent: -36.0pt; line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 54.0pt;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">1.<span style=\\"font: 7.0pt ''Times New Roman'';\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0 <\\/span><\\/span><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">New York, New York<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">7th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">100<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 15\\" src=\\"images\\/06-07-2016\\/article2\\/image011.jpg\\" alt=\\"https:\\/\\/www.burgessyachts.com\\/media\\/adminforms\\/locations\\/n\\/e\\/new_york_1.jpg\\" width=\\"646\\" height=\\"429\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">Follow us and find more useful information on \\u00a0real estate issues. <\\/span><\\/strong><\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-06 13:50:03","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-06 13:44:22","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/image001.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":3,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"2","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0),
(81, 27, 1, '', '2016-07-06 13:57:47', 528, 16912, 'c32e9747961fea4f9f2e7c9fc7031d83cc906ed9', '{"id":27,"asset_id":"79","title":"Most Expensive Cities of America","alias":"expensive-cities-of-america","introtext":"<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\">The twice yearly report of <span class=\\"apple-converted-space\\"><span style=\\"background: white;\\">\\u00a0<\\/span><\\/span><a href=\\"http:\\/\\/www.eiu.com\\/\\"><span style=\\"color: windowtext; background: white; text-decoration: none;\\">Economist Intelligence Unit<\\/span><\\/a><span style=\\"background: white;\\">''s (EIU) highlights<span class=\\"apple-converted-space\\">\\u00a0<\\/span>most expensive cities of the world. Among 50 cities, 11 US cities are represented. <\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The annual report compares hundreds of individual prices, such as utility bills, household supplies, food, drink, clothing, education, transports, \\u00a0recreational and other costs.<\\/span><\\/p>\\r\\n","fulltext":"\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">These costs make cost of living -\\u00a0 the amount of money needed for a certain level of living. Cost of living can be a significant factor in personal wealth accumulation because a smaller salary can go further in a city where it doesn''t cost a lot to get by, while a large salary can seem insufficient in an expensive city.<\\/span><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif'';\\"><br \\/> <br \\/> <span style=\\"background: white;\\">Tottaly more\\u00a0 than 50,000 individual prices are collected in each survey round and surveys are updated each June and December.<\\/span><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">The survey itself is a purpose-built internet tool. It helps human resources and finance managers calculate cost-of-living allowances and build compensation packages for expatriates and business travelers. All cities are compared to a base city of New York, which has an index set at 100. Once the reference point has been established, the Price Index value of every other city in the database is calculated by comparing their cost of living to the cost of living in New York. The survey has more than 30 year of hostory.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">Here you can find most expensive cities of USA.<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">11. Miami, Florida<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">49th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">77<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 2\\" src=\\"images\\/06-07-2016\\/article2\\/image001.jpg\\" alt=\\"http:\\/\\/media.local10.com\\/weather\\/icons\\/wx_98.jpg\\" width=\\"645\\" height=\\"196\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">10. Honolulu, Hawaii (TIE)<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">46th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 3\\" src=\\"images\\/06-07-2016\\/article2\\/image002.jpg\\" alt=\\"http:\\/\\/www.charterflightgroup.com\\/wp-content\\/uploads\\/2012\\/12\\/honolulu.jpeg\\" width=\\"600\\" height=\\"350\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif'';\\">9. Pittsburgh, Pennsylvania (TIE)<\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\" style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-style: normal;\\">47th most expensive city in the world.<\\/span><\\/em><\\/p>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">79<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 4\\" src=\\"images\\/06-07-2016\\/article2\\/image003.jpg\\" alt=\\"https:\\/\\/www.antiagingcostarica.com\\/wp-content\\/uploads\\/2014\\/12\\/Pittsburgh-Pennsylvania-014.jpg\\" width=\\"646\\" height=\\"444\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">8. Seattle, Washington<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">42nd\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:<span class=\\"apple-converted-space\\">\\u00a0<\\/span><strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">80<\\/span><\\/strong><\\/span> <img id=\\"Picture 5\\" src=\\"images\\/06-07-2016\\/article2\\/image004.jpg\\" alt=\\"http:\\/\\/aipnw.com\\/wp-content\\/uploads\\/sites\\/3\\/2015\\/06\\/seattle-public-adjusters-ai.jpg\\" width=\\"630\\" height=\\"300\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">7. San Francisco, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">34th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">82<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 6\\" src=\\"images\\/06-07-2016\\/article2\\/image005.jpg\\" alt=\\"http:\\/\\/healthpsychology.ucsf.edu\\/sites\\/healthpsychology.ucsf.edu\\/files\\/wysiwyg\\/GGBridge%20at%20dusk.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">6. Houston, Texas<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">31st\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">83<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 7\\" src=\\"images\\/06-07-2016\\/article2\\/image006.jpg\\" alt=\\"http:\\/\\/www.lennar.com\\/images\\/com\\/images\\/new-homes\\/18\\/28\\/mhi\\/1210SKYLINEBAYOU.jpg\\" width=\\"646\\" height=\\"291\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">5. Washington, DC<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">26th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">86<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 8\\" src=\\"images\\/06-07-2016\\/article2\\/image007.jpg\\" alt=\\"http:\\/\\/i.huffpost.com\\/gen\\/1790723\\/images\\/o-WASHINGTON-DC-AERIAL-facebook.jpg\\" width=\\"646\\" height=\\"323\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">4. Minneapolis, Minnesota<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">24th most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">87<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 9\\" src=\\"images\\/06-07-2016\\/article2\\/image008.jpg\\" alt=\\"http:\\/\\/www.findyourspot.com\\/sites\\/all\\/images\\/fys\\/city\\/photos\\/Minneapolis-Minnesota-1_photo.jpg\\" width=\\"460\\" height=\\"325\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">3. Chicago, Illinois<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">21st most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">88<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 10\\" src=\\"images\\/06-07-2016\\/article2\\/image009.jpg\\" alt=\\"https:\\/\\/www.bleuribbonkitchen.com\\/content\\/images\\/uploaded\\/BRK%20city%20images_CHI.jpg\\" width=\\"646\\" height=\\"305\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">2. Los Angeles, California<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">8th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">99<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 11\\" src=\\"images\\/06-07-2016\\/article2\\/image010.jpg\\" alt=\\"http:\\/\\/lkncambodia.com\\/userfiles\\/image\\/upload\\/Night-Los-Angeles-California-USA.jpg\\" width=\\"646\\" height=\\"404\\" border=\\"0\\" \\/><\\/p>\\r\\n<h2 style=\\"text-indent: -36.0pt; line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 54.0pt;\\"><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">1.<span style=\\"font: 7.0pt ''Times New Roman'';\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0 <\\/span><\\/span><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">New York, New York<\\/span><\\/h2>\\r\\n<h2 style=\\"line-height: 15.6pt; background: white; margin: 7.5pt 0cm 7.5pt 0cm;\\"><em><span style=\\"font-size: 14.0pt; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal; font-style: normal;\\">7th\\u00a0most expensive city in the world.<\\/span><\\/em><\\/h2>\\r\\n<p class=\\"MsoNormal\\"><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white;\\">World Cost of Living Index:\\u00a0<strong><span style=\\"font-family: ''Arial'',''sans-serif''; font-weight: normal;\\">100<\\/span><\\/strong><\\/span><\\/p>\\r\\n<p class=\\"MsoNormal\\"><img id=\\"Picture 15\\" src=\\"images\\/06-07-2016\\/article2\\/image011.jpg\\" alt=\\"https:\\/\\/www.burgessyachts.com\\/media\\/adminforms\\/locations\\/n\\/e\\/new_york_1.jpg\\" width=\\"646\\" height=\\"429\\" border=\\"0\\" \\/><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">\\u00a0<\\/span><\\/strong><\\/p>\\r\\n<p class=\\"MsoNormal\\"><strong><span style=\\"font-size: 14.0pt; line-height: 107%; font-family: ''Arial'',''sans-serif''; background: white; font-weight: normal;\\">Follow us and find more useful information on \\u00a0real estate issues. <\\/span><\\/strong><\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-06 13:57:47","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-06 13:50:03","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/image001.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":4,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"4","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0);
INSERT INTO `h0qwo_ucm_history` (`version_id`, `ucm_item_id`, `ucm_type_id`, `version_note`, `save_date`, `editor_user_id`, `character_count`, `sha1_hash`, `version_data`, `keep_forever`) VALUES
(84, 27, 1, '', '2016-07-14 07:52:48', 528, 22907, '52983fc496d9d5c9109bb9f6b4d38289036ad593', '{"id":27,"asset_id":"79","title":"\\u041a\\u043e\\u0433\\u0434\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0430 \\u043f\\u043e\\u0447\\u0442\\u0438 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u0430, \\u0435\\u0441\\u0442\\u044c \\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435?","alias":"expensive-cities-of-america","introtext":"<p style=\\"text-align: justify;\\"><strong>\\u0418\\u043d\\u0442\\u0435\\u0440\\u0432\\u044c\\u044e \\u043d\\u0430 \\u0442\\u0435\\u043c\\u0443 \\u00ab\\u0420\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438\\u00bb<\\/strong>.<\\/p>\\r\\n","fulltext":"\\r\\n<p style=\\"text-align: justify;\\"><strong>\\u0412\\u043e\\u043f\\u0440\\u043e\\u0441: <i>\\u00ab<\\/i><\\/strong><i>\\u0421 \\u043f\\u0440\\u0438\\u0431\\u043b\\u0438\\u0436\\u0435\\u043d\\u0438\\u0435\\u043c \\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438 \\u043a \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0443\\u043c\\u0435\\u043d\\u044c\\u0448\\u0430\\u044e\\u0442\\u0441\\u044f, \\u043d\\u043e \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u043d\\u0435 \\u0438\\u0441\\u0447\\u0435\\u0437\\u0430\\u044e\\u0442 \\u0441\\u043e\\u0432\\u0441\\u0435\\u043c. \\u0421 \\u043a\\u0430\\u043a\\u0438\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u0442\\u044c\\u0441\\u044f \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a, \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0430\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 (\\u0432\\u043e\\u0437\\u0432\\u0435\\u0434\\u0435\\u043d\\u0438\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u044d\\u0442\\u0430\\u0436\\u0435\\u0439, \\u0432\\u043d\\u0443\\u0442\\u0440\\u0435\\u043d\\u043d\\u044f\\u044f \\u043e\\u0442\\u0434\\u0435\\u043b\\u043a\\u0430 \\u0438 \\u0442.\\u043f.)\\u00bb<span id=\\"more-407\\"><\\/span><\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e\\u0442\\u0432\\u0435\\u0442:<\\/b> \\u041f\\u043e\\u043b\\u0430\\u0433\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u0436\\u0438\\u043b\\u044c\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u043e\\u043c \\u043c\\u043e\\u0436\\u043d\\u043e \\u043d\\u0430\\u0437\\u0432\\u0430\\u0442\\u044c \\u0441\\u0430\\u043c\\u044b\\u043c \\u043e\\u043f\\u0430\\u0441\\u043d\\u044b\\u043c. \\u041d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u043f\\u043e \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0436\\u0438\\u043b\\u043e\\u0433\\u043e \\u0434\\u043e\\u043c\\u0430 \\u043e\\u0440\\u0433\\u0430\\u043d\\u044b \\u0432\\u043b\\u0430\\u0441\\u0442\\u0438 \\u0432\\u044b\\u0434\\u0430\\u044e\\u0442 \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u0435 \\u043d\\u0430 \\u0432\\u0432\\u043e\\u0434 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430 \\u0432 \\u044d\\u043a\\u0441\\u043f\\u043b\\u0443\\u0430\\u0442\\u0430\\u0446\\u0438\\u044e. \\u041e\\u0442\\u0441\\u0443\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435 \\u044d\\u0442\\u043e\\u0433\\u043e \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430 \\u044f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u043f\\u0440\\u0435\\u043f\\u044f\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435\\u043c \\u0434\\u043b\\u044f \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u043d\\u0438\\u044f \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u043c\\u0435\\u0449\\u0435\\u043d\\u0438\\u0439 \\u0432 \\u043d\\u0451\\u043c \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438. \\u0414\\u0440\\u0443\\u0433\\u0438\\u043c\\u0438 \\u0441\\u043b\\u043e\\u0432\\u0430\\u043c\\u0438, \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u043e\\u0444\\u043e\\u0440\\u043c\\u0438\\u0442\\u044c \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u0432 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0431\\u0443\\u0434\\u0435\\u0442 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c\\u0430\\u0442\\u0438\\u0447\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u00a0<\\/b><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.: <\\/b><i>\\u00ab\\u0421\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u043b\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f? \\u0418\\u043b\\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f (\\u0432 \\u0441\\u0438\\u043b\\u0443 214 \\u0437\\u0430\\u043a\\u043e\\u043d\\u0430 \\u0438 \\u0434\\u0440. \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0430\\u043a\\u0442\\u043e\\u0432) \\u0442\\u0430\\u043a\\u0438\\u0435 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0438 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u044b?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0435 \\u0440\\u0438\\u0441\\u043a \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u0435\\u0442\\u0441\\u044f \\u0432\\u0441\\u0435\\u0433\\u0434\\u0430. \\u0422\\u0430\\u043a\\u0438\\u0435 \\u043d\\u0435\\u0431\\u043b\\u0430\\u0433\\u043e\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u0441\\u0442\\u0432\\u0438\\u044f \\u0437\\u0430\\u0432\\u0438\\u0441\\u044f\\u0442 \\u043e\\u0442 \\u0441\\u043e\\u0441\\u0442\\u043e\\u044f\\u043d\\u0438\\u044f \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0438 \\u0432 \\u0446\\u0435\\u043b\\u043e\\u043c \\u0438\\u043b\\u0438 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0438 \\u2013 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430 \\u0432 \\u0447\\u0430\\u0441\\u0442\\u043d\\u043e\\u0441\\u0442\\u0438. \\u042d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0443 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e \\u0437\\u0430\\u0433\\u043d\\u0430\\u0442\\u044c \\u0432 \\u0442\\u0438\\u0441\\u043a\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0440\\u0435\\u0433\\u0443\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f. \\u00a0\\u0424\\u0435\\u0434\\u0435\\u0440\\u0430\\u043b\\u044c\\u043d\\u044b\\u0439 \\u0437\\u0430\\u043a\\u043e\\u043d \\u043e\\u0442 30.12.2004 \\u2116214-\\u0424\\u0417 \\u00ab\\u041e\\u0431 \\u0443\\u0447\\u0430\\u0441\\u0442\\u0438\\u0438 \\u0432 \\u0434\\u043e\\u043b\\u0435\\u0432\\u043e\\u043c \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u043c\\u043d\\u043e\\u0433\\u043e\\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u043d\\u044b\\u0445 \\u0434\\u043e\\u043c\\u043e\\u0432 \\u0438 \\u0438\\u043d\\u044b\\u0445 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u043e\\u0432 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438\\u2026\\u00bb \\u0432\\u0432\\u0451\\u043b \\u043f\\u0440\\u0430\\u0432\\u0438\\u043b\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0435 \\u0443\\u0441\\u0442\\u0430\\u043d\\u043e\\u0432\\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0445\\u0435\\u043c\\u044b \\u043f\\u0440\\u0438\\u0432\\u043b\\u0435\\u0447\\u0435\\u043d\\u0438\\u044f \\u0434\\u0435\\u043d\\u0435\\u0436\\u043d\\u044b\\u0445 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432 \\u043d\\u0430 \\u0441\\u0442\\u0430\\u0434\\u0438\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043f\\u0440\\u043e\\u043f\\u0438\\u0441\\u0430\\u043b\\u0438 \\u043f\\u043e\\u0440\\u044f\\u0434\\u043e\\u043a \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0439 \\u0438 \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0434\\u043b\\u044f \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430, \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0438\\u043b\\u0438 \\u0434\\u0440\\u0443\\u0433\\u0438\\u0435 \\u0432\\u043e\\u043f\\u0440\\u043e\\u0441\\u044b. \\u0422\\u0435\\u043c \\u043d\\u0435 \\u043c\\u0435\\u043d\\u0435\\u0435, \\u0437\\u0430\\u043a\\u043e\\u043d \\u043d\\u0435 \\u0441\\u043f\\u0430\\u0441\\u0430\\u0435\\u0442 \\u043e\\u0442 \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0445 \\u0437\\u0430\\u0442\\u0440\\u0443\\u0434\\u043d\\u0435\\u043d\\u0438\\u0439 \\u0438 \\u0431\\u0430\\u043d\\u043a\\u0440\\u043e\\u0442\\u0441\\u0442\\u0432\\u0430.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<i>\\u00ab\\u041a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0435\\u0441\\u0442\\u044c \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0443\\u0436\\u0435 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435? \\u0410 \\u043a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u0432 \\u0442\\u043e\\u043c \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0434\\u043e\\u043c \\u0443\\u0436\\u0435 \\u0441\\u0434\\u0430\\u043d?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u0412 \\u043e\\u0431\\u043e\\u0438\\u0445 \\u0441\\u043b\\u0443\\u0447\\u0430\\u044f\\u0445 \\u043e\\u0441\\u043d\\u043e\\u0432\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u0432\\u044f\\u0437\\u0430\\u043d\\u044b \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c\\u0438 \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438. \\u0422\\u043e\\u043b\\u044c\\u043a\\u043e \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435\\u00a0 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0438 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0431\\u043e\\u043b\\u044c\\u0448\\u0435. \\u041d\\u0430\\u0447\\u0438\\u043d\\u0430\\u044f \\u043e\\u0442 \\u043f\\u0440\\u043e\\u043c\\u0435\\u0434\\u043b\\u0435\\u043d\\u0438\\u044f \\u0441 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435\\u043c \\u043f\\u0440\\u0430\\u0432\\u0430 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u0437\\u0430\\u043a\\u0430\\u043d\\u0447\\u0438\\u0432\\u0430\\u044f \\u0441\\u043d\\u043e\\u0441\\u043e\\u043c \\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u043a\\u0430\\u043a \\u0441\\u0430\\u043c\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0439 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041a\\u0430\\u043a \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a \\u043c\\u043e\\u0436\\u0435\\u0442 \\u043d\\u0438\\u0432\\u0438\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u043e\\u043c \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043d\\u0430 \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438 \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u0441\\u043b\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438? \\u041c\\u043e\\u0436\\u0435\\u0442 \\u043b\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435 \\u0444\\u0438\\u043d\\u0430\\u043d\\u0441\\u043e\\u0432\\u044b\\u0445 \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432 \\u0438\\u043b\\u0438 \\u043f\\u043e\\u043a\\u0430 \\u044d\\u0442\\u043e \\u043d\\u0435 \\u043e\\u0447\\u0435\\u043d\\u044c \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u044e\\u0449\\u0438\\u0439 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u0423 \\u043a\\u043e\\u0433\\u043e \\u0432 \\u0436\\u0438\\u0437\\u043d\\u0438 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u0430\\u043b \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u043e\\u0439 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0439, \\u0442\\u043e\\u0442 \\u0437\\u043d\\u0430\\u0435\\u0442, \\u043a\\u0430\\u043a \\u0432 \\u0420\\u043e\\u0441\\u0441\\u0438\\u0438 \\u043c\\u043e\\u0436\\u043d\\u043e \\u043f\\u043e\\u043b\\u0443\\u0447\\u0438\\u0442\\u044c \\u0434\\u0435\\u043d\\u044c\\u0433\\u0438 \\u043e\\u0442 \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u044b\\u0445 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0439! \\u041d\\u0430 \\u043d\\u0430\\u0448 \\u0432\\u0437\\u0433\\u043b\\u044f\\u0434 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c\\u044b \\u0434\\u043e\\u0431\\u0440\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432, \\u0447\\u0442\\u043e \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0443\\u044e\\u0442 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f, \\u043d\\u0435 \\u0441\\u043d\\u0438\\u0437\\u0438\\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f. \\u0421 1 \\u044f\\u043d\\u0432\\u0430\\u0440\\u044f 2014 \\u0433\\u043e\\u0434\\u0430 \\u043f\\u043e\\u044f\\u0432\\u0438\\u0442\\u0441\\u044f \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c \\u0432\\u0437\\u0430\\u0438\\u043c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u043e\\u0432 \\u2013 \\u0432\\u043e\\u0442 \\u044d\\u0442\\u043e \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043d\\u043e \\u0441 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u043f\\u043e\\u0432\\u044b\\u0448\\u0435\\u043d\\u0438\\u044f \\u0437\\u0430\\u0449\\u0438\\u0449\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041d\\u0430 \\u0447\\u0442\\u043e \\u0441\\u0442\\u043e\\u0438\\u0442 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c \\u0432\\u043d\\u0438\\u043c\\u0430\\u043d\\u0438\\u0435, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0438\\u0437\\u0431\\u0435\\u0436\\u0430\\u0442\\u044c \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0445 \\u0441\\u044e\\u0440\\u043f\\u0440\\u0438\\u0437\\u043e\\u0432?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430\\u0448 \\u0441\\u043e\\u0432\\u0435\\u0442\\u00a0 \\u2014 \\u043f\\u0440\\u0438\\u0433\\u043b\\u0430\\u0441\\u0438\\u0442\\u0435 \\u043d\\u0430 \\u043e\\u0437\\u043d\\u0430\\u043a\\u043e\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435 \\u0441 \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430\\u043c\\u0438 \\u0438 \\u0441\\u0434\\u0435\\u043b\\u043a\\u0443 \\u043f\\u043e \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0435 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043d\\u0443 \\u0438\\u043b\\u0438 \\u0440\\u0438\\u044d\\u043b\\u0442\\u043e\\u0440\\u0430. \\u041d\\u0430\\u0439\\u0442\\u0438 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e, \\u043d\\u043e \\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0427\\u0442\\u043e \\u0434\\u0435\\u043b\\u0430\\u0442\\u044c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443, \\u0435\\u0441\\u043b\\u0438 \\u0441\\u043e\\u0431\\u044b\\u0442\\u0438\\u044f \\u0440\\u0430\\u0437\\u0432\\u0438\\u0432\\u0430\\u044e\\u0442\\u0441\\u044f \\u043f\\u043e \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u043e\\u043c\\u0443 \\u0441\\u0446\\u0435\\u043d\\u0430\\u0440\\u0438\\u044e \\u0438 \\u043e\\u043d \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u043b\\u0441\\u044f \\u0441 \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u041c\\u044b \\u0440\\u0435\\u043a\\u043e\\u043c\\u0435\\u043d\\u0434\\u0443\\u0435\\u043c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u043b\\u0435\\u043d\\u0438\\u044f \\u043d\\u0435\\u0433\\u0430\\u0442\\u0438\\u0432\\u043d\\u043e\\u0439 \\u0441\\u0438\\u0442\\u0443\\u0430\\u0446\\u0438\\u0438 \\u043f\\u0440\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u0436\\u0438\\u043b\\u044c\\u044f \\u043f\\u0440\\u043e\\u043a\\u043e\\u043d\\u0441\\u0443\\u043b\\u044c\\u0442\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c\\u0441\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0441\\u0442\\u043e\\u043c, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u0440\\u044b\\u043d\\u043a\\u0435 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0421\\u0442\\u043e\\u0438\\u0442 \\u043b\\u0438 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c\\u0441\\u044f \\u0432 \\u0441\\u0443\\u0434? \\u0418 \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043b\\u0438 \\u0440\\u0435\\u0448\\u0438\\u0442\\u044c \\u0434\\u0435\\u043b\\u043e \\u0432 \\u0441\\u0432\\u043e\\u044e \\u043f\\u043e\\u043b\\u044c\\u0437\\u0443 \\u0432 \\u0441\\u0443\\u0434\\u0435?\\u00bb<\\/i><\\/p>\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u0421\\u0443\\u0434 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u044d\\u0444\\u0444\\u0435\\u043a\\u0442\\u0438\\u0432\\u043d\\u044b\\u043c, \\u0430 \\u0438\\u043d\\u043e\\u0433\\u0434\\u0430 \\u2014 \\u0435\\u0434\\u0438\\u043d\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u043c \\u0441\\u043f\\u043e\\u0441\\u043e\\u0431\\u043e\\u043c \\u0437\\u0430\\u0449\\u0438\\u0442\\u044b \\u043d\\u0430\\u0440\\u0443\\u0448\\u0435\\u043d\\u043d\\u044b\\u0445 \\u043f\\u0440\\u0430\\u0432 \\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0445 \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043e\\u0432 \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u043e\\u0432. \\u041d\\u0435\\u0441\\u043c\\u043e\\u0442\\u0440\\u044f \\u043d\\u0430 \\u0442\\u043e, \\u0447\\u0442\\u043e \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d\\u0435 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f \\u0441 \\u043d\\u0435\\u0434\\u043e\\u0432\\u0435\\u0440\\u0438\\u0435\\u043c \\u043e\\u0442\\u043d\\u043e\\u0441\\u044f\\u0442\\u0441\\u044f \\u043a \\u0432\\u043b\\u0430\\u0441\\u0442\\u043d\\u044b\\u043c \\u0438\\u043d\\u0441\\u0442\\u0438\\u0442\\u0443\\u0442\\u0430\\u043c, \\u043c\\u044b \\u0438\\u0437 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0438 \\u0437\\u043d\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0441\\u0443\\u0434\\u044b \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043c\\u043e\\u0433\\u0443\\u0442 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c. \\u0422\\u0430\\u043a, \\u043d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u0441\\u0443\\u0434\\u044b \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u0432\\u0430\\u043b\\u0438 \\u043f\\u0440\\u0430\\u0432\\u043e \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0443 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d \\u043d\\u0430 \\u0440\\u0443\\u043a\\u0430\\u0445 \\u0438\\u043c\\u0435\\u043b\\u0438\\u0441\\u044c \\u043f\\u0440\\u0435\\u0434\\u0432\\u0430\\u0440\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0434\\u043e\\u0433\\u043e\\u0432\\u043e\\u0440\\u0430 \\u043a\\u0443\\u043f\\u043b\\u0438-\\u043f\\u0440\\u043e\\u0434\\u0430\\u0436\\u0438.\\u00a0 \\u0421 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u043e\\u0439 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u044d\\u0442\\u043e \\u0431\\u044b\\u043b\\u0438 \\u043d\\u0435\\u043e\\u0434\\u043d\\u043e\\u0437\\u043d\\u0430\\u0447\\u043d\\u044b\\u0435 \\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u044f, \\u043d\\u043e \\u043b\\u044e\\u0434\\u044f\\u043c \\u043e\\u043d\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0433\\u0430\\u043b\\u0438 \\u0432\\u0447\\u0435\\u0440\\u0430. \\u041f\\u043e\\u043c\\u043e\\u0433\\u0430\\u044e\\u0442 \\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f.<\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-14 07:52:48","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-14 07:51:31","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/image001.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"info_block_show_title\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":6,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"14","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0);
INSERT INTO `h0qwo_ucm_history` (`version_id`, `ucm_item_id`, `ucm_type_id`, `version_note`, `save_date`, `editor_user_id`, `character_count`, `sha1_hash`, `version_data`, `keep_forever`) VALUES
(85, 27, 1, '', '2016-07-14 07:52:58', 528, 22938, '2a8b9676c4bb09a009a06eab782b6baf8b33233b', '{"id":27,"asset_id":"79","title":"\\u041a\\u043e\\u0433\\u0434\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0430 \\u043f\\u043e\\u0447\\u0442\\u0438 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u0430, \\u0435\\u0441\\u0442\\u044c \\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435?","alias":"kogda-novostrojka-pochti-postroena-est-li-risk-pri-pokupke","introtext":"<p style=\\"text-align: justify;\\"><strong>\\u0418\\u043d\\u0442\\u0435\\u0440\\u0432\\u044c\\u044e \\u043d\\u0430 \\u0442\\u0435\\u043c\\u0443 \\u00ab\\u0420\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438\\u00bb<\\/strong>.<\\/p>\\r\\n","fulltext":"\\r\\n<p style=\\"text-align: justify;\\"><strong>\\u0412\\u043e\\u043f\\u0440\\u043e\\u0441: <i>\\u00ab<\\/i><\\/strong><i>\\u0421 \\u043f\\u0440\\u0438\\u0431\\u043b\\u0438\\u0436\\u0435\\u043d\\u0438\\u0435\\u043c \\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438 \\u043a \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0443\\u043c\\u0435\\u043d\\u044c\\u0448\\u0430\\u044e\\u0442\\u0441\\u044f, \\u043d\\u043e \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u043d\\u0435 \\u0438\\u0441\\u0447\\u0435\\u0437\\u0430\\u044e\\u0442 \\u0441\\u043e\\u0432\\u0441\\u0435\\u043c. \\u0421 \\u043a\\u0430\\u043a\\u0438\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u0442\\u044c\\u0441\\u044f \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a, \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0430\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 (\\u0432\\u043e\\u0437\\u0432\\u0435\\u0434\\u0435\\u043d\\u0438\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u044d\\u0442\\u0430\\u0436\\u0435\\u0439, \\u0432\\u043d\\u0443\\u0442\\u0440\\u0435\\u043d\\u043d\\u044f\\u044f \\u043e\\u0442\\u0434\\u0435\\u043b\\u043a\\u0430 \\u0438 \\u0442.\\u043f.)\\u00bb<span id=\\"more-407\\"><\\/span><\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e\\u0442\\u0432\\u0435\\u0442:<\\/b> \\u041f\\u043e\\u043b\\u0430\\u0433\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u0436\\u0438\\u043b\\u044c\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u043e\\u043c \\u043c\\u043e\\u0436\\u043d\\u043e \\u043d\\u0430\\u0437\\u0432\\u0430\\u0442\\u044c \\u0441\\u0430\\u043c\\u044b\\u043c \\u043e\\u043f\\u0430\\u0441\\u043d\\u044b\\u043c. \\u041d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u043f\\u043e \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0436\\u0438\\u043b\\u043e\\u0433\\u043e \\u0434\\u043e\\u043c\\u0430 \\u043e\\u0440\\u0433\\u0430\\u043d\\u044b \\u0432\\u043b\\u0430\\u0441\\u0442\\u0438 \\u0432\\u044b\\u0434\\u0430\\u044e\\u0442 \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u0435 \\u043d\\u0430 \\u0432\\u0432\\u043e\\u0434 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430 \\u0432 \\u044d\\u043a\\u0441\\u043f\\u043b\\u0443\\u0430\\u0442\\u0430\\u0446\\u0438\\u044e. \\u041e\\u0442\\u0441\\u0443\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435 \\u044d\\u0442\\u043e\\u0433\\u043e \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430 \\u044f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u043f\\u0440\\u0435\\u043f\\u044f\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435\\u043c \\u0434\\u043b\\u044f \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u043d\\u0438\\u044f \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u043c\\u0435\\u0449\\u0435\\u043d\\u0438\\u0439 \\u0432 \\u043d\\u0451\\u043c \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438. \\u0414\\u0440\\u0443\\u0433\\u0438\\u043c\\u0438 \\u0441\\u043b\\u043e\\u0432\\u0430\\u043c\\u0438, \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u043e\\u0444\\u043e\\u0440\\u043c\\u0438\\u0442\\u044c \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u0432 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0431\\u0443\\u0434\\u0435\\u0442 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c\\u0430\\u0442\\u0438\\u0447\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u00a0<\\/b><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.: <\\/b><i>\\u00ab\\u0421\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u043b\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f? \\u0418\\u043b\\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f (\\u0432 \\u0441\\u0438\\u043b\\u0443 214 \\u0437\\u0430\\u043a\\u043e\\u043d\\u0430 \\u0438 \\u0434\\u0440. \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0430\\u043a\\u0442\\u043e\\u0432) \\u0442\\u0430\\u043a\\u0438\\u0435 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0438 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u044b?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0435 \\u0440\\u0438\\u0441\\u043a \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u0435\\u0442\\u0441\\u044f \\u0432\\u0441\\u0435\\u0433\\u0434\\u0430. \\u0422\\u0430\\u043a\\u0438\\u0435 \\u043d\\u0435\\u0431\\u043b\\u0430\\u0433\\u043e\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u0441\\u0442\\u0432\\u0438\\u044f \\u0437\\u0430\\u0432\\u0438\\u0441\\u044f\\u0442 \\u043e\\u0442 \\u0441\\u043e\\u0441\\u0442\\u043e\\u044f\\u043d\\u0438\\u044f \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0438 \\u0432 \\u0446\\u0435\\u043b\\u043e\\u043c \\u0438\\u043b\\u0438 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0438 \\u2013 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430 \\u0432 \\u0447\\u0430\\u0441\\u0442\\u043d\\u043e\\u0441\\u0442\\u0438. \\u042d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0443 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e \\u0437\\u0430\\u0433\\u043d\\u0430\\u0442\\u044c \\u0432 \\u0442\\u0438\\u0441\\u043a\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0440\\u0435\\u0433\\u0443\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f. \\u00a0\\u0424\\u0435\\u0434\\u0435\\u0440\\u0430\\u043b\\u044c\\u043d\\u044b\\u0439 \\u0437\\u0430\\u043a\\u043e\\u043d \\u043e\\u0442 30.12.2004 \\u2116214-\\u0424\\u0417 \\u00ab\\u041e\\u0431 \\u0443\\u0447\\u0430\\u0441\\u0442\\u0438\\u0438 \\u0432 \\u0434\\u043e\\u043b\\u0435\\u0432\\u043e\\u043c \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u043c\\u043d\\u043e\\u0433\\u043e\\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u043d\\u044b\\u0445 \\u0434\\u043e\\u043c\\u043e\\u0432 \\u0438 \\u0438\\u043d\\u044b\\u0445 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u043e\\u0432 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438\\u2026\\u00bb \\u0432\\u0432\\u0451\\u043b \\u043f\\u0440\\u0430\\u0432\\u0438\\u043b\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0435 \\u0443\\u0441\\u0442\\u0430\\u043d\\u043e\\u0432\\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0445\\u0435\\u043c\\u044b \\u043f\\u0440\\u0438\\u0432\\u043b\\u0435\\u0447\\u0435\\u043d\\u0438\\u044f \\u0434\\u0435\\u043d\\u0435\\u0436\\u043d\\u044b\\u0445 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432 \\u043d\\u0430 \\u0441\\u0442\\u0430\\u0434\\u0438\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043f\\u0440\\u043e\\u043f\\u0438\\u0441\\u0430\\u043b\\u0438 \\u043f\\u043e\\u0440\\u044f\\u0434\\u043e\\u043a \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0439 \\u0438 \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0434\\u043b\\u044f \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430, \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0438\\u043b\\u0438 \\u0434\\u0440\\u0443\\u0433\\u0438\\u0435 \\u0432\\u043e\\u043f\\u0440\\u043e\\u0441\\u044b. \\u0422\\u0435\\u043c \\u043d\\u0435 \\u043c\\u0435\\u043d\\u0435\\u0435, \\u0437\\u0430\\u043a\\u043e\\u043d \\u043d\\u0435 \\u0441\\u043f\\u0430\\u0441\\u0430\\u0435\\u0442 \\u043e\\u0442 \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0445 \\u0437\\u0430\\u0442\\u0440\\u0443\\u0434\\u043d\\u0435\\u043d\\u0438\\u0439 \\u0438 \\u0431\\u0430\\u043d\\u043a\\u0440\\u043e\\u0442\\u0441\\u0442\\u0432\\u0430.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<i>\\u00ab\\u041a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0435\\u0441\\u0442\\u044c \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0443\\u0436\\u0435 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435? \\u0410 \\u043a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u0432 \\u0442\\u043e\\u043c \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0434\\u043e\\u043c \\u0443\\u0436\\u0435 \\u0441\\u0434\\u0430\\u043d?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u0412 \\u043e\\u0431\\u043e\\u0438\\u0445 \\u0441\\u043b\\u0443\\u0447\\u0430\\u044f\\u0445 \\u043e\\u0441\\u043d\\u043e\\u0432\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u0432\\u044f\\u0437\\u0430\\u043d\\u044b \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c\\u0438 \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438. \\u0422\\u043e\\u043b\\u044c\\u043a\\u043e \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435\\u00a0 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0438 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0431\\u043e\\u043b\\u044c\\u0448\\u0435. \\u041d\\u0430\\u0447\\u0438\\u043d\\u0430\\u044f \\u043e\\u0442 \\u043f\\u0440\\u043e\\u043c\\u0435\\u0434\\u043b\\u0435\\u043d\\u0438\\u044f \\u0441 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435\\u043c \\u043f\\u0440\\u0430\\u0432\\u0430 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u0437\\u0430\\u043a\\u0430\\u043d\\u0447\\u0438\\u0432\\u0430\\u044f \\u0441\\u043d\\u043e\\u0441\\u043e\\u043c \\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u043a\\u0430\\u043a \\u0441\\u0430\\u043c\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0439 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041a\\u0430\\u043a \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a \\u043c\\u043e\\u0436\\u0435\\u0442 \\u043d\\u0438\\u0432\\u0438\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u043e\\u043c \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043d\\u0430 \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438 \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u0441\\u043b\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438? \\u041c\\u043e\\u0436\\u0435\\u0442 \\u043b\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435 \\u0444\\u0438\\u043d\\u0430\\u043d\\u0441\\u043e\\u0432\\u044b\\u0445 \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432 \\u0438\\u043b\\u0438 \\u043f\\u043e\\u043a\\u0430 \\u044d\\u0442\\u043e \\u043d\\u0435 \\u043e\\u0447\\u0435\\u043d\\u044c \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u044e\\u0449\\u0438\\u0439 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u0423 \\u043a\\u043e\\u0433\\u043e \\u0432 \\u0436\\u0438\\u0437\\u043d\\u0438 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u0430\\u043b \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u043e\\u0439 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0439, \\u0442\\u043e\\u0442 \\u0437\\u043d\\u0430\\u0435\\u0442, \\u043a\\u0430\\u043a \\u0432 \\u0420\\u043e\\u0441\\u0441\\u0438\\u0438 \\u043c\\u043e\\u0436\\u043d\\u043e \\u043f\\u043e\\u043b\\u0443\\u0447\\u0438\\u0442\\u044c \\u0434\\u0435\\u043d\\u044c\\u0433\\u0438 \\u043e\\u0442 \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u044b\\u0445 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0439! \\u041d\\u0430 \\u043d\\u0430\\u0448 \\u0432\\u0437\\u0433\\u043b\\u044f\\u0434 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c\\u044b \\u0434\\u043e\\u0431\\u0440\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432, \\u0447\\u0442\\u043e \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0443\\u044e\\u0442 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f, \\u043d\\u0435 \\u0441\\u043d\\u0438\\u0437\\u0438\\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f. \\u0421 1 \\u044f\\u043d\\u0432\\u0430\\u0440\\u044f 2014 \\u0433\\u043e\\u0434\\u0430 \\u043f\\u043e\\u044f\\u0432\\u0438\\u0442\\u0441\\u044f \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c \\u0432\\u0437\\u0430\\u0438\\u043c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u043e\\u0432 \\u2013 \\u0432\\u043e\\u0442 \\u044d\\u0442\\u043e \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043d\\u043e \\u0441 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u043f\\u043e\\u0432\\u044b\\u0448\\u0435\\u043d\\u0438\\u044f \\u0437\\u0430\\u0449\\u0438\\u0449\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041d\\u0430 \\u0447\\u0442\\u043e \\u0441\\u0442\\u043e\\u0438\\u0442 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c \\u0432\\u043d\\u0438\\u043c\\u0430\\u043d\\u0438\\u0435, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0438\\u0437\\u0431\\u0435\\u0436\\u0430\\u0442\\u044c \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0445 \\u0441\\u044e\\u0440\\u043f\\u0440\\u0438\\u0437\\u043e\\u0432?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430\\u0448 \\u0441\\u043e\\u0432\\u0435\\u0442\\u00a0 \\u2014 \\u043f\\u0440\\u0438\\u0433\\u043b\\u0430\\u0441\\u0438\\u0442\\u0435 \\u043d\\u0430 \\u043e\\u0437\\u043d\\u0430\\u043a\\u043e\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435 \\u0441 \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430\\u043c\\u0438 \\u0438 \\u0441\\u0434\\u0435\\u043b\\u043a\\u0443 \\u043f\\u043e \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0435 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043d\\u0443 \\u0438\\u043b\\u0438 \\u0440\\u0438\\u044d\\u043b\\u0442\\u043e\\u0440\\u0430. \\u041d\\u0430\\u0439\\u0442\\u0438 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e, \\u043d\\u043e \\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0427\\u0442\\u043e \\u0434\\u0435\\u043b\\u0430\\u0442\\u044c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443, \\u0435\\u0441\\u043b\\u0438 \\u0441\\u043e\\u0431\\u044b\\u0442\\u0438\\u044f \\u0440\\u0430\\u0437\\u0432\\u0438\\u0432\\u0430\\u044e\\u0442\\u0441\\u044f \\u043f\\u043e \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u043e\\u043c\\u0443 \\u0441\\u0446\\u0435\\u043d\\u0430\\u0440\\u0438\\u044e \\u0438 \\u043e\\u043d \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u043b\\u0441\\u044f \\u0441 \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u041c\\u044b \\u0440\\u0435\\u043a\\u043e\\u043c\\u0435\\u043d\\u0434\\u0443\\u0435\\u043c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u043b\\u0435\\u043d\\u0438\\u044f \\u043d\\u0435\\u0433\\u0430\\u0442\\u0438\\u0432\\u043d\\u043e\\u0439 \\u0441\\u0438\\u0442\\u0443\\u0430\\u0446\\u0438\\u0438 \\u043f\\u0440\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u0436\\u0438\\u043b\\u044c\\u044f \\u043f\\u0440\\u043e\\u043a\\u043e\\u043d\\u0441\\u0443\\u043b\\u044c\\u0442\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c\\u0441\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0441\\u0442\\u043e\\u043c, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u0440\\u044b\\u043d\\u043a\\u0435 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0421\\u0442\\u043e\\u0438\\u0442 \\u043b\\u0438 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c\\u0441\\u044f \\u0432 \\u0441\\u0443\\u0434? \\u0418 \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043b\\u0438 \\u0440\\u0435\\u0448\\u0438\\u0442\\u044c \\u0434\\u0435\\u043b\\u043e \\u0432 \\u0441\\u0432\\u043e\\u044e \\u043f\\u043e\\u043b\\u044c\\u0437\\u0443 \\u0432 \\u0441\\u0443\\u0434\\u0435?\\u00bb<\\/i><\\/p>\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u0421\\u0443\\u0434 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u044d\\u0444\\u0444\\u0435\\u043a\\u0442\\u0438\\u0432\\u043d\\u044b\\u043c, \\u0430 \\u0438\\u043d\\u043e\\u0433\\u0434\\u0430 \\u2014 \\u0435\\u0434\\u0438\\u043d\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u043c \\u0441\\u043f\\u043e\\u0441\\u043e\\u0431\\u043e\\u043c \\u0437\\u0430\\u0449\\u0438\\u0442\\u044b \\u043d\\u0430\\u0440\\u0443\\u0448\\u0435\\u043d\\u043d\\u044b\\u0445 \\u043f\\u0440\\u0430\\u0432 \\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0445 \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043e\\u0432 \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u043e\\u0432. \\u041d\\u0435\\u0441\\u043c\\u043e\\u0442\\u0440\\u044f \\u043d\\u0430 \\u0442\\u043e, \\u0447\\u0442\\u043e \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d\\u0435 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f \\u0441 \\u043d\\u0435\\u0434\\u043e\\u0432\\u0435\\u0440\\u0438\\u0435\\u043c \\u043e\\u0442\\u043d\\u043e\\u0441\\u044f\\u0442\\u0441\\u044f \\u043a \\u0432\\u043b\\u0430\\u0441\\u0442\\u043d\\u044b\\u043c \\u0438\\u043d\\u0441\\u0442\\u0438\\u0442\\u0443\\u0442\\u0430\\u043c, \\u043c\\u044b \\u0438\\u0437 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0438 \\u0437\\u043d\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0441\\u0443\\u0434\\u044b \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043c\\u043e\\u0433\\u0443\\u0442 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c. \\u0422\\u0430\\u043a, \\u043d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u0441\\u0443\\u0434\\u044b \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u0432\\u0430\\u043b\\u0438 \\u043f\\u0440\\u0430\\u0432\\u043e \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0443 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d \\u043d\\u0430 \\u0440\\u0443\\u043a\\u0430\\u0445 \\u0438\\u043c\\u0435\\u043b\\u0438\\u0441\\u044c \\u043f\\u0440\\u0435\\u0434\\u0432\\u0430\\u0440\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0434\\u043e\\u0433\\u043e\\u0432\\u043e\\u0440\\u0430 \\u043a\\u0443\\u043f\\u043b\\u0438-\\u043f\\u0440\\u043e\\u0434\\u0430\\u0436\\u0438.\\u00a0 \\u0421 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u043e\\u0439 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u044d\\u0442\\u043e \\u0431\\u044b\\u043b\\u0438 \\u043d\\u0435\\u043e\\u0434\\u043d\\u043e\\u0437\\u043d\\u0430\\u0447\\u043d\\u044b\\u0435 \\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u044f, \\u043d\\u043e \\u043b\\u044e\\u0434\\u044f\\u043c \\u043e\\u043d\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0433\\u0430\\u043b\\u0438 \\u0432\\u0447\\u0435\\u0440\\u0430. \\u041f\\u043e\\u043c\\u043e\\u0433\\u0430\\u044e\\u0442 \\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f.<\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-14 07:52:58","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-14 07:52:48","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/image001.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"info_block_show_title\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":7,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"15","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0);
INSERT INTO `h0qwo_ucm_history` (`version_id`, `ucm_item_id`, `ucm_type_id`, `version_note`, `save_date`, `editor_user_id`, `character_count`, `sha1_hash`, `version_data`, `keep_forever`) VALUES
(86, 27, 1, '', '2016-07-14 08:02:09', 528, 22992, 'bb5a0ae129c2063619c6b40d6a4b7c683807fb30', '{"id":27,"asset_id":"79","title":"\\u041a\\u043e\\u0433\\u0434\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0430 \\u043f\\u043e\\u0447\\u0442\\u0438 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u0430, \\u0435\\u0441\\u0442\\u044c \\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435?","alias":"kogda-novostrojka-pochti-postroena-est-li-risk-pri-pokupke","introtext":"<p style=\\"text-align: justify;\\"><strong>\\u0418\\u043d\\u0442\\u0435\\u0440\\u0432\\u044c\\u044e \\u043d\\u0430 \\u0442\\u0435\\u043c\\u0443 \\u00ab\\u0420\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438\\u00bb<\\/strong>.<\\/p>\\r\\n","fulltext":"\\r\\n<p style=\\"text-align: justify;\\"><strong>\\u0412\\u043e\\u043f\\u0440\\u043e\\u0441: <i>\\u00ab<\\/i><\\/strong><i>\\u0421 \\u043f\\u0440\\u0438\\u0431\\u043b\\u0438\\u0436\\u0435\\u043d\\u0438\\u0435\\u043c \\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438 \\u043a \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0443\\u043c\\u0435\\u043d\\u044c\\u0448\\u0430\\u044e\\u0442\\u0441\\u044f, \\u043d\\u043e \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u043d\\u0435 \\u0438\\u0441\\u0447\\u0435\\u0437\\u0430\\u044e\\u0442 \\u0441\\u043e\\u0432\\u0441\\u0435\\u043c. \\u0421 \\u043a\\u0430\\u043a\\u0438\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u0442\\u044c\\u0441\\u044f \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a, \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0430\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 (\\u0432\\u043e\\u0437\\u0432\\u0435\\u0434\\u0435\\u043d\\u0438\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u044d\\u0442\\u0430\\u0436\\u0435\\u0439, \\u0432\\u043d\\u0443\\u0442\\u0440\\u0435\\u043d\\u043d\\u044f\\u044f \\u043e\\u0442\\u0434\\u0435\\u043b\\u043a\\u0430 \\u0438 \\u0442.\\u043f.)\\u00bb<span id=\\"more-407\\"><\\/span><\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e\\u0442\\u0432\\u0435\\u0442:<\\/b> \\u041f\\u043e\\u043b\\u0430\\u0433\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u0436\\u0438\\u043b\\u044c\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u043e\\u043c \\u043c\\u043e\\u0436\\u043d\\u043e \\u043d\\u0430\\u0437\\u0432\\u0430\\u0442\\u044c \\u0441\\u0430\\u043c\\u044b\\u043c \\u043e\\u043f\\u0430\\u0441\\u043d\\u044b\\u043c. \\u041d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u043f\\u043e \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0436\\u0438\\u043b\\u043e\\u0433\\u043e \\u0434\\u043e\\u043c\\u0430 \\u043e\\u0440\\u0433\\u0430\\u043d\\u044b \\u0432\\u043b\\u0430\\u0441\\u0442\\u0438 \\u0432\\u044b\\u0434\\u0430\\u044e\\u0442 \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u0435 \\u043d\\u0430 \\u0432\\u0432\\u043e\\u0434 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430 \\u0432 \\u044d\\u043a\\u0441\\u043f\\u043b\\u0443\\u0430\\u0442\\u0430\\u0446\\u0438\\u044e. \\u041e\\u0442\\u0441\\u0443\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435 \\u044d\\u0442\\u043e\\u0433\\u043e \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430 \\u044f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u043f\\u0440\\u0435\\u043f\\u044f\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435\\u043c \\u0434\\u043b\\u044f \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u043d\\u0438\\u044f \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u043c\\u0435\\u0449\\u0435\\u043d\\u0438\\u0439 \\u0432 \\u043d\\u0451\\u043c \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438. \\u0414\\u0440\\u0443\\u0433\\u0438\\u043c\\u0438 \\u0441\\u043b\\u043e\\u0432\\u0430\\u043c\\u0438, \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u043e\\u0444\\u043e\\u0440\\u043c\\u0438\\u0442\\u044c \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u0432 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0431\\u0443\\u0434\\u0435\\u0442 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c\\u0430\\u0442\\u0438\\u0447\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u00a0<\\/b><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.: <\\/b><i>\\u00ab\\u0421\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u043b\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f? \\u0418\\u043b\\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f (\\u0432 \\u0441\\u0438\\u043b\\u0443 214 \\u0437\\u0430\\u043a\\u043e\\u043d\\u0430 \\u0438 \\u0434\\u0440. \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0430\\u043a\\u0442\\u043e\\u0432) \\u0442\\u0430\\u043a\\u0438\\u0435 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0438 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u044b?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0435 \\u0440\\u0438\\u0441\\u043a \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u0435\\u0442\\u0441\\u044f \\u0432\\u0441\\u0435\\u0433\\u0434\\u0430. \\u0422\\u0430\\u043a\\u0438\\u0435 \\u043d\\u0435\\u0431\\u043b\\u0430\\u0433\\u043e\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u0441\\u0442\\u0432\\u0438\\u044f \\u0437\\u0430\\u0432\\u0438\\u0441\\u044f\\u0442 \\u043e\\u0442 \\u0441\\u043e\\u0441\\u0442\\u043e\\u044f\\u043d\\u0438\\u044f \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0438 \\u0432 \\u0446\\u0435\\u043b\\u043e\\u043c \\u0438\\u043b\\u0438 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0438 \\u2013 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430 \\u0432 \\u0447\\u0430\\u0441\\u0442\\u043d\\u043e\\u0441\\u0442\\u0438. \\u042d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0443 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e \\u0437\\u0430\\u0433\\u043d\\u0430\\u0442\\u044c \\u0432 \\u0442\\u0438\\u0441\\u043a\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0440\\u0435\\u0433\\u0443\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f. \\u00a0\\u0424\\u0435\\u0434\\u0435\\u0440\\u0430\\u043b\\u044c\\u043d\\u044b\\u0439 \\u0437\\u0430\\u043a\\u043e\\u043d \\u043e\\u0442 30.12.2004 \\u2116214-\\u0424\\u0417 \\u00ab\\u041e\\u0431 \\u0443\\u0447\\u0430\\u0441\\u0442\\u0438\\u0438 \\u0432 \\u0434\\u043e\\u043b\\u0435\\u0432\\u043e\\u043c \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u043c\\u043d\\u043e\\u0433\\u043e\\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u043d\\u044b\\u0445 \\u0434\\u043e\\u043c\\u043e\\u0432 \\u0438 \\u0438\\u043d\\u044b\\u0445 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u043e\\u0432 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438\\u2026\\u00bb \\u0432\\u0432\\u0451\\u043b \\u043f\\u0440\\u0430\\u0432\\u0438\\u043b\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0435 \\u0443\\u0441\\u0442\\u0430\\u043d\\u043e\\u0432\\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0445\\u0435\\u043c\\u044b \\u043f\\u0440\\u0438\\u0432\\u043b\\u0435\\u0447\\u0435\\u043d\\u0438\\u044f \\u0434\\u0435\\u043d\\u0435\\u0436\\u043d\\u044b\\u0445 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432 \\u043d\\u0430 \\u0441\\u0442\\u0430\\u0434\\u0438\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043f\\u0440\\u043e\\u043f\\u0438\\u0441\\u0430\\u043b\\u0438 \\u043f\\u043e\\u0440\\u044f\\u0434\\u043e\\u043a \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0439 \\u0438 \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0434\\u043b\\u044f \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430, \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0438\\u043b\\u0438 \\u0434\\u0440\\u0443\\u0433\\u0438\\u0435 \\u0432\\u043e\\u043f\\u0440\\u043e\\u0441\\u044b. \\u0422\\u0435\\u043c \\u043d\\u0435 \\u043c\\u0435\\u043d\\u0435\\u0435, \\u0437\\u0430\\u043a\\u043e\\u043d \\u043d\\u0435 \\u0441\\u043f\\u0430\\u0441\\u0430\\u0435\\u0442 \\u043e\\u0442 \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0445 \\u0437\\u0430\\u0442\\u0440\\u0443\\u0434\\u043d\\u0435\\u043d\\u0438\\u0439 \\u0438 \\u0431\\u0430\\u043d\\u043a\\u0440\\u043e\\u0442\\u0441\\u0442\\u0432\\u0430.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<i>\\u00ab\\u041a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0435\\u0441\\u0442\\u044c \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0443\\u0436\\u0435 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435? \\u0410 \\u043a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u0432 \\u0442\\u043e\\u043c \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0434\\u043e\\u043c \\u0443\\u0436\\u0435 \\u0441\\u0434\\u0430\\u043d?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u0412 \\u043e\\u0431\\u043e\\u0438\\u0445 \\u0441\\u043b\\u0443\\u0447\\u0430\\u044f\\u0445 \\u043e\\u0441\\u043d\\u043e\\u0432\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u0432\\u044f\\u0437\\u0430\\u043d\\u044b \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c\\u0438 \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438. \\u0422\\u043e\\u043b\\u044c\\u043a\\u043e \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435\\u00a0 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0438 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0431\\u043e\\u043b\\u044c\\u0448\\u0435. \\u041d\\u0430\\u0447\\u0438\\u043d\\u0430\\u044f \\u043e\\u0442 \\u043f\\u0440\\u043e\\u043c\\u0435\\u0434\\u043b\\u0435\\u043d\\u0438\\u044f \\u0441 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435\\u043c \\u043f\\u0440\\u0430\\u0432\\u0430 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u0437\\u0430\\u043a\\u0430\\u043d\\u0447\\u0438\\u0432\\u0430\\u044f \\u0441\\u043d\\u043e\\u0441\\u043e\\u043c \\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u043a\\u0430\\u043a \\u0441\\u0430\\u043c\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0439 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041a\\u0430\\u043a \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a \\u043c\\u043e\\u0436\\u0435\\u0442 \\u043d\\u0438\\u0432\\u0438\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u043e\\u043c \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043d\\u0430 \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438 \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u0441\\u043b\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438? \\u041c\\u043e\\u0436\\u0435\\u0442 \\u043b\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435 \\u0444\\u0438\\u043d\\u0430\\u043d\\u0441\\u043e\\u0432\\u044b\\u0445 \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432 \\u0438\\u043b\\u0438 \\u043f\\u043e\\u043a\\u0430 \\u044d\\u0442\\u043e \\u043d\\u0435 \\u043e\\u0447\\u0435\\u043d\\u044c \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u044e\\u0449\\u0438\\u0439 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u0423 \\u043a\\u043e\\u0433\\u043e \\u0432 \\u0436\\u0438\\u0437\\u043d\\u0438 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u0430\\u043b \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u043e\\u0439 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0439, \\u0442\\u043e\\u0442 \\u0437\\u043d\\u0430\\u0435\\u0442, \\u043a\\u0430\\u043a \\u0432 \\u0420\\u043e\\u0441\\u0441\\u0438\\u0438 \\u043c\\u043e\\u0436\\u043d\\u043e \\u043f\\u043e\\u043b\\u0443\\u0447\\u0438\\u0442\\u044c \\u0434\\u0435\\u043d\\u044c\\u0433\\u0438 \\u043e\\u0442 \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u044b\\u0445 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0439! \\u041d\\u0430 \\u043d\\u0430\\u0448 \\u0432\\u0437\\u0433\\u043b\\u044f\\u0434 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c\\u044b \\u0434\\u043e\\u0431\\u0440\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432, \\u0447\\u0442\\u043e \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0443\\u044e\\u0442 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f, \\u043d\\u0435 \\u0441\\u043d\\u0438\\u0437\\u0438\\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f. \\u0421 1 \\u044f\\u043d\\u0432\\u0430\\u0440\\u044f 2014 \\u0433\\u043e\\u0434\\u0430 \\u043f\\u043e\\u044f\\u0432\\u0438\\u0442\\u0441\\u044f \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c \\u0432\\u0437\\u0430\\u0438\\u043c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u043e\\u0432 \\u2013 \\u0432\\u043e\\u0442 \\u044d\\u0442\\u043e \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043d\\u043e \\u0441 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u043f\\u043e\\u0432\\u044b\\u0448\\u0435\\u043d\\u0438\\u044f \\u0437\\u0430\\u0449\\u0438\\u0449\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041d\\u0430 \\u0447\\u0442\\u043e \\u0441\\u0442\\u043e\\u0438\\u0442 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c \\u0432\\u043d\\u0438\\u043c\\u0430\\u043d\\u0438\\u0435, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0438\\u0437\\u0431\\u0435\\u0436\\u0430\\u0442\\u044c \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0445 \\u0441\\u044e\\u0440\\u043f\\u0440\\u0438\\u0437\\u043e\\u0432?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430\\u0448 \\u0441\\u043e\\u0432\\u0435\\u0442\\u00a0 \\u2014 \\u043f\\u0440\\u0438\\u0433\\u043b\\u0430\\u0441\\u0438\\u0442\\u0435 \\u043d\\u0430 \\u043e\\u0437\\u043d\\u0430\\u043a\\u043e\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435 \\u0441 \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430\\u043c\\u0438 \\u0438 \\u0441\\u0434\\u0435\\u043b\\u043a\\u0443 \\u043f\\u043e \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0435 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043d\\u0443 \\u0438\\u043b\\u0438 \\u0440\\u0438\\u044d\\u043b\\u0442\\u043e\\u0440\\u0430. \\u041d\\u0430\\u0439\\u0442\\u0438 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e, \\u043d\\u043e \\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0427\\u0442\\u043e \\u0434\\u0435\\u043b\\u0430\\u0442\\u044c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443, \\u0435\\u0441\\u043b\\u0438 \\u0441\\u043e\\u0431\\u044b\\u0442\\u0438\\u044f \\u0440\\u0430\\u0437\\u0432\\u0438\\u0432\\u0430\\u044e\\u0442\\u0441\\u044f \\u043f\\u043e \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u043e\\u043c\\u0443 \\u0441\\u0446\\u0435\\u043d\\u0430\\u0440\\u0438\\u044e \\u0438 \\u043e\\u043d \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u043b\\u0441\\u044f \\u0441 \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u041c\\u044b \\u0440\\u0435\\u043a\\u043e\\u043c\\u0435\\u043d\\u0434\\u0443\\u0435\\u043c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u043b\\u0435\\u043d\\u0438\\u044f \\u043d\\u0435\\u0433\\u0430\\u0442\\u0438\\u0432\\u043d\\u043e\\u0439 \\u0441\\u0438\\u0442\\u0443\\u0430\\u0446\\u0438\\u0438 \\u043f\\u0440\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u0436\\u0438\\u043b\\u044c\\u044f \\u043f\\u0440\\u043e\\u043a\\u043e\\u043d\\u0441\\u0443\\u043b\\u044c\\u0442\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c\\u0441\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0441\\u0442\\u043e\\u043c, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u0440\\u044b\\u043d\\u043a\\u0435 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0421\\u0442\\u043e\\u0438\\u0442 \\u043b\\u0438 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c\\u0441\\u044f \\u0432 \\u0441\\u0443\\u0434? \\u0418 \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043b\\u0438 \\u0440\\u0435\\u0448\\u0438\\u0442\\u044c \\u0434\\u0435\\u043b\\u043e \\u0432 \\u0441\\u0432\\u043e\\u044e \\u043f\\u043e\\u043b\\u044c\\u0437\\u0443 \\u0432 \\u0441\\u0443\\u0434\\u0435?\\u00bb<\\/i><\\/p>\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u0421\\u0443\\u0434 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u044d\\u0444\\u0444\\u0435\\u043a\\u0442\\u0438\\u0432\\u043d\\u044b\\u043c, \\u0430 \\u0438\\u043d\\u043e\\u0433\\u0434\\u0430 \\u2014 \\u0435\\u0434\\u0438\\u043d\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u043c \\u0441\\u043f\\u043e\\u0441\\u043e\\u0431\\u043e\\u043c \\u0437\\u0430\\u0449\\u0438\\u0442\\u044b \\u043d\\u0430\\u0440\\u0443\\u0448\\u0435\\u043d\\u043d\\u044b\\u0445 \\u043f\\u0440\\u0430\\u0432 \\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0445 \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043e\\u0432 \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u043e\\u0432. \\u041d\\u0435\\u0441\\u043c\\u043e\\u0442\\u0440\\u044f \\u043d\\u0430 \\u0442\\u043e, \\u0447\\u0442\\u043e \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d\\u0435 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f \\u0441 \\u043d\\u0435\\u0434\\u043e\\u0432\\u0435\\u0440\\u0438\\u0435\\u043c \\u043e\\u0442\\u043d\\u043e\\u0441\\u044f\\u0442\\u0441\\u044f \\u043a \\u0432\\u043b\\u0430\\u0441\\u0442\\u043d\\u044b\\u043c \\u0438\\u043d\\u0441\\u0442\\u0438\\u0442\\u0443\\u0442\\u0430\\u043c, \\u043c\\u044b \\u0438\\u0437 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0438 \\u0437\\u043d\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0441\\u0443\\u0434\\u044b \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043c\\u043e\\u0433\\u0443\\u0442 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c. \\u0422\\u0430\\u043a, \\u043d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u0441\\u0443\\u0434\\u044b \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u0432\\u0430\\u043b\\u0438 \\u043f\\u0440\\u0430\\u0432\\u043e \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0443 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d \\u043d\\u0430 \\u0440\\u0443\\u043a\\u0430\\u0445 \\u0438\\u043c\\u0435\\u043b\\u0438\\u0441\\u044c \\u043f\\u0440\\u0435\\u0434\\u0432\\u0430\\u0440\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0434\\u043e\\u0433\\u043e\\u0432\\u043e\\u0440\\u0430 \\u043a\\u0443\\u043f\\u043b\\u0438-\\u043f\\u0440\\u043e\\u0434\\u0430\\u0436\\u0438.\\u00a0 \\u0421 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u043e\\u0439 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u044d\\u0442\\u043e \\u0431\\u044b\\u043b\\u0438 \\u043d\\u0435\\u043e\\u0434\\u043d\\u043e\\u0437\\u043d\\u0430\\u0447\\u043d\\u044b\\u0435 \\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u044f, \\u043d\\u043e \\u043b\\u044e\\u0434\\u044f\\u043c \\u043e\\u043d\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0433\\u0430\\u043b\\u0438 \\u0432\\u0447\\u0435\\u0440\\u0430. \\u041f\\u043e\\u043c\\u043e\\u0433\\u0430\\u044e\\u0442 \\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f.<\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-14 08:02:09","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-14 07:52:58","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/novostroika.png\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/novostroika.png\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"info_block_show_title\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":8,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"16","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0);
INSERT INTO `h0qwo_ucm_history` (`version_id`, `ucm_item_id`, `ucm_type_id`, `version_note`, `save_date`, `editor_user_id`, `character_count`, `sha1_hash`, `version_data`, `keep_forever`) VALUES
(87, 27, 1, '', '2016-07-14 08:03:48', 528, 22980, 'defb52cd2068a5e1db035e728b2bcb22732443a7', '{"id":27,"asset_id":"79","title":"\\u041a\\u043e\\u0433\\u0434\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0430 \\u043f\\u043e\\u0447\\u0442\\u0438 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u0430, \\u0435\\u0441\\u0442\\u044c \\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435?","alias":"kogda-novostrojka-pochti-postroena-est-li-risk-pri-pokupke","introtext":"<p style=\\"text-align: justify;\\"><strong>\\u0418\\u043d\\u0442\\u0435\\u0440\\u0432\\u044c\\u044e \\u043d\\u0430 \\u0442\\u0435\\u043c\\u0443 \\u00ab\\u0420\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438\\u00bb<\\/strong>.<\\/p>\\r\\n","fulltext":"\\r\\n<p style=\\"text-align: justify;\\"><strong>\\u0412\\u043e\\u043f\\u0440\\u043e\\u0441: <i>\\u00ab<\\/i><\\/strong><i>\\u0421 \\u043f\\u0440\\u0438\\u0431\\u043b\\u0438\\u0436\\u0435\\u043d\\u0438\\u0435\\u043c \\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438 \\u043a \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0443\\u043c\\u0435\\u043d\\u044c\\u0448\\u0430\\u044e\\u0442\\u0441\\u044f, \\u043d\\u043e \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u043d\\u0435 \\u0438\\u0441\\u0447\\u0435\\u0437\\u0430\\u044e\\u0442 \\u0441\\u043e\\u0432\\u0441\\u0435\\u043c. \\u0421 \\u043a\\u0430\\u043a\\u0438\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u0442\\u044c\\u0441\\u044f \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a, \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0430\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 (\\u0432\\u043e\\u0437\\u0432\\u0435\\u0434\\u0435\\u043d\\u0438\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u043d\\u0438\\u0445 \\u044d\\u0442\\u0430\\u0436\\u0435\\u0439, \\u0432\\u043d\\u0443\\u0442\\u0440\\u0435\\u043d\\u043d\\u044f\\u044f \\u043e\\u0442\\u0434\\u0435\\u043b\\u043a\\u0430 \\u0438 \\u0442.\\u043f.)\\u00bb<span id=\\"more-407\\"><\\/span><\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e\\u0442\\u0432\\u0435\\u0442:<\\/b> \\u041f\\u043e\\u043b\\u0430\\u0433\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0440\\u0438\\u0441\\u043a \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u0436\\u0438\\u043b\\u044c\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u043e\\u043c \\u043c\\u043e\\u0436\\u043d\\u043e \\u043d\\u0430\\u0437\\u0432\\u0430\\u0442\\u044c \\u0441\\u0430\\u043c\\u044b\\u043c \\u043e\\u043f\\u0430\\u0441\\u043d\\u044b\\u043c. \\u041d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u043f\\u043e \\u0437\\u0430\\u0432\\u0435\\u0440\\u0448\\u0435\\u043d\\u0438\\u044e \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0436\\u0438\\u043b\\u043e\\u0433\\u043e \\u0434\\u043e\\u043c\\u0430 \\u043e\\u0440\\u0433\\u0430\\u043d\\u044b \\u0432\\u043b\\u0430\\u0441\\u0442\\u0438 \\u0432\\u044b\\u0434\\u0430\\u044e\\u0442 \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u0435 \\u043d\\u0430 \\u0432\\u0432\\u043e\\u0434 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430 \\u0432 \\u044d\\u043a\\u0441\\u043f\\u043b\\u0443\\u0430\\u0442\\u0430\\u0446\\u0438\\u044e. \\u041e\\u0442\\u0441\\u0443\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435 \\u044d\\u0442\\u043e\\u0433\\u043e \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430 \\u044f\\u0432\\u043b\\u044f\\u0435\\u0442\\u0441\\u044f \\u043f\\u0440\\u0435\\u043f\\u044f\\u0442\\u0441\\u0442\\u0432\\u0438\\u0435\\u043c \\u0434\\u043b\\u044f \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u043d\\u0438\\u044f \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u043c\\u0435\\u0449\\u0435\\u043d\\u0438\\u0439 \\u0432 \\u043d\\u0451\\u043c \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438. \\u0414\\u0440\\u0443\\u0433\\u0438\\u043c\\u0438 \\u0441\\u043b\\u043e\\u0432\\u0430\\u043c\\u0438, \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u043e\\u0444\\u043e\\u0440\\u043c\\u0438\\u0442\\u044c \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443 \\u0432 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0431\\u0443\\u0434\\u0435\\u0442 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c\\u0430\\u0442\\u0438\\u0447\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u00a0<\\/b><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.: <\\/b><i>\\u00ab\\u0421\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u043b\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0441\\u0442\\u0430\\u0434\\u0438\\u044f\\u0445 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f? \\u0418\\u043b\\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f (\\u0432 \\u0441\\u0438\\u043b\\u0443 214 \\u0437\\u0430\\u043a\\u043e\\u043d\\u0430 \\u0438 \\u0434\\u0440. \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0445 \\u0430\\u043a\\u0442\\u043e\\u0432) \\u0442\\u0430\\u043a\\u0438\\u0435 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0438 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u044b?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0435 \\u0440\\u0438\\u0441\\u043a \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u0435\\u0442\\u0441\\u044f \\u0432\\u0441\\u0435\\u0433\\u0434\\u0430. \\u0422\\u0430\\u043a\\u0438\\u0435 \\u043d\\u0435\\u0431\\u043b\\u0430\\u0433\\u043e\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0435 \\u043f\\u043e\\u0441\\u043b\\u0435\\u0434\\u0441\\u0442\\u0432\\u0438\\u044f \\u0437\\u0430\\u0432\\u0438\\u0441\\u044f\\u0442 \\u043e\\u0442 \\u0441\\u043e\\u0441\\u0442\\u043e\\u044f\\u043d\\u0438\\u044f \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0438 \\u0432 \\u0446\\u0435\\u043b\\u043e\\u043c \\u0438\\u043b\\u0438 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0438 \\u2013 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430 \\u0432 \\u0447\\u0430\\u0441\\u0442\\u043d\\u043e\\u0441\\u0442\\u0438. \\u042d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u043a\\u0443 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e \\u0437\\u0430\\u0433\\u043d\\u0430\\u0442\\u044c \\u0432 \\u0442\\u0438\\u0441\\u043a\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043e\\u0434\\u0430\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0440\\u0435\\u0433\\u0443\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f. \\u00a0\\u0424\\u0435\\u0434\\u0435\\u0440\\u0430\\u043b\\u044c\\u043d\\u044b\\u0439 \\u0437\\u0430\\u043a\\u043e\\u043d \\u043e\\u0442 30.12.2004 \\u2116214-\\u0424\\u0417 \\u00ab\\u041e\\u0431 \\u0443\\u0447\\u0430\\u0441\\u0442\\u0438\\u0438 \\u0432 \\u0434\\u043e\\u043b\\u0435\\u0432\\u043e\\u043c \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u043c\\u043d\\u043e\\u0433\\u043e\\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u043d\\u044b\\u0445 \\u0434\\u043e\\u043c\\u043e\\u0432 \\u0438 \\u0438\\u043d\\u044b\\u0445 \\u043e\\u0431\\u044a\\u0435\\u043a\\u0442\\u043e\\u0432 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438\\u2026\\u00bb \\u0432\\u0432\\u0451\\u043b \\u043f\\u0440\\u0430\\u0432\\u0438\\u043b\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0435 \\u0443\\u0441\\u0442\\u0430\\u043d\\u043e\\u0432\\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0445\\u0435\\u043c\\u044b \\u043f\\u0440\\u0438\\u0432\\u043b\\u0435\\u0447\\u0435\\u043d\\u0438\\u044f \\u0434\\u0435\\u043d\\u0435\\u0436\\u043d\\u044b\\u0445 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432 \\u043d\\u0430 \\u0441\\u0442\\u0430\\u0434\\u0438\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043f\\u0440\\u043e\\u043f\\u0438\\u0441\\u0430\\u043b\\u0438 \\u043f\\u043e\\u0440\\u044f\\u0434\\u043e\\u043a \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0439 \\u0438 \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u044c \\u0434\\u043b\\u044f \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u0430, \\u0440\\u0430\\u0437\\u0440\\u0435\\u0448\\u0438\\u043b\\u0438 \\u0434\\u0440\\u0443\\u0433\\u0438\\u0435 \\u0432\\u043e\\u043f\\u0440\\u043e\\u0441\\u044b. \\u0422\\u0435\\u043c \\u043d\\u0435 \\u043c\\u0435\\u043d\\u0435\\u0435, \\u0437\\u0430\\u043a\\u043e\\u043d \\u043d\\u0435 \\u0441\\u043f\\u0430\\u0441\\u0430\\u0435\\u0442 \\u043e\\u0442 \\u044d\\u043a\\u043e\\u043d\\u043e\\u043c\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u0445 \\u0437\\u0430\\u0442\\u0440\\u0443\\u0434\\u043d\\u0435\\u043d\\u0438\\u0439 \\u0438 \\u0431\\u0430\\u043d\\u043a\\u0440\\u043e\\u0442\\u0441\\u0442\\u0432\\u0430.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<i>\\u00ab\\u041a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0435\\u0441\\u0442\\u044c \\u043f\\u0440\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0435 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0443\\u0436\\u0435 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435? \\u0410 \\u043a\\u0430\\u043a\\u0438\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u043e\\u0445\\u0440\\u0430\\u043d\\u044f\\u044e\\u0442\\u0441\\u044f \\u0432 \\u0442\\u043e\\u043c \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0434\\u043e\\u043c \\u0443\\u0436\\u0435 \\u0441\\u0434\\u0430\\u043d?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u0412 \\u043e\\u0431\\u043e\\u0438\\u0445 \\u0441\\u043b\\u0443\\u0447\\u0430\\u044f\\u0445 \\u043e\\u0441\\u043d\\u043e\\u0432\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u0441\\u0432\\u044f\\u0437\\u0430\\u043d\\u044b \\u0441 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u0438\\u043c\\u0438 \\u0434\\u0435\\u0444\\u0435\\u043a\\u0442\\u0430\\u043c\\u0438. \\u0422\\u043e\\u043b\\u044c\\u043a\\u043e \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435\\u00a0 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0438 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u0435\\u043d\\u043d\\u043e\\u043c, \\u043d\\u043e \\u043d\\u0435 \\u0441\\u0434\\u0430\\u043d\\u043d\\u043e\\u043c \\u0434\\u043e\\u043c\\u0435 \\u043f\\u0440\\u043e\\u0431\\u043b\\u0435\\u043c \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0431\\u043e\\u043b\\u044c\\u0448\\u0435. \\u041d\\u0430\\u0447\\u0438\\u043d\\u0430\\u044f \\u043e\\u0442 \\u043f\\u0440\\u043e\\u043c\\u0435\\u0434\\u043b\\u0435\\u043d\\u0438\\u044f \\u0441 \\u043e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435\\u043c \\u043f\\u0440\\u0430\\u0432\\u0430 \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043f\\u043e\\u043a\\u0443\\u043f\\u0430\\u0442\\u0435\\u043b\\u0435\\u0439 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u0437\\u0430\\u043a\\u0430\\u043d\\u0447\\u0438\\u0432\\u0430\\u044f \\u0441\\u043d\\u043e\\u0441\\u043e\\u043c \\u0437\\u0434\\u0430\\u043d\\u0438\\u044f \\u043a\\u0430\\u043a \\u0441\\u0430\\u043c\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0439 \\u043f\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041a\\u0430\\u043a \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a \\u043c\\u043e\\u0436\\u0435\\u0442 \\u043d\\u0438\\u0432\\u0438\\u043b\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u0435 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0430 \\u0444\\u0438\\u043d\\u0430\\u043b\\u044c\\u043d\\u043e\\u043c \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0430, \\u043d\\u0430 \\u044d\\u0442\\u0430\\u043f\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438 \\u0434\\u043e\\u043c\\u0430 \\u0438 \\u043f\\u043e\\u0441\\u043b\\u0435 \\u0441\\u0434\\u0430\\u0447\\u0438? \\u041c\\u043e\\u0436\\u0435\\u0442 \\u043b\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u0435 \\u0444\\u0438\\u043d\\u0430\\u043d\\u0441\\u043e\\u0432\\u044b\\u0445 \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432 \\u0438\\u043b\\u0438 \\u043f\\u043e\\u043a\\u0430 \\u044d\\u0442\\u043e \\u043d\\u0435 \\u043e\\u0447\\u0435\\u043d\\u044c \\u0440\\u0430\\u0431\\u043e\\u0442\\u0430\\u044e\\u0449\\u0438\\u0439 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u0423 \\u043a\\u043e\\u0433\\u043e \\u0432 \\u0436\\u0438\\u0437\\u043d\\u0438 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u0430\\u043b \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u043e\\u0439 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0439, \\u0442\\u043e\\u0442 \\u0437\\u043d\\u0430\\u0435\\u0442, \\u043a\\u0430\\u043a \\u0432 \\u0420\\u043e\\u0441\\u0441\\u0438\\u0438 \\u043c\\u043e\\u0436\\u043d\\u043e \\u043f\\u043e\\u043b\\u0443\\u0447\\u0438\\u0442\\u044c \\u0434\\u0435\\u043d\\u044c\\u0433\\u0438 \\u043e\\u0442 \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u044b\\u0445 \\u043a\\u043e\\u043c\\u043f\\u0430\\u043d\\u0438\\u0439! \\u041d\\u0430 \\u043d\\u0430\\u0448 \\u0432\\u0437\\u0433\\u043b\\u044f\\u0434 \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c\\u044b \\u0434\\u043e\\u0431\\u0440\\u043e\\u0432\\u043e\\u043b\\u044c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u0440\\u0438\\u0441\\u043a\\u043e\\u0432, \\u0447\\u0442\\u043e \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0443\\u044e\\u0442 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f, \\u043d\\u0435 \\u0441\\u043d\\u0438\\u0437\\u0438\\u043b\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0438 \\u043d\\u0435\\u0434\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f \\u0438\\u043b\\u0438 \\u0434\\u043e\\u043b\\u0433\\u043e\\u0441\\u0442\\u0440\\u043e\\u044f. \\u0421 1 \\u044f\\u043d\\u0432\\u0430\\u0440\\u044f 2014 \\u0433\\u043e\\u0434\\u0430 \\u043f\\u043e\\u044f\\u0432\\u0438\\u0442\\u0441\\u044f \\u043c\\u0435\\u0445\\u0430\\u043d\\u0438\\u0437\\u043c \\u0432\\u0437\\u0430\\u0438\\u043c\\u043d\\u043e\\u0433\\u043e \\u0441\\u0442\\u0440\\u0430\\u0445\\u043e\\u0432\\u0430\\u043d\\u0438\\u044f \\u043e\\u0442\\u0432\\u0435\\u0442\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0437\\u0430\\u0441\\u0442\\u0440\\u043e\\u0439\\u0449\\u0438\\u043a\\u043e\\u0432 \\u2013 \\u0432\\u043e\\u0442 \\u044d\\u0442\\u043e \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043d\\u043e \\u0441 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u043f\\u043e\\u0432\\u044b\\u0448\\u0435\\u043d\\u0438\\u044f \\u0437\\u0430\\u0449\\u0438\\u0449\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u041d\\u0430 \\u0447\\u0442\\u043e \\u0441\\u0442\\u043e\\u0438\\u0442 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c \\u0432\\u043d\\u0438\\u043c\\u0430\\u043d\\u0438\\u0435, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0438\\u0437\\u0431\\u0435\\u0436\\u0430\\u0442\\u044c \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u044b\\u0445 \\u0441\\u044e\\u0440\\u043f\\u0440\\u0438\\u0437\\u043e\\u0432?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.:<\\/b> \\u041d\\u0430\\u0448 \\u0441\\u043e\\u0432\\u0435\\u0442\\u00a0 \\u2014 \\u043f\\u0440\\u0438\\u0433\\u043b\\u0430\\u0441\\u0438\\u0442\\u0435 \\u043d\\u0430 \\u043e\\u0437\\u043d\\u0430\\u043a\\u043e\\u043c\\u043b\\u0435\\u043d\\u0438\\u0435 \\u0441 \\u0434\\u043e\\u043a\\u0443\\u043c\\u0435\\u043d\\u0442\\u0430\\u043c\\u0438 \\u0438 \\u0441\\u0434\\u0435\\u043b\\u043a\\u0443 \\u043f\\u043e \\u043f\\u0440\\u0438\\u043e\\u0431\\u0440\\u0435\\u0442\\u0435\\u043d\\u0438\\u044f \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u044b \\u0432 \\u043d\\u043e\\u0432\\u043e\\u0441\\u0442\\u0440\\u043e\\u0439\\u043a\\u0435 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043d\\u0443 \\u0438\\u043b\\u0438 \\u0440\\u0438\\u044d\\u043b\\u0442\\u043e\\u0440\\u0430. \\u041d\\u0430\\u0439\\u0442\\u0438 \\u044e\\u0440\\u0438\\u0441\\u0442\\u0430, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0434\\u0435\\u0439\\u0441\\u0442\\u0432\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u043e \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438 \\u0442\\u0440\\u0443\\u0434\\u043d\\u043e, \\u043d\\u043e \\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u043e.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0427\\u0442\\u043e \\u0434\\u0435\\u043b\\u0430\\u0442\\u044c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443, \\u0435\\u0441\\u043b\\u0438 \\u0441\\u043e\\u0431\\u044b\\u0442\\u0438\\u044f \\u0440\\u0430\\u0437\\u0432\\u0438\\u0432\\u0430\\u044e\\u0442\\u0441\\u044f \\u043f\\u043e \\u043d\\u0435\\u043f\\u0440\\u0438\\u044f\\u0442\\u043d\\u043e\\u043c\\u0443 \\u0441\\u0446\\u0435\\u043d\\u0430\\u0440\\u0438\\u044e \\u0438 \\u043e\\u043d \\u0432\\u0441\\u0435-\\u0442\\u0430\\u043a\\u0438 \\u0441\\u0442\\u043e\\u043b\\u043a\\u043d\\u0443\\u043b\\u0441\\u044f \\u0441 \\u0443\\u043a\\u0430\\u0437\\u0430\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0440\\u0438\\u0441\\u043a\\u0430\\u043c\\u0438?\\u00bb<\\/i><\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u041c\\u044b \\u0440\\u0435\\u043a\\u043e\\u043c\\u0435\\u043d\\u0434\\u0443\\u0435\\u043c \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u0443 \\u0432 \\u0441\\u043b\\u0443\\u0447\\u0430\\u0435 \\u043d\\u0430\\u0441\\u0442\\u0443\\u043f\\u043b\\u0435\\u043d\\u0438\\u044f \\u043d\\u0435\\u0433\\u0430\\u0442\\u0438\\u0432\\u043d\\u043e\\u0439 \\u0441\\u0438\\u0442\\u0443\\u0430\\u0446\\u0438\\u0438 \\u043f\\u0440\\u0438 \\u0441\\u0442\\u0440\\u043e\\u0438\\u0442\\u0435\\u043b\\u044c\\u0441\\u0442\\u0432\\u0435 \\u0436\\u0438\\u043b\\u044c\\u044f \\u043f\\u0440\\u043e\\u043a\\u043e\\u043d\\u0441\\u0443\\u043b\\u044c\\u0442\\u0438\\u0440\\u043e\\u0432\\u0430\\u0442\\u044c\\u0441\\u044f \\u0441 \\u044e\\u0440\\u0438\\u0441\\u0442\\u043e\\u043c, \\u043a\\u043e\\u0442\\u043e\\u0440\\u044b\\u0439 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u0438\\u0437\\u0438\\u0440\\u0443\\u0435\\u0442\\u0441\\u044f \\u043d\\u0430 \\u0440\\u044b\\u043d\\u043a\\u0435 \\u043d\\u0435\\u0434\\u0432\\u0438\\u0436\\u0438\\u043c\\u043e\\u0441\\u0442\\u0438.<\\/p>\\r\\n<p style=\\"text-align: justify;\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u0412.:<\\/b> <i>\\u00ab\\u0421\\u0442\\u043e\\u0438\\u0442 \\u043b\\u0438 \\u043e\\u0431\\u0440\\u0430\\u0449\\u0430\\u0442\\u044c\\u0441\\u044f \\u0432 \\u0441\\u0443\\u0434? \\u0418 \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043b\\u0438 \\u0440\\u0435\\u0448\\u0438\\u0442\\u044c \\u0434\\u0435\\u043b\\u043e \\u0432 \\u0441\\u0432\\u043e\\u044e \\u043f\\u043e\\u043b\\u044c\\u0437\\u0443 \\u0432 \\u0441\\u0443\\u0434\\u0435?\\u00bb<\\/i><\\/p>\\r\\n<p class=\\"MsoNormal\\">\\u00a0<\\/p>\\r\\n<p style=\\"text-align: justify;\\"><b>\\u041e.: <\\/b>\\u0421\\u0443\\u0434 \\u043c\\u043e\\u0436\\u0435\\u0442 \\u0431\\u044b\\u0442\\u044c \\u044d\\u0444\\u0444\\u0435\\u043a\\u0442\\u0438\\u0432\\u043d\\u044b\\u043c, \\u0430 \\u0438\\u043d\\u043e\\u0433\\u0434\\u0430 \\u2014 \\u0435\\u0434\\u0438\\u043d\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u043c \\u0441\\u043f\\u043e\\u0441\\u043e\\u0431\\u043e\\u043c \\u0437\\u0430\\u0449\\u0438\\u0442\\u044b \\u043d\\u0430\\u0440\\u0443\\u0448\\u0435\\u043d\\u043d\\u044b\\u0445 \\u043f\\u0440\\u0430\\u0432 \\u0438\\u043b\\u0438 \\u0437\\u0430\\u043a\\u043e\\u043d\\u043d\\u044b\\u0445 \\u0438\\u043d\\u0442\\u0435\\u0440\\u0435\\u0441\\u043e\\u0432 \\u0434\\u043e\\u043b\\u044c\\u0449\\u0438\\u043a\\u043e\\u0432. \\u041d\\u0435\\u0441\\u043c\\u043e\\u0442\\u0440\\u044f \\u043d\\u0430 \\u0442\\u043e, \\u0447\\u0442\\u043e \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d\\u0435 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f \\u0441 \\u043d\\u0435\\u0434\\u043e\\u0432\\u0435\\u0440\\u0438\\u0435\\u043c \\u043e\\u0442\\u043d\\u043e\\u0441\\u044f\\u0442\\u0441\\u044f \\u043a \\u0432\\u043b\\u0430\\u0441\\u0442\\u043d\\u044b\\u043c \\u0438\\u043d\\u0441\\u0442\\u0438\\u0442\\u0443\\u0442\\u0430\\u043c, \\u043c\\u044b \\u0438\\u0437 \\u043f\\u0440\\u0430\\u043a\\u0442\\u0438\\u043a\\u0438 \\u0437\\u043d\\u0430\\u0435\\u043c, \\u0447\\u0442\\u043e \\u0441\\u0443\\u0434\\u044b \\u0440\\u0435\\u0430\\u043b\\u044c\\u043d\\u043e \\u043c\\u043e\\u0433\\u0443\\u0442 \\u043f\\u043e\\u043c\\u043e\\u0447\\u044c. \\u0422\\u0430\\u043a, \\u043d\\u0430\\u043f\\u0440\\u0438\\u043c\\u0435\\u0440, \\u0441\\u0443\\u0434\\u044b \\u043f\\u0440\\u0438\\u0437\\u043d\\u0430\\u0432\\u0430\\u043b\\u0438 \\u043f\\u0440\\u0430\\u0432\\u043e \\u0441\\u043e\\u0431\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u043e\\u0441\\u0442\\u0438 \\u043d\\u0430 \\u043a\\u0432\\u0430\\u0440\\u0442\\u0438\\u0440\\u0443, \\u043a\\u043e\\u0433\\u0434\\u0430 \\u0443 \\u0433\\u0440\\u0430\\u0436\\u0434\\u0430\\u043d \\u043d\\u0430 \\u0440\\u0443\\u043a\\u0430\\u0445 \\u0438\\u043c\\u0435\\u043b\\u0438\\u0441\\u044c \\u043f\\u0440\\u0435\\u0434\\u0432\\u0430\\u0440\\u0438\\u0442\\u0435\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0434\\u043e\\u0433\\u043e\\u0432\\u043e\\u0440\\u0430 \\u043a\\u0443\\u043f\\u043b\\u0438-\\u043f\\u0440\\u043e\\u0434\\u0430\\u0436\\u0438.\\u00a0 \\u0421 \\u044e\\u0440\\u0438\\u0434\\u0438\\u0447\\u0435\\u0441\\u043a\\u043e\\u0439 \\u0442\\u043e\\u0447\\u043a\\u0438 \\u0437\\u0440\\u0435\\u043d\\u0438\\u044f \\u044d\\u0442\\u043e \\u0431\\u044b\\u043b\\u0438 \\u043d\\u0435\\u043e\\u0434\\u043d\\u043e\\u0437\\u043d\\u0430\\u0447\\u043d\\u044b\\u0435 \\u0440\\u0435\\u0448\\u0435\\u043d\\u0438\\u044f, \\u043d\\u043e \\u043b\\u044e\\u0434\\u044f\\u043c \\u043e\\u043d\\u0438 \\u043f\\u043e\\u043c\\u043e\\u0433\\u0430\\u043b\\u0438 \\u0432\\u0447\\u0435\\u0440\\u0430. \\u041f\\u043e\\u043c\\u043e\\u0433\\u0430\\u044e\\u0442 \\u0438 \\u0441\\u0435\\u0433\\u043e\\u0434\\u043d\\u044f.<\\/p>","state":1,"catid":"9","created":"2016-07-06 13:43:44","created_by":"528","created_by_alias":"","modified":"2016-07-14 08:03:48","modified_by":"528","checked_out":"528","checked_out_time":"2016-07-14 08:02:09","publish_up":"2016-07-06 13:43:44","publish_down":"0000-00-00 00:00:00","images":"{\\"image_intro\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/novos.jpg\\",\\"float_intro\\":\\"\\",\\"image_intro_alt\\":\\"\\",\\"image_intro_caption\\":\\"\\",\\"image_fulltext\\":\\"images\\\\\\/06-07-2016\\\\\\/article2\\\\\\/novos.jpg\\",\\"float_fulltext\\":\\"\\",\\"image_fulltext_alt\\":\\"\\",\\"image_fulltext_caption\\":\\"\\"}","urls":"{\\"urla\\":false,\\"urlatext\\":\\"\\",\\"targeta\\":\\"\\",\\"urlb\\":false,\\"urlbtext\\":\\"\\",\\"targetb\\":\\"\\",\\"urlc\\":false,\\"urlctext\\":\\"\\",\\"targetc\\":\\"\\"}","attribs":"{\\"show_title\\":\\"\\",\\"link_titles\\":\\"\\",\\"show_tags\\":\\"\\",\\"show_intro\\":\\"\\",\\"info_block_position\\":\\"\\",\\"info_block_show_title\\":\\"\\",\\"show_category\\":\\"\\",\\"link_category\\":\\"\\",\\"show_parent_category\\":\\"\\",\\"link_parent_category\\":\\"\\",\\"show_author\\":\\"\\",\\"link_author\\":\\"\\",\\"show_create_date\\":\\"\\",\\"show_modify_date\\":\\"\\",\\"show_publish_date\\":\\"\\",\\"show_item_navigation\\":\\"\\",\\"show_icons\\":\\"\\",\\"show_print_icon\\":\\"\\",\\"show_email_icon\\":\\"\\",\\"show_vote\\":\\"\\",\\"show_hits\\":\\"\\",\\"show_noauth\\":\\"\\",\\"urls_position\\":\\"\\",\\"alternative_readmore\\":\\"\\",\\"article_layout\\":\\"\\",\\"show_publishing_options\\":\\"\\",\\"show_article_options\\":\\"\\",\\"show_urls_images_backend\\":\\"\\",\\"show_urls_images_frontend\\":\\"\\",\\"spfeatured_image\\":\\"\\",\\"post_format\\":\\"standard\\",\\"gallery\\":\\"\\",\\"audio\\":\\"\\",\\"video\\":\\"\\",\\"link_title\\":\\"\\",\\"link_url\\":\\"\\",\\"quote_text\\":\\"\\",\\"quote_author\\":\\"\\",\\"post_status\\":\\"\\"}","version":9,"ordering":"0","metakey":"","metadesc":"","access":"1","hits":"16","metadata":"{\\"robots\\":\\"\\",\\"author\\":\\"\\",\\"rights\\":\\"\\",\\"xreference\\":\\"\\"}","featured":"1","language":"*","xreference":""}', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_updates`
--

CREATE TABLE IF NOT EXISTS `h0qwo_updates` (
  `update_id` int(11) NOT NULL AUTO_INCREMENT,
  `update_site_id` int(11) DEFAULT '0',
  `extension_id` int(11) DEFAULT '0',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `folder` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `client_id` tinyint(3) DEFAULT '0',
  `version` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `detailsurl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `infourl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_query` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Available Updates' AUTO_INCREMENT=312 ;

--
-- Дамп данных таблицы `h0qwo_updates`
--

INSERT INTO `h0qwo_updates` (`update_id`, `update_site_id`, `extension_id`, `name`, `description`, `element`, `type`, `folder`, `client_id`, `version`, `data`, `detailsurl`, `infourl`, `extra_query`) VALUES
(2, 1, 700, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.0', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(3, 3, 0, 'Armenian', '', 'pkg_hy-AM', 'package', '', 0, '3.4.4.1', '', 'https://update.joomla.org/language/details3/hy-AM_details.xml', '', ''),
(4, 3, 0, 'Malay', '', 'pkg_ms-MY', 'package', '', 0, '3.4.1.2', '', 'https://update.joomla.org/language/details3/ms-MY_details.xml', '', ''),
(5, 3, 0, 'Romanian', '', 'pkg_ro-RO', 'package', '', 0, '3.5.0.1', '', 'https://update.joomla.org/language/details3/ro-RO_details.xml', '', ''),
(6, 3, 0, 'Flemish', '', 'pkg_nl-BE', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/nl-BE_details.xml', '', ''),
(7, 3, 0, 'Chinese Traditional', '', 'pkg_zh-TW', 'package', '', 0, '3.5.0.1', '', 'https://update.joomla.org/language/details3/zh-TW_details.xml', '', ''),
(8, 3, 0, 'French', '', 'pkg_fr-FR', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/fr-FR_details.xml', '', ''),
(9, 3, 0, 'Galician', '', 'pkg_gl-ES', 'package', '', 0, '3.3.1.2', '', 'https://update.joomla.org/language/details3/gl-ES_details.xml', '', ''),
(10, 3, 0, 'Greek', '', 'pkg_el-GR', 'package', '', 0, '3.4.2.1', '', 'https://update.joomla.org/language/details3/el-GR_details.xml', '', ''),
(11, 3, 0, 'Japanese', '', 'pkg_ja-JP', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/ja-JP_details.xml', '', ''),
(12, 3, 0, 'Hebrew', '', 'pkg_he-IL', 'package', '', 0, '3.1.1.1', '', 'https://update.joomla.org/language/details3/he-IL_details.xml', '', ''),
(13, 3, 0, 'Hungarian', '', 'pkg_hu-HU', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/hu-HU_details.xml', '', ''),
(14, 3, 0, 'Afrikaans', '', 'pkg_af-ZA', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/af-ZA_details.xml', '', ''),
(15, 3, 0, 'Arabic Unitag', '', 'pkg_ar-AA', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/ar-AA_details.xml', '', ''),
(16, 3, 0, 'Belarusian', '', 'pkg_be-BY', 'package', '', 0, '3.2.1.1', '', 'https://update.joomla.org/language/details3/be-BY_details.xml', '', ''),
(17, 3, 0, 'Bulgarian', '', 'pkg_bg-BG', 'package', '', 0, '3.4.4.2', '', 'https://update.joomla.org/language/details3/bg-BG_details.xml', '', ''),
(18, 3, 0, 'Catalan', '', 'pkg_ca-ES', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/ca-ES_details.xml', '', ''),
(19, 3, 0, 'Chinese Simplified', '', 'pkg_zh-CN', 'package', '', 0, '3.4.1.1', '', 'https://update.joomla.org/language/details3/zh-CN_details.xml', '', ''),
(20, 3, 0, 'Croatian', '', 'pkg_hr-HR', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/hr-HR_details.xml', '', ''),
(21, 3, 0, 'Czech', '', 'pkg_cs-CZ', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/cs-CZ_details.xml', '', ''),
(22, 3, 0, 'Danish', '', 'pkg_da-DK', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/da-DK_details.xml', '', ''),
(23, 3, 0, 'Dutch', '', 'pkg_nl-NL', 'package', '', 0, '3.5.1.2', '', 'https://update.joomla.org/language/details3/nl-NL_details.xml', '', ''),
(24, 3, 0, 'Estonian', '', 'pkg_et-EE', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/et-EE_details.xml', '', ''),
(25, 3, 0, 'Italian', '', 'pkg_it-IT', 'package', '', 0, '3.6.0.2', '', 'https://update.joomla.org/language/details3/it-IT_details.xml', '', ''),
(26, 3, 0, 'Khmer', '', 'pkg_km-KH', 'package', '', 0, '3.4.5.1', '', 'https://update.joomla.org/language/details3/km-KH_details.xml', '', ''),
(27, 3, 0, 'Korean', '', 'pkg_ko-KR', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/ko-KR_details.xml', '', ''),
(28, 3, 0, 'Latvian', '', 'pkg_lv-LV', 'package', '', 0, '3.4.3.1', '', 'https://update.joomla.org/language/details3/lv-LV_details.xml', '', ''),
(29, 3, 0, 'Macedonian', '', 'pkg_mk-MK', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/mk-MK_details.xml', '', ''),
(30, 3, 0, 'Norwegian Bokmal', '', 'pkg_nb-NO', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/nb-NO_details.xml', '', ''),
(31, 3, 0, 'Norwegian Nynorsk', '', 'pkg_nn-NO', 'package', '', 0, '3.4.2.1', '', 'https://update.joomla.org/language/details3/nn-NO_details.xml', '', ''),
(32, 3, 0, 'Persian', '', 'pkg_fa-IR', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/fa-IR_details.xml', '', ''),
(33, 3, 0, 'Polish', '', 'pkg_pl-PL', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/pl-PL_details.xml', '', ''),
(34, 3, 0, 'Portuguese', '', 'pkg_pt-PT', 'package', '', 0, '3.5.1.4', '', 'https://update.joomla.org/language/details3/pt-PT_details.xml', '', ''),
(36, 3, 0, 'English AU', '', 'pkg_en-AU', 'package', '', 0, '3.5.1.2', '', 'https://update.joomla.org/language/details3/en-AU_details.xml', '', ''),
(37, 3, 0, 'Slovak', '', 'pkg_sk-SK', 'package', '', 0, '3.5.1.2', '', 'https://update.joomla.org/language/details3/sk-SK_details.xml', '', ''),
(38, 3, 0, 'English US', '', 'pkg_en-US', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/en-US_details.xml', '', ''),
(39, 3, 0, 'Swedish', '', 'pkg_sv-SE', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/sv-SE_details.xml', '', ''),
(40, 3, 0, 'Syriac', '', 'pkg_sy-IQ', 'package', '', 0, '3.4.5.1', '', 'https://update.joomla.org/language/details3/sy-IQ_details.xml', '', ''),
(41, 3, 0, 'Tamil', '', 'pkg_ta-IN', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/ta-IN_details.xml', '', ''),
(42, 3, 0, 'Thai', '', 'pkg_th-TH', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/th-TH_details.xml', '', ''),
(43, 3, 0, 'Turkish', '', 'pkg_tr-TR', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/tr-TR_details.xml', '', ''),
(44, 3, 0, 'Ukrainian', '', 'pkg_uk-UA', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/uk-UA_details.xml', '', ''),
(45, 3, 0, 'Uyghur', '', 'pkg_ug-CN', 'package', '', 0, '3.3.0.1', '', 'https://update.joomla.org/language/details3/ug-CN_details.xml', '', ''),
(46, 3, 0, 'Albanian', '', 'pkg_sq-AL', 'package', '', 0, '3.1.1.1', '', 'https://update.joomla.org/language/details3/sq-AL_details.xml', '', ''),
(47, 3, 0, 'Basque', '', 'pkg_eu-ES', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/eu-ES_details.xml', '', ''),
(48, 3, 0, 'Hindi', '', 'pkg_hi-IN', 'package', '', 0, '3.3.6.1', '', 'https://update.joomla.org/language/details3/hi-IN_details.xml', '', ''),
(49, 3, 0, 'German DE', '', 'pkg_de-DE', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/de-DE_details.xml', '', ''),
(50, 3, 0, 'Portuguese Brazil', '', 'pkg_pt-BR', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/pt-BR_details.xml', '', ''),
(51, 3, 0, 'Serbian Latin', '', 'pkg_sr-YU', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/sr-YU_details.xml', '', ''),
(52, 3, 0, 'Spanish', '', 'pkg_es-ES', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/es-ES_details.xml', '', ''),
(53, 3, 0, 'Bosnian', '', 'pkg_bs-BA', 'package', '', 0, '3.4.8.1', '', 'https://update.joomla.org/language/details3/bs-BA_details.xml', '', ''),
(54, 3, 0, 'Serbian Cyrillic', '', 'pkg_sr-RS', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/sr-RS_details.xml', '', ''),
(55, 3, 0, 'Vietnamese', '', 'pkg_vi-VN', 'package', '', 0, '3.2.1.1', '', 'https://update.joomla.org/language/details3/vi-VN_details.xml', '', ''),
(56, 3, 0, 'Bahasa Indonesia', '', 'pkg_id-ID', 'package', '', 0, '3.3.0.2', '', 'https://update.joomla.org/language/details3/id-ID_details.xml', '', ''),
(57, 3, 0, 'Finnish', '', 'pkg_fi-FI', 'package', '', 0, '3.5.1.1', '', 'https://update.joomla.org/language/details3/fi-FI_details.xml', '', ''),
(58, 3, 0, 'Swahili', '', 'pkg_sw-KE', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/sw-KE_details.xml', '', ''),
(59, 3, 0, 'Montenegrin', '', 'pkg_srp-ME', 'package', '', 0, '3.3.1.1', '', 'https://update.joomla.org/language/details3/srp-ME_details.xml', '', ''),
(60, 3, 0, 'English CA', '', 'pkg_en-CA', 'package', '', 0, '3.5.1.2', '', 'https://update.joomla.org/language/details3/en-CA_details.xml', '', ''),
(61, 3, 0, 'French CA', '', 'pkg_fr-CA', 'package', '', 0, '3.5.1.2', '', 'https://update.joomla.org/language/details3/fr-CA_details.xml', '', ''),
(62, 3, 0, 'Welsh', '', 'pkg_cy-GB', 'package', '', 0, '3.3.0.2', '', 'https://update.joomla.org/language/details3/cy-GB_details.xml', '', ''),
(63, 3, 0, 'Sinhala', '', 'pkg_si-LK', 'package', '', 0, '3.3.1.1', '', 'https://update.joomla.org/language/details3/si-LK_details.xml', '', ''),
(64, 3, 0, 'Dari Persian', '', 'pkg_prs-AF', 'package', '', 0, '3.4.4.1', '', 'https://update.joomla.org/language/details3/prs-AF_details.xml', '', ''),
(65, 3, 0, 'Turkmen', '', 'pkg_tk-TM', 'package', '', 0, '3.5.0.1', '', 'https://update.joomla.org/language/details3/tk-TM_details.xml', '', ''),
(66, 3, 0, 'Irish', '', 'pkg_ga-IE', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/ga-IE_details.xml', '', ''),
(67, 3, 0, 'Dzongkha', '', 'pkg_dz-BT', 'package', '', 0, '3.4.5.1', '', 'https://update.joomla.org/language/details3/dz-BT_details.xml', '', ''),
(68, 3, 0, 'Slovenian', '', 'pkg_sl-SI', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/sl-SI_details.xml', '', ''),
(69, 3, 0, 'Spanish CO', '', 'pkg_es-CO', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/es-CO_details.xml', '', ''),
(70, 3, 0, 'German CH', '', 'pkg_de-CH', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/de-CH_details.xml', '', ''),
(71, 3, 0, 'German AT', '', 'pkg_de-AT', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/de-AT_details.xml', '', ''),
(72, 3, 0, 'German LI', '', 'pkg_de-LI', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/de-LI_details.xml', '', ''),
(73, 3, 0, 'German LU', '', 'pkg_de-LU', 'package', '', 0, '3.6.0.1', '', 'https://update.joomla.org/language/details3/de-LU_details.xml', '', ''),
(74, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.1', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(75, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.1', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(76, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.1', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(77, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.1', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(78, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(79, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(80, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(81, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(82, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(83, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(84, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(85, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(86, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(87, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(88, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(89, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(90, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(91, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(92, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(93, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(94, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(95, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(96, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(97, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(98, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(99, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(100, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(101, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(102, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(103, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(104, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(105, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(106, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(107, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(108, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(109, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(110, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(111, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(112, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(113, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(114, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(115, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(116, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(117, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(118, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(119, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(120, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(121, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(122, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(123, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(124, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(125, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(126, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(127, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(128, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(129, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(130, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(131, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(132, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(133, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(134, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(135, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(136, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(137, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(138, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(139, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(140, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(141, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(142, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(143, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(144, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(145, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(146, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(147, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(148, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(149, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(150, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(151, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(152, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(153, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(154, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(155, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(156, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(157, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(158, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(159, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(160, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(161, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(162, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(163, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(164, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(165, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(166, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(167, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(168, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(169, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(170, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(171, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(172, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(173, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(174, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(175, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(176, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(177, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(178, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(179, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(180, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(181, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(182, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(183, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(184, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(185, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(186, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(187, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(188, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(189, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(190, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(191, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(192, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(193, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(194, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(195, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(196, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(197, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(198, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(199, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(200, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(201, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(202, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(203, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(204, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(205, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(206, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(207, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(208, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(209, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(210, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(211, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(212, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(213, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(214, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(215, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(216, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(217, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(218, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(219, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(220, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(221, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(222, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(223, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(224, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(225, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(226, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(227, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(228, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(229, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(230, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(231, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(232, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(233, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(234, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(235, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(236, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(237, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(238, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(239, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(240, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(241, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(242, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(243, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(244, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(245, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(246, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(247, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(248, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(249, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(250, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(251, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(252, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(253, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(254, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(255, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(256, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(257, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(258, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(259, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(260, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(261, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(262, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(263, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(264, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(265, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(266, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(267, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(268, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(269, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(270, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(271, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(272, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(273, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(274, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(275, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(276, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(277, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(278, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(279, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(280, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(281, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(282, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(283, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(284, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(285, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(286, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(287, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(288, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(289, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(290, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(291, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(292, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(293, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(294, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(295, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(296, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(297, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(298, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(299, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(300, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(301, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(302, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(303, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(304, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(305, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(306, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(307, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(308, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(309, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(310, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', ''),
(311, 1, 0, 'Joomla', '', 'joomla', 'file', '', 0, '3.6.2', '', 'https://update.joomla.org/core/sts/extension_sts.xml', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_update_sites`
--

CREATE TABLE IF NOT EXISTS `h0qwo_update_sites` (
  `update_site_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` int(11) DEFAULT '0',
  `last_check_timestamp` bigint(20) DEFAULT '0',
  `extra_query` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`update_site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Update Sites' AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `h0qwo_update_sites`
--

INSERT INTO `h0qwo_update_sites` (`update_site_id`, `name`, `type`, `location`, `enabled`, `last_check_timestamp`, `extra_query`) VALUES
(1, 'Joomla! Core', 'collection', 'https://update.joomla.org/core/list.xml', 1, 1476627102, ''),
(2, 'Joomla! Extension Directory', 'collection', 'https://update.joomla.org/jed/list.xml', 1, 1476627102, ''),
(3, 'Accredited Joomla! Translations', 'collection', 'https://update.joomla.org/language/translationlist_3.xml', 1, 1468480164, ''),
(4, 'Joomla! Update Component Update Site', 'extension', 'https://update.joomla.org/core/extensions/com_joomlaupdate.xml', 1, 0, ''),
(5, 'Helix3 - Ajax', 'extension', 'http://www.joomshaper.com/updates/plg-ajax-helix3.xml', 1, 0, ''),
(6, 'System - Helix3 Framework', 'extension', 'http://www.joomshaper.com/updates/plg-system-helix3.xml', 1, 0, ''),
(7, 'shaper_helix3', 'extension', 'http://www.joomshaper.com/updates/shaper-helix3.xml', 1, 0, ''),
(8, 'SP Page Builder', 'extension', 'http://www.joomshaper.com/updates/com-sp-page-builder-free.xml', 1, 0, ''),
(9, 'Accredited Joomla! Translations', 'collection', 'http://update.joomla.org/language/translationlist_3.xml', 1, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_update_sites_extensions`
--

CREATE TABLE IF NOT EXISTS `h0qwo_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL DEFAULT '0',
  `extension_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`update_site_id`,`extension_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Links extensions to update sites';

--
-- Дамп данных таблицы `h0qwo_update_sites_extensions`
--

INSERT INTO `h0qwo_update_sites_extensions` (`update_site_id`, `extension_id`) VALUES
(1, 700),
(2, 700),
(3, 802),
(4, 28),
(5, 10001),
(6, 10002),
(7, 10003),
(8, 10004),
(9, 10014);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_usergroups`
--

CREATE TABLE IF NOT EXISTS `h0qwo_usergroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `h0qwo_usergroups`
--

INSERT INTO `h0qwo_usergroups` (`id`, `parent_id`, `lft`, `rgt`, `title`) VALUES
(1, 0, 1, 18, 'Public'),
(2, 1, 8, 15, 'Registered'),
(3, 2, 9, 14, 'Author'),
(4, 3, 10, 13, 'Editor'),
(5, 4, 11, 12, 'Publisher'),
(6, 1, 4, 7, 'Manager'),
(7, 6, 5, 6, 'Administrator'),
(8, 1, 16, 17, 'Super Users'),
(9, 1, 2, 3, 'Guest');

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_users`
--

CREATE TABLE IF NOT EXISTS `h0qwo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT '0' COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Require user to reset password on next login',
  PRIMARY KEY (`id`),
  KEY `idx_name` (`name`(100)),
  KEY `idx_block` (`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=529 ;

--
-- Дамп данных таблицы `h0qwo_users`
--

INSERT INTO `h0qwo_users` (`id`, `name`, `username`, `email`, `password`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`, `lastResetTime`, `resetCount`, `otpKey`, `otep`, `requireReset`) VALUES
(528, 'Super User', 'mixas8383', 'mixas.8383@gmail.com', '$2y$10$E/FoTrDipxB0uAHRGLJ0TOptmrkfUc.OQ/kEmhYGr4ZxSL6oBtS9m', 0, 1, '2016-04-08 13:12:48', '2016-07-14 07:51:06', '0', '', '0000-00-00 00:00:00', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_user_keys`
--

CREATE TABLE IF NOT EXISTS `h0qwo_user_keys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `series` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invalid` tinyint(4) NOT NULL,
  `time` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uastring` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `series` (`series`),
  UNIQUE KEY `series_2` (`series`),
  UNIQUE KEY `series_3` (`series`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_user_notes`
--

CREATE TABLE IF NOT EXISTS `h0qwo_user_notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `catid` int(10) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) unsigned NOT NULL,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_user_profiles`
--

CREATE TABLE IF NOT EXISTS `h0qwo_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Simple user profile storage table';

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_user_usergroup_map`
--

CREATE TABLE IF NOT EXISTS `h0qwo_user_usergroup_map` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `h0qwo_user_usergroup_map`
--

INSERT INTO `h0qwo_user_usergroup_map` (`user_id`, `group_id`) VALUES
(528, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_utf8_conversion`
--

CREATE TABLE IF NOT EXISTS `h0qwo_utf8_conversion` (
  `converted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `h0qwo_utf8_conversion`
--

INSERT INTO `h0qwo_utf8_conversion` (`converted`) VALUES
(2);

-- --------------------------------------------------------

--
-- Структура таблицы `h0qwo_viewlevels`
--

CREATE TABLE IF NOT EXISTS `h0qwo_viewlevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `rules` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `h0qwo_viewlevels`
--

INSERT INTO `h0qwo_viewlevels` (`id`, `title`, `ordering`, `rules`) VALUES
(1, 'Public', 0, '[1]'),
(2, 'Registered', 2, '[6,2,8]'),
(3, 'Special', 3, '[6,3,8]'),
(5, 'Guest', 1, '[9]'),
(6, 'Super Users', 4, '[8]');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
