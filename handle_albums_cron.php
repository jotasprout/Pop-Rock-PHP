<?php

session_start();
require 'auth.php';
require_once 'rockdb.php';
// require_once 'albums.php';
require 'artists.php';
require 'artists_arrays_objects.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

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
		
            echo $albumName . ' released ' . $albumReleased . ' is ' . $albumPop . '<br>';

		}
	};
}

function divideCombineArtistsForAlbums ($allArtists) {

	// Divide all artists into chunks of 50
	$artistsChunk = array ();
	$x = ceil((count($allArtists))/50);

	$firstArtist = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastArtist = 49;
		$artistsChunk = array_slice($allArtists, $firstArtist, $lastArtist);
		// put chunks of 50 into an array
		$artistsArraysArray [] = $artistsChunk;
		$firstArtist += 50;
	};

	for ($i=0; $i<(count($artistsArraysArray)); ++$i) {
		// echo '<br> $artistsArrays[$i] is ' . $artistsArrays[$i];
		// $artistsIds = implode(',', $artistsArrays[$i]);
		// echo '<br>these are the artist IDs ' . $artistsIds;
		$artistsArray = $artistsArraysArray[$i];
			
		for ($i=0; $i<(count($artistsArray)); ++$i) {

			$artistID = $artistsArray[$i];
			echo '<br>this is a single artist ID ' . $artistsArray[$i];

			$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
				'market' => 'us',
				'album_type' => 'album',
				'limit' => '50'
			]);
			
			foreach ($discography->items as $album) {
				$albumID = $album->id;
				$artistAlbums [] = $albumID;
			}
			
			divideCombineAlbumsForArt ($artistAlbums);
			
		}
	};	
}

divideCombineArtistsForAlbums ($allArtists);

die();

?>