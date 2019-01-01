<?php

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$happyScabies2 = "SELECT a.albumName, a.artistID, a.year, a.albumArt, z.artistName, p1.pop, p1.date
	FROM (SELECT
				y.albumID AS albumID,
				y.albumName AS albumName,
				y.artistID AS artistID,
				y.albumArt AS albumArt,
				y.year AS year
			FROM albums y) a
	JOIN artists z ON z.artistID = a.artistID
	JOIN (SELECT p.*
			FROM popAlbums p
			INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
						FROM popAlbums  
						GROUP BY albumID) groupedp
			ON p.albumID = groupedp.albumID
			AND p.date = groupedp.MaxDate) p1 
	ON a.albumID = p1.albumID
    WHERE a.artistID IN ('0p9uD4WGPHqMicwXm3Kavk', '0t1uzfQspxLvAifZLdmFe2', '5MQsxr7sbsewUTIEEYxauR', '0PGxNwykt4KgnvSnNHVUSZ')
	ORDER BY year ASC;";						

$result = mysqli_query($connekt, $happyScabies2);

if (mysqli_num_rows($result) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($connekt);

?>