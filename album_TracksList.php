<?php

$albumSpotID = $_GET['albumSpotID'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

$gatherTrackInfo = "SELECT t.trackSpotID, t.trackName, a.albumName, a.artistSpotID, p1.pop, p1.date, f1.dataDate, f1.trackListeners, f1.trackPlaycount
						FROM tracks t
						INNER JOIN albums a ON a.albumSpotID = t.albumSpotID
						JOIN (SELECT p.* FROM popTracks p
								INNER JOIN (SELECT trackSpotID, pop, max(date) AS MaxDate
											FROM popTracks  
											GROUP BY trackSpotID) groupedp
								ON p.trackSpotID = groupedp.trackSpotID
								AND p.date = groupedp.MaxDate) p1 
						ON t.trackSpotID = p1.trackSpotID
						LEFT JOIN (SELECT f.*
								FROM tracksLastFM f
								INNER JOIN (SELECT trackMBID, trackListeners, trackPlaycount, max(dataDate) AS MaxDataDate
											FROM tracksLastFM  
											GROUP BY trackMBID) groupedf
								ON f.trackMBID = groupedf.trackMBID
								AND f.dataDate = groupedf.MaxDataDate) f1
						ON t.trackMBID = f1.trackMBID
						WHERE a.albumSpotID = '$albumSpotID'
						ORDER BY p1.pop DESC";

$getit = $connekt->query( $gatherTrackInfo );

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

				-->
			<th onClick="sortColumn('trackName', 'DESC')"><div class="pointyHead">Track Title</div></th>
			<th class="popStyle">Spotify<br>Data Date</th>
			<th class="popStyle" onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Track<br>Popularity</div></th>
			<th>LastFM<br>Data Date</th>
			<th class="rightNum pointyHead">LastFM<br>Listeners</th>
			<th class="rightNum pointyHead">LastFM<br>Playcount</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $getit ) ) {
			echo "inside the while";
			$albumName = $row[ "albumName" ];
			echo "<p>album name is " . $albumName . "</p>";
			$trackName = $row[ "trackName" ];
			echo "<p>track name is " . $trackName . "</p>";
			$trackSpotID = $row[ "trackSpotID" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "date" ];
			$lastFMDate = $row[ "dataDate" ];
			$trackListenersNum = $row[ "trackListeners"];
			$trackListeners = number_format ($trackListenersNum);
			if (!$trackListeners > 0) {
				$trackListeners = "n/a";
			};
			$trackPlaycountNum = $row[ "trackPlaycount"];
			$trackPlaycount = number_format ($trackPlaycountNum);
			if (!$trackPlaycount > 0) {
				$trackPlaycount = "n/a";
			};
	?>
<tr>
<td><?php echo $albumName ?></td>
<td><?php echo $trackSpotID ?></td>
<!--  -->
<td><a href='https://www.roxorsoxor.com/poprock/track_Chart.php?trackSpotID=<?php echo $trackSpotID ?>'><?php echo $trackName ?></a></td>
<td class="popStyle"><?php echo $popDate ?></td>
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
<script src="https://www.roxorsoxor.com/poprock/functions/sort_Tracks.js"></script>
</body>
	
</html>