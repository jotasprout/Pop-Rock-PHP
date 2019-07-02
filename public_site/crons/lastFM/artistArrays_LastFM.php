<?php
/*
function assembleURL ($artistForURL) {
    $baseURL = 'data/';
	$today = date("m-d-y");
	//$today = "05-19-19";
    $endURL = '.json';
	$artistURL = $baseURL . $artistForURL . "_" . $today . $endURL;
	//echo "<p>" . $artistURL . "</p>";
};
*/

function insertLastFMtrackDataArtistNames ($artistNames) {
	
	$y = ceil((count($artistNames)));
	
	for ($i=0; $i<$y; ++$i){
		
		$artistForURL = $artistNames[$i];
		$baseURL = 'data/';
		$today = date("m-d-y");
		//$today = "05-19-19";
		$endURL = '.json';
		$artistURL = $baseURL . $artistForURL . "_" . $today . $endURL;
		echo "<p>" . $artistURL . "</p>";

		$jsonFile = $artistURL;
		$fileContents = file_get_contents($jsonFile);
		$artistData = json_decode($fileContents,true);

		$artistMBID = $artistData['mbid'];
		$artistNameMB = $artistData['name'];
		echo "<h1>" . $artistNameMB . "</h1>";

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
					$release = $releases[0];
					$releaseMBID = $album['releases'][0]['mbid'];
					$releaseName = $album['releases'][0]['name'];
					echo "<h2>" . $releaseName . "</h2>";

					$tracks = $release['tracks'];
					$tracksNum = ceil((count($tracks)));   

					for ($m=0; $m<$tracksNum; ++$m) {
						$track = $tracks[$m];
						$trackMBID = $track['mbid'];
						$trackNameYucky = $track['title'];
						$trackNameMB = mysqli_real_escape_string($connekt,$trackNameYucky);
						$trackListeners = $track['stats']['listeners'];
						$trackPlaycount = $track['stats']['playcount'];

						$insertMBIDtrackInfo = "INSERT INTO tracksMB (
							albumMBID,
							trackMBID,
							trackNameMB
							) 
							VALUES(
								'$releaseMBID',
								'$trackMBID',
								'$trackNameMB'
							)";

						$addTrack = $connekt->query($insertMBIDtrackInfo);

						if(!$addTrack){
							echo '<p>Could not add <b>' . $trackNameMB . '</b> into tracksMB.</p>';
						} else {
							echo '<p>Added <b>' . $trackNameMB . '</b> from <i>' . $releaseName . '</i> into tracksMB.</p>';
						};

						$insertLastFMtrackStats = "INSERT INTO tracksLastFM (
							trackMBID, 
							dataDate,
							trackListeners,
							trackPlaycount 
							) 
							VALUES(
								'$trackMBID',
								'$dataDate',
								'$trackListeners',
								'$trackPlaycount'
							)";

						$pushTrack = $connekt->query($insertLastFMtrackStats);

						if(!$pushTrack){
							echo '<p>Shickety Brickety! Could not insert ' . $trackNameMB . ' stats.</p>';
						} else {
							echo '<p>' . $trackNameMB . ' from ' . $releaseName . ' had ' . $trackListeners . ' listeners and ' . $trackPlaycount . ' plays on ' . $dataDate . '.</p>';
						}; // end of IF query is not successful ELSE it is      
					} // end of FOR each track on the album
				}; // end of IF there are releases
			}; // end of FOR every album
		}; // end of IF database connection       
	}; // end of FOR each artist in array
}; // end of FUNCTION insert tracks

function insertLastFMalbumDataArtistNames ($artistNames) {
	
	$y = ceil((count($artistNames)));
	
	for ($j=0; $j<$y; ++$j){
		
		$artistForURL = $artistNames[$j];
		$baseURL = 'data/';
		$today = date("m-d-y");
		//$today = "05-19-19";
		$endURL = '.json';
		$artistURL = $baseURL . $artistForURL . "_" . $today . $endURL;
		echo "<p>" . $artistURL . "</p>";

		$jsonFile = $artistURL;
		$fileContents = file_get_contents($jsonFile);
		$artistData = json_decode($fileContents,true);

		$artistMBID = $artistData['mbid'];
		$artistNameMB = $artistData['name'];
		echo "<h1>" . $artistNameMB . "</h1>";

		$dataDate = $artistData['date'];

		$albums = $artistData['albums'];

		$albumsNum = ceil((count($albums)));

		$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

		if(!$connekt){
			echo 'Fiddlesticks! Could not connect to database.<br>';
		} else {

			for ($q=0; $q<$albumsNum; ++$q) {
				$album = $albums[$q];
				$releases = $album['releases'];
				$releasesNum = ceil((count($releases)));
				if ($releasesNum > 0){
					$releaseMBID = $album['releases'][0]['mbid'];
					$releaseNameYucky = $album['releases'][0]['name'];
					$releaseName = mysqli_real_escape_string($connekt,$releaseNameYucky);
					$albumListeners = $album['releases'][0]['listeners'];
					$albumPlaycount = $album['releases'][0]['playcount'];

					$insertAlbumMBinfo = "INSERT INTO albumsMB (
						albumMBID,
						albumNameMB,
						artistMBID
						) 
						VALUES(
							'$releaseMBID',
							'$releaseName',
							'$artistMBID'
							)";

					$rockout = $connekt->query($insertAlbumMBinfo);
		
					if(!$rockout){
						echo '<p>Shuzbutt! Could not add <b>' . $releaseName . '</b> to albumsMB.</p>';
					};

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
						echo '<p>Shickety Brickety! Could not insert <b>' . $releaseName . '</b> stats.</p>';
					} else {
						echo '<p><b>' . $releaseName . '</b> had ' . $albumListeners . ' listeners and ' . $albumPlaycount . ' plays on ' . $dataDate . '.</p>';
					}; // end of if stats are inserted

				}; // end of if there are any releases for this album
			}; // end of FOR each album
		}; // End of IF ELSE connect to db
	}; // End of FOR each artist name
}; // end of Function


function insertLastFMtrackDataFilenames ($filenames) {
	
	$y = ceil((count($filenames)));
	
	for ($i=0; $i<$y; ++$i){
		
		$jsonFile = $filenames[$i];
		$fileContents = file_get_contents($jsonFile);
		$artistData = json_decode($fileContents,true);

		$artistMBID = $artistData['mbid'];
		$artistNameMB = $artistData['name'];
		echo "<h1>" . $artistNameMB . "</h1>";

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
					$release = $releases[0];
					$releaseMBID = $album['releases'][0]['mbid'];
					$releaseName = $album['releases'][0]['name'];
					echo "<h2>" . $releaseName . "</h2>";

					$tracks = $release['tracks'];
					$tracksNum = ceil((count($tracks)));   

					for ($m=0; $m<$tracksNum; ++$m) {
						$track = $tracks[$m];
						$trackMBID = $track['mbid'];
						$trackNameYucky = $track['title'];
						$trackNameMB = mysqli_real_escape_string($connekt,$trackNameYucky);
						$trackListeners = $track['stats']['listeners'];
						$trackPlaycount = $track['stats']['playcount'];

						$insertMBIDtrackInfo = "INSERT INTO tracksMB (
							albumMBID,
							trackMBID,
							trackNameMB
							) 
							VALUES(
								'$releaseMBID',
								'$trackMBID',
								'$trackNameMB'
							)";

						$addTrack = $connekt->query($insertMBIDtrackInfo);

						if(!$addTrack){
							echo '<p>Could not add <b>' . $trackNameMB . '</b> into tracksMB.</p>';
						} else {
							echo '<p>Added <b>' . $trackNameMB . '</b> from <i>' . $releaseName . '</i> into tracksMB.</p>';
						};

						$insertLastFMtrackStats = "INSERT INTO tracksLastFM (
							trackMBID, 
							dataDate,
							trackListeners,
							trackPlaycount 
							) 
							VALUES(
								'$trackMBID',
								'$dataDate',
								'$trackListeners',
								'$trackPlaycount'
							)";

						$pushTrack = $connekt->query($insertLastFMtrackStats);

						if(!$pushTrack){
							echo '<p>Shickety Brickety! Could not insert ' . $trackNameMB . ' stats.</p>';
						} else {
							echo '<p>' . $trackNameMB . ' from ' . $releaseName . ' had ' . $trackListeners . ' listeners and ' . $trackPlaycount . ' plays on ' . $dataDate . '.</p>';
						}; // end of IF query is not successful ELSE it is      
					} // end of FOR each track on the album
				}; // end of IF there are releases
			}; // end of FOR every album
		}; // end of IF database connection       
	}; // end of FOR each artist in array
}; // end of FUNCTION insert tracks


function insertLastFMalbumDataFilenames ($filenames) {
	
	$x = ceil((count($filenames)));
	
	for ($i=0; $i<$x; ++$i) {

		$jsonFile = $filenames[$i];
		$fileContents = file_get_contents($jsonFile);

		$artistData = json_decode($fileContents,true);

		$artistMBID = $artistData['mbid'];
		$artistNameMB = $artistData['name'];

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
};

$aliceJJ = array (
	'data/AliceCooper_Combined_06-16-19.json',
	'data/JoanJett_Combined_06-16-19.json'
);

$filenames_01 = array (
    'data/AliceCooper_Combined_06-09-19.json',
    'data/TheAmboyDukes_Group_06-09-19.json',
    'data/EvilStig_Group_06-09-19.json', 
    'data/JoanJett_Combined_06-09-19.json', 
	'data/TheRunaways_Group_06-09-19.json',
    'data/TedNugent_Person_06-09-19.json', 
    'data/DavidBowie_Person_06-09-19.json',
    'data/JanetJackson_Person_06-09-19.json',	
    'data/AliceCooper_Combined_06-02-19.json',
    'data/TheAmboyDukes_Group_06-02-19.json',
    'data/EvilStig_Group_06-02-19.json', 
    'data/JoanJett_Combined_06-02-19.json', 
	'data/TheRunaways_Group_06-02-19.json',
    'data/TedNugent_Person_06-02-19.json', 
    'data/DavidBowie_Person_06-02-19.json',
    'data/JanetJackson_Person_06-02-19.json',	
    'data/AliceCooper_Combined_05-30-19.json',
    'data/TheAmboyDukes_Group_05-30-19.json',
    'data/EvilStig_Group_05-30-19.json', 
    'data/JoanJett_Combined_05-30-19.json', 
	'data/TheRunaways_Group_05-30-19.json',
    'data/TedNugent_Person_05-30-19.json', 
    'data/DavidBowie_Person_05-30-19.json',
    'data/JanetJackson_Person_05-30-19.json'
);

$artistNames_01 = array (
	'AliceCooper_Combined',
	'EvilStig_Group',
	'JoanJett_Combined',
	'TheRunaways_Group',
    'TheAmboyDukes_Group',
	'TedNugent_Person', 
	'DavidBowie_Person',
	'JanetJackson_Person'
);

$filenames_02 = array (
    'data/Anvil_Group_06-10-19.json',
    'data/LindseyBuckingham_Person_06-10-19.json',
    'data/TheCure_Group_06-10-19.json',
    'data/Eminem_Person_06-10-19.json',
    'data/FleetwoodMac_Group_06-10-19.json',
    'data/StevieNicks_Person_06-10-19.json',
    'data/Radiohead_Group_06-10-19.json',	
    'data/Anvil_Group_06-03-19.json',
    'data/LindseyBuckingham_Person_06-03-19.json',
    'data/TheCure_Group_06-03-19.json',
    'data/Eminem_Person_06-03-19.json',
    'data/FleetwoodMac_Group_06-03-19.json',
    'data/StevieNicks_Person_06-03-19.json',
    'data/Radiohead_Group_06-03-19.json',	
    'data/Anvil_Group_05-27-19.json',
    'data/LindseyBuckingham_Person_05-27-19.json',
    'data/TheCure_Group_05-27-19.json',
    'data/Eminem_Person_05-27-19.json',
    'data/FleetwoodMac_Group_05-27-19.json',
    'data/StevieNicks_Person_05-27-19.json',
    'data/Radiohead_Group_05-27-19.json'
);

$artistNames_02 = array (
    'Anvil_Group',
    'LindseyBuckingham_Person',
	'TheCure_Group',
    'Eminem_Person',
    'FleetwoodMac_Group',
    'StevieNicks_Person',
    'Radiohead_Group'
);

$filenames_03 = array (
    'data/BlackSabbath_Group_05-28-19.json',
    'data/Dio_Group_05-28-19.json', 
    'data/Elf_Group_05-28-19.json', 
    'data/TheElectricElves_Group_05-28-19.json', 
    'data/Heaven&Hell_Group_05-28-19.json', 
    'data/OzzyOsbourne_Person_05-28-19.json', 
	'data/Rainbow_Group_05-28-19.json',
    'data/RonnieDioandtheProphets_Group_05-28-19.json', 
	'data/RonnieDioandtheRedCaps_Group_05-28-19.json',
    'data/BlackSabbath_Group_06-04-19.json',
    'data/Dio_Group_06-04-19.json', 
    'data/Elf_Group_06-04-19.json', 
    'data/TheElectricElves_Group_06-04-19.json', 
    'data/Heaven&Hell_Group_06-04-19.json', 
    'data/OzzyOsbourne_Person_06-04-19.json', 
	'data/Rainbow_Group_06-04-19.json',
    'data/RonnieDioandtheProphets_Group_06-04-19.json', 
	'data/RonnieDioandtheRedCaps_Group_06-04-19.json',
    'data/BlackSabbath_Group_06-11-19.json',
    'data/Dio_Group_06-11-19.json', 
    'data/Elf_Group_06-11-19.json', 
    'data/TheElectricElves_Group_06-11-19.json', 
    'data/Heaven&Hell_Group_06-11-19.json', 
    'data/OzzyOsbourne_Person_06-11-19.json', 
	'data/Rainbow_Group_06-11-19.json',
    'data/RonnieDioandtheProphets_Group_06-11-19.json', 
    'data/RonnieDioandtheRedCaps_Group_06-11-19.json'	
);

$artistNames_03 = array (
	'BlackSabbath_Group',
	'Dio_Group', 
    'Elf_Group',
	'TheElectricElves_Group',
	'Heaven&Hell_Group',
	'OzzyOsbourne_Person',
	'Rainbow_Group',
	'RonnieDioandtheProphets_Group', 
    'RonnieDioandtheRedCaps_Group'
);

$filenames_04 = array (
    'data/TheFirm_Group_06-05-19.json',
    'data/JimmyPage_Person_06-05-19.json',
    'data/JimmyPage&RobertPlant_Group_06-05-19.json',
    'data/LedZeppelin_Group_06-05-19.json',
    'data/RobertPlant_Person_06-05-19.json',
	'data/TheYardbirds_Group_06-05-19.json',
    'data/TheFirm_Group_06-12-19.json',
    'data/JimmyPage_Person_06-12-19.json',
    'data/JimmyPage&RobertPlant_Group_06-12-19.json',
    'data/LedZeppelin_Group_06-12-19.json',
    'data/RobertPlant_Person_06-12-19.json',
	'data/TheYardbirds_Group_06-12-19.json',
    'data/TheFirm_Group_05-29-19.json',
    'data/JimmyPage_Person_05-29-19.json',
    'data/JimmyPage&RobertPlant_Group_05-29-19.json',
    'data/LedZeppelin_Group_05-29-19.json',
    'data/RobertPlant_Person_05-29-19.json',
    'data/TheYardbirds_Group_05-29-19.json'
);

$artistNames_04 = array (
	'TheFirm_Group',
	'JimmyPage_Person',
    'JimmyPage&RobertPlant_Group',
	'LedZeppelin_Group',
	'RobertPlant_Person',
	'TheYardbirds_Group'
);

$filenames_05 = array (
    'data/IggyandTheStooges_Group_05-30-19.json',
    'data/IggyPop_Person_05-30-19.json',
    'data/Journey_Group_05-30-19.json', 
    'data/MeatLoaf_Person_05-30-19.json', 
    'data/Stoney&Meatloaf_Group_05-30-19.json',
    'data/TheStooges_Group_05-30-19.json'
);

$artistNames_05 = array (
	'IggyandTheStooges_Group',
	'IggyPop_Person',
	'Journey_Group',
	'MeatLoaf_Person',
	'Stoney&Meatloaf_Group',
	'TheStooges_Group'
);

$filenames_06 = array (
    'data/2Pac_Person_05-31-19.json',
    'data/DefLeppard_Group_05-31-19.json',
    'data/MötleyCrüe_Group_05-31-19.json',
    'data/Queen_Group_05-31-19.json', 
    'data/QuietRiot_Group_05-31-19.json', 
    'data/ToddRundgren_Person_05-31-19.json',
	'data/Utopia_Group_05-31-19.json',
	'data/2Pac_Person_06-14-19.json',
    'data/DefLeppard_Group_06-14-19.json',
    'data/MötleyCrüe_Group_06-14-19.json',
    'data/Queen_Group_06-14-19.json', 
    'data/QuietRiot_Group_06-14-19.json', 
    'data/ToddRundgren_Person_06-14-19.json',
    'data/Utopia_Group_06-14-19.json'
);

$artistNames_06 = array (
	'2Pac_Person',
	'DefLeppard_Group',
	'MötleyCrüe_Group',
	'Queen_Group', 
    'QuietRiot_Group',
	'ToddRundgren_Person',
    'Utopia_Group'
);

$filenames_07 = array (
    'data/Cream_Group_06-01-19.json',
    'data/EricClapton_Person_06-01-19.json',
    'data/RoxyMusic_Group_06-01-19.json',
    'data/Saxon_Group_06-01-19.json', 
    'data/NeilYoung_Person_06-01-19.json',
	'data/TheZombies_Group_06-01-19.json',
    'data/Cream_Group_06-08-19.json',
    'data/EricClapton_Person_06-08-19.json',
    'data/RoxyMusic_Group_06-08-19.json',
    'data/Saxon_Group_06-08-19.json', 
    'data/NeilYoung_Person_06-08-19.json',
    'data/TheZombies_Group_06-08-19.json'	
);

$artistNames_07 = array (
	'Cream_Group',
	'EricClapton_Person',
	'RoxyMusic_Group',
    'Saxon_Group',
	'NeilYoung_Person',
    'TheZombies_Group',
);

?>