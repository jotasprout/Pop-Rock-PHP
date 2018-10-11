<?php
include 'page_pieces/sesh.php';
require_once 'secrets/auth.php';
require_once 'functions/artists.php';
$artistID = $_POST['artist'];
// $artistID = $_SESSION['artist'];
// $_SESSION['artist'] = $artistID;

require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';
require_once 'functions/albums.php';
require_once 'functions/tracks.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

// put these in api.php and require that
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);
   
$artist = $GLOBALS['api']->$artistID);
$artistName = $artist->name;
$artistPop = $artist->popularity;

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Latest Tracks Data from Spotify</title><?php echo $stylesAndSuch; ?></head>
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

<?php
// echo "<h2>" . $artistName . "</h2>"; 
// echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>";
echo '<table class="table">';
echo '<tr><th>Album Name</th><th>Track Name</th><th>Track Popularity</th></tr>';

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

divideCombineAlbumsForTracks ($artistAlbums);

?>

</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
</body>
</html>