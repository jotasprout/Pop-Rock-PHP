<?php

require ("class.artist.php");
require_once 'rockdb.php';

function divideCombineArtists ($allArtists) {
	
	$totalTracks = count($allArtists);

	// Divide all artists into chunks of 50
	$artistsChunk = array ();
	$x = ceil((count($allArtists))/50);

	$firstArtist = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastArtist = 49;
		$artistsChunk = array_slice($allArtists, $firstArtist, $lastArtist);
		// put chunks of 50 into an array
		$artistsArrays [] = $artistsChunk;
		$firstArtist += 50;
	};

	for ($i=0; $i<(count($artistsArrays)); ++$i) {
				
		$artistsThisTime = count($artistsArrays[$i]);

		$artistIds = implode(',', $artistsArrays[$i]);

		// For each array of artists (50 at a time), "get several artists"
		$bunchofartists = $GLOBALS['api']->getArtists($artistIds);
			
		foreach ($bunchofartists->artists as $artist) {
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			$artistID = $artist->id;
			$artistNameYucky = $artist->name;
			$artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
			$artistPop = $artist->popularity;
			$insertArtistsInfo = "INSERT INTO artists (artistID,artistName) VALUES('$artistID','$artistName')";
			$rockout = $connekt->query($insertArtistsInfo);
			if(!$rockout){
				echo 'Cursed-Crap. Could not insert artists.';
			}
	
			$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";
			$rockpop = $connekt->query($insertArtistsPop);
			if(!$rockpop){
				echo 'Cursed-Crap. Could not insert artists popularity.';
			}
	
			else {
				echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';
			}
			
		}
	};	
}

function inserttArtistsAndPop ($artistsToInsert) {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsToInsert);

	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistNameYucky = $artist->name;
		$artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
		$artistPop = $artist->popularity;

		$insertArtistsInfo = "INSERT INTO artists (artistID,artistName) VALUES('$artistID','$artistName')";

		if (!$connekt) {
			echo 'Darn. Did not connect.';
		};

		$rockout = $connekt->query($insertArtistsInfo);

		if(!$rockout){
			echo 'Cursed-Crap. Could not insert artists.';
		}

		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";

		$rockpop = $connekt->query($insertArtistsPop);
		
		if(!$rockpop){
			echo 'Cursed-Crap. Could not insert artists popularity.';
		}

		else {
			echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';
		}

	}

	// When attempt is complete, connection closes
	mysqli_close($connekt);

}

function getArtistsPopCron ($artists) {
	
	$artistsIds = implode(',', $artists);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsIds);

	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistName = $artist->name;
		$artistPop = $artist->popularity;

		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";

		$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

		$rockout = $connekt->query($insertArtistsPop);

		// When attempt is complete, connection closes
		mysqli_close($connekt);

	}

}

function getArtistsPop ($artists) {
				
	$artistsIds = implode(',', $artists);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsIds);
		
	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistName = $artist->name;
		$artistPop = $artist->popularity;
		
		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";
		
		$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
		
		if (!$connekt) {
			echo 'Darn. Did not connect.';
		};
		
		$rockout = $connekt->query($insertArtistsPop);
		
		if(!$rockout){
			echo 'Cursed-Crap. Could not insert artists popularity.';
		}
	
		echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';

		// When attempt is complete, connection closes
		mysqli_close($connekt);

	}	
}

function getArtistsAndPop ($artists) {
	
	$artistsIds = implode(',', $artists);

	$bunchofartists = $GLOBALS['api']->getArtists($artistsIds);

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	foreach ($bunchofartists->artists as $artist) {

		$artistID = $artist->id;
		$artistName = $artist->name;
		$artistPop = $artist->popularity;

		$insertArtistsPop = "INSERT INTO popArtists (artistID,pop) VALUES('$artistID','$artistPop')";

		if (!$connekt) {
			echo 'Darn. Did not connect.';
		};

		$rockout = $connekt->query($insertArtistsPop);

		if(!$rockout){
			echo 'Cursed-Crap. Could not insert artists popularity.';
		}

		echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td></tr>';

	}

	// When attempt is complete, connection closes
	mysqli_close($connekt);

}

function showArtists () {

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
		ORDER BY b.pop DESC";

	$getit = $connekt->query($artistInfoRecent);

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

function showThisArtist ($artistID) {
	
	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

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