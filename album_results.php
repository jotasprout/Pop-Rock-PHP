<?php

session_start();

require 'vendor/autoload.php';
require_once 'stylesThatRock.php';
require_once 'api.php';
require ("class.artist.php");

// could next line go in artist class?
$artistID = $_POST['artist'];

// could these be methods in the artist class? 
// Let me count the ways this could be more efficient and elegant
$thisArtist = $api->getArtist($artistID);
$artist = new artist($artistID);
$artistName = $thisArtist->name;
$artist->set_artistName($artistName);
$artistPop = $thisArtist->popularity;
$artist->set_artistPop($artistPop);

$artistAlbums = array ();
$albumsArrays = array ();

// should this go in albums? albums should be a class.

function divideCombineAlbums ($artistAlbums) {
	
	// Divide all artist's albums into chunks of 20
	$artistAlbumsChunk = array ();
	$x = ceil((count($artistAlbums))/20);

	$firstAlbum = 0;
	
    for ($i=0; $i<$x; ++$i) {
	  $lastAlbum = $firstAlbum + 19;
      $artistAlbumsChunk = array_slice($artistAlbums, $firstAlbum, $lastAlbum);
	  // put chunks of 20 into an array
      $albumsArrays [] = $artistAlbumsChunk;
      $firstAlbum += 19;
	};

	for ($i=0; $i<(count($albumsArrays)); ++$i) {
				
			$albumIds = implode(',', $albumsArrays[$i]);
		
			// For each array of albums (20 at a time), "get several albums"
			$bunchofalbums = $GLOBALS['api']->getAlbums($albumIds);
				
			foreach ($bunchofalbums->albums as $album) {
		
				$albumID = $album->id;
				$albumName = $album->name;
				$albumReleased = $album->release_date;
				$albumPop = $album->popularity;
			
				echo '<tr><td>' . $albumName . '</td><td>' . $albumReleased . '</td><td>' . $albumPop . '</td></tr>';
			}
		};
  
}

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Ye Olde Artist Results</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php
echo "<h2>" . $artistName . "</h2>"; 
echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>";
echo '<table class="table">';
echo '<tr><th>Album Name</th><th>Released</th><th>Popularity</th></tr>';

$discography = $api->getArtistAlbums($artistID, [
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

divideCombineAlbums ($artistAlbums);

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
</body>
</html>