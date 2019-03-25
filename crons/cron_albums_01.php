<?php

require '../secrets/auth.php';
require_once '../rockdb.php';
require_once '../functions/albums.php';
require '../functions/artists.php';
require '../data_text/artists_arrays.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

$accessToken = $_SESSION['accessToken'];
// Does the cron needs this next line?
$_SESSION['accessToken'] = $accessToken;


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
		$artistsIds = implode(',', $artistsArraysArray[$i]);
		$artistsArray = $artistsArraysArray[$i];
			
		for ($j=0; $j<(count($artistsArray)); ++$j) {

			$artistID = $artistsArray[$j];

			$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
				'limit' => '50'
			]);
			


			// Somewhere about here is future home of algorithm for using offset and ...

			foreach ($discography->items as $album) {
				$albumID = $album->id;
				$artistAlbums [] = $albumID;
			}
			
			divideCombineAlbums ($artistAlbums);

			unset($artistAlbums);
			
		}
	};	
}

divideCombineArtistsForAlbums ($artists01);

die();

?>