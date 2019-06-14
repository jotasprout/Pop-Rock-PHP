<?php

$albumsTracksArrays = array ();

// create function that just grabs a single track to be used with a button

// I don't think the first one gets used so I'm commenting it out until either something breaks or I delete it

/*
function divideCombineInsertTracksAndPop ($AlbumsTracks) {

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

		$trackSpotIDs = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackSpotIDs);
			
		foreach ($bunchoftracks->tracks as $track) {
			
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};			

			$trackSpotID = $track->id;
			$trackalbumSpotID = $track->album->id;
			$trackAlbumNameYucky = $track->album->name;
			$trackAlbumName = mysqli_real_escape_string($connekt,$trackAlbumNameYucky);
			$trackNameYucky = $track->name;
			$trackName = mysqli_real_escape_string($connekt,$trackNameYucky);
			$trackPop = $track->popularity;
			$thisArtistName = $track->artists[0]->name;
			
			$insertTrackInfo = "INSERT INTO tracks (trackSpotID,trackName,albumSpotID) VALUES('$trackSpotID','$trackName','$trackalbumSpotID')";
	
			$rockout = $connekt->query($insertTrackInfo);
	
			if(!$rockout){
				echo '<p>Cursed-Crap. Could not insert "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.</p>';
			}
	
			$insertTrackPop = "INSERT INTO popTracks (trackSpotID,pop,date) VALUES('$trackSpotID','$trackPop', curdate())";
	
			$rockpop = $connekt->query($insertTrackPop);
			
			if(!$rockpop){
				echo '<p>Confounded-Crap. Could not insert POPULARITY for "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.</p>';
			}
	
			else {
				echo "<p>" . $thisArtistName . "'s album <i>" . $trackAlbumName . "</i>, track " . $trackName . " has pop " . $trackPop . "</p>";
			}
		}
	};
}
*/

function divideCombineTracksAndInsertPop ($allArtistTracks) {

	$thisMany4 = ceil(count($allArtistTracks));

	echo "I have gathered " . $thisMany4 . " tracks from this artist.";
	
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

		$trackSpotIDs = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackSpotIDs);
			
		foreach ($bunchoftracks->tracks as $track) {
			
			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
			
			if (!$connekt) {
				echo 'Darn. Did not connect.';
			};			

			$trackSpotID = $track->id;
			$trackAlbumName = $track->album->name;
			$trackName = $track->name;
			$trackPop = $track->popularity;
	
			$insertTrackPop = "INSERT INTO popTracks (trackSpotID,pop,date) VALUES('$trackSpotID','$trackPop',curdate())";
	
			$rockpop = $connekt->query($insertTrackPop);
			
			if(!$rockpop){
				echo '<p>Confounded-Crap. Could not insert POPULARITY for "' . $trackName . '" from <i>' . $trackAlbumName . '</i>.</p>';
			}
	
			else {
				echo "<p>" . $trackName . " from <i>" . $trackAlbumName . "</i>" . " has pop " . $trackPop . "</p>";
			}
		}
	};
}


?>