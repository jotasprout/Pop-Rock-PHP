<?php

$artistSpotID = $_GET['artistSpotID'];
//$artistSpotID = '3EhbVgyfGd7HkpsagwL9GS';
require_once '../rockdb.php';
require( "class.artist.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$getLastFM = "SELECT a.artistName, f1.artistListeners, f1.artistPlaycount, f1.dataDate
    FROM (SELECT f.*
			FROM artistsLastFM f
			INNER JOIN (SELECT artistMBID, artistListeners, artistPlaycount, max(dataDate) AS MaxDataDate
						FROM artistsLastFM  
						GROUP BY artistMBID) groupedf
			ON f.artistMBID = groupedf.artistMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	JOIN artists a ON a.artistMBID = f1.artistMBID
    WHERE a.artistSpotID = '$artistSpotID'
	ORDER BY a.artistName ASC";

$getit = mysqli_query($connekt, $getLastFM);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	

if (mysqli_num_rows($getit) > 0) {
    $rows = array();
	while ($row = mysqli_fetch_array($getit)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($connekt);

?>