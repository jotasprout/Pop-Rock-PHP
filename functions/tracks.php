<?php

$albumsTracksArrays = array ();

// create function that just grabs a single track to be used with a button

function divideCombineInsertTracksAndPop ($AlbumsTracks) {

	// $totalTracks = count($AlbumsTracks);
	// echo $totalTracks . '<br>';

	// Divide all artist's tracks into chunks of 50
	$tracksChunk = array ();
	$x = ceil((count($AlbumsTracks))/50);

	$firstTrack = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastTrack = 49;
		$tracksChunk = array_slice($AlbumsTracks, $firstTrack, $lastTrack);
		// put chunks of 50 into an array
		$albumsTracksArrays [] = $tracksChunk;
		$firstTrack += 50;
	};

	for ($i=0; $i<(count($albumsTracksArrays)); ++$i) {
				
		$tracksThisTime = count($albumsTracksArrays[$i]);
		// echo $tracksThisTime . '<br>';

		$trackIds = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackIds);
			
		foreach ($bunchoftracks->tracks as $track) {
			
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};			

			$trackID = $track->id;
			$trackAlbumID = $track->album->id;
			$trackAlbumNameYucky = $track->album->name;
			$trackAlbumName = mysqli_real_escape_string($connekt,$trackAlbumNameYucky);
			$trackNameYucky = $track->name;
			$trackName = mysqli_real_escape_string($connekt,$trackNameYucky);
			$trackPop = $track->popularity;
			$thisArtistName = $track->artists[0]->name;
			
			$insertTrackInfo = "INSERT INTO tracks (trackID,trackName,albumID) VALUES('$trackID','$trackName','$trackAlbumID')";
	
			$rockout = $connekt->query($insertTrackInfo);
	
			if(!$rockout){
				echo 'Cursed-Crap. Could not insert "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.<br>';
			}
	
			$insertTrackPop = "INSERT INTO popTracks (trackID,pop,date) VALUES('$trackID','$trackPop', curdate())";
	
			$rockpop = $connekt->query($insertTrackPop);
			
			if(!$rockpop){
				echo 'Confounded-Crap. Could not insert POPULARITY for "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.<br>';
			}
	
			else {
				echo $thisArtistName . "'s album <i>" . $trackAlbumName . "</i>, track " . $trackName . " has pop " . $trackPop . "<br>";
			}
		}
	};
}





function divideCombineTracksAndInsertPop ($allArtistTracks) {

	// Divide all artist's tracks into chunks of 50
	$tracksChunk = array ();
	$x = ceil((count($allArtistTracks))/50);

	$firstTrack = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastTrack = 49;
		$tracksChunk = array_slice($allArtistTracks, $firstTrack, $lastTrack);
		// put chunks of 50 into an array
		$albumsTracksArrays [] = $tracksChunk;
		$firstTrack += 50;
	};

	for ($i=0; $i<(count($albumsTracksArrays)); ++$i) {
				
		$tracksThisTime = count($albumsTracksArrays[$i]);
		// echo $tracksThisTime . '<br>';

		$trackIds = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackIds);
			
		foreach ($bunchoftracks->tracks as $track) {
			
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};			

			$trackID = $track->id;
			$trackAlbumName = $track->album->name;
			$trackName = $track->name;
			$trackPop = $track->popularity;
	
			$insertTrackPop = "INSERT INTO popTracks (trackID,pop,date) VALUES('$trackID','$trackPop',curdate())";
	
			$rockpop = $connekt->query($insertTrackPop);
			
			if(!$rockpop){
				echo 'Confounded-Crap. Could not insert POPULARITY for "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.<br>';
			}
	
			else {
				echo $trackName . " from <i>" . $trackAlbumName . "</i>" . " has pop " . $trackPop . "<br>";
			}
		}
	};
}


?>