<?php

include 'sesh.php';
// $artistID = $_POST['artist'];
$artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$happyScabies2 = "SELECT a.albumName, a.year, a.albumArt, z.artistName, p1.pop, p1.date
	FROM (SELECT
				y.albumID AS albumID,
				y.albumName AS albumName,
				y.artistID AS artistID,
				y.albumArt AS albumArt,
				y.year AS year
			FROM albums y 
			WHERE y.artistID = '$artistID') a
	JOIN artists z ON z.artistID = '$artistID'
	JOIN (SELECT p.*
			FROM popAlbums p
			INNER JOIN (SELECT albumID, pop, max(date) AS MaxDate
						FROM popAlbums  
						GROUP BY albumID) groupedp
			ON p.albumID = groupedp.albumID
			AND p.date = groupedp.MaxDate) p1 
	ON a.albumID = p1.albumID
	ORDER BY year ASC;";

$getit = $connekt->query($happyScabies2);

?>

<!DOCTYPE html>
<html>
	
<head>
	<meta charset="UTF-8">
	<title>My Album Info</title>
	<?php echo $stylesAndSuch; ?>
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

		<?php if(!empty($getit)) { ?>
		
			<table class="table" id="recordCollection">
				<thead>
					<tr>
						<th>Album Art</th>
						<th onClick="sortColumn('albumName', 'ASC')">Album Name</th>
						<th onClick="sortColumn('year', 'DESC')">Released</th>
						<th onClick="sortColumn('pop', 'ASC')">Popularity</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					
					<?php
						while ($row = mysqli_fetch_array($getit)) {
							$artistName = $row['artistName'];
							$albumArt = $row['albumArt'];
							$albumName = $row['albumName'];
							$albumReleased = $row['year'];
							$albumPop = $row['pop'];
							$date = $row['date'];
					?>
					
					<tr>
						<td><img src='<?php echo $albumArt ?>' height='64' width='64'></td>
						<td><?php echo $albumName ?></td>
						<td><?php echo $albumReleased ?></td>
						<td><?php echo $albumPop ?></td>
						<td><?php echo $date ?></td>
					</tr>
					
					<?php 
						} // end of while
					?>
					
				</tbody>
			</table>
		<?php 
			} // end of if
		?>

	</div> <!-- panel body -->
<!--
<footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2018</p></footer>
-->
</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>
<script src="https://www.roxorsoxor.com/poprock/sortingHat.js"></script>
</body>
	
</html>