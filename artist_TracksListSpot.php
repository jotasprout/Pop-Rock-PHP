<?php

$artistSpotID = $_GET['artistSpotID'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$blackSabbath_SpotID = '5M52tdBnJaKSvOpJGz8mfZ';

$gatherTrackInfo = "SELECT t.trackSpotID, t.trackName, a.albumName, a.artistSpotID, p1.pop, p1.date
		FROM tracks t
		INNER JOIN albums a ON a.albumSpotID = t.albumSpotID
		WHERE a.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
		JOIN (SELECT p.* FROM popTracks p
				INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
							FROM popTracks  
							GROUP BY trackSpotID) groupedp
				ON p.trackSpotID = groupedp.trackSpotID
				AND p.date = groupedp.MaxDate) p1 
		ON t.trackSpotID = p1.trackSpotID
		ORDER BY t.trackName ASC";

$gatherTrackInfo = "SELECT t.trackSpotID, t.trackName, a.albumName, a.artistSpotID, p1.pop, p1.date
		FROM tracks t
		GROUP BY albumSpotID
		INNER JOIN albums a ON a.albumSpotID = t.albumSpotID
		JOIN (SELECT p.* FROM popTracks p
				INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
							FROM popTracks  
							GROUP BY trackSpotID) groupedp
				ON p.trackSpotID = groupedp.trackSpotID
				AND p.date = groupedp.MaxDate) p1 
		ON t.trackSpotID = p1.trackSpotID
		WHERE a.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
		ORDER BY t.trackName ASC";

$gatherTrackInfo = "SELECT t.trackSpotID, t.trackName, a.albumName, a.artistSpotID, p1.pop, p1.date
		FROM tracks t
		INNER JOIN albums a ON a.albumSpotID = t.albumSpotID
		JOIN (SELECT p.* FROM popTracks p
				INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
							FROM popTracks  
							GROUP BY trackSpotID) groupedp
				ON p.trackSpotID = groupedp.trackSpotID
				AND p.date = groupedp.MaxDate) p1 
		ON t.trackSpotID = p1.trackSpotID
		WHERE a.artistSpotID = '$artistSpotID'
		ORDER BY t.trackName ASC";

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

		<?php echo $navbar ?>

		<!-- main -->
		<p>If this page is empty, or the wrong discography displays, <a href='https://www.roxorsoxor.com/poprock/index.php'>choose an artist</a> first.</p>

		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Latest Tracks Stats from My Database</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
<table class="table" id="tableotracks">
	<thead>
		<tr>
			<th onClick="sortColumn('albumName', 'DESC', '<?php echo $artistSpotID ?>')"><div class="pointyHead">Album Title</div></th>
			<th>Spotify<br>trackSpotID</th>
			
			<th onClick="sortColumn('trackName', 'ASC', '<?php echo $artistSpotID ?>')"><div class="pointyHead">Track Title</div></th>
			<th>Spotify<br>Data Date</th>
			<th class="popStyle" onClick="sortColumn('pop', 'ASC', '<?php echo $artistSpotID ?>')"><div class="pointyHead">Spotify<br>Popularity</div></th>
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
							$trackSpotID = $row[ "trackSpotID" ];
							$trackPop = $row[ "pop" ];
							$popDate = $row[ "date" ];
							$lastFMDate = $row[ "dataDate" ];
							$trackListenersNum = $row["trackListeners"];
							$trackListeners = number_format ($trackListenersNum);
							if (!$trackListeners > 0) {
								$trackListeners = "n/a";
							};
							$trackPlaycountNum = $row["trackPlaycount"];
							$trackPlaycount = number_format ($trackPlaycountNum);
							if (!$trackPlaycount > 0) {
								$trackPlaycount = "n/a";
							};
					?>
							<tr>
								<td><?php echo $albumName ?></td>
								<td><?php echo $trackSpotID ?></td>
								
								<td><?php echo $trackName ?></td>
								<td><?php echo $popDate ?></td>
								<td class="popStyle"><?php echo $trackPop ?></td>
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

<script>
	let artistSpotID = '<?php echo $artistSpotID ?>';
</script>

<script src="https://www.roxorsoxor.com/poprock/functions/sort_Tracks.js"></script>

</body>
	
</html>