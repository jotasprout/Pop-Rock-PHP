<?php
session_start();

require 'vendor/autoload.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

// It's now possible to request data from the Spotify catalog
print_r(
    $api->getTrack('7EjyzZcbLxW7PaaLua9Ksb')
);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pseudo 10d</title>
</head>

<body>

    <script src='https://www.roxorsoxor.com/js/jquery-214.js'></script>
    <script src="pseudo_10d.js"></script>

</body>

</html>