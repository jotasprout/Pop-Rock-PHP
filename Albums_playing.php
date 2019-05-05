<?php

$liveEvil_albumSpotID = '1Uq7JKrKGGYCkg6l79gkoa';

$crossPurposes_albumMBID = '5d2e8936-8c36-3ccd-8e8f-916e3b771d49';

$thirteen_SpotID = '46fDgOnY2RavytWwL88x5M';
$thirteen_MBID = '7dbf4b1f-d3e9-47bc-9194-d15b31017bd6';

$blackSabbath_SpotID = '5M52tdBnJaKSvOpJGz8mfZ';
$blackSabbath_MBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8';

$blackScabies = "SELECT b.albumName, b.albumMBID, b.albumSpotID, b.artistSpotID, a.year
FROM (SELECT sp.albumName, sp.albumMBID, sp.albumSpotID, sp.artistSpotID
	FROM albums sp
	WHERE sp.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ'
UNION
SELECT mb.albumName, mb.albumMBID, mb.albumSpotID, mb.artistSpotID
	FROM albumsMB mb 
	WHERE mb.artistSpotID='5M52tdBnJaKSvOpJGz8mfZ') b 
LEFT JOIN albums a ON b.albumSpotID = a.albumSpotID	
JOIN artists z ON z.artistSpotID = b.artistSpotID
LEFT JOIN albumsMB x ON b.albumMBID = x.albumMBID
ORDER BY b.albumName ASC;";


?>