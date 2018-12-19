<?php
$thrashetc = array ('2ye2Wgw4gimLv2eAKyk1NB', '14pVkFUHDL207LzLHtSA18', '1Yox196W7bzVNZI7RBaPnf', '1IQ2e1buppatiN1bxUVkrk', '3JysSUOyfVs1UQ0UaESheP', '0yLwGBQiBqhXOvmTfH2A7n', '28hJdGN1Awf7u3ifk2lVkg', '3BM0EaYmkKWuPmmHFUTQHv', '76S65NHJHrNy4JTrXHP2BH', '5fwaejlOHVBAw1KhIPPaQe', '6SYbLA9utoNsllunR1TnkM', '0NmYchKQ8JIR9QHYJA0FRe', '3dnH7fdVm2X07MK6Fkbhbt', '6KVc8Llznru8n9LVCYe9dz', '4ZISAmHmQUDCpv8xydqeKG', '0nxo4nAEYNbNpA8wwNvqXY', '0AA0qugrTsIv7JFMEnhaqu', '06T4NL0adq4kfYAr2nZv5t', '3lgxzeCbj6oMQMmaUhH2H6', '4YO2spr6BIQ3z4qs9yTisd');
require_once '../rockdb.php';
require( "class.artist.php" );
$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
if (!$connekt) {
	echo 'Darn. Did not connect.';
};
$multiArtistPop = "SELECT a.artistID, a.artistArt , a.artistName, p.pop, p.date
    FROM artists a
    JOIN popArtists p ON p.artistID = a.artistID
	WHERE a.artistID IN ('2ye2Wgw4gimLv2eAKyk1NB', '14pVkFUHDL207LzLHtSA18', '1Yox196W7bzVNZI7RBaPnf', '1IQ2e1buppatiN1bxUVkrk', '3JysSUOyfVs1UQ0UaESheP', '0yLwGBQiBqhXOvmTfH2A7n', '28hJdGN1Awf7u3ifk2lVkg', '3BM0EaYmkKWuPmmHFUTQHv', '76S65NHJHrNy4JTrXHP2BH', '5fwaejlOHVBAw1KhIPPaQe', '6SYbLA9utoNsllunR1TnkM', '0NmYchKQ8JIR9QHYJA0FRe', '3dnH7fdVm2X07MK6Fkbhbt', '6KVc8Llznru8n9LVCYe9dz', '4ZISAmHmQUDCpv8xydqeKG', '0nxo4nAEYNbNpA8wwNvqXY', '0AA0qugrTsIv7JFMEnhaqu', '06T4NL0adq4kfYAr2nZv5t', '3lgxzeCbj6oMQMmaUhH2H6', '4YO2spr6BIQ3z4qs9yTisd')
	ORDER BY a.artistID ASC";
$getit = mysqli_query($connekt, $multiArtistPop);
if(!$getit){
	echo 'Cursed-Crap. Did not run the query.';
}	
if (mysqli_num_rows($getit) > 0) {
	$rows = array();
	while ($row = mysqli_fetch_array($getit)) {
		$rows[] = $row;
	}
	echo json_encode($rows);
}
else {
	echo "Nope. Nothing to see here.";
}
mysqli_close($connekt);
?>