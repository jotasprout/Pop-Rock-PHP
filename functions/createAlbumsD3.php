<?php

$artistSpotID = $_GET['artistSpotID'];

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
};

$happyScabies2 = "SELECT a.albumName, a.year, a.albumArtSpot, z.artistName, p1.pop, p1.date
	FROM (SELECT
				y.albumSpotID AS albumSpotID,
				y.albumName AS albumName,
				y.artistSpotID AS artistSpotID,
				y.albumArtSpot AS albumArtSpot,
				y.year AS year
			FROM albums y 
			WHERE y.artistSpotID = '$artistSpotID') a
	JOIN artists z ON z.artistSpotID = '$artistSpotID'
	JOIN (SELECT p.*
			FROM popAlbums p
			INNER JOIN (SELECT albumSpotID, pop, max(date) AS MaxDate
						FROM popAlbums  
						GROUP BY albumSpotID) groupedp
			ON p.albumSpotID = groupedp.albumSpotID
			AND p.date = groupedp.MaxDate) p1 
	ON a.albumSpotID = p1.albumSpotID
	ORDER BY year ASC;";	
	
/*
	$happyScabies3 = "SELECT a.albumName, a.year, a.albumArtSpot, z.artistName, p.pop, p.date
	FROM (SELECT
				y.albumSpotID AS albumSpotID,
				y.albumName AS albumName,
				y.artistSpotID AS artistSpotID,
				y.albumArtSpot AS albumArtSpot,
				y.year AS year
			FROM albums y 
			WHERE y.artistSpotID = '0cc6vw3VN8YlIcvr1v7tBL') a
	JOIN artists z ON z.artistSpotID = a.artistSpotID
	JOIN popAlbums p ON a.albumSpotID = p.albumSpotID
		WHERE p.date = '2019-03-17'
	ORDER BY a.year ASC;";
*/
$result = mysqli_query($connekt, $happyScabies2);

if (mysqli_num_rows($result) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($result)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

else {
	echo "Nope. Nothing to see here. Screwed up like this: " . mysqli_error($result) . "</p>";
}

mysqli_close($connekt);

?>