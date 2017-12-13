<?php

require_once 'rockdb.php';

function artistsD3 () {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
	$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
		ORDER BY a.artistName ASC";

	$artistInfoRecent = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
				WHERE b.date = (select max(b2.date)
								FROM popArtists b2)
		ORDER BY b.pop ASC";

	$jsonData = array ();

	$getit = $connekt->query($artistInfoRecent);

	for ($row = mysqli_fetch_array($getit)) {
		$jsonData[] = mysqli_fetch_assoc($getit);
	}

	echo json_encode($jsonData);
}

artistsD3();

?>