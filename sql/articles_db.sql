-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2015 at 10:07 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `articles_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 58),
(2, 1, NULL, NULL, 'Articles', 2, 23),
(3, 2, NULL, NULL, 'index', 3, 4),
(4, 2, NULL, NULL, 'view', 5, 6),
(5, 2, NULL, NULL, 'add', 7, 8),
(6, 2, NULL, NULL, 'edit', 9, 10),
(7, 2, NULL, NULL, 'delete', 11, 12),
(8, 2, NULL, NULL, 'change_status', 13, 14),
(9, 2, NULL, NULL, 'admin_index', 15, 16),
(10, 2, NULL, NULL, 'admin_edit', 17, 18),
(11, 2, NULL, NULL, 'admin_change_status', 19, 20),
(12, 2, NULL, NULL, 'admin_delete', 21, 22),
(13, 1, NULL, NULL, 'Pages', 24, 27),
(14, 13, NULL, NULL, 'display', 25, 26),
(15, 1, NULL, NULL, 'Users', 28, 55),
(16, 15, NULL, NULL, 'login', 29, 30),
(17, 15, NULL, NULL, 'logout', 31, 32),
(18, 15, NULL, NULL, 'signup', 33, 34),
(19, 15, NULL, NULL, 'forgot_password', 35, 36),
(20, 15, NULL, NULL, 'activate', 37, 38),
(21, 15, NULL, NULL, 'reset_password', 39, 40),
(22, 15, NULL, NULL, 'edit_password', 41, 42),
(23, 15, NULL, NULL, 'admin_index', 43, 44),
(24, 15, NULL, NULL, 'admin_change_status', 45, 46),
(25, 1, NULL, NULL, 'AclExtras', 56, 57),
(26, 15, NULL, NULL, 'initDB', 47, 48),
(27, 15, NULL, NULL, 'admin_delete', 49, 50),
(28, 15, NULL, NULL, 'admin_logout', 51, 52),
(29, 15, NULL, NULL, 'add_balance', 53, 54);

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `foreign_key` int(10) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 1, NULL, 1, 2),
(2, NULL, 'Group', 2, NULL, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) NOT NULL,
  `aco_id` int(10) NOT NULL,
  `_create` varchar(2) NOT NULL DEFAULT '0',
  `_read` varchar(2) NOT NULL DEFAULT '0',
  `_update` varchar(2) NOT NULL DEFAULT '0',
  `_delete` varchar(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ARO_ACO_KEY` (`aro_id`,`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 2, 1, '-1', '-1', '-1', '-1'),
(3, 2, 15, '1', '1', '1', '1'),
(4, 2, 2, '1', '1', '1', '1'),
(5, 2, 11, '-1', '-1', '-1', '-1'),
(6, 2, 12, '-1', '-1', '-1', '-1'),
(7, 2, 9, '-1', '-1', '-1', '-1'),
(8, 2, 10, '-1', '-1', '-1', '-1'),
(9, 2, 24, '-1', '-1', '-1', '-1'),
(10, 2, 27, '-1', '-1', '-1', '-1'),
(11, 2, 23, '-1', '-1', '-1', '-1');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `enabled`, `user_id`, `created`, `modified`) VALUES
(1, 'Ar', 'hhjkhkjhjk hk h kh jkh\r\n\r\njh jkhjkh k\r\n\r\n\r\nh khjkhk kl 1', 1, 2, '2015-12-24 08:09:13', '2015-12-24 09:01:27'),
(4, 'jhk', 'jhk jhkjhkh', 1, 3, '2015-12-24 08:41:32', '2015-12-24 08:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `code` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `balance`, `group_id`, `enabled`, `code`, `created`, `modified`) VALUES
(1, 'Miheretab', 'Alemu', 'admin@gmail.com', '57cbdef7cb0dd703044925574c5584b5f131d145', 0, 1, 1, '0ce2ffd21fc958d9ef0ee9ba5336e357', '2015-12-23 20:25:21', '2015-12-24 08:08:13'),
(2, 'A', 'D', 'aguamit@gmail.com', '57cbdef7cb0dd703044925574c5584b5f131d145', 11.45, 2, 1, '2bb4997e9e7e9f45820e6df11e801f88', '2015-12-24 08:22:50', '2015-12-24 10:06:37'),
(3, 'Miheretab', 'Alemu', 'mihrtab@gmail.com', '57cbdef7cb0dd703044925574c5584b5f131d145', 0, 2, 0, '0ce2ffd21fc958d9ef0ee9ba5336e357', '2015-12-23 20:25:21', '2015-12-24 10:06:37');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
