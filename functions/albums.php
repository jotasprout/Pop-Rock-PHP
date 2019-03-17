<?php

$artistAlbums = array ();

require_once '../rockdb.php';

function divideCombineAlbumsForTracks ($artistAlbums) {

	$albumsArrays = array ();
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = 19;
      $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 20;
	};

	for ($i=0; $i<(count($albumsArrays)); ++$i) {
				
		$albumIds = implode(',', $albumsArrays[$i]);
	
		// For each array of albums (20 at a time), "get several albums"
		$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
			
		foreach ($bunchofalbums->albums as $album) {

			$AlbumsTracks = array();
	
			$albumID = $album->id;
			
			$thisAlbumTracks = $GLOBALS['api']->getAlbumTracks($albumID);

			// should be method in albums class
			foreach ($thisAlbumTracks->items as $track) {
				
				// Get each trackID for requesting Full Track Object with popularity
				$trackID = $track->id;
				
				// Put trackIDs in array for requesting several at a time (far fewer requests)
				$AlbumsTracks [] = $trackID;
				
			}

			divideCombineInsertTracksAndPop ($AlbumsTracks);

			unset($AlbumsTracks);
			
		}
	};
}

function divideCombineAlbums ($artistAlbums) {
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = 19;
	  $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 20;
	};

	for ($i=0; $i<(count($albumsArrays)); ++$i) {
				
		$albumIds = implode(',', $albumsArrays[$i]);
	
		// For each array of albums (20 at a time), "get several albums"
		$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
			
		foreach ($bunchofalbums->albums as $album) {

			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
			$albumID = $album->id;	
			$albumNameYucky = $album->name;
			$albumName = mysqli_real_escape_string($connekt,$albumNameYucky);
			$albumReleasedWhole = $album->release_date;
			$albumReleased = substr($albumReleasedWhole, 0, 4);
			$albumTotalTracks = $album->total_tracks;
			$thisArtistID = $album->artists[0]->id;
			$thisArtistName = $album->artists[0]->name;
			$albumPop = $album->popularity;
			$albumArt = $album->images[0]->url;

			$insertAlbums = "INSERT INTO albums (albumID,albumName,artistID,year,albumArt) VALUES('$albumID','$albumName','$thisArtistID','$albumReleased','$albumTotalTracks','$albumArt')";
			
			if (!$connekt) {
				echo 'Darn. Did not connect.<br>';
			};
			
			$rockout = $connekt->query($insertAlbums);

			if(!$rockout){
				echo '<p>Crap de General Tsao! Could not insert ' . $albumName . '.</p>';
			}

			$insertAlbumsPop = "INSERT INTO popAlbums (albumID,pop,date) VALUES('$albumID','$albumPop',curdate())";

			$rockin = $connekt->query($insertAlbumsPop);
			
			if(!$rockin){
				echo 'Sweet & Sour Crap! Could not insert albums popularity.';
			}
		
            echo '<p><img src="' . $albumArt . '" height="64" width="64"><br>' . $albumName . '<br>' . $albumReleased . '<br>Pop is ' . $albumPop . '<br>Total tracks: ' . $albumTotalTracks . '</p>';

		}
	};
  
}

?>