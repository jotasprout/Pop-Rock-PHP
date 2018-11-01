<?php
session_start();
require '../secrets/spotifySecrets.php';
require '../vendor/autoload.php';
require_once '../rockdb.php';
require_once 'functions/artists.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';
require_once 'functions/albums.php';
require_once 'functions/tracks.php';

// Fetch saved access token
$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);
$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// put these in api.php and require that
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);
   
$thisArtist = $_POST['artist'];
$artist = $GLOBALS['api']->getArtist($thisArtist);
$artistName = $artist->name;
echo $artistName;
$artistPop = $artist->popularity;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"><title>Add New Tracks for New Artists</title>
	<?php echo $stylesAndSuch; ?>
</head>
<body>

<div class="container">

	<?php echo $navbar ?>
	
	<!-- main -->
	
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Latest Tracks Info from Spotify</h3>
	</div>
	<div class="panel-body"> 
		
		<!-- Panel Content --> 
<table class="table">
<tr><th>Album Name</th><th>Track Name</th><th>Track Popularity</th></tr>

<?php

$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
	'market' => 'us',
	'album_type' => 'album',
	'limit' => '50'
]);
$artistAlbums = array ();
// should be method in albums class
foreach ($discography->items as $album) {
	
	// Get each albumID for requesting Full Album Object with popularity
	$albumID = $album->id;
	
	// Put albumIDs in array for requesting several at a time (far fewer requests)
	$artistAlbums [] = $albumID;
	
}

divideCombineAlbumsForTracks ($artistAlbums);

?>

</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
	</div> <!-- closing container -->
	<?php echo $scriptsAndSuch; ?>
</body>
</html>