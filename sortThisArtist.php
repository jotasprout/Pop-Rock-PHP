<?php 

include 'sesh.php';
$artistID = $_SESSION['artist'];
$_SESSION['artist'] = $artistID;
require_once 'rockdb.php';
require_once 'artists.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!$connekt) {
	echo 'Darn. Did not connect.';
};	

$artistInfoAll = "SELECT a.artistID, a.artistName, b.pop, b.date 
	FROM artists a
		INNER JOIN popArtists b ON a.artistID = b.artistID
			WHERE a.artistID = '$artistID'
				ORDER BY b.date ASC";

$getit = $connekt->query($artistInfoAll);

if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}

if(!empty($sortit))	 { ?>

	<table class="table-content">
		<thead>
			<tr>
				<th>Artist Name</th>
				<th>Popularity</th>
				<th onClick="sortColumn('date', '<?php echo $dateNextOrder; ?>')">Date</th>
			</tr>
		</thead>
		<tbody>

<?php
		while ($row = mysqli_fetch_array($getit)) {
	// $artistID = $row["artistID"];
	$artistName = $row["artistName"];
	$artistPop = $row["pop"];
	$popDate = $row["date"];
	
?>

	<tr>
		<td><?php echo $artistName; ?></td>
		<td><?php echo $artistPop; ?></td>
		<td><?php echo $popDate; ?></td>
	</tr>

<?php
} // end of while
?>
</tbody>
</table>
<?php
} // end of if
?>