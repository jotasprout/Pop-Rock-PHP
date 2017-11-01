<?php

session_start();

require 'vendor/autoload.php';
require_once 'stylesThatRock.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

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
    <table class="table">
        <tr><th>ID</th><th>Name</th><th>Released</th><th>Popularity</th></tr>

<?php

$bunchofalbums = $api->getAlbums(['6p7jHbG5Bd6z2JgfKx0um7','4CR04QNS93ZYEt4mJNOSij']);

// $bunchofalbums = $api->getAlbums(['3P2p1wEaLrAeuainTWeq7e','3tAWE5mBEFzkQVnB04ygqB','36n2UcQrpMJDXRTPNxTj4N','6a5LpJhC02l1PlRiXmxr4T','25Jo67rdeQQWaWF6x6jY2b','24kjyGW47XaNL3AqyaEL07','2d0borBFxjqcmjmMiqgV9E','7GwAz2iAtNu6f5mvMsPKj1','4CR04QNS93ZYEt4mJNOSij, 1OBOTv0qiBwO05w41mOCKB','2PlFEQG4JRHtW1yXO5MMYg','7atI6qWYXKVYjyiD0kFn0d','4BU7PgNyj5kvWFklAVziuB','1Bwa1kD95xPzyVQkZBFXEU','0lhICEAy0rRGbhvWzlP0Ke','033cvSPAuSU5ArRfIgQSDU','4nWnmRz6C8AZXE6MjJ1X74','5UUhQDSXBdRgIELKusNkmI','3F3JU1MJDN9PgHFwbCvFvV']);

// echo '<b>bunchofalbums includes</b> <br>' . implode(", ", $bunchofalbums) . '<br>';

foreach ($bunchofalbums->albums as $album) {
    
    // Get each albumID for requesting Full Album Object with popularity
    $albumID = $album->id;
    $albumName = $album->name;
    $albumReleased = $album->release_date;
    $albumPop = $album->popularity;
    $artistID = $album->artists->id;

    echo '<tr><td>' . $albumID . '</td><td>' . $albumName . '</td><td>' . $albumReleased . '</td><td>' . $albumPop . '</td></tr>';
}

?>

</table>
    </div> <!-- closing container -->
<?php echo $scriptsAndSuch; ?>

</body>
</html>