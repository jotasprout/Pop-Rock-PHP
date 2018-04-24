<?php

require_once 'rockdb.php';

function showThisArtist ($artistID) {
	
	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$findDupes = "	SELECT * FROM popArtists 
					WHERE artistID = '6kACVPfCOnqzgfEF5ryl0x' 
					AND DATE(date) = '2017-12-13'";

	$dupeyDupes = "	SELECT id, artistID, date, pop, COUNT(DATE(date)) dupeDate
					FROM popArtists 
					WHERE artistID = "6kACVPfCOnqzgfEF5ryl0x" 
					GROUP BY DATE(date)
					HAVING dupeDate >1";

	$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
				WHERE a.artistID = '$artistID'
					ORDER BY b.date ASC";

	$getit = $connekt->query($artistInfoAll);

	if (!$connekt) {
		echo 'Darn. Did not connect.';
	};	

	if(!$getit){
		echo 'Cursed-Crap. Did not run the query.';
	}	

	while ($row = mysqli_fetch_array($getit)) {
		// $artistID = $row["artistID"];
		$artistName = $row["artistName"];
		$artistPop = $row["pop"];
		$popDate = $row["date"];
		
		echo "<tr>";
		echo "<td>" . $artistName . "</td>";
		echo "<td>" . $artistPop . "</td>";
		echo "<td>" . $popDate . "</td>";
		echo "</tr>";
	} 
}


?>