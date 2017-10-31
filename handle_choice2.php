<?php

session_start();

require 'vendor/autoload.php';
require_once 'stylesThatRock.php';
require_once 'albums.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

$artistID = $_POST['artist'];

// It's now possible to request data from the Spotify catalog
    
$artist = $api->getArtist($artistID);
$artistName = $artist->name;
$artistPop = $artist->popularity;

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ye Olde Artist Results</title>
    <?php echo $stylesAndSuch; ?>
</head>

<body>

<div class="container">
    <?php 
        // Get artist name and popularity for tracking pop over time and comparing to other artists
        echo "<h2>" . $artistName . "</h2>"; 
        echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>"; 

        $discography = $api->getArtistAlbums($artistID, [
            'market' => 'us',
            'album_type' => 'album',
            'limit' => '50'
        ]);
    ?>

    <table class="table">
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Released</th>
        <th>Popularity</th>
        </tr>

<!-- Need a loop here that gets artist's albums -->

<!-- For each album, get name, popularity, and release date to compare popularity of albums in different stages of artist's career and compare popularity of albums in those stages to similar stages in careers of other artists. -->

        <?php

            // Get list of artist's albums. 50 is maximum allowed. For now, no compilations. Never want outside US.
            foreach ($discography->items as $album) {

                // Get each albumID for requesting Full Album Object with popularity
                $albumID = $album->id;
                $albumName = $album->name;
                
                // Put albumIDs in array for requesting several at a time (far fewer requests)
                $artistAlbums [] = $albumID;
                
            }

            // Divide albumIDs array into smaller arrays. Limit is 20 for "get several albums" requests.
            divideCombineAlbums ($artistAlbums);
            
            for ($i=0; $i<(count($albumsArrays)); ++$i) {
                
                // echo '<b>albumsArrays [' . $i . '] includes</b> <br>' . implode(", ", $albumsArrays[$i]) . '<br>';
        
                $albumIds = implode(",", $albumsArrays[$i]);
                echo '<b>this albumIds batch includes</b> <br>' . $albumIds . '<br>';
        
                // For each array of albums (20 at a time), "get several albums"
                $thisAlbumsBatch = $api->getAlbums($albumsArrays[$i]);
        
                echo 'thisalbumsBatch includes ' . $thisAlbumsBatch . '<br>';
        
                foreach($thisAlbumsBatch as $thisAlbum) {
                    $albumID = $album->id;
                    $albumName = $album->name;
                    echo $albumName;
                    $albumReleased = $thisAlbum->release_date;
                    $albumPop = $thisAlbum->popularity;
                    $artistID = $thisAlbum->artists->id;
        
                    // echo '<tr><td>' . $albumID . '</td><td>' . $albumName . '</td><td>' . $albumReleased . '</td><td>' . $albumPop . '</td></tr>';
                }
        
            };
            
            

        ?>

    </table>
        </div> <!-- closing container -->
    <?php echo $scriptsAndSuch; ?>

</body>
</html>