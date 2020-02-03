-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 31, 2020 at 12:50 PM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memory`
--
CREATE DATABASE IF NOT EXISTS `memory` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `memory`;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `temps` time NOT NULL,
  `score` int(11) NOT NULL,
  `difficulte` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) NOT NULL,
  `psw` varchar(250) NOT NULL,
  `profilPic` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `pseudo`, `psw`, `profilPic`) VALUES
(1, 'admin', '$2y$10$LWoPbgF9ZtAS8KDU6IInCuhaX.wTvPmyGeEhoiNobSLCBBnI37V06', 'assets/profilPics/1.png'),
(2, 'test', '$2y$10$6pO.i0pb3Q0WCByRxo9OoODu6TFpuhfWrEQ0AWcruBpe4XjBClZAW', 'assets/profilPics/profil8.png'),
(3, 'amar', '$2y$10$pJntiEYxtMj0p38M4lEDHO/nQ6VIvCZwjRUHnGHkl0dLcP1rY3oO6', 'assets/profilPics/profil3.png'),
(4, 'testeur', '$2y$10$nhdGgaIva1q/LmwPsni44uQEi71/ETjq5K/lsnxeo5bLUv9TGsUpi', 'assets/profilPics/profil1.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
