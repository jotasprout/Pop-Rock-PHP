<?php

$albumID = $_GET['albumID'];

require_once '../rockdb.php';
require( "class.album.php" );

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$albumInfoAll = "SELECT a.artistID, a.artistName, a.artistArt, r.albumID, r.albumName, b.pop, b.date
	FROM albums r
    JOIN artists a ON a.artistID = r.artistID
		INNER JOIN popAlbums b ON a.albumID = b.albumID
			WHERE a.albumID = '$albumID'
				ORDER BY b.date DESC";

$getit = mysqli_query($connekt, $albumInfoAll);

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