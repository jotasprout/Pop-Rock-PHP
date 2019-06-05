<?php

$artistSpotID = $_GET['artistSpotID'];
$artistMBID = $_GET['artistMBID'];
$source = $_GET['source'];

require_once 'rockdb.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$blackSabbath_SpotID = '5M52tdBnJaKSvOpJGz8mfZ';

$gatherTrackInfo = "SELECT v.artistName, v.trackName, v.albumName, v.pop, max(v.date) AS MaxDate
					FROM (
						SELECT z.artistName, z.trackSpotID, z.trackName, z.albumName, p.date, p.pop
							FROM (
								SELECT t.*, r.albumName, a.artistName
									FROM tracks t
									INNER JOIN albums r ON r.albumSpotID = t.albumSpotID
									JOIN artists a ON r.artistSpotID = a.artistSpotID
									WHERE a.artistSpotID = '$artistSpotID'
							) z
						JOIN popTracks p 
							ON z.trackSpotID = p.trackSpotID					
					) v
					GROUP BY v.trackSpotID
					ORDER BY v.pop DESC";

$getit = $connekt->query( $gatherTrackInfo );

if ( !$getit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Stats for All Tracks By This Artist</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class="container-fluid">

	<div id="fluidCon">
	</div> <!-- end of fluidCon -->

		<!-- main -->

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 id='panelTitle' class="panel-title">Latest Tracks Stats from My Database</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
<table class="table" id="tableotracks">
	<thead>
	<tr>
		<th onClick="sortColumn('albumName', 'DESC', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Album Title</div></th>
		<th onClick="sortColumn('trackName', 'ASC', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Track Title</div></th>
		<th class="popStyle" onClick="sortColumn('pop', 'ASC', '<?php echo $artistSpotID ?>', '<?php echo $source ?>')"><div class="pointyHead">Spotify<br>Popularity</div></th>
		<th>Spotify<br>Data Date</th>
		<!--
		
		<th>Spotify<br>trackSpotID</th>
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
							$artistName = $row[ "artistName" ];
							$trackName = $row[ "trackName" ];
							$trackPop = $row[ "pop" ];
							$popDate = $row[ "MaxDate" ];

					?>
							<tr>
								<td><?php echo $albumName ?></td>
								<td><?php echo $trackName ?></td>
								<td><?php echo $popDate ?></td>
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
	const artistName = '<?php echo $artistName ?>';
	const panelTitleText = 'Spotify stats for all tracks by ' + artistName;
	const panelTitle = document.getElementById('panelTitle');
	const docTitleText = 'All ' + artistName + ' tracks Spotify Stats';
	$(document).ready(function(){
		panelTitle.innerHTML = panelTitleText;
		document.title = docTitleText;
	});
</script>
<script>
	const artistSpotID = '<?php echo $artistSpotID ?>';
	const artistMBID = '<?php echo $artistMBID ?>';
</script>
<script src="https://www.roxorsoxor.com/poprock/functions/sort_artistTracksSpot.js"></script>
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
	
</html>