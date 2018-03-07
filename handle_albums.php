<?php

include 'sesh.php';
require_once 'auth.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// could next line go in artist class?

$artistID = $_POST['artist'];
$_SESSION['artist'] = $artistID;

// could these be methods in the artist class?    
$artist = $GLOBALS['api']->getArtist($artistID);
$artistName = $artist->name;
$artistPop = $artist->popularity;

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Latest Album Data from Spotify</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

	<?php echo $navbar ?>
	
	<!-- main -->
	
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Albums</h3>
	</div>
	<div class="panel-body"> 
		
		<!-- Panel Content --> 

<?php
echo '<table class="table">';
echo '<tr><th>Album Cover</th><th>Album Name</th><th>Released</th><th>Popularity</th></tr>';

$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
	'market' => 'us',
	'album_type' => 'album',
	'limit' => '50'
]);

// should be method in albums class
foreach ($discography->items as $album) {
	
	// Get each albumID for requesting Full Album Object with popularity
	$albumID = $album->id;
	
	// Put albumIDs in array for requesting several at a time (far fewer requests)
	$artistAlbums [] = $albumID;
	
}

// $howmanytotal = count($artistAlbums);
// echo $howmanytotal . '<br>';
// divideCombineAlbums ($artistAlbums);
// getAlbumsPop ($artistAlbums);
divideCombineAlbumsForArt ($artistAlbums);

?>

</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->

<?php echo $scriptsAndSuch; ?>

</body>
</html>