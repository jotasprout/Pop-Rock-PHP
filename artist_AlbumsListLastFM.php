<?php

$artistMBID = $_GET['artistMBID'];
$artistSpotID = $_GET['artistSpotID'];
$source = $_GET['source'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo '<p>Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

$blackSabbath_SpotID = '5M52tdBnJaKSvOpJGz8mfZ';
$blackSabbath_MBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8';

$blackScabies = "SELECT b.albumName, b.albumMBID, z.artistName, f1.dataDate, f1.albumListeners, f1.albumPlaycount, x.albumArtMB
FROM (SELECT mb.albumName, mb.albumMBID, mb.artistMBID
	FROM albumsMB mb 
	WHERE mb.artistMBID='$artistMBID') b 
JOIN artists z ON z.artistMBID = b.artistMBID
LEFT JOIN albumsMB x ON b.albumMBID = x.albumMBID
LEFT JOIN (SELECT f.*
		FROM albumsLastFM f
		INNER JOIN (SELECT albumMBID, albumListeners, albumPlaycount, max(dataDate) AS MaxDataDate
		FROM albumsLastFM
		GROUP BY albumMBID) groupedf
		ON f.albumMBID = groupedf.albumMBID
		AND f.dataDate = groupedf.MaxDataDate) f1
ON b.albumMBID = f1.albumMBID	
ORDER BY f1.albumPlaycount DESC;";

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
	
	<!-- main 
<p>Please be patient while data loads.</p>
<p>If, after the page loads, it is empty, or the wrong discography displays, <a href='https://www.roxorsoxor.com/poprock/index.php'>choose an artist</a> from the <a href='https://www.roxorsoxor.com/poprock/index.php'>Artists List</a> first.</p>
	-->
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
<th onClick="sortColumn('albumName', 'ASC', '<?php echo $artistMBID; ?>')"><div class="pointyHead">Album Name</div></th>
<!--
<th>Album MBID</th>
<th class="popStyle">LastFM<br>Data Date</th>
-->
<th onClick="sortColumn('albumListeners', 'unsorted', '<?php echo $artistMBID; ?>')"><div class="pointyHead rightNum">LastFM<br>Listeners</div></th>
<th onClick="sortColumn('albumPlaycount', 'unsorted', '<?php echo $artistMBID; ?>')"><div class="pointyHead rightNum">LastFM<br>Playcount</div></th>

</tr>

</thead>

<tbody>
					
<?php

	while ($row = mysqli_fetch_array($getit)) {
		$artistName = $row['artistName'];
		$albumMBID = $row['albumMBID'];
		$albumName = $row['albumName'];	
        //$source = 'musicbrainz';
        $coverArt = $row['albumArtMB'];

		$lastFMDate = $row[ "dataDate" ];

		$albumListenersNum = $row[ "albumListeners"];
		$albumListeners = number_format ($albumListenersNum);
		$albumPlaycountNum = $row[ "albumPlaycount"];
		$albumPlaycount = number_format ($albumPlaycountNum);

?>
					
<tr>
<td><img src='<?php echo $coverArt ?>' height='64' width='64'></td>

<td><a href='https://www.roxorsoxor.com/poprock/album_TracksListLastFM.php?artistSpotID=<?php echo $artistSpotID ?>&artistMBID=<?php echo $artistMBID ?>&albumMBID=<?php echo $albumMBID ?>&source=musicbrainz'><?php echo $albumName ?></a></td>

<!--
	<td><?php echo $albumMBID ?></td>
<td class="popStyle"><?php //echo $lastFMDate ?></td>
-->
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
<!-- -->
<script>
	let artistMBID = '<?php echo $artistMBID ?>';
	console.log(artistMBID);
</script>

<script src="https://www.roxorsoxor.com/poprock/functions/sort_artistAlbums2.js"></script>

</body>
	
</html>