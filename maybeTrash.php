<?php
function divideCombineAlbumsForArt ($artistAlbums) {
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = 19;
	  $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 20;
	};

	for ($i=0; $i<(count($albumsArrays)); ++$i) {

		$howmanyhere = count($albumsArrays[$i]);
				
		$albumIds = implode(',', $albumsArrays[$i]);
	
		// For each array of albums (20 at a time), "get several albums"
		$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
			
		foreach ($bunchofalbums->albums as $album) {

			$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
			$albumID = $album->id;	
			$albumArt = $album->images[0]->url;
			$albumNameYucky = $album->name;
			$albumName = mysqli_real_escape_string($connekt,$albumNameYucky);
			$albumReleasedWhole = $album->release_date;
			$albumReleased = substr($albumReleasedWhole, 0, 4);
			$thisArtistID = $album->artists[0]->id;
			$thisArtistName = $album->artists[0]->name;
			$albumPop = $album->popularity;

			$insertAlbumArt = "UPDATE albums SET albumArt = '$albumArt' WHERE albumID = '$albumID'";
			
			if (!$connekt) {
				echo 'Darn. Did not connect.<br>';
			};
			
			$rockout = $connekt->query($insertAlbumArt);

			if(!$rockout){
				echo 'Crapola! Could not add album art.<br>';
			}

			$insertAlbumsPop = "INSERT INTO popAlbums (albumID,pop) VALUES('$albumID','$albumPop')";
			
			$rockin = $connekt->query($insertAlbumsPop);
			
			if(!$rockin){
				echo 'Sweet Christmas! Could not insert albums popularity.';
			}
		
            echo $albumName . ' by ' . $thisArtistName . ' released ' . $albumReleased . ' is ' . $albumPop . '<br>';

		}
	};
}

?>