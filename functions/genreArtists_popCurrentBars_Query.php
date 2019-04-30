<?php

require_once '../rockdb.php';
require( "class.artist.php" );

$artistGenre = $_GET['artistGenre'];

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$genreArtistsRecentWithArt = "SELECT a.artistSpotID AS artistSpotID, a.artistArt AS artistArt, a.artistName AS artistName, g.genre AS genre, p1.pop AS pop, p1.date AS date
    FROM artists a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistSpotID) groupedp
			ON p.artistSpotID = groupedp.artistSpotID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistSpotID = p1.artistSpotID
	JOIN genres g ON a.artistSpotID = g.artistSpotID WHERE g.genre = '$artistGenre'   
    ORDER BY a.artistName ASC";
    
$result = mysqli_query($connekt, $genreArtistsRecentWithArt);

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