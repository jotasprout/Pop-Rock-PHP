SELECT a.albumName, a.year, a.albumArt, z.artistName, p1.pop, p1.date
	FROM (SELECT
				y.albumID AS albumID,
				y.albumName AS albumName,
				y.artistID AS artistID,
				y.albumArt AS albumArt,
				y.year AS year
			FROM albums y 
			WHERE y.artistID = '3EhbVgyfGd7HkpsagwL9GS') a
	JOIN artists z ON z.artistID = '3EhbVgyfGd7HkpsagwL9GS'
	JOIN (SELECT p.*
			FROM popAlbums p
			INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
						FROM popAlbums  
						GROUP BY albumID) groupedp
			ON p.albumID = groupedp.albumID
			AND p.date = groupedp.MaxDate) p1 
	ON a.albumID = p1.albumID
	ORDER BY a.year ASC;