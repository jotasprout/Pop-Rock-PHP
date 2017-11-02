<?php

  $albumsTracksArrays = array ();
  
  function divideCombineTracks ($AlbumsTracks) {
	
	// Divide all artist's albums into chunks of 20
	$tracksChunk = array ();
	$x = ceil((count($AlbumsTracks))/50);

	$firstTrack = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastTrack = $firstTrack + 49;
      $tracksChunk = array_slice($AlbumsTracks, $firstTrack, $lastTrack);
	  // put chunks of 20 into an array
      $albumsTracksArrays [] = $tracksChunk;
      $firstTrack += 49;
	};

	for ($i=0; $i<(count($albumsTracksArrays)); ++$i) {
				
			$trackIds = implode(',', $albumsTracksArrays[$i]);
		
			// For each array of albums (20 at a time), "get several albums"
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



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>