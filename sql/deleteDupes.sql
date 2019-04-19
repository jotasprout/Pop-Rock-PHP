DELETE a FROM popAlbums a
INNER JOIN popAlbums b
WHERE a.albumID = b.albumID AND a.date = b.date AND a.id < b.id;

###############################

DELETE a FROM popArtists a
INNER JOIN popArtists b
WHERE a.artistID = b.artistID AND a.date = b.date AND a.id < b.id;

###############

DELETE a FROM popTracks a
INNER JOIN popTracks b
WHERE a.trackID = b.trackID AND a.date = b.date AND a.id < b.id;

###############

SELECT count(*) FROM (SELECT * FROM popTracks a
INNER JOIN popTracks b
WHERE a.trackID = b.trackID AND a.date = b.date) pops;

##############################

DELETE a FROM albumsLastFM2 a
INNER JOIN albumsLastFM2 b
WHERE a.albumMBID = b.albumMBID AND a.dataDate = b.dataDate AND a.id < b.id;

###############

DELETE a FROM artistsLastFM2 a
INNER JOIN artistsLastFM2 b
WHERE a.artistMBID = b.artistMBID AND a.dataDate = b.dataDate AND a.id < b.id;

###############

DELETE a FROM tracksLastFM2 a
INNER JOIN tracksLastFM2 b
WHERE a.trackMBID = b.trackMBID AND a.dataDate = b.dataDate AND a.id < b.id;

##################

SELECT * FROM `albumsMB` WHERE artistSpotID='5M52tdBnJaKSvOpJGz8mfZ' ORDER BY albumName ASC;

#####################

SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID 
FROM albums sp
WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ' 
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
FROM albumsMB mb 
WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ' AND mb.albumMBID NOT IN (SELECT al.albumMBID FROM albums al)
ORDER BY albumName ASC;

################

SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID 
FROM albums sp
WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
FROM albumsMB mb 
WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ' 
ORDER BY albumName ASC;