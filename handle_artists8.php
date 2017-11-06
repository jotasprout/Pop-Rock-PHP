<?php

session_start();

require 'vendor/autoload.php';
require_once 'rockdb.php';
require_once 'stylesAndScripts.php';
require_once 'artists.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

// $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// could these be methods in the artist class?    
$artist = $GLOBALS['api']->getArtists($artists);

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Ye Olde Album Results</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php
echo '<table class="table">';
echo '<tr><th>Artist Name</th><th>Popularity</th><th>Artist ID</th></tr>';

$supergroup = $GLOBALS['api']->getArtists($artists);

// should be method in albums class
foreach ($supergroup->artists as $artist) {
	
	// Get each albumID for requesting Full Album Object with popularity
	$artistName = $artist->name;
	$artistPop = $artist->popularity;
	$artistID = $artist->id;

	echo '<tr><td>' . $artistName . '</td><td>' . $artistPop . '</td><td>' . $artistID . '</td></tr>';
	
}

echo '</table>';

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</body>
</html>