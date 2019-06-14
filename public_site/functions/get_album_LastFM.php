<?php

$albumSpotID = $_GET['albumSpotID'];
require_once '../rockdb.php';
require( "class.album.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$getLastFM = "SELECT z.artistName, a.albumName, f1.albumListeners, f1.albumPlaycount, f1.dataDate
    FROM (SELECT f.*
			FROM albumsLastFM f
			INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
						FROM albumsLastFM  
						GROUP BY albumMBID) groupedf
			ON f.albumMBID = groupedf.albumMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	JOIN albums a ON a.albumMBID = f1.albumMBID
    JOIN artists z ON a.artistSpotID = z.artistSpotID
    WHERE a.albumSpotID = '$albumSpotID'
	ORDER BY a.albumName ASC";

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