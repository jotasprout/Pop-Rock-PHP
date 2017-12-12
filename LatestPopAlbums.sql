SELECT
	popAlbums.albumID AS albumID,
	popAlbums.pop AS pop,
	max(popAlbums.date) AS latestDate
FROM popAlbums 
GROUP BY popAlbums.albumID