# Original 

SELECT a.albumName, a.year, a.albumArt, a.tracksTotal, z.artistName, p1.pop, p1.date, a.albumID, f1.albumMBID, f1.dataDate, f1.albumListeners, f1.albumPlaycount
	FROM (SELECT
				y.albumID AS albumID,
				y.albumMBID AS albumMBID,
				y.albumName AS albumName,
				y.artistID AS artistID,
				y.tracksTotal AS tracksTotal,
				y.albumArt AS albumArt,
				y.year AS year
			FROM albums y 
			WHERE y.artistID = '$artistID') a
	JOIN artists z ON z.artistID = '$artistID'
	JOIN (SELECT p.*
			FROM popAlbums p
			INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
						FROM popAlbums  
						GROUP BY albumID) groupedp
			ON p.albumID = groupedp.albumID
			AND p.date = groupedp.MaxDate) p1 
	ON a.albumID = p1.albumID
	LEFT JOIN (SELECT f.*
			FROM albumsLastFM f
			INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
			FROM albumsLastFM
			GROUP BY albumMBID) groupedf
			ON f.albumMBID = groupedf.albumMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	ON a.albumMBID = f1.albumMBID
	ORDER BY albumName ASC;

# Adding LastFMdata worked but withoutdata

SELECT b.albumName, b.albumMBID, b.albumID, b.artistID, a.year, a.albumArt, a.tracksTotal, z.artistName, p1.pop, p1.date, f1.dataDate, f1.albumListeners, f1.albumPlaycount
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID
	FROM albums sp
	WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ') b 
LEFT JOIN albums a ON b.albumID = a.albumID	
JOIN artists z ON z.artistID = b.artistID
LEFT JOIN (SELECT p.*
		FROM popAlbums p
		INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
					FROM popAlbums  
					GROUP BY albumID) groupedp
		ON p.albumID = groupedp.albumID
		AND p.date = groupedp.MaxDate) p1 
ON a.albumID = p1.albumID
LEFT JOIN (SELECT f.*
		FROM albumsLastFM f
		INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
		FROM albumsLastFM
		GROUP BY albumMBID) groupedf
		ON f.albumMBID = groupedf.albumMBID
		AND f.dataDate = groupedf.MaxDataDate) f1
ON a.albumMBID = f1.albumMBID
ORDER BY b.albumName ASC;


# This gets just MBID LastFM stats
# ReplaceLines 53to59 withBelow
SELECT mb.albumMBID, mb.albumName, f1.albumListeners, f1.albumPlaycount
FROM albumsMB mb 	
LEFT JOIN (SELECT f.*
		FROM albumsLastFM f
		INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
		FROM albumsLastFM
		GROUP BY albumMBID) groupedf
		ON f.albumMBID = groupedf.albumMBID
		AND f.dataDate = groupedf.MaxDataDate) f1
ON mb.albumMBID = f1.albumMBID	
WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ'
ORDER BY mb.albumName ASC;

# Adding spotify popularity WORKS

SELECT b.albumName, b.albumMBID, b.albumID, b.artistID, a.year, a.albumArt, a.tracksTotal, z.artistName, p1.pop, p1.date
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID
	FROM albums sp
	WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ') b 
LEFT JOIN albums a ON b.albumID = a.albumID	
JOIN artists z ON z.artistID = b.artistID
LEFT JOIN (SELECT p.*
		FROM popAlbums p
		INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
					FROM popAlbums  
					GROUP BY albumID) groupedp
		ON p.albumID = groupedp.albumID
		AND p.date = groupedp.MaxDate) p1 
ON a.albumID = p1.albumID
ORDER BY b.albumName ASC;

# Adding artistName fromartiststable works

SELECT b.albumName, b.albumMBID, b.albumID, b.artistID, a.year, a.albumArt, a.tracksTotal, z.artistName
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID
	FROM albums sp
	WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ') b 
LEFT JOIN albums a ON b.albumID = a.albumID	
JOIN artists z ON z.artistID = b.artistID
ORDER BY b.albumName ASC;

# LEFTJOINing albums toget rest of info works

SELECT b.albumName, b.albumMBID, b.albumID, b.artistID, a.year, a.albumArt, a.tracksTotal
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID
	FROM albums sp
	WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ') b 
LEFT JOIN albums a ON b.albumID = a.albumID	
ORDER BY b.albumName ASC;

# Wrappingin aSELECT works

SELECT b.albumName, b.albumMBID, b.albumID, b.artistID
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID
	FROM albums sp
	WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ') b 
ORDER BY b.albumName ASC;

# Below gets all albums

SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID 
	FROM albums sp
	WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ' 
ORDER BY albumName ASC;
