<?php

$albumsTracksArrays = array ();

function divideCombineTracks ($AlbumsTracks) {

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
				
		$trackIds = implode(',', $albumsTracksArrays[$i]);

		// For each array of tracks (50 at a time), "get several tracks"
		$bunchoftracks = $GLOBALS['api']->getTracks($trackIds);
			
		foreach ($bunchoftracks->tracks as $track) {

			$trackID = $track->id;
			$trackAlbumName = $track->album->name;
			$trackName = $track->name;
			$trackPop = $track->popularity;
			echo '<tr><td>' . $trackAlbumName . '</td><td>' . $trackName . '</td><td>' . $trackPop . '</td></tr>';
		}
	};
  
}

?>