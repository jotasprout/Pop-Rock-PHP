<?php

require_once '../rockdb.php';
require_once 'artists.php';
require_once '../page_pieces/navbar_rock.php';
require_once '../page_pieces/stylesAndScripts.php';

$jsonFile = '../data_text/jsonLastFM/AliceCooper_Combined_03-08-19.json';
$fileContents = file_get_contents($jsonFile);

$artistData = json_decode($fileContents,true);

$artistMBID = $artistData['mbid'];
$artistName = $artistData['name'];

$dataDate = $artistData['date'];

$albums = $artistData['albums'];

$albumsNum = ceil((count($albums)));

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if(!$connekt){
    echo 'Fiddlesticks! Could not connect to database.<br>';
} else {

    for ($j=0; $j<$albumsNum; ++$j) {
        $album = $albums[$j];
        $releases = $album['releases'];
        $release = $releases[$k];
        $releaseMBID = $release['mbid'];
        $releaseName = $release['name'];

        $selectCurrentAlbums = "INSERT INTO artistListenersPlaycount (
            artistMBID, 
            dataDate, 
            artistListeners, 
            artistPlaycount
            ) 
            VALUES(
                '$artistMBID',
                '$dataDate',
                '$artistListeners', 
                '$artistPlaycount'
            )";

            $insertMBIDalbums = "INSERT INTO artistListenersPlaycount (
                artistMBID, 
                dataDate, 
                artistListeners, 
                artistPlaycount
                ) 
                VALUES(
                    '$artistMBID',
                    '$dataDate',
                    '$artistListeners', 
                    '$artistPlaycount'
                )";



            $tracks = $release['tracks'];
            $tracksNum = ceil((count($tracks)));   
            
            for ($m=0; $m<$tracksNum; ++$m) {
                $track = $tracks[$m];
                $trackMBID = $track['mbid'];
                $trackName = $track['name'];
                $trackListeners = $track['stats']['listeners'];
                $trackPlaycount = $track['stats']['playcount'];
            };
        };
    };




    $insertMBIDalbums = "INSERT INTO artistListenersPlaycount (
        artistMBID, 
        dataDate, 
        artistListeners, 
        artistPlaycount
        ) 
        VALUES(
            '$artistMBID',
            '$dataDate',
            '$artistListeners', 
            '$artistPlaycount'
        )";

    $rockout = $connekt->query($insertMBIDalbums);


    if(!$rockout){
        echo 'Shickety Brickety! Could not insert albums for ' . $artistName . '.<br>';
    } else {
        echo ' Inserted ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays for ' . $artistName . '.<br>';
    }


    
    echo $artistName . ' had ' . $artistListeners . ' listeners and ' . $artistPlaycount . ' plays on ' . $dataDate . '.<br>';
    

    
 
    
};

?>