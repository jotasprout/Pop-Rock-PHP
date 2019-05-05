<?php
$blackSabbath_SpotID = '5M52tdBnJaKSvOpJGz8mfZ';

$blackSabbath_MBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8';

$gatherTrackInfo = "SELECT b.trackSpotID, b.trackName, b.albumName, b.artistSpotID
                    FROM (SELECT s.trackSpotID, s.trackName, s.albumSpotID, s.artistSpotID
                    FROM tracks s
                    WHERE s.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
                    UNION
                    SELECT m.trackSpotID, m.trackName, m.albumName, m.artistSpotID
                    FROM tracksMB m
                    WHERE s.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ') b
                    LEFT JOIN albums a ON a.albumSpotID = b.albumSpotID
                    LEFT JOIN albumsMB c ON c.albumMBID = b.albumMBID
                    ORDER BY t.trackName ASC";

?>