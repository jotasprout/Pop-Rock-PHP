<?php

    include 'sesh.php';   
    $artistID = $_SESSION['artist'];
    $_SESSION['artist'] = $artistID;
    require_once 'rockdb.php';
    require_once 'navbar_rock.php';
    require_once 'stylesAndScripts.php';
    require_once 'artists.php';
    
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Artists from My DB</title>
    <?php echo $stylesAndSuch; ?>
    <script src='https://d3js.org/d3.v4.min.js'></script>
</head>

    <body>

        <div class="container">
            <?php echo $navbar ?>

            <!-- D3 chart goes here -->

            <table class="table">
                <tr><th>Artist Name</th><th>Popularity</th><th>Date</th></tr>
                <?php showArtists (); ?>
            </table>

        </div> <!-- close container -->
        
        <?php echo $scriptsAndSuch; ?>
        <footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>

    </body>
</html>