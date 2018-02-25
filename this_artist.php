<?php

    session_start();

    require_once 'rockdb.php';
    require_once 'navbar_rock.php';
    require_once 'stylesAndScripts.php';
    require_once 'artists.php';

    $session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);

    $session->requestCredentialsToken();
    $accessToken = $session->getAccessToken();

    $_SESSION['accessToken'] = $accessToken;
    $accessToken = $_SESSION['accessToken'];

    $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
    $GLOBALS['api']->setAccessToken($accessToken);

    $artistID = $_POST['artist'];
    $_SESSION['artist'] = $artistID;
    // this page loads directly from choose_artist so it gets the post
    // all other pages will get session artist from this page

?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>This Artist</title>
    <?php echo $stylesAndSuch; ?>
    <script src='https://d3js.org/d3.v4.min.js'></script>
</head>

    <body>

        <div class="container">
            <?php echo $navbar ?>

            <!-- D3 chart goes here -->

            <table class="table">
                <tr><th>Artist Name</th><th>Popularity</th><th>Date</th></tr>
                <?php showThisArtist ($artistID); ?>
            </table>

            <?php
            echo "<h2>" . $artistName . "</h2>"; 
            echo "<p>" . $artistName . "'s popularity is " . $artistPop . ".</p>";
            ?>

        </div> <!-- close container -->
        
        <?php echo $scriptsAndSuch; ?>
        <footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>

    </body>
</html>