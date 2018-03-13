SELECT t.trackID, t.trackName, a.albumName, a.artistID, p1.pop, p1.date
    FROM tracks t
    INNER JOIN albums a ON a.albumID = t.albumID
    JOIN (SELECT p.* FROM popTracks p
            INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
                        FROM popTracks  
                        GROUP BY trackID) groupedp
            ON p.trackID = groupedp.trackID
            AND p.date = groupedp.MaxDate) p1 
    ON t.trackID = p1.trackID
    WHERE a.artistID = '1Qp56T7n950O3EGMsSl81D'
    ORDER BY t.trackName ASC;