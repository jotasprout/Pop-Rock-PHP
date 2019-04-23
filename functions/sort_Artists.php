<?php

require_once '../rockdb.php';


$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
    echo '<p>Darn. Did not connect. Screwed up like: ' . mysqli_connect_error() . '.</p>';
};

$postedColumnName = $_POST[ "columnName" ];
$postedCurrentOrder = $_POST[ "currentOrder" ];

// if any POSTed variables did not come through, these defaults were basic starting sort from original sql query
$columnName = "artistName";
$currentOrder = "ASC";

if ( !empty( $_POST[ "columnName" ] ) ) {
    // if the column name came through, use it
	$columnName = $_POST[ "columnName" ];
}

if ( !empty( $_POST[ "currentOrder" ] ) ) {
    // if the current order came through, use it
	$currentOrder = $_POST[ "currentOrder" ];
}
/*
// Next is for the SQL query
if ($currentOrder == "ASC" or $currentOrder == "unsorted") {
    $newOrder = "DESC";
} else {
	$newOrder = "ASC";
}
*/
///////////////////

$artistNameNewOrder = "unsorted";

if ( $columnName == "artistName" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "DESC") {
		$artistNameNewOrder = "ASC";
		$newOrder = "ASC";
	} else {
		$artistNameNewOrder = "DESC";
		$newOrder = "DESC";
	};
};

///////////////////

$popNewOrder = "unsorted";

if ( $columnName == "pop" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$popNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$popNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$followersNewOrder = "unsorted";

if ( $columnName == "followers" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$followersNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$followersNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$datadateNewOrder = "unsorted";

if ( $columnName == "datadate" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$datadateNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$datadateNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$listenersNewOrder = "unsorted";

if ( $columnName == "artistListeners" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$listenersNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$listenersNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$playcountNewOrder = "unsorted";

if ( $columnName == "artistPlaycount" ) {
	if ($currentOrder == "unsorted" or $currentOrder == "ASC") {
		$playcountNewOrder = "DESC";
		$newOrder = "DESC";
	} else {
		$playcountNewOrder = "ASC";
		$newOrder = "ASC";
	};
};

$allthatAndLastFM = "SELECT a.artistID AS artistID, a.artistArt AS artistArt, a.artistName AS artistName, a.albumsTotal AS albumsTotal, p1.pop AS pop, p1.followers AS followers, f1.dataDate AS dataDate, f1.artistListeners AS artistListeners, f1.artistPlaycount AS artistPlaycount, p1.date AS date
    FROM artists a
    JOIN (SELECT p.*
			FROM popArtists p
			INNER JOIN (SELECT artistID, pop, max(date) AS MaxDate
						FROM popArtists  
						GROUP BY artistID) groupedp
			ON p.artistID = groupedp.artistID
			AND p.date = groupedp.MaxDate) p1
	ON a.artistID = p1.artistID
	LEFT JOIN (SELECT f.*
			FROM artistsLastFM f
			INNER JOIN (SELECT artistMBID, artistListeners, artistPlaycount, max(dataDate) AS MaxDataDate
						FROM artistsLastFM  
						GROUP BY artistMBID) groupedf
			ON f.artistMBID = groupedf.artistMBID
			AND f.dataDate = groupedf.MaxDataDate) f1
	ON a.artistMBID = f1.artistMBID
	ORDER BY " . $columnName . " " . $newOrder . ";";	

$sortit = $connekt->query($allthatAndLastFM); 

if (!$sortit) {
    echo '<p>Darn. No query. Screwed up like this: ' . mysqli_error($connekt) . '</p>';
};

if (!empty($sortit)) { ?>

<table class="table" id="tableoartists">
<thead>
	<tr>
	<th>Pretty Face</th>	
	<th onClick="sortColumn('artistName', '<?php echo $artistNameNewOrder; ?>')"><div class="pointyHead">Artist Name</div></th>
	<!--
	<th class="popStyle">Spotify ID</th>
	<th class="popStyle">Spotify<br>Data Date</th>
	-->
	<th onClick="sortColumn('pop', '<?php echo $popNewOrder; ?>')"><div class="pointyHead popStyle">Spotify<br>Popularity</div></th>
	<th onClick="sortColumn('followers', '<?php echo $followersNewOrder; ?>')"><div class="pointyHead rightNum">Spotify<br>Followers</div></th>
	<!--
	<th onClick="sortColumn('datadate', '<?php echo $datadateNewOrder; ?>')"><div class="pointyHead popStyle">LastFM<br>Data Date</div></th>
	-->
	<th onClick="sortColumn('artistListeners', '<?php echo $listenersNewOrder; ?>')"><div class="pointyHead rightNum">LastFM<br>Listeners</div></th>
	<th onClick="sortColumn('artistPlaycount', '<?php echo $playcountNewOrder; ?>')"><div class="pointyHead rightNum">LastFM<br>Playcount</div></th>
	</tr>
</thead>

		<tbody>

		<?php
			while ($row = mysqli_fetch_array($sortit)) {
				$artistName = $row[ "artistName" ];
				$artistID = $row[ "artistID" ];
				$artistPop = $row[ "pop" ];
				$artistFollowersNum = $row[ "followers"];
				$artistFollowers = number_format ($artistFollowersNum);
				$artistArt = $row[ "artistArt" ];
				$popDate = $row[ "date" ];
				$albumsTotal = $row[ "albumsTotal" ];
				$lastFMDate = $row[ "dataDate" ];
				$artistListenersNum = $row[ "artistListeners"];
				$artistListeners = number_format ($artistListenersNum);
				if (!$artistListeners > 0) {
					$artistListeners = "n/a";
				};
				$artistPlaycountNum = $row[ "artistPlaycount"];
				$artistPlaycount = number_format ($artistPlaycountNum);
				if (!$artistPlaycount > 0) {
					$artistPlaycount = "n/a";
				};
		?>

<tr>
	<td><img src='<?php echo $artistArt ?>' class="indexArtistArt"></td>	
	<td><a href='https://www.roxorsoxor.com/poprock/artist_Chart.php?artistID=<?php echo $artistID ?>'><?php echo $artistName ?></a></td>
<!--
	<td class="popStyle"><?php echo $artistID ?></td>
	<td class="popStyle"><?php echo $popDate ?></td>
	-->
	<td class="popStyle"><?php echo $artistPop ?></td>
	<td id="followers" class="rightNum"><?php echo $artistFollowers ?></td>
<!--
	<td class="popStyle"><?php echo $lastFMDate ?></td>
-->
	<td class="rightNum"><?php echo $artistListeners ?></td>
	<td class="rightNum"><?php echo $artistPlaycount ?></td>
</tr>

		<?php 
			} // end of while
		?>

		</tbody>
	</table>
<?php 
	} // end of if
?>
