-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2013 at 07:23 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `friendlab`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatar`
--

CREATE TABLE IF NOT EXISTS `avatar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gold` int(11) NOT NULL,
  `hungry` int(11) NOT NULL,
  `energy` int(11) NOT NULL,
  `clean` int(11) NOT NULL,
  `edit` bigint(11) DEFAULT NULL,
  `sleep` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` int(11) NOT NULL,
  `pic` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1475945682 ;

--
-- Dumping data for table `avatar`
--

INSERT INTO `avatar` (`id`, `gold`, `hungry`, `energy`, `clean`, `edit`, `sleep`, `avatar`, `pic`) VALUES
(0, 240, 100, 55, 95, 1368784347796, 1, 1, 1289503018),
(1475945681, 130, 70, 70, 70, 1369052394781, 0, 2, 1289503018);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
