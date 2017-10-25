--
-- Create table for `artists`
--

CREATE TABLE IF NOT EXISTS artists (
  artistID varchar(48) NOT NULL,
  artistName varchar(72) NOT NULL,
  PRIMARY KEY (artistID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- inserting Artists
--

INSERT INTO artists (artistID, artistName) VALUES
('07XSN3sPlIlB2L2XNcTwJw', 'Kiss'),
('0oSGxfWSnnOXhD2fKuz2Gy', 'David Bowie'),
('1l8grPt6eiOS4YlzjIs0LF', 'Iggy Pop and James Williamsson'),
('33EUXrFKGjpUSGacqEHhU4', 'Iggy Pop'),
('3EhbVgyfGd7HkpsagwL9GS', 'Alice Cooper'),
('3eqjTLE0HfPfh78zjh6TqT', 'Bruce Springsteen'),
('4BFMTELQyWJU1SwqcXMBm3', 'Stooges'),
('74ASZWbe4lXaubB36ztrGX', 'Bob Dylan'),
('7dnB1wSxbYa8CejeVg98hz', 'Meat Loaf'),
('3lPQ2Fk5JOwGWAF3ORFCqH', 'John Mellencamp'),
('22bE4uQ6baNwSHPVcDxLCe', 'Rolling Stones'),
('2UZMlIwnkgAEDBsw1Rejkn', 'Tom Petty'),
('4tX2TplrkIP4v05BNC903e', 'Tom Petty and the Heartbreakers');
-- --------------------------------------------------------
--
-- Create table `popArtists`
--
CREATE TABLE IF NOT EXISTS `popArtists` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `artistID` varchar(48) NOT NULL,
  `date` date NOT NULL,
  `pop` int(2) NOT NULL,
  PRIMARY KEY (id),
  INDEX (artistID),
  INDEX (date)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS albums (
	albumID varchar(48) NOT NULL UNIQUE,
	albumName varchar(255) NOT NULL,
	artistID varchar(48) NOT NULL,
	year varchar(4) NOT NULL,
	PRIMARY KEY (albumID),
	FOREIGN KEY (artistID) REFERENCES artists (artistID),
	INDEX (year),
	INDEX (artistID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Create table `popAlbums`
--

CREATE TABLE IF NOT EXISTS `popAlbums` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `albumID` varchar(48) NOT NULL,
  `date` date NOT NULL,
  `pop` int(2) NOT NULL,
  PRIMARY KEY (id),
  INDEX (albumID),
  INDEX (date)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Create table `tracks`
--

CREATE TABLE IF NOT EXISTS tracks (
  trackID varchar(30) NOT NULL,
  trackName varchar(255) NOT NULL,
  albumID varchar(30) NOT NULL,
  PRIMARY KEY (trackID),
  FOREIGN KEY (albumID) REFERENCES albums (albumID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
-- 
-- Create table `popTracks`
--
CREATE TABLE IF NOT EXISTS `popTracks` (
  `id` int(24) NOT NULL AUTO_INCREMENT,
  `trackID` varchar(48) NOT NULL,
  `date` date NOT NULL,
  `pop` int(2) NOT NULL,
  PRIMARY KEY (id),
  INDEX (trackID),
  INDEX (date)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Table structure for table `myTypes`
--

CREATE TABLE IF NOT EXISTS `myTypes` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `myType` varchar(6) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;