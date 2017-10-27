<?php
session_start();

require 'vendor/autoload.php';

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
    <script src='https://www.roxorsoxor.com/js/jquery-214.js'></script>
</head>

<body>

    <?php 
        // Get artist name and popularity for tracking pop over time and comparing to other artists
        echo "<h2>" . $artistName . "</h2>"; 
        echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>"; 

        $discography = $api->getArtistAlbums($artistID, [
            'country' => 'us',
            'album_type' => 'album',
            'int' => 'US'
        ]);
        echo $discography;
    ?>

    <table id="albums" class="table table-striped table-hover ">
        <tr>
        <th>Album ID</th>
        <th>Album Name</th>
        <th>Album Released</th>
        <th>Album Popularity</th>
        </tr>

<!-- Need a loop here that gets artist's albums -->

<!-- For each album, get name, popularity, and release date to compare popularity of albums in different stages of artist's career and compare popularity of albums in those stages to similar stages in careers of other artists. -->

        <?php

            // Get list of artist's albums. 50 is maximum allowed. For now, no compilations. Never want outside US.
            foreach ($discography->items as $album) {
                echo '<tr><td>' . $album->id . '</td><td>' . $album->name . '</td><td>' . $album->release_date . '</td><td>' . $album->popularity . '</td></tr>';
            }

            echo '</table>';
            // Get each albumID for requesting Full Album Object with popularity
            // Put albumIDs in array for requesting several at a time (far fewer requests)
            // Divide albumIDs array into smaller arrays. Limit is 20 for "get several albums" requests.
            // For each array of albums (20 at a time), "get several albums"


        ?>



    </table>

</body>
</html>