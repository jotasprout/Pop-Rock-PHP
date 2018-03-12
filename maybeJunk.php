<?php

$query = "SELECT a.albumID, a.albumName, a.artistID, a.year, b.pop, c.artistName 
FROM albums a
	INNER JOIN popAlbums b ON a.albumID = b.albumID
	INNER JOIN artists c ON a.artistID = c.artistID
		WHERE a.artistID = '$artistID'
			ORDER BY a.year ASC;";

$happyScabies = "SELECT a.albumName, a.year, z.artistName, p1.pop, p1.date
			FROM (SELECT
						y.albumID AS albumID,
						y.albumName AS albumName,
						y.artistID AS artistID,
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
			ORDER BY a.year ASC;";

?>