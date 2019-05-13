<?php

$artistSpotID = $_GET['artistSpotID'];
$albumSpotID = $_GET['albumSpotID'];
$albumMBID = $_GET['albumMBID'];
$source = $_GET['source'];

echo $source;

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

$liveEvil_albumSpotID = '1Uq7JKrKGGYCkg6l79gkoa';
$crossPurposes_albumMBID = '5d2e8936-8c36-3ccd-8e8f-916e3b771d49';
$thirteen_SpotID = '46fDgOnY2RavytWwL88x5M';
$thirteen_MBID = '7dbf4b1f-d3e9-47bc-9194-d15b31017bd6';

$getAlbumTracks = "SELECT d.trackName, d.albumName, d.trackListeners, d.trackPlaycount, max(d.dataDate) AS MaxDataDate
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

		<?php echo $navbar ?>

		<!-- main -->
		<p>Please be patient while data loads.</p>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">This Album's Tracks Popularity On Spotify</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
<table class="table" id="tableotracks">
	<thead>
		<tr>
			<th onClick="sortColumn('albumName', 'ASC')"><div class="pointyHead">Album Name</div></th>
			<th>Spotify<br>trackSpotID</th>
				<!--
			<th onClick="sortColumn('trackName', 'DESC')"><div class="pointyHead">Track Title</div></th>
			<th class="popStyle">Spotify<br>Data Date</th>
			<th class="popStyle" onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Track<br>Popularity</div></th>					
				-->
				

			<th class="popStyle">LastFM<br>Data Date</th>
			<th class="rightNum pointyHead">LastFM<br>Listeners</th>
			<th class="rightNum pointyHead">LastFM<br>Playcount</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $getit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
/*
			$trackSpotID = $row[ "trackSpotID" ];
			echo "<p>trackSpotID is " . $trackSpotID . ".</p>";
			if ($trackSpotID == '') {
				$trackSpotID = "n/a";			
			};		

			$trackPop = $row[ "pop" ];
			echo "<p>trackPop is " . $trackPop . ".</p>";
			if ($trackPop == '') {
				$trackPop = "n/a";				
			};	

			$popDate = $row[ "MaxDate" ];
			if ($popDate == '') {
				$popDate = "n/a";				
			};
*/
			$lastFMDate = $row[ "MaxDataDate" ];
			if ($lastFMDate == 'NULL') {
				$lastFMDate = "n/a";
			};			
			$trackListenersNum = $row[ "trackListeners"];
			echo "<p>trackListenersNum is " . $trackListenersNum . ".</p>";
			if ($trackListenersNum != 'NULL') {
				$trackListeners = number_format ($trackListenersNum);
				if (!$trackListeners > 0) {
					$trackListeners = "n/a";
				};
			};

			$trackPlaycountNum = $row[ "trackPlaycount"];
			echo "<p>trackPlaycountNum is " . $trackPlaycountNum . ".</p>";
			if ($trackPlaycountNum != 'NULL'){
				$trackPlaycount = number_format ($trackPlaycountNum);
				if (!$trackPlaycount > 0) {
					$trackPlaycount = "n/a";
				};
			};

	?>
<tr>
<td><?php echo $albumName ?></td>
<td><?php echo $trackMBID ?></td>

<td><a href='https://www.roxorsoxor.com/poprock/track_Chart.php?trackMBID=<?php echo $trackMBID ?>'><?php echo $trackName ?></a></td>
<!-- 
	<td class="popStyle"><?php //echo $popDate ?></td>
<td class="popStyle"><?php //echo $trackPop ?></td>
 -->
<td class="popStyle"><?php echo $lastFMDate ?></td>
<td class="rightNum"><?php echo $trackListeners ?></td>
<td class="rightNum"><?php echo $trackPlaycount ?></td>
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
<script src="https://www.roxorsoxor.com/poprock/functions/sort_Tracks.js"></script>
</body>
	
</html>