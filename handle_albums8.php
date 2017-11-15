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
		<h1 class="hide"><a href="index.php">Stakeout</a></h1>
		<ul class='nav navbar-nav'>		
		<li><a id='home' href='http://www.roxorsoxor.com/stakeout/index.php'>Home</a></li>						
		<li><a id='cases' href='http://www.roxorsoxor.com/stakeout/cases.php'>Cases</a></li>				
		<li><a href='http://www.roxorsoxor.com/stakeout/observations.php'>Observations</a></li>				
		<li><a href='http://www.roxorsoxor.com/stakeout/gators.php'>Investigators</a></li>				
		<li><a href='http://www.roxorsoxor.com/stakeout/assignments.php'>Assignments</a></li>	
		<li><a href='http://www.roxorsoxor.com/stakeout/reports.php'>Reports</a></li>
		<li><a href='http://www.roxorsoxor.com/stakeout/logout.php'>Logout</a></li>			
		</ul>
	</div> <!-- /container-fluid -->   
</nav> <!-- /navbar -->	
	
	<!-- main -->
	
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Cases</h3>
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

$howmanytotal = count($artistAlbums);
echo $howmanytotal . '<br>';

// getAlbumsPop ($artistAlbums);
// divideCombineAlbums ($artistAlbums);
showAlbums ($artistID);

?>

</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>

</body>
</html>