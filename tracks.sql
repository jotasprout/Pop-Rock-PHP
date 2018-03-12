SELECT a.trackID, a.trackName, a.albumID, b.albumName, b.artistID, b.year, c.pop, d.artistName 
    FROM tracks a
        INNER JOIN albums b ON a.albumID = b.albumID
        INNER JOIN popTracks c ON a.trackID = c.trackID
        INNER JOIN artists d ON b.artistID = d.artistID
            WHERE b.artistID = '5kadFhaVFgdn1J4rX3HqB2' 
            ORDER BY a.trackName ASC;