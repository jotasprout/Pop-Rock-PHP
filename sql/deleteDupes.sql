
SELECT t1.artistSpotID
    FROM albums t1
LEFT JOIN artists t2 ON t1.artistSpotID = t2.artistSpotID
WHERE t2.artistSpotID IS NULL


#################

DELETE a FROM popAlbums a
INNER JOIN popAlbums b
WHERE a.albumSpotID = b.albumSpotID AND a.date = b.date AND a.id < b.id;

# ##############################

DELETE a FROM popArtists a
INNER JOIN popArtists b
WHERE a.artistSpotID = b.artistSpotID AND a.date = b.date AND a.id < b.id;


DELETE a.* FROM albums a
WHERE a.artistSpotID IN ("06nsZ3qSOYZ2hPVIMcr1IN", "0AKXyxpM8OTfV5xlJkWhhh", "0FI0kxP0BWurTz8cB8BBug", "0FRIWJYklnmsll5M6h4gUL", "0yV8woUT2cpAkxkBNfXoin", "1coQ4GcxuazfjZ0MP9JnBF", "1dfUmPiIel95MFXvQMUAED", "1eKucUW0u8DXDBkNCewl0m", "1I5Cu7bqjkRg85idwYsD91", "1nJvji2KIlWSseXRSlNYsC", "1RpIWJHxLsDE8YfFcRaBKw", "1WOIkzm2dYpAqf5FZf5ziQ", "2bmixwMZXlkl2sbIbOfviq", "2Ex4vjQ6mSh5woTlDWto6d", "2ScuQMRWThcifBRIvNDFDC", "375zxMmh2cSgUzFFnva0O7", "3fo31cpxTYmcMT3m4A1RNC", "3rxIQc9kWT6Ueg4BhnOwRK", "3Y8HQ2Val8XhZg7RxyCfqH", "3YowTUlFJJA6E5Yd67GZNv", "43YDeIUqhR3Y5rRPSH6AOt", "4fteWGGNzyj9p8TnMQwcOA", "4kGt8nIQNBkCRusp4sJ3RX", "4kHtgiRnpmFIV5Tm4BIs8l", "55bGuHb50r5c0PeqqMeNBV", "5RNFFojXkPRmlJZIwXeKQC", "69VgCcXFV59QuQWEXSTxfK", "6gABJRqeRV4XW6T8vP9QEn", "6IRouO5mvvfcyxtPDKMYFN", "73ndLgs6jSrpZzjyzU9TJV", "7Hf9AwMO37bSdxHb0FBGmO");


###############

DELETE a FROM popTracks a
INNER JOIN popTracks b
WHERE a.trackSpotID = b.trackSpotID AND a.date = b.date AND a.id < b.id;

############################################################
############################################################
############################################################

DELETE a FROM albumsLastFM a
INNER JOIN albumsLastFM b
WHERE a.albumMBID = b.albumMBID AND a.dataDate = b.dataDate AND a.id < b.id;

###############

DELETE a FROM artistsLastFM a
INNER JOIN artistsLastFM b
WHERE a.artistMBID = b.artistMBID AND a.dataDate = b.dataDate AND a.id < b.id;

###############

DELETE a FROM tracksLastFM a
INNER JOIN tracksLastFM b
WHERE a.trackMBID = b.trackMBID AND a.dataDate = b.dataDate AND a.id < b.id;

############################################################
############################################################
############################################################

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

###############

SELECT count(*) FROM (SELECT * FROM popTracks a
INNER JOIN popTracks b
WHERE a.trackID = b.trackID AND a.date = b.date) pops;