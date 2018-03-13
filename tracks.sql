SELECT t.trackID, t.trackName, t.albumID, a.albumName, a.artistID, a.year, p.pop, r.artistName 
    FROM tracks t
        INNER JOIN albums a ON t.albumID = a.albumID
        INNER JOIN popTracks p ON t.trackID = p.trackID
        INNER JOIN artists r ON a.artistID = r.artistID
            WHERE a.artistID = '5kadFhaVFgdn1J4rX3HqB2' 
            ORDER BY t.trackName ASC;

/* ADAPTED HAPPY SCABIES 2 FOR TRACKS 
t = tracks
a = albums
r = artists (rockstars)
p = popularity
*/

SELECT t.trackID, t.trackName, t.albumName, a.artistID, p1.pop, p1.date
    FROM tracks t
    INNER JOIN albums a ON a.albumID = t.albumID
    JOIN (SELECT p.* FROM popTracks p
            INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
                        FROM popTracks  
                        GROUP BY trackID) groupedp
            ON p.trackID = groupedp.trackID
            AND p.date = groupedp.MaxDate) p1 
    ON t.trackID = p1.trackID
    WHERE a.artistID = '$artistID'
    ORDER BY t.trackName ASC;

/* ORIGINAL WORKING ALBUM QUERY -- HAPPY SCABIES 2 */

SELECT a.albumName, a.year, a.albumArt, z.artistName, p1.pop, p1.date
    FROM (SELECT
                y.albumID AS albumID,
                y.albumName AS albumName,
                y.artistID AS artistID,
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
    ORDER BY a.year ASC;

/* THIS ORIGINAL WORKS SHOWING ALL TRACKS FROM ALL DATES */

SELECT a.trackID, a.trackName, a.albumID, b.albumName, b.artistID, b.year, c.pop, d.artistName 
    FROM tracks a
        INNER JOIN albums b ON a.albumID = b.albumID
        INNER JOIN popTracks c ON a.trackID = c.trackID
        INNER JOIN artists d ON b.artistID = d.artistID
            WHERE b.artistID = '5kadFhaVFgdn1J4rX3HqB2' 
            ORDER BY a.trackName ASC;