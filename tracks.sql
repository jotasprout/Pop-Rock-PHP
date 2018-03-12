SELECT a.trackID, a.trackName, a.albumID, b.albumName, b.artistID, b.year, c.pop, d.artistName 
    FROM tracks a
        INNER JOIN albums b ON a.albumID = b.albumID
        INNER JOIN popTracks c ON a.trackID = c.trackID
        INNER JOIN artists d ON b.artistID = d.artistID
            WHERE b.artistID = '5kadFhaVFgdn1J4rX3HqB2' 
            ORDER BY a.trackName ASC;


/* ADAPTED HAPPY SCABIES 2 FOR TRACKS */

SELECT a.albumName, z.artistName, p1.pop, p1.date
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