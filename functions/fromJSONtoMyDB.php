<?php

$jsonFile="../data_text/Anvil_Group_03-01-19.json";

$fileContents = file_get_contents($jsonFile);

$artistData = json_decode($fileContents,true);


$artistName = $artistData['name'];
$artistListeners = $artistData['stats']['listeners'];
echo $artistName . ' has ' . $artistListeners . ' listeners.';




?>