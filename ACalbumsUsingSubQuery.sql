SELECT a.albumName, a.year, z.artistName
FROM (SELECT
			y.albumID AS albumID,
			y.albumName AS albumName,
			y.artistID AS artistID,
			y.year AS year
		FROM albums y 
        WHERE y.artistID = '3EhbVgyfGd7HkpsagwL9GS') a
JOIN artists z ON z.artistID = '3EhbVgyfGd7HkpsagwL9GS'