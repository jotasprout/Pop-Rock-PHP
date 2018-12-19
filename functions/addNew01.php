<?php

include '../page_pieces/sesh.php';
require_once '../secrets/auth.php';
require_once '../rockdb.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';
require_once '../functions/artists.php';
require_once '../data_text/artists_arrays.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();

// I don't think the cron needs this next line 
$_SESSION['accessToken'] = $accessToken;
// and I don't think the cron needs this next line either
$accessToken = $_SESSION['accessToken'];

$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Artists and Such</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">
    <?php echo $navbar ?>
    <table class="table">
    <tr><th>Pretty Picture</th><th>Artist Name</th><th>Artist Popularity</th></tr>

        <?php 
            divideCombineArtists ($dec19);
        ?>
    </table>

</div> <!-- closing container -->

<?php echo $scriptsAndSuch; ?>
<footer class="footer"></footer>
</body>
</html>