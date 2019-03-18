<?php

require '../secrets/auth.php';
require_once '../rockdb.php';
require_once '../functions/albums.php';
require '../functions/artists.php';
require '../data_text/artists_arrays.php';

function insertTotalAlbums ($theseArtists) {

	// Divide all artists into chunks of 50
	$artistsChunk = array ();
	$x = ceil((count($theseArtists))/50);

	$firstArtist = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastArtist = 49;
		$artistsChunk = array_slice($theseArtists, $firstArtist, $lastArtist);
		// put chunks of 50 into an array
		$artistsArraysArray [] = $artistsChunk;
		$firstArtist += 50;
	};

	for ($i=0; $i<(count($artistsArraysArray)); ++$i) {
		$artistsIds = implode(',', $artistsArraysArray[$i]);
		$artistsArray = $artistsArraysArray[$i];
			
		for ($j=0; $j<(count($artistsArray)); ++$j) {

			$artistID = $artistsArray[$j];

			$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
				'limit' => '50'
			]);
			
            $artistAlbumsTotal = $discography->total;
            //$artistAlbumsTotalInt = intval($artistAlbumsTotalString);
            
            echo ("<p>Artist " . $artistID . " has " . $artistAlbumsTotal . " total albums.</p>");

            $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
    
            if(!$connekt){
                echo '<p>Dangit! No connektion!</p>';
            } else { 
                echo '<p>Yay! I am connekted.';
        
                $update = "UPDATE artists SET albumsTotal = '$artistAlbumsTotal' WHERE artistID = '$artistID'";
            
                $albumsTote = $connekt->query($update);
                
                if(!$albumsTote){
                    echo '<p>Cursed-Crap. Could not insert albums total.</p>';
                }
            
                else {
                    echo '<p>Inserted ' . $artistAlbumsTotal . ' total albums for ' . $artistID . '.</p>';
                } 
            };
		}
	};	
}

insertTotalAlbums ($allArtists);

?>