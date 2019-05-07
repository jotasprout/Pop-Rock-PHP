<?php

require_once '../../rockdb.php';

$baseURL = 'data/';
$today = date("m/d/y");
$endURL = '.json';

function assembleURL ($artistForURL) {
	$artistURL = $baseURL . $artistForURL . "_" . $today . $endURL;
	echo $artistURL;
};

$artistNames = array (
    '2Pac_Person',
    'AliceCooper_Combined',
    'Anvil_Group',
    'BlackSabbath_Group',
    'DavidBowie_Person',
    'LindseyBuckingham_Person',
    'Eminem_Person',
    'Cream_Group',
    'DefLeppard_Group',
    'Dio_Group', 
    'Elf_Group', 
    'EricClapton_Person',
    'EvilStig_Group', 
    'FleetwoodMac_Group',
    'Heaven&Hell_Group', 
    'IggyandTheStooges_Group',
    'JanetJackson_Person', 
    'JimmyPage_Person',
    'JimmyPage&RobertPlant_Group',
    'JoanJett_Combined', 
    'Journey_Group', 
    'LedZeppelin_Group',
    'MeatLoaf_Person', 
    'MötleyCrüe_Group', 
    'NeilYoung_Person',
    'StevieNicks_Person',
    'OzzyOsbourne_Person', 
    'RobertPlant_Person',
    'IggyPop_Person',
    'Queen_Group', 
    'QuietRiot_Group', 
    'Radiohead_Group',
    'Rainbow_Group', 
    'RonnieDioandtheProphets_Group', 
    'RonnieDioandtheRedCaps_Group', 
    'RoxyMusic_Group',
    'Saxon_Group', 
    'Stoney&Meatloaf_Group',
    'TedNugent_Person', 
    'TheAmboyDukes_Group',
    'TheCure_Group',
    'TheElectricElves_Group', 
    'TheFirm_Group',
    'TheRunaways_Group',
    'TheStooges_Group',
    'TheYardbirds_Group',
    'TheZombies_Group',
    'ToddRundgren_Person',
    'Utopia_Group'
);

$filenames = array (
    'data/2Pac_Person_05-04-19.json',
    'data/AliceCooper_Combined_05-04-19.json',
    'data/Anvil_Group_05-04-19.json',
    'data/BlackSabbath_Group_05-04-19.json',
    'data/DavidBowie_Person_05-04-19.json',
    'data/LindseyBuckingham_Person_05-04-19.json',
    'data/Eminem_Person_05-04-19.json',
    'data/Cream_Group_05-04-19.json',
    'data/DefLeppard_Group_05-04-19.json',
    'data/Dio_Group_05-04-19.json', 
    'data/Elf_Group_05-04-19.json', 
    'data/EricClapton_Person_05-04-19.json',
    'data/EvilStig_Group_05-04-19.json', 
    'data/FleetwoodMac_Group_05-04-19.json',
    'data/Heaven&Hell_Group_05-04-19.json', 
    'data/IggyandTheStooges_Group_05-04-19.json',
    'data/JanetJackson_Person_05-04-19.json', 
    'data/JimmyPage_Person_05-04-19.json',
    'data/JimmyPage&RobertPlant_Group_05-04-19.json',
    'data/JoanJett_Combined_05-04-19.json', 
    'data/Journey_Group_05-04-19.json', 
    'data/LedZeppelin_Group_05-04-19.json',
    'data/MeatLoaf_Person_05-04-19.json', 
    'data/MötleyCrüe_Group_05-04-19.json', 
    'data/NeilYoung_Person_05-04-19.json',
    'data/StevieNicks_Person_05-04-19.json',
    'data/OzzyOsbourne_Person_05-04-19.json', 
    'data/RobertPlant_Person_05-04-19.json',
    'data/IggyPop_Person_05-04-19.json',
    'data/Queen_Group_05-04-19.json', 
    'data/QuietRiot_Group_05-04-19.json', 
    'data/Radiohead_Group_05-04-19.json',
    'data/Rainbow_Group_05-04-19.json', 
    'data/RonnieDioandtheProphets_Group_05-04-19.json', 
    'data/RonnieDioandtheRedCaps_Group_05-04-19.json', 
    'data/RoxyMusic_Group_05-04-19.json',
    'data/Saxon_Group_05-04-19.json', 
    'data/Stoney&Meatloaf_Group_05-04-19.json',
    'data/TedNugent_Person_05-04-19.json', 
    'data/TheAmboyDukes_Group_05-04-19.json',
    'data/TheCure_Group_05-04-19.json',
    'data/TheElectricElves_Group_05-04-19.json', 
    'data/TheFirm_Group_05-04-19.json',
    'data/TheRunaways_Group_05-04-19.json',
    'data/TheStooges_Group_05-04-19.json',
    'data/TheYardbirds_Group_05-04-19.json',
    'data/TheZombies_Group_05-04-19.json',
    'data/ToddRundgren_Person_05-04-19.json',
    'data/Utopia_Group_05-04-19.json'
);

$filenames = $filenames;

$x = ceil((count($filenames)));

$y = ceil((count($artistNames)));

for ($j=0; $j<$y; ++$j){
	assembleURL ($artistNames[$j]);
};

for ($i=0; $i<$x; ++$i) {

    $jsonFile = $filenames[$i];
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
            $releasesNum = ceil((count($releases)));
            if ($releasesNum > 0){
                $releaseMBID = $album['releases'][0]['mbid'];
                $releaseNameYucky = $album['releases'][0]['name'];
                $releaseName = mysqli_real_escape_string($connekt,$releaseNameYucky);
                $albumListeners = $album['releases'][0]['listeners'];
                $albumPlaycount = $album['releases'][0]['playcount'];
				
				$insertLastFMalbumData = "INSERT INTO albumsLastFM (
					albumMBID, 
					dataDate,
					albumListeners,
					albumPlaycount
					) 
					VALUES(
						'$releaseMBID',
						'$dataDate',
						'$albumListeners',
						'$albumPlaycount'
					)";	
				
				$insertReleaseStats = $connekt->query($insertLastFMalbumData);
    
                if(!$insertReleaseStats){
                    echo '<p>Shickety Brickety! Could not insert ' . $releaseName . ' stats.</p>';
                } else {
                    echo '<p>' . $releaseName . ' had ' . $albumListeners . ' listeners and ' . $albumPlaycount . ' plays on ' . $dataDate . '.</p>';
                }
				
            }
        };
    };
};

?>