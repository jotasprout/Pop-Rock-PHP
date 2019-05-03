<?php

$artistSpotID = $_GET['artistSpotID'];
require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo '<p>Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

$blackSabbath_SpotID = '5M52tdBnJaKSvOpJGz8mfZ';
$blackSabbath_MBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8';

$blackScabies = "SELECT b.albumName, b.albumMBID, b.albumSpotID, b.artistSpotID, a.year, a.albumArtSpot, a.tracksTotal, z.artistName, p1.pop, p1.date, f1.dataDate, f1.albumListeners, f1.albumPlaycount, x.albumArtMB
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumSpotID, sp.artistSpotID
	FROM albums sp
	WHERE sp.artistSpotID='$artistSpotID'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='$artistSpotID') b 
LEFT JOIN albums a ON b.albumSpotID = a.albumSpotID	
JOIN artists z ON z.artistSpotID = b.artistSpotID
LEFT JOIN (SELECT p.*
		FROM popAlbums p
		INNER JOIN (SELECT albumSpotID, pop, max(date) AS MaxDate
					FROM popAlbums  
					GROUP BY albumSpotID) groupedp
		ON p.albumSpotID = groupedp.albumSpotID
		AND p.date = groupedp.MaxDate) p1 
ON a.albumSpotID = p1.albumSpotID
LEFT JOIN albumsMB x ON b.albumMBID = x.albumMBID
LEFT JOIN (SELECT f.*
		FROM albumsLastFM f
		INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
		FROM albumsLastFM
		GROUP BY albumMBID) groupedf
		ON f.albumMBID = groupedf.albumMBID
		AND f.dataDate = groupedf.MaxDataDate) f1
ON b.albumMBID = f1.albumMBID	
ORDER BY b.albumName ASC;";

$getit = $connekt->query($blackScabies);

if(!$getit){
	echo '<p>Cursed-Crap. Did not run the query. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
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

<th>Cover Art</th>
<!---->
<th onClick="sortColumn('albumName', 'ASC', '<?php echo $artistSpotID; ?>')"><div class="pointyHead">Album Name</div></th>
<th>Album Spotify ID</th>
<th>Album MBID</th>


<th onClick="sortColumn('year', 'unsorted', '<?php echo $artistSpotID; ?>')"><div class="pointyHead popStyle">Released</div></th>
<!--
<th><div class="pointyHead popStyle">Total<br>Tracks</div></th>
-->
<th class="popStyle">Spotify<br>Data Date</th>

<th onClick="sortColumn('pop', 'ASC', '<?php echo $artistSpotID; ?>')"><div class="pointyHead popStyle">Spotify<br>Popularity</div></th>
<!---->
<th class="popStyle">LastFM<br>Data Date</th>

<th onClick="sortColumn('albumListeners', 'unsorted', '<?php echo $artistSpotID; ?>')"><div class="pointyHead rightNum">LastFM<br>Listeners</div></th>
<th onClick="sortColumn('albumPlaycount', 'unsorted', '<?php echo $artistSpotID; ?>')"><div class="pointyHead rightNum">LastFM<br>Playcount</div></th>

</tr>

</thead>

<tbody>
					
<?php

	while ($row = mysqli_fetch_array($getit)) {
		$artistName = $row['artistName'];
		$albumSpotID = $row['albumSpotID'];
		$albumMBID = $row['albumMBID'];

		if (is_null($row['albumMBID'])) {
			$albumMBID = "NULL";
		};

		$source = 'spotify';
		$albumPop = $row['pop'];
		$coverArt = $row['albumArtSpot'];
		$tracksTotal = $row['tracksTotal'];
		// need to get a tracks total for MusicBrainz-only albums
		$albumName = $row['albumName'];
		$albumReleased = $row['year'];	
		// need to get release year for MusicBrainz-only albums	
/*
		if (is_null($row['albumArtSpot'])) {
			
		} else {
			
		};
*/
		$date = $row['date'];
		if (is_null($row['albumSpotID'])) {
			$source = 'musicbrainz';
			$albumSpotID = "NULL";
			$date = "n/a";
			$coverArt = $row['albumArtMB'];
			$albumPop = "n/a";
		};

		$lastFMDate = $row[ "dataDate" ];
		if (!$lastFMDate == "NULL") {
			$lastFMDate = "n/a";
		};

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
<td><img src='<?php echo $coverArt ?>' height='64' width='64'></td>
<!---->
<td><a href='https://www.roxorsoxor.com/poprock/album_TracksList.php?artistSpotID=<?php echo $artistSpotID ?>&albumSpotID=<?php echo $albumSpotID ?>&albumMBID=<?php echo $albumMBID ?>&source=<?php echo $source ?>'><?php echo $albumName ?></a></td>
<td><?php echo $albumSpotID ?></td>
<td><?php echo $albumMBID ?></td>


<td class="popStyle"><?php echo $albumReleased ?></td>
<!--
<td class="popStyle"><?php //echo $tracksTotal ?></td>
-->
<td class="popStyle"><?php echo $date ?></td>

<td class="popStyle"><?php echo $albumPop ?></td>
<!---->
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
	let artistSpotID = '<?php echo $artistSpotID ?>';
</script>

<script src="https://www.roxorsoxor.com/poprock/functions/sort_artistAlbums2.js"></script>

</body>
	
</html>