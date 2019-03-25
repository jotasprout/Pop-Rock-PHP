<?php

require '../secrets/auth.php';
require_once '../rockdb.php';

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
			$albumName = $album->name;
			$albumReleasedWhole = $album->release_date;
			$albumReleased = substr($albumReleasedWhole, 0, 4);
			$albumTotalTracks = $album->total_tracks;
			$thisArtistID = $album->artists[0]->id;
			$thisArtistName = $album->artists[0]->name;
			$albumPop = $album->popularity;
			$albumArt = $album->images[0]->url;
		
            echo '<p><img src="' . $albumArt . '" height="64" width="64"><br>' . $albumName . '<br>' . $albumReleased . '<br><strong>Popularity:</strong> ' . $albumPop . '<br><strong>Total tracks:</strong> ' . $albumTotalTracks . '</p>';

		}
	};
  
}

function gatherArtistAlbums ($artistID) {
	
    $discogOffset = 0;

    $discography = $GLOBALS['api']->getArtistAlbums($artistID, [
        'limit' => '50',
        'offset' => $discogOffset
    ]);

    $artistAlbumsTotal = intval($discography->total);

    echo "<p>Alice has " . $artistAlbumsTotal . " total albums.</p>";

    $a = ceil($artistAlbumsTotal/50);

    echo "<p>Total albums divided by 50 = " . $a;

    $allAlbumsThisArtist = array ();

    echo "<p>allAlbumsThisArtist array has = " . count($allAlbumsThisArtist);

    for ($p=0; $p<$a; $p++) {
        
        $discogChunk = array ();
        
        echo "<p>Discog Offset = " . $discogOffset . ".</p>";

        echo "<p>discogChunk # " . $p . "has = " . count($discogChunk) . " albums.</p>";

        $discography = $GLOBALS['api']->getArtistAlbums($artistID, [
            'limit' => '50',
            'offset' => $discogOffset,
            'album_type' => ['album', 'compilation']//,
            //'market' => 'US'
        ]);

        foreach ($discography->items as $album) {
            $albumID = $album->id;
            $discogChunk [] = $albumID;
        };

        $allAlbumsThisArtist = array_merge($allAlbumsThisArtist, $discogChunk);
        echo "<p>allAlbumsThisArtist array NOW has = " . count($allAlbumsThisArtist) . " albums.</p>";
        
        $discogOffset += 50;

        unset($discogChunk);
        echo "<p>discogChunk # " . $p . " NOW has = " . count($discogChunk) . " albums.</p>";
    };

    divideCombineAlbums ($allAlbumsThisArtist);
    echo "<p>allAlbumsThisArtist array has = " . count($allAlbumsThisArtist);

    unset($allAlbumsThisArtist);
    echo "<p>At the END, allAlbumsThisArtist array NOW has = " . count($allAlbumsThisArtist) . " albums.</p>";

}


?>