<?php

$artistMBID = $_GET['artistMBID'];
$artistSpotID = $_GET['artistSpotID'];
$albumMBID = $_GET['albumMBID'];
//$source = $_GET['source'];

require_once 'rockdb.php';
//require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

$liveEvil_albumSpotID = '1Uq7JKrKGGYCkg6l79gkoa';
$crossPurposes_albumMBID = '5d2e8936-8c36-3ccd-8e8f-916e3b771d49';
$thirteen_SpotID = '46fDgOnY2RavytWwL88x5M';
$thirteen_MBID = '7dbf4b1f-d3e9-47bc-9194-d15b31017bd6';

$getAlbumTracks = "SELECT d.trackMBID, d.trackName, d.albumName, d.trackListeners, d.trackPlaycount, max(d.dataDate) AS MaxDataDate
	FROM (
		SELECT k.trackMBID, k.trackName, h.albumName, fm.dataDate, fm.trackListeners, fm.trackPlaycount
			FROM (
				SELECT m.trackMBID, m.trackName, m.albumMBID
					FROM tracksMB m
					WHERE m.albumMBID = '$albumMBID'
			) k
			INNER JOIN albumsMB h
				ON h.albumMBID = k.albumMBID
			JOIN tracksLastFM fm
				ON fm.trackMBID = k.trackMBID
	) d
	GROUP BY d.trackMBID";
/*
if ($source = 'spotify') {
	$getAlbumTracks = $SpotAndLastFM;
};

if ($source = 'musicbrainz') {
	$getAlbumTracks = $LastFMAndSpot;
};
*/
$getit = $connekt->query( $getAlbumTracks );

if ( !$getit ) {
	echo '<p>Cursed-Crap. Did not run the query. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>This Album's Tracks Popularity On Spotify</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class="container-fluid">
	<div id="fluidCon">
	</div> <!-- end of fluidCon -->

		<!-- main -->
		<!--
		-->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 id="panelTitle" class="panel-title">This Album's Tracks Popularity On Spotify</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
<table class="table" id="tableotracks">
<thead>
<tr>
<th onClick="sortColumn('trackName', 'DESC', '<?php echo $albumMBID ?>', 'musicbrainz')"><div class="pointyHead">Track Title</div></th>
<th class="popStyle" >LastFM<br>Data Date</th>
<th class="rightNum pointyHead" onClick="sortColumn('trackListeners', 'DESC', '<?php echo $albumMBID ?>', 'musicbrainz')">LastFM<br>Listeners</th>
<th class="rightNum pointyHead" onClick="sortColumn('trackPlaycount', 'DESC', '<?php echo $albumMBID ?>', 'musicbrainz')">LastFM<br>Playcount</th>
<th><div class="popStyle">LastFM<br>Ratio</div></th>
</tr>
</thead>
	
	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $getit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			$trackMBID = $row[ "trackMBID" ];
			$lastFMDate = $row[ "MaxDataDate" ];
			$trackListenersNum = $row[ "trackListeners"];
			$trackPlaycountNum = $row[ "trackPlaycount"];
			$trackListeners = number_format ($trackListenersNum);
			$trackPlaycount = number_format ($trackPlaycountNum);			

	?>
<tr>
<td><a href='https://www.roxorsoxor.com/poprock/track_Chart.php?trackMBID=<?php echo $trackMBID ?>'><?php echo $trackName ?></a></td>
<td class="popStyle"><?php echo $lastFMDate ?></td>
<td class="rightNum"><?php echo $trackListeners ?></td>
<td class="rightNum"><?php echo $trackPlaycount ?></td>
<td class="popStyle"><p>Coming Soon</p></td>
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
	const albumName = '<?php echo $albumName ?>';
	const panelTitleText = 'Popularity On Spotify for tracks from <em>' + albumName + '</em>';
	const panelTitle = document.getElementById('panelTitle');
	$(document).ready(function(){
		panelTitle.innerHTML = panelTitleText;
	});
</script>
<script>
	const artistSpotID = '<?php echo $artistSpotID ?>';
	const artistMBID = '<?php echo $artistMBID ?>';
</script>
<script src="https://www.roxorsoxor.com/poprock/functions/sort_albumTracksLastFM.js"></script>
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
	
</html>