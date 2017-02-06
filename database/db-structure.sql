-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 06, 2017 at 04:49 PM
-- Server version: 10.2.3-MariaDB-log
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `fanlistings`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cname` varchar(60) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `listings`
--

CREATE TABLE IF NOT EXISTS `listings` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cat` smallint(5) UNSIGNED NOT NULL,
  `url` varchar(60) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `img` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `loggin` varchar(50) NOT NULL,
  `ashes` varchar(255) NOT NULL,
  `passw` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `imgurl` varchar(50) NOT NULL,
  `imgpath` varchar(50) NOT NULL,
  `imgtype` varchar(50) NOT NULL DEFAULT 'nc',
  `linktarget` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
