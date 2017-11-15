<?php

session_start();

require 'vendor/autoload.php';
// require_once 'rockdb.php';
require_once 'stylesAndScripts.php';
require_once 'albums8.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

// $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// could next line go in artist class?
$artistID = $_POST['artist'];

// could these be methods in the artist class?    
// $artist = $GLOBALS['api']->getArtist($artistID);
// $artistName = $artist->name;
// $artistPop = $artist->popularity;

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Ye Olde Album Results</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<nav class='navbar navbar-default'>	
	<div id='header' class='container-fluid'>		
		<ul class='nav navbar-nav'>		
			<li><a id='home' href='http://www.roxorsoxor.com/stakeout/index.php'>Choose Artist</a></li>					
			<li><a id='cases' href='https://roxorsoxor.com/poprock/handle_artists8.php'>Artists</a></li>				
			<li><a href='https://roxorsoxor.com/poprock/handle_albums8.php'>Albums</a></li>				
			<li><a href='https://roxorsoxor.com/poprock/handle_tracks8.php'>Tracks</a></li>						
		</ul>
	</div> <!-- /container-fluid -->   
</nav> <!-- /navbar -->	
	
	<!-- main -->
	
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Albums</h3>
	</div>
	<div class="panel-body"> 
		
		<!-- Panel Content --> 

<?php
// echo "<h2>" . $artistName . "</h2>"; 
// echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>";
echo '<table class="table">';
echo '<tr><th>Artist Name</th><th>Album Name</th><th>Released</th><th>Popularity</th></tr>';

$discography = $GLOBALS['api']->getArtistAlbums($artistID, [
	'market' => 'us',
	// Removing next line because most users probably grab most popular songs from compilations
	// 'album_type' => 'album',
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

// getAlbumsPop ($artistAlbums);
// divideCombineAlbums ($artistAlbums);
showAlbums ($artistID);

?>

</table>
</div> <!-- panel body -->

    </div> <!-- closing container -->
	<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
<?php echo $scriptsAndSuch; ?>

</body>
</html>