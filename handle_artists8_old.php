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
// $artist = $GLOBALS['api']->getArtists($artists);

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Artists and Such</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php
echo '<table class="table">';
echo '<tr><th>Artist Name</th><th>Popularity</th></tr>';

// inserttArtistsAndPop ($nominees2018);
getArtistsPop ($artists);

echo '</table>';

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</body>
</html>