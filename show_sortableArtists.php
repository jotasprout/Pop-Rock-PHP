<?php

include 'sesh.php'; 
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'artists.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
    echo 'Darn. Did not connect.';
};

$artistInfoRecent = "SELECT a.artistID AS artistID, a.artistName AS artistName, b.pop AS pop, b.date AS date
    FROM artists a
        INNER JOIN popArtists b ON a.artistID = b.artistID
            WHERE b.date = (select max(b2.date)
                            FROM popArtists b2)
    ORDER BY b.pop DESC";

$getit = $connekt->query($artistInfoRecent);

while ($row = mysqli_fetch_array($getit)) {
    // $artistID = $row["artistID"];
    $artistName = $row["artistName"];
    $artistPop = $row["pop"];
    $popDate = $row["date"];
    
    echo "<tr>";
    echo "<td>" . $artistName . "</td>";
    echo "<td>" . $artistPop . "</td>";
    echo "<td>" . $popDate . "</td>";
    echo "</tr>";
}
    
?>

<!DOCTYPE html>

<html>
<head>
    <meta charset="UTF-8">
    <title>Artists and Such</title>
    <?php echo $stylesAndSuch; ?>
    <script src='https://d3js.org/d3.v4.min.js'></script>
</head>

    <body>

        <div class="container">
            <?php echo $navbar ?>

            <!-- main -->

            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title">Album Info from My DB</h3>
                </div>

                <div class="panel-body"> 
                    
                    <!-- Panel Content --> 
                    <!-- D3 chart goes here -->
                    <?php if (!empty($getit)) { ?>

                        <table class="table" id = "tableoartists">
                            <thead>
                                <tr>
                                    <th>Artist Name</th>
                                    <th>Popularity</th>
                                    <th>Date</th>
                                </tr>
                            <?php showArtists (); ?>
                        </table>

                    }

                    <?php
                        } // end of if
                    ?>

                </div> <!-- panel body -->

            </div> <!-- panel panel-primary -->

        </div> <!-- close container -->
        
        <?php echo $scriptsAndSuch; ?>
        <script src="https://www.roxorsoxor.com/poprock/sortTheseArtists.js"></script>

    </body>
</html>