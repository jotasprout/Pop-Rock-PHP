SELECT a.albumName, a.year, z.artistName, p1.pop, p1.date
FROM (SELECT
			y.albumID AS albumID,
			y.albumName AS albumName,
			y.artistID AS artistID,
			y.year AS year
		FROM albums y 
        WHERE y.artistID = '3EhbVgyfGd7HkpsagwL9GS') a
JOIN artists z ON z.artistID = '3EhbVgyfGd7HkpsagwL9GS'
JOIN (SELECT
	popAlbums.albumID AS albumID,
	popAlbums.pop AS pop,
	popAlbums.date AS date
FROM popAlbums) p1 ON a.albumID = p1.albumID
ORDER BY a.albumID ASC