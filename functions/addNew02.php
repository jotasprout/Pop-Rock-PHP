<?php

session_start();
require '../secrets/auth.php';
require_once '../rockdb.php';
require_once '../functions/albums.php';
require '../functions/artists.php';
require '../data_text/artists_arrays.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);


function divideCombineArtistsForAlbums ($theseArtists) {

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
		// echo '<br> $artistsArrays[$i] is ' . $artistsArrays[$i];
		$artistsIds = implode(',', $artistsArraysArray[$i]);
		echo '<br>these are the artist IDs ' . $artistsIds;
		$artistsArray = $artistsArraysArray[$i];
			
		for ($j=0; $j<(count($artistsArray)); ++$j) {

			$artistID = $artistsArray[$j];
			echo '<br>this is a single artist ID ' . $artistID . '<br>';

			$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
				'market' => 'us',
				'album_type' => 'album',
				'limit' => '50'
			]);
			
			foreach ($discography->items as $album) {
				$albumID = $album->id;
				$artistAlbums [] = $albumID;
			}
			
			divideCombineAlbums ($artistAlbums);

			unset($artistAlbums);
			
		}
	};	
}

divideCombineArtistsForAlbums ($feb22);

die();

?>