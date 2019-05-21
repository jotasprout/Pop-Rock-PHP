<?php

$artistSpotID = $_GET['artistSpotID'];
$albumSpotID = $_GET['albumSpotID'];
$artistMBID = $_GET['artistMBID'];

require_once 'rockdb.php';

require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

$liveEvil_albumSpotID = '1Uq7JKrKGGYCkg6l79gkoa';
$crossPurposes_albumMBID = '5d2e8936-8c36-3ccd-8e8f-916e3b771d49';
$thirteen_SpotID = '46fDgOnY2RavytWwL88x5M';
$thirteen_MBID = '7dbf4b1f-d3e9-47bc-9194-d15b31017bd6';

$getAlbumTracks = "SELECT v.trackSpotID, v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
	FROM (
		SELECT z.trackSpotID, z.trackName, r.albumName, p.date, p.pop
			FROM (
				SELECT t.trackSpotID, t.trackName, t.albumSpotID
					FROM tracks t
					WHERE t.albumSpotID = '$albumSpotID'
			) z
		INNER JOIN albums r 
			ON r.albumSpotID = z.albumSpotID
		JOIN popTracks p 
			ON z.trackSpotID = p.trackSpotID					
	) v
	GROUP BY v.trackSpotID";
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
		<!-- -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 id="panelTitle" class="panel-title">This Album's Tracks Popularity On Spotify</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
<table class="table" id="tableotracks">
<thead>
<tr>
<!--
<th onClick="sortColumn('albumName', 'ASC')"><div class="pointyHead">Album Name</div></th>
<th>Spotify<br>trackSpotID</th>
-->
<th onClick="sortColumn('trackName', 'DESC', '<?php echo $albumSpotID ?>', 'spotify')"><div class="pointyHead">Track Title</div></th>
<th class="popStyle">Spotify<br>Data Date</th>
<th class="popStyle" onClick="sortColumn('pop', 'ASC', '<?php echo $albumSpotID ?>', 'spotify')"><div class="pointyHead">Track<br>Popularity</div></th>
<!--
<th class="popStyle">LastFM<br>Data Date</th>
<th class="rightNum pointyHead">LastFM<br>Listeners</th>
<th class="rightNum pointyHead">LastFM<br>Playcount</th>
-->
</tr>
</thead>
	
	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $getit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];

			// $trackSpotID = $row[ "trackSpotID" ];		

			$trackPop = $row[ "pop" ];
			//echo "<p>trackPop is " . $trackPop . ".</p>";
			if ($trackPop == '') {
				$trackPop = "n/a";				
			};	

			$popDate = $row[ "MaxDate" ];
			if ($popDate == '') {
				$popDate = "n/a";				
			};

	?>
<tr>

<!--
	<td><?php //echo $albumName ?></td>
<td><?php //echo $trackSpotID ?></td>
-->
<td><a href='https://www.roxorsoxor.com/poprock/track_Chart.php?trackSpotID=<?php echo $trackSpotID ?>'><?php echo $trackName ?></a></td>
<td class="popStyle"><?php echo $popDate ?></td>
<td class="popStyle"><?php echo $trackPop ?></td>

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
	const albumName = "<?php echo $albumName ?>";
	const panelTitleText = 'Popularity on Spotify for tracks from <em>' + albumName + '</em>';
	const panelTitle = document.getElementById('panelTitle');
	$(document).ready(function(){
		panelTitle.innerHTML = panelTitleText;
	});
</script>
<script>
	const artistSpotID = '<?php echo $artistSpotID ?>';
	const artistMBID = '<?php echo $artistMBID ?>';
</script>

<script src="https://www.roxorsoxor.com/poprock/functions/sort_albumTracksSpot.js"></script>
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
	
</html>