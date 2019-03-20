<?php

$artistID = $_GET['artistID'];
require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$happyScabies2 = "SELECT a.albumName, a.year, a.albumArt, a.tracksTotal, z.artistName, p1.pop, p1.date, a.albumID
	FROM (SELECT
				y.albumID AS albumID,
				y.albumName AS albumName,
				y.artistID AS artistID,
				y.tracksTotal AS tracksTotal,
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

<!doctype html>
<html>
	
<head>
	<meta charset="UTF-8">
	<title>This Artist's Albums</title>
	<?php echo $stylesAndSuch; ?>
</head>
	
<body>

<div class="container">

	<?php echo $navbar ?>
	
	<!-- main -->
	<p>Please be patient while data loads.</p>
	<p>If, after the page loads, it is empty, or the wrong discography displays, <a href='https://www.roxorsoxor.com/poprock/index.php'>choose an artist</a> from the <a href='https://www.roxorsoxor.com/poprock/index.php'>Artists List</a> first.</p>
	
<div class="panel panel-primary">

	<div class="panel-heading">
		<h3 class="panel-title">This Artist's Albums</h3>

	</div>

	<div class="panel-body"> 
		
		<!-- Panel Content --> 

		<?php if(!empty($getit)) { ?>
		
<table class="table" id="recordCollection">
	<thead>
		<tr>
			<th>Album Art</th>
			<th>Album Spotify ID</th>
			<th onClick="sortColumn('albumName', 'ASC', '<?php echo $artistID; ?>')"><div class="pointyHead">Album Name</div></th>
			<th onClick="sortColumn('year', 'DESC', '<?php echo $artistID; ?>')"><div class="pointyHead popStyle">Released</div></th>
			<th onClick="sortColumn('tracksTotal', 'DESC', '<?php echo $tracksTotal; ?>')"><div class="pointyHead popStyle">Total Tracks</div></th>
			<th class="popStyle">Date</th>
			<th onClick="sortColumn('pop', 'ASC', '<?php echo $artistID; ?>')"><div class="pointyHead popStyle">Popularity</div></th>
		</tr>
	</thead>
				<tbody>
					
					<?php
						while ($row = mysqli_fetch_array($getit)) {
							$artistName = $row['artistName'];
							$albumArt = $row['albumArt'];
							$albumID = $row['albumID'];
							$albumName = $row['albumName'];
							$tracksTotal = $row['tracksTotal'];
							$albumReleased = $row['year'];
							$albumPop = $row['pop'];
							$date = $row['date'];
					?>
					
<tr>
<td><img src='<?php echo $albumArt ?>' height='64' width='64'></td>
<td><?php echo $albumID ?></td>
<!-- NEED TO CREATE FUNCTION IN NEXT LINE -->
<td><a href='https://www.roxorsoxor.com/poprock/thisAlbum_TracksList.php?albumID=<?php echo $albumID ?>'><?php echo $albumName ?></a></td>
<td class="popStyle"><?php echo $albumReleased ?></td>
<td class="popStyle"><?php echo $tracksTotal ?></td>
<th class="popStyle"><?php echo $date ?></th>
<td class="popStyle"><?php echo $albumPop ?></td>

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

<script>
	let artistID = '<?php echo $artistID ?>';
</script>

<script src="https://www.roxorsoxor.com/poprock/functions/sortTheseAlbums.js"></script>

</body>
	
</html>