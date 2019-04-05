<?php

$artistID = $_GET['artistID'];
require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};

$happyScabies2 = "SELECT a.albumName, a.year, a.albumArt, a.tracksTotal, z.artistName, p1.pop, p1.date, a.albumID, f1.albumMBID, f1.dataDate, f1.albumListeners, f1.albumPlaycount
	FROM (SELECT
				y.albumID AS albumID,
				y.albumMBID AS albumMBID,
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
	LEFT JOIN (SELECT f.*
			FROM albumsLastFM f
			INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
			FROM albumsLastFM
			GROUP BY albumMBID) groupedf
			ON f.albumMBID = groupedf.albumMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	ON a.albumMBID = f1.albumMBID
	ORDER BY albumName ASC;";

$blackScabies = "SELECT sp.albumName, sp.albumMBID, sp.albumID, sp.artistID 
FROM albums sp
WHERE sp.artistID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
FROM albumsMB mb 
WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ' 
ORDER BY albumName ASC;"

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

<div class="container-fluid">

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
		<th>albumMBID</th>
		<th onClick="sortColumn('albumName', 'ASC', '<?php echo $artistID; ?>')"><div class="pointyHead">Album Name</div></th>
		<th onClick="sortColumn('year', 'DESC', '<?php echo $artistID; ?>')"><div class="pointyHead popStyle">Released</div></th>
		<th><div class="pointyHead popStyle">Total<br>Tracks</div></th>
		<th class="popStyle">Spotify<br>Data Date</th>
		<th onClick="sortColumn('pop', 'ASC', '<?php echo $artistID; ?>')"><div class="pointyHead popStyle">Spotify<br>Popularity</div></th>
		<th>LastFM<br>Data Date</th>
		<th class="rightNum pointyHead">LastFM<br>Listeners</th>
		<th class="rightNum pointyHead">LastFM<br>Playcount</th>
	</tr>
</thead>
<tbody>
					
<?php
	while ($row = mysqli_fetch_array($getit)) {
		$artistName = $row['artistName'];
		$albumArt = $row['albumArt'];
		$albumID = $row['albumID'];
		$albumMBID = $row['albumMBID'];
		$albumName = $row['albumName'];
		$tracksTotal = $row['tracksTotal'];
		$albumReleased = $row['year'];
		$albumPop = $row['pop'];
		$date = $row['date'];
		$lastFMDate = $row[ "dataDate" ];
		$albumListenersNum = $row[ "albumListeners"];
		$albumListeners = number_format ($albumListenersNum);
		if (!$albumListeners > 0) {
			$albumListeners = "n/a";
		};
		$albumPlaycountNum = $row[ "albumPlaycount"];
		$albumPlaycount = number_format ($albumPlaycountNum);
		if (!$albumPlaycount > 0) {
			$albumPlaycount = "n/a";
		};
?>
					
<tr>
<td><img src='<?php echo $albumArt ?>' height='64' width='64'></td>
<td><?php echo $albumID ?></td>
<td><?php echo $albumMBID ?></td>
<td><a href='https://www.roxorsoxor.com/poprock/thisAlbum_TracksList.php?albumID=<?php echo $albumID ?>'><?php echo $albumName ?></a></td>
<td class="popStyle"><?php echo $albumReleased ?></td>
<td class="popStyle"><?php echo $tracksTotal ?></td>
<th class="popStyle"><?php echo $date ?></th>
<td class="popStyle"><?php echo $albumPop ?></td>
<td class="popStyle"><?php echo $lastFMDate ?></td>
<td class="rightNum"><?php echo $albumListeners ?></td>
<td class="rightNum"><?php echo $albumPlaycount ?></td>
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