-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2017 at 07:43 AM
-- Server version: 5.5.51-38.2
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jscript_popRock`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `albumID` varchar(48) NOT NULL,
  `albumName` varchar(255) NOT NULL,
  `artistID` varchar(48) NOT NULL,
  `released` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `artistID` varchar(48) NOT NULL,
  `artistName` varchar(72) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artistID`, `artistName`) VALUES
('07XSN3sPlIlB2L2XNcTwJw', 'Kiss'),
('0oSGxfWSnnOXhD2fKuz2Gy', 'David Bowie'),
('1l8grPt6eiOS4YlzjIs0LF', 'Iggy Pop & James Williamsson'),
('33EUXrFKGjpUSGacqEHhU4', 'Iggy Pop'),
('3EhbVgyfGd7HkpsagwL9GS', 'Alice Cooper'),
('3eqjTLE0HfPfh78zjh6TqT', 'Bruce Springsteen'),
('4BFMTELQyWJU1SwqcXMBm3', 'Stooges'),
('74ASZWbe4lXaubB36ztrGX', 'Bob Dylan'),
('7dnB1wSxbYa8CejeVg98hz', 'Meat Loaf');

-- --------------------------------------------------------

--
-- Table structure for table `myTypes`
--

CREATE TABLE IF NOT EXISTS `myTypes` (
  `id` int(12) NOT NULL,
  `myType` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `popAlbums`
--

CREATE TABLE IF NOT EXISTS `popAlbums` (
  `id` int(24) NOT NULL,
  `albumID` varchar(48) NOT NULL,
  `date` date NOT NULL,
  `pop` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `popArtists`
--

CREATE TABLE IF NOT EXISTS `popArtists` (
  `id` int(12) NOT NULL,
  `artistID` varchar(48) NOT NULL,
  `date` date NOT NULL,
  `pop` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `popTracks`
--

CREATE TABLE IF NOT EXISTS `popTracks` (
  `id` int(24) NOT NULL,
  `trackID` varchar(48) NOT NULL,
  `date` date NOT NULL,
  `pop` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE IF NOT EXISTS `tracks` (
  `trackID` varchar(30) NOT NULL,
  `trackName` varchar(255) NOT NULL,
  `albumID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`albumID`), ADD KEY `artistID` (`artistID`), ADD KEY `released` (`released`), ADD KEY `artistID_2` (`artistID`), ADD KEY `artistID_3` (`artistID`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artistID`);

--
-- Indexes for table `myTypes`
--
ALTER TABLE `myTypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popAlbums`
--
ALTER TABLE `popAlbums`
  ADD PRIMARY KEY (`id`), ADD KEY `albumID` (`albumID`,`date`);

--
-- Indexes for table `popArtists`
--
ALTER TABLE `popArtists`
  ADD PRIMARY KEY (`id`), ADD KEY `artistID` (`artistID`,`date`);

--
-- Indexes for table `popTracks`
--
ALTER TABLE `popTracks`
  ADD PRIMARY KEY (`id`), ADD KEY `trackID` (`trackID`,`date`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`trackID`), ADD KEY `albumID` (`albumID`), ADD KEY `albumID_2` (`albumID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `myTypes`
--
ALTER TABLE `myTypes`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `popAlbums`
--
ALTER TABLE `popAlbums`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `popArtists`
--
ALTER TABLE `popArtists`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `popTracks`
--
ALTER TABLE `popTracks`
  MODIFY `id` int(24) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
