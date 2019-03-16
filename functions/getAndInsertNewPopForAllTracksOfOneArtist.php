<?php

session_start();
require '../secrets/auth.php';
require_once '../rockdb.php';
require_once 'tracks.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$artistID = '3EhbVgyfGd7HkpsagwL9GS';

$allTracks = array ();

$gatherAllTrackIDsForThisArtist = "SELECT t.trackID, t.trackName, a.albumName, a.artistID
						FROM tracks t
						INNER JOIN albums a 
						ON a.albumID = t.albumID
						WHERE a.artistID = '$artistID'";

$getit = $connekt->query( $gatherAllTrackIDsForThisArtist );

if ( !$getit ) {
	echo 'Cursed-Crap. Did not run the query.';
};

if(!empty($getit)) {

	while ( $row = mysqli_fetch_array( $getit ) ) {
		$trackID = $row[ "trackID" ];
		$allTracks [] = $trackID;		
	}; // end of while
	
	$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

	$session->requestCredentialsToken();
	$accessToken = $session->getAccessToken();

	// I don't think the cron needs this next line 
	$_SESSION['accessToken'] = $accessToken;
	// and I don't think the cron needs this next line either
	$accessToken = $_SESSION['accessToken'];

	$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
	$GLOBALS['api']->setAccessToken($accessToken);
	
	
	divideCombineTracksAndInsertPop ($allTracks);
} // end of if
			
?>


