CREATE DATABASE listeners;

GRANT PRIVILEGES ON listeners TO 'username'@'hostname' IDENTIFIED BY 'password';

CREATE TABLE listenersArtists (
    artistMBID VARCHAR(128),
    artistID FOREIGNKEY,
    datefetched DATE,
    listeners INT,
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    INDEX(artistMBID))
    ENGINE MyISAM;
)