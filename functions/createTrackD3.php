<?php

$trackID = $_GET['trackID'];

require_once '../rockdb.php';
//require( "class.artist.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$trackPop = "SELECT t.trackID, t.trackName, a.albumName, a.artistID, p.pop, p.date
						FROM tracks t
						JOIN albums a ON a.albumID = t.albumID
						JOIN popTracks p ON p.trackID = t.trackID
						WHERE t.trackID = '$trackID'
						ORDER BY p.date ASC";

$getit = mysqli_query($connekt, $trackPop);

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