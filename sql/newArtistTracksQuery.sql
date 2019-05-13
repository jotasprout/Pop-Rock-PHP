/*
Based on #1 Original below. Trying to make it all tracks for an artist.
*/
SELECT v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
	FROM (
		SELECT z.trackSpotID, z.trackName, r.albumName, p.date, p.pop
			FROM (
				SELECT t.*, r.albumName, a.artistName
					FROM tracks t
                    INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
                    JOIN artists a ON r.artistSpotID = a.artistSpotID
                    WHERE a.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
			) z
		JOIN popTracks p 
			ON z.trackSpotID = p.trackSpotID					
	) v
	GROUP BY v.trackSpotID


/*
#1 ORIGINAL #1 - Spotify version filtered to current day -- HOLY SHIT IT'S FAST TOO!
*/
SELECT v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
	FROM (
		SELECT z.trackSpotID, z.trackName, r.albumName, p.date, p.pop
			FROM (
				SELECT t.trackSpotID, t.trackName, t.albumSpotID
					FROM tracks t
					WHERE t.albumSpotID = '6AOClmLV3vaZ83kjqXtwrq'
			) z
		INNER JOIN albums r 
			ON r.albumSpotID = z.albumSpotID
		JOIN popTracks p 
			ON z.trackSpotID = p.trackSpotID					
	) v
	GROUP BY v.trackSpotID
