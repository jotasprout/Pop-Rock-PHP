<?php

session_start();
require '../secrets/auth.php';
require_once '../rockdb.php';
require_once 'albums.php';
require 'artists.php';
require_once 'tracks.php';
require '../data_text/artists_arrays_objects.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

$orphanAlbums = ["6uCwsgDWKVfmJMyt6D06gg","4ZLy3U2q17Yjw7jkjXPJQj","71SdSYZuuy7fCWbx0iqtac","2Hnje5QVKaPVNuGJ5yHC7Z","2Hnje5QVKaPVNuGJ5yHC7Z","5efoVI6WIhxLCIrbZuxwBu","2Q5MwpTmtjscaS34mJFXQQ","0MDhZ0yRkugNEg7PmMMUE8","72qrnM4yUNMDDlWiqKc8iY","0bJMFJ2XQwpO5nKTrYdUtX"];

?>

<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>

<body>
<?php
divideCombineAlbums ($orphanAlbums);
divideCombineAlbumsForTracks ($orphanAlbums);
?>

</body>
</html>