<?php

include 'sesh.php';
// $artistID = $_POST['artist'];
$artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;

require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
require_once 'albums.php';
require_once 'tracks.php';

function showTracks ($artistID) {

	$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

	if (!$connekt) {
		echo 'Darn. Did not connect.';
	};
	
	$gatherTrackInfo = "SELECT t.trackID, t.trackName, a.albumName, a.artistID, p1.pop, p1.date
    FROM tracks t
    INNER JOIN albums a ON a.albumID = t.albumID
    JOIN (SELECT p.* FROM popTracks p
            INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
                        FROM popTracks  
                        GROUP BY trackID) groupedp
            ON p.trackID = groupedp.trackID
            AND p.date = groupedp.MaxDate) p1 
    ON t.trackID = p1.trackID
    WHERE a.artistID = '$artistID'
    ORDER BY t.trackName ASC";

	$getit = $connekt->query($gatherTrackInfo);

	if(!$getit){
		echo 'Cursed-Crap. Did not run the query.';
	}

	while ($row = mysqli_fetch_array($getit)) {
		// $artistID = $row["artistID"];
		// $artistName = $row["artistName"];
		$albumName = $row["albumName"];
		$trackName = $row["trackName"];
		// $albumReleased = $row["year"];
		$trackPop = $row["pop"];
		$popDate = $row["date"];
		
		echo "<tr>";
		// echo "<td>" . $artistName . "</td>";
		echo "<td>" . $albumName . "</td>";
		echo "<td>" . $trackName . "</td>";
		echo "<td>" . $trackPop . "</td>";
		echo "<td>" . $popDate . "</td>";
		echo "</tr>";
	}
}

?>

<!DOCTYPE html><html>
<head><meta charset="UTF-8"><title>Tracks of My Database</title><?php echo $stylesAndSuch; ?></head>
<body>

<div class="container">

<?php echo $navbar ?>

<!-- main -->

<div class="panel panel-primary">
<div class="panel-heading">
	<h3 class="panel-title">Latest Tracks Info from My Database</h3>
</div>
<div class="panel-body"> 

<table class="table">
	<tr><th>Album</th><th>Track</th><th>Track Popularity</th><th>Date</th></tr>
	<?php
		showTracks ($artistID);
	?>
</table>
</div> <!-- panel body -->
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
</body>
</html>