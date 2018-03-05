<?php

    session_start();
    require_once 'rockdb.php';
    require_once 'stylesAndScripts.php';
    require_once 'navbar_rock.php';
    require_once 'artists.php';

    $artistID = $_SESSION['artist'];
    $_SESSION['artist'] = $artistID;

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
            <footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
        </div> <!-- close container -->
        
        <?php echo $scriptsAndSuch; ?>
        

    </body>
</html>