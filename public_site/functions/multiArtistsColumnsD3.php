<?php

require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

// Rock en Espanol

$artistInfoRecentWithArt = "SELECT a.artistSpotID AS artistSpotID, a.artistArt AS artistArt, a.artistNameSpot AS artistNameSpot, p1.pop AS pop, p1.date AS date
    FROM artistsSpot a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistSpotID) groupedp
			ON p.artistSpotID = groupedp.artistSpotID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistSpotID = p1.artistSpotID
	WHERE a.artistSpotID IN ('6ZLTlhejhndI4Rh53vYhrY', '4UjiBRkTw9VmvDZiJZKPJ7', '4CYeVo5iZbtYGBN4Isc3n6', '5M52tdBnJaKSvOpJGz8mfZ', '6SLAMfhOi7UJI0fMztaK0m')    
    ORDER BY a.artistNameSpot ASC";
    

$result = mysqli_query($connekt, $artistInfoRecentWithArt);

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