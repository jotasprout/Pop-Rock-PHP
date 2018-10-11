<?php

$artistID = $_COOKIE['artistID'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$happyScabies2 = "SELECT a.albumName, a.year, a.albumArt, z.artistName, p1.pop, p1.date, a.albumID
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

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}

?>

<!DOCTYPE html>
<html>
	
<head>
	<meta charset="UTF-8">
	<title>Album Info from My DB</title>
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
						<th onClick="sortColumn('albumName', 'ASC')"><div class="pointyHead">Album Name</div></th>
						<th onClick="sortColumn('year', 'DESC')"><div class="pointyHead">Released</div></th>
						<th onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Popularity</div></th>
						<th>1 day</th>
						<th>7 days</th>
						<th>30 days</th>
						<th>90 days</th>
						<th>180 days</th>
		<!--
			<th>Date</th>
		--> 
					</tr>
				</thead>
				<tbody>
					
					<?php
						while ($row = mysqli_fetch_array($getit)) {
							$artistName = $row['artistName'];
							$albumArt = $row['albumArt'];
							$albumID = $row['albumID'];
							$albumName = $row['albumName'];
							$albumReleased = $row['year'];
							$albumPop = $row['pop'];
							$date = $row['date'];
					?>
					
					<tr>
						<td><img src='<?php echo $albumArt ?>' height='64' width='64'></td>
						<!-- NEED TO CREATE FUNCTION IN NEXT LINE -->
						<td onClick="showAlbumPage('<?php echo $albumID ?>')"><?php echo $albumName ?></td>
						<td><?php echo $albumReleased ?></td>
						<td><?php echo $albumPop ?></td>
						<td>*</td>
						<td>*</td>
						<td>*</td>
						<td>*</td>
						<td>*</td>
						
						<!--
							<td><?php //echo $date ?></td>	
						-->
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

</div> <!-- panel panel-primary -->
    </div> <!-- closing container -->
	
<?php echo $scriptsAndSuch; ?>
<script src="https://www.roxorsoxor.com/poprock/functions/sortTheseAlbums2.js"></script>
</body>
	
</html>