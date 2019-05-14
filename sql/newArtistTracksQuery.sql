SELECT v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
	FROM (
		SELECT z.trackSpotID, z.trackName, r.albumName, p.date, p.pop
			FROM (
				SELECT t.*, r.albumName, a.artistName
					FROM tracks t
                    INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
                    JOIN artists a ON r.artistSpotID = a.artistSpotID
                    WHERE a.artistSpotID = '$artistSpotID'
			) z
		JOIN popTracks p 
			ON z.trackSpotID = p.trackSpotID					
	) v
	GROUP BY v.trackSpotID


SELECT v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
	FROM (
		SELECT z.trackSpotID, z.trackName, r.albumName, p.date, p.pop
			FROM (
				SELECT t.trackSpotID, t.trackName, t.albumSpotID
					FROM tracks t
					WHERE t.albumSpotID = '$albumSpotID'
			) z
		INNER JOIN albums r 
			ON r.albumSpotID = z.albumSpotID
		JOIN popTracks p 
			ON z.trackSpotID = p.trackSpotID					
	) v
	GROUP BY v.trackSpotID
