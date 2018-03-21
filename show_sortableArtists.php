<?php

    session_start();
    require 'vendor/autoload.php';
    require_once 'rockdb.php';
    require_once 'navbar_rock.php';
    require_once 'stylesAndScripts.php';
    require_once 'artists.php';

    $accessToken = $_SESSION['accessToken'];

function showArtists () {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
	
	$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
		FROM artists a
			INNER JOIN popArtists b ON a.artistID = b.artistID
		ORDER BY a.artistName ASC";

	$artistInfoRecent = "SELECT a.artistID, a.artistName, b.pop, b.date 
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