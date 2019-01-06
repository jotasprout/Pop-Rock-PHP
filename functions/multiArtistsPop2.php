<?php
$latin = array ('7CJiKj8TrQSms0WSCKbHm4', '4PtVXWSOmF4Tox1jj6ctSq', '3MqjsWDLhq8SyY6N3PE8yW', '3oNy8cjBtJzLC07I70sklp', '5XsWrYhwadPBjW20qYbdZg', '2mSHY8JOR0nRi3mtHqVa04', '3qAPxVwIQRBuz5ImPUxpZT', '27Owkm4TGlMqb0BqaEt3PW', '2QWIScpFDNxmS6ZEMIUvgm', '60uh2KYYSCqAgJNxcU4DA0', '4U7lXyKdSf1JbM1aXvsodC', '6IdtcAwaNVAggwd6sCKgTI');

require_once '../rockdb.php';
require( "class.artist.php" );
$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);
if (!$connekt) {
	echo 'Darn. Did not connect.';
};
$multiArtistPop = "SELECT a.artistID, a.artistArt , a.artistName, p.pop, p.date
    FROM artists a
    JOIN popArtists p ON p.artistID = a.artistID
	WHERE a.artistID IN ('7CJiKj8TrQSms0WSCKbHm4', '4PtVXWSOmF4Tox1jj6ctSq', '3MqjsWDLhq8SyY6N3PE8yW', '3oNy8cjBtJzLC07I70sklp', '5XsWrYhwadPBjW20qYbdZg', '2mSHY8JOR0nRi3mtHqVa04', '3qAPxVwIQRBuz5ImPUxpZT', '27Owkm4TGlMqb0BqaEt3PW', '2QWIScpFDNxmS6ZEMIUvgm', '60uh2KYYSCqAgJNxcU4DA0', '4U7lXyKdSf1JbM1aXvsodC', '6IdtcAwaNVAggwd6sCKgTI')
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