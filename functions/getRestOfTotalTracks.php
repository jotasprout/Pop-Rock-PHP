<?php

session_start();
require '../secrets/auth.php';
require_once '../rockdb.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$albumsWithZero = array ();

$gatherAlbumsWithZeroInTracksColumn = "SELECT a.albumID, a.albumTotalTracks
						FROM albums a 
						WHERE a.albumTotalTracks = '0'";

$getit = $connekt->query( $gatherAlbumsWithZeroInTracksColumn );

if ( !$getit ) {
	echo 'Cursed-Crap. Did not run the query.';
};

if(!empty($getit)) {

	while ( $row = mysqli_fetch_array( $getit ) ) {
		$albumID = $row[ "albumID" ];
		$albumsWithZero [] = $albumID;		
	}; // end of while
 
    $session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

    $session->requestCredentialsToken();
    $accessToken = $session->getAccessToken();

    $_SESSION['accessToken'] = $accessToken;
    $accessToken = $_SESSION['accessToken'];

    $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
    $GLOBALS['api']->setAccessToken($accessToken);

    function divideCombineAlbums ($albumsWithZero) {
        
        $albumsWithZeroChunk = array ();
        $x = ceil((count($albumsWithZero))/20);

        $firstAlbum = 0;
        
        for ($i=0; $i<$x; ++$i) {
        $lastAlbum = 19;
        $albumsWithZeroChunk = array_slice($albumsWithZero, $firstAlbum, $lastAlbum);
        $albumsArrays [] = $albumsWithZeroChunk;
        $firstAlbum += 20;
        };

        for ($i=0; $i<(count($albumsArrays)); ++$i) {
                    
            $albumIds = implode(',', $albumsArrays[$i]);
        
            $bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
                
            foreach ($bunchofalbums->albums as $album) {

                $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
        
                $albumID = $album->id;	
                $albumName = $album->name;
                $albumTotalTracks = $album->total_tracks;

                $insertAlbumTotalTracks = "UPDATE albums SET albumTotalTracks='$albumTotalTracks' WHERE albumID='$albumID'";
                
                if (!$connekt) {
                    echo 'Darn. Did not connect.<br>';
                };
                
                $rockout = $connekt->query($insertAlbumTotalTracks);

                if(!$rockout){
                    echo 'Crap de General Tsao! Could not insert ' . $albumName . ' total tracks.<br>';
                }
            
                echo '<p>' . $albumName . ' has ' . $albumTotalTracks . ' total tracks.</p>';

            }
        };
    }

    divideCombineAlbums ($albumsWithZero);
}
/*
function divideCombineArtistsForAlbums ($theseArtists) {

	$artistsChunk = array ();
	$x = ceil((count($theseArtists))/50);

	$firstArtist = 0;

	for ($i=0; $i<$x; ++$i) {
		$lastArtist = 49;
		$artistsChunk = array_slice($theseArtists, $firstArtist, $lastArtist);
		$artistsArraysArray [] = $artistsChunk;
		$firstArtist += 50;
	};

	for ($i=0; $i<(count($artistsArraysArray)); ++$i) {
		$artistsIds = implode(',', $artistsArraysArray[$i]);
		$artistsArray = $artistsArraysArray[$i];
			
		for ($j=0; $j<(count($artistsArray)); ++$j) {

			$artistID = $artistsArray[$j];

			$discography = $GLOBALS['api']->getalbumsWithZero($artistID, [
                'limit' => '50'
			]);
			
			foreach ($discography->items as $album) {
				$albumID = $album->id;
				$albumsWithZero [] = $albumID;
			}
			
			divideCombineAlbums ($albumsWithZero);

			unset($albumsWithZero);
			
		}
	};	
}

divideCombineArtistsForAlbums ($allArtists)
*/
?>