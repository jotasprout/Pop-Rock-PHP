<?php

session_start();

require 'vendor/autoload.php';
require_once 'stylesThatRock.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

// could next line go in artist class?
$artistID = $_POST['artist'];

// could these be methods in the artist class?    
$artist = $api->getArtist($artistID);
$artistName = $artist->name;
$artistPop = $artist->popularity;

// should this go in albums? albums should be a class.
$discography = $api->getArtistAlbums($artistID, [
	'market' => 'us',
	'album_type' => 'album',
	'limit' => '50'
]);

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Ye Olde Artist Results</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php
echo "<h2>" . $artistName . "</h2>"; 
echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>";
echo '<table class="table">';
echo '<tr><th>Artist Name</th><th>Album ID</th><th>Album Name</th><th>Released</th><th>Popularity</th></tr>';

// should be method in albums class
foreach ($discography->items as $album) {
	
	// Get each albumID for requesting Full Album Object with popularity
	$albumID = $album->id;
	
	// Put albumIDs in array for requesting several at a time (far fewer requests)
	$artistAlbums [] = $albumID;
	
}

divideCombineAlbums ($artistAlbums);

for ($i=0; $i<(count($albumsArrays)); ++$i) {

	$albumIds = '["' . implode('","', $albumsArrays[$i]) . '"]';

	// For each array of albums (20 at a time), "get several albums"
	$bunchofalbums = $api->getAlbums($albumIds);

	foreach ($bunchofalbums->albums as $album) {

		$albumID = $album->id;
		$albumName = $album->name;
		$albumReleased = $album->release_date;
		$albumPop = $album->popularity;
		$thisArtistName = $album->artists[0]->name;
	
		echo '<tr><td>' . $thisArtistName . '</td><td>' . $albumID . '</td><td>' . $albumName . '</td><td>' . $albumReleased . '</td><td>' . $albumPop . '</td></tr>';
}

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</body>
</html>