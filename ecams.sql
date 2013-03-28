-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 14, 2012 at 04:29 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ecams`
--

-- --------------------------------------------------------

--
-- Table structure for table `cdc_downloads`
--

CREATE TABLE IF NOT EXISTS `cdc_downloads` (
  `rid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'row id',
  `bid` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'branch id',
  `yid` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'year id',
  `cid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'category id',
  `uid` bigint(20) NOT NULL DEFAULT '1' COMMENT 'maps downloads to user',
  `filename` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'file on disk',
  `displayname` char(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'display filename',
  `size` int(11) NOT NULL COMMENT 'size of file',
  `date` date NOT NULL COMMENT 'time stamp',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cdc_downloads`
--

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'row id, user table row id',
  `first_name` varchar(80) CHARACTER SET utf8 NOT NULL COMMENT 'user''s first name',
  `last_name` varchar(80) CHARACTER SET utf8 NOT NULL COMMENT 'user''s last name',
  `dob` date NOT NULL COMMENT 'birth day',
  `photo` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'photoplaceholder.jpg' COMMENT 'user''s photo',
  `department` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'department',
  `post` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'post',
  `qualification` varchar(280) CHARACTER SET utf8 NOT NULL COMMENT 'educational qualification',
  `second_email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'second email',
  `phone` char(15) NOT NULL COMMENT 'land line',
  `mobile` char(15) NOT NULL COMMENT 'mobile phone',
  `address` longtext CHARACTER SET utf8 NOT NULL COMMENT 'address',
  `last_edit_date` datetime NOT NULL COMMENT 'the date on which the profile was edited',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='the profiles of the users are stored here. the contacts modu';

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `first_name`, `last_name`, `dob`, `photo`, `department`, `post`, `qualification`, `second_email`, `phone`, `mobile`, `address`, `last_edit_date`) VALUES
(1, 'Admin', '_Admin_', '1990-10-20', '1.jpg', 'Administration', 'Administrator', 'qualification', 'jspreddy@yahoo.com', '23831546', '2147483647', 'CSE\r\nDRKCET,\r\nBowrampet,\r\nHyderabad\r\n.', '2012-03-28 09:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'row id',
  `user_login` varchar(60) CHARACTER SET utf8 NOT NULL COMMENT 'login ID',
  `user_pass` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT 'encrypted password',
  `user_email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'mail id',
  `user_registered_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'registration date',
  `activation_key` varchar(168) CHARACTER SET utf8 NOT NULL COMMENT 'key for the external access to profile',
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT 'user status, active, locked',
  `display_name` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'display name',
  `user_type` int(11) NOT NULL COMMENT 'user type',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='the table contains all the users' AUTO_INCREMENT=100;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_login`, `user_pass`, `user_email`, `user_registered_date`, `activation_key`, `user_status`, `display_name`, `user_type`) VALUES
(1, 'admin', '9bb695980962f137', 'jspreddy@yahoo.com', '2012-01-30 08:13:00', '', 1, 'Administrator', 1),
(13, 'jspreddy', '1a9998f3ccc21bfd', 'jspreddy@yahoo.com', '2012-02-13 10:35:06', '19b37504c67ea35216ae6be2d1d2e102d166aeb8ad356e0c', 1, 'jspreddy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_archive`
--

CREATE TABLE IF NOT EXISTS `user_archive` (
  `id` bigint(20) unsigned NOT NULL COMMENT 'row id, user table row id',
  `user_login` varchar(60) CHARACTER SET utf8 NOT NULL COMMENT 'login ID',
  `user_pass` varchar(64) CHARACTER SET utf8 NOT NULL COMMENT 'encrypted password',
  `user_email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'mail id',
  `user_registered_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'registration date',
  `user_delete_date` datetime NOT NULL COMMENT 'the user''s deletion date',
  `activation_key` varchar(60) CHARACTER SET utf8 NOT NULL COMMENT 'reset key',
  `user_status` int(11) NOT NULL DEFAULT '0' COMMENT 'user status, active, locked',
  `display_name` varchar(250) CHARACTER SET utf8 NOT NULL COMMENT 'display name',
  `user_type` int(11) NOT NULL COMMENT 'user type',
  `first_name` varchar(80) CHARACTER SET utf8 NOT NULL COMMENT 'user''s first name',
  `last_name` varchar(80) CHARACTER SET utf8 NOT NULL COMMENT 'user''s last name',
  `dob` date NOT NULL COMMENT 'birth day',
  `photo` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT 'photoplaceholder.jpg' COMMENT 'user''s photo',
  `department` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'department',
  `post` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'post',
  `qualification` varchar(280) CHARACTER SET utf8 NOT NULL COMMENT 'educational qualification',
  `second_email` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT 'second email',
  `phone` char(15) NOT NULL COMMENT 'land line',
  `mobile` char(15) NOT NULL COMMENT 'mobile phone',
  `address` longtext CHARACTER SET utf8 NOT NULL COMMENT 'address',
  `last_edit_date` datetime NOT NULL COMMENT 'date on which profile was edited',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='the deleted user data is archived here';

--
-- Dumping data for table `user_archive`
--
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
