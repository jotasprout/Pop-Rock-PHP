<?php

session_start();

require 'vendor/autoload.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';
require_once 'tracks.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

// put these in api.php and require that
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

// could next line go in artist class?
$artistID = $_SESSION['artist'];
// temporarily commenting out next line and using previous line
// $artistID = $_POST['artist'];
// $_SESSION['artist'] = $artistID;
// could these be methods in the artist class?    
$artist = $GLOBALS['api']->getArtist($artistID);

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Artists and Such</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">
	<?php echo $navbar ?>

<?php
echo '<table class="table">';
echo '<tr><th>Album Name</th><th>Track Name</th><th>Track Popularity</th></tr>';

showTracks ($artistID);

echo '</table>';

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</body>
</html>