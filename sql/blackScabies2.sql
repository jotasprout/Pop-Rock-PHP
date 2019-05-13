/*
Adding LastFM data worked but without data
*/
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
ON b.albumMBID = f1.albumMBID	
ORDER BY b.albumName ASC;


/*
This gets just MBID LastFM stats
ReplaceLines 53to59 withBelow
*/

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
