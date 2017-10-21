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

    <?php echo "<h2>" . $artistName . "</h2>"; ?>
    <?php echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>"; ?>

    <table id="albums" class="table table-striped table-hover ">
        <tr>
        <th>Album ID</th>
        <th>Album Name</th>
        <th>Album Released</th>
        <th>Album Popularity</th>
        </tr>
    </table>

</body>
</html>