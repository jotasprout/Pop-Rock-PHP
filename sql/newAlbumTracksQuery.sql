/* 
That worked dope, now I'll add the album name
*/



/* 
Get trackName, trackSpotID, albumName
*/

SELECT t.trackSpotID, t.trackName, r.albumName
FROM tracks t
INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
WHERE t.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'



/* 
trying this
*/
SELECT z.trackName 
FROM (
	SELECT t.trackSpotID, t.trackName
	FROM tracks t
	WHERE t.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'
) z

/* 
That worked great so adding unfiltered popularity
*/
SELECT z.trackName, p.date, p.pop
FROM (
	SELECT t.trackSpotID, t.trackName
	FROM tracks t
	WHERE t.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'
) z
JOIN popTracks p ON z.trackSpotID = p.trackSpotID
ORDER BY z.trackName ASC, p.date DESC

/* 
That worked swell, maybe I'll try filtering results to most current date AND IT WORKS AND FAST!
*/
SELECT z.trackName, p1.date, p1.pop
	FROM (
		SELECT t.trackSpotID, t.trackName
		FROM tracks t
		WHERE t.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'
	) z
	JOIN (SELECT p.* FROM popTracks p
		INNER JOIN (SELECT p2.trackSpotID, p2.pop, max(p2.date) AS MaxDate
					FROM popTracks p2
					JOIN tracks t1 ON t1.trackSpotID = p2.trackSpotID
					WHERE t1.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'  
					GROUP BY t1.trackSpotID) groupedp
		ON p.trackSpotID = groupedp.trackSpotID
		AND p.date = groupedp.MaxDate) p1 
ON z.trackSpotID = p1.trackSpotID
ORDER BY z.trackName ASC, p1.date DESC
/* 
Cutting lastFM stuff from current query - Also works AND also really super slow
*/

SELECT t.trackSpotID, t.trackName, a.albumName, a.artistSpotID, p1.pop, p1.date
FROM tracks t
INNER JOIN albums a ON a.albumSpotID = t.albumSpotID
JOIN (SELECT p.* FROM popTracks p
		INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
					FROM popTracks  
					GROUP BY trackSpotID) groupedp
		ON p.trackSpotID = groupedp.trackSpotID
		AND p.date = groupedp.MaxDate) p1 
ON t.trackSpotID = p1.trackSpotID
WHERE a.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'
ORDER BY p1.pop DESC;


/* 
Next one works but it is really super slow
*/

SELECT groupedp.trackSpotID, groupedp.pop, groupedp.MaxDate, t1.trackName
FROM (SELECT p0.trackSpotID, p0.pop, max(p0.date) AS MaxDate
FROM popTracks p0 
GROUP BY p0.trackSpotID) groupedp
JOIN tracks t1
ON groupedp.trackSpotID = t1.trackSpotID
WHERE t1.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'


/* 
Adding current popularity DOES NOT WORK
*/
SELECT t.trackSpotID, t.trackName, r.albumName, p1.pop
FROM tracks t
INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
JOIN (SELECT p.* FROM popTracks p
	 INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
				FROM popTracks
				GROUP BY trackSpotID) groupedp
	 ON p.trackSpotID = groupedp.trackSpotID
	 AND p.date = groupedp.MaxDate) p1
ON t.trackSpotID = p1.trackSpotID
WHERE t.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'

