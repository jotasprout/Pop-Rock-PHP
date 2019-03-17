<?php

require ("class.artist.php");

function updateArtistAlbumsTotal($artistID, $artistAlbumsTotal){

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	$artistID = $artistID;
	$artistAlbumsTotal = $artistAlbumsTotal;

	$updateArtistsTableAlbumsTotal = "UPDATE artists SET artistAlbumsTotal $artistAlbumsTotal WHERE artistID = $artistID";

	$albumsTote = $connekt->query($updateArtistsTableAlbumsTotal);
	
	if(!$albumsTote){
		echo 'Cursed-Crap. Could not insert albums total.';
	}

	else {
		echo '<tr><td>' . $artistName . ' has </td><td>' . $artistAlbumsTotal . ' total albums</td></tr>';
	} 
};


function divideCombineArtists ($theseArtists) {
	
	$totalArtists = count($theseArtists);

	// Divide all artists into chunks of 50
	$artistsChunk = array ();
	$x = ceil((count($theseArtists))/50);

	$firstArtist = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastArtist = 49;
		$artistsChunk = array_slice($theseArtists, $firstArtist, $lastArtist);
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
			if(!$connekt){
				echo 'Fiddlesticks! Could not connect to database.<br>';
			}
			$artistID = $artist->id;
			$artistNameYucky = $artist->name;
			$artistName = mysqli_real_escape_string($connekt,$artistNameYucky);
			$artistArt = $artist->images[0]->url;
			$artistPop = $artist->popularity;
			$artistFollowers = $artist->followers->total;
			$jsonArtistGenres = $artist->genres;

			$insertArtistsInfo = "INSERT INTO artists (artistID, artistName, artistArt) VALUES('$artistID','$artistName', '$artistArt')";

			$rockout = $connekt->query($insertArtistsInfo);

			if(!$rockout){
			echo 'Cursed-Crap. Could not insert artist ' . $artistName . '.<br>';
			}
	
			$insertArtistsPop = "INSERT INTO popArtists (artistID,pop,followers,date) VALUES('$artistID','$artistPop','$artistFollowers',curdate())";

			$rockpop = $connekt->query($insertArtistsPop);
			if(!$rockpop){
				echo '<p>Cursed-Crap. Could not insert artists popularity & followers.</p>';
			}
	
			else {
				echo '<p><img src="' . $artistArt . '"><br>' . $artistName . '<br><b>Population:</b> ' . $artistPop . '<br><b>Followers:</b> ' . $artistFollowers . '</p>';
			} 
			
		}
	};	
}

?>