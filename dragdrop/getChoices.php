<?php

require_once '../rockdb.php';
require_once '../data_text/artists_groups.php';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if (!connekt) {
    echo 'Nope. No connection.';
}

$getChoices = 'SELECT a.artistSpotID AS artistSpotID, a.artistArt AS artistArt, a.artistName AS artistName, p1.pop AS pop, p1.date AS date
FROM artists a
JOIN (SELECT p.*
        FROM popArtists p
        INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
                    FROM popArtists  
                    GROUP BY artistSpotID) groupedp
        ON p.artistSpotID = groupedp.artistSpotID
        AND p.date = groupedp.MaxDate) p1
ON a.artistSpotID = p1.artistSpotID
WHERE a.artistSpotID IN ("' . implode('", "', $dragdrop) . '")    
ORDER BY a.artistName ASC';

$getChoices2 = "SELECT a.artistSpotID AS artistSpotID, a.artistArt AS artistArt, a.artistName AS artistName, p1.pop AS pop, p1.date AS date
FROM artists a
JOIN (SELECT p.*
        FROM popArtists p
        INNER JOIN (SELECT artistSpotID, pop, max(date) AS MaxDate
                    FROM popArtists  
                    GROUP BY artistSpotID) groupedp
        ON p.artistSpotID = groupedp.artistSpotID
        AND p.date = groupedp.MaxDate) p1
ON a.artistSpotID = p1.artistSpotID
WHERE a.artistSpotID IN ('" . implode("', '", $dragdrop) . "')    
ORDER BY a.artistName ASC";

$multiArtistPop = 'SELECT a.artistSpotID, a.artistArt , a.artistName, p.pop, p.date
    FROM artists a
    JOIN popArtists p ON p.artistSpotID = a.artistSpotID
	WHERE a.artistSpotID IN ("' . implode('", "', $group_sabbathRainbow) . '")
    ORDER BY a.artistSpotID ASC';
    
$getem = mysqli_query($connekt, $multiArtistPop);

if(!$getem){
    echo 'Did not run the query.';
}	

if (mysqli_num_rows($getem) > 0) {
    $rows = array();
    while ($row = mysqli_fetch_array($getem)) {
        $rows[] = $row;
    }
    echo json_encode($rows);
}
else {
    echo "Nope. No results.";
}

mysqli_close($connekt);

?>