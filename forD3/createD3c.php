<?php

include '../sesh.php';
$artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;
require_once '../rockdb.php';
require( "../class.artist.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
	FROM artists a
		INNER JOIN popArtists b ON a.artistID = b.artistID
			WHERE a.artistID = '$artistID'
				ORDER BY b.date DESC";

$getit = $connekt->query($artistInfoAll);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	

function consoleLog ($getit) {
	echo '<script>';
	echo 'console.log('. json_encode($getit) .')';
	echo '</script>';
}

if (mysqli_num_rows($getit) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($getit)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}

while ($row = mysqli_fetch_array($getit)) {
    $artistName = $row["artistName"];
    $artistPop = $row["pop"];
    $popDate = $row["date"];
    $popDateShort = substr($popDate, 0, 10);
} // end of while

else {
	echo "Nope. Nothing to see here.";
}

mysqli_close($connekt);

?>