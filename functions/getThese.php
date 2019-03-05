<?php

include '../page_pieces/sesh.php';
require_once '../secrets/auth.php';
require_once '../rockdb.php';

$AlbumsTracks = array();
	
$albumID = '74QNc1Vo0PshHAkQu3K9sI';
			
$thisAlbumTracks = $GLOBALS['api']->getAlbumTracks($albumID);

foreach ($thisAlbumTracks->items as $track) {
    // Get each trackID for requesting Full Track Object with popularity
    $trackID = $track->id;
    // Put trackIDs in array for requesting several at a time (far fewer requests)
    $AlbumsTracks [] = $trackID;
}


function divideCombineInsertTracksAndPop ($AlbumsTracks) {

	$totalTracks = count($AlbumsTracks);
	echo $totalTracks . '<br>';

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
		echo $tracksThisTime . '<br>';

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
	
			$insertTrackPop = "INSERT INTO popTracks (trackID,pop) VALUES('$trackID','$trackPop')";
	
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

divideCombineInsertTracksAndPop ($AlbumsTracks);

?>