<?php

require_once '../../rockdb.php';

$filenames = array (
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-14-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-17-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-21-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-22-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-24-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-25-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-27-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_02-28-19.json',        
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-01-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-03-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-06-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-08-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-14-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-16-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-17-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-20-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-21-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-22-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-25-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-27-19.json', 
    '../../data_text/jsonLastFM/BlackSabbath_Group_03-29-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_04-02-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_04-03-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_04-04-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_04-05-19.json',
    '../../data_text/jsonLastFM/BlackSabbath_Group_04-06-19.json' 
);

class Blackalbum {
	
	public $albummbid;
	
	function __construct($albummbid) {
		$this -> albummbid = $albummbid;
	}
	
	public function setAlbummbid ($newAlbummbid){
		$this -> albummbid = $newAlbummbid;
	}

	public function getAlbummbid (){
		return $this -> albummbid;
	}
	
	public $records = array ();	
	
	public function addRecord ($newRecord) {
		$this -> records[] = $newRecord;
	}	
		
}

class Blackrelease {
	
    public $name;
    public $releasembid;
	public $country;
	public $datadate;
	public $listeners;
	public $playcount;
	public $disambiguation;
	
	function __construct($releasembid, $country) {
		$this -> releasembid = $releasembid;
		$this -> country = $country;
	}	
	
	public function setName ($name){
		$this -> name = $name;
	}

	public function getName (){
		return $this -> name;
    }
        
    public function setReleasembid ($releasembid){
		$this -> releasembid = $releasembid;
	}

	public function getReleasembid (){
		return $this -> releasembid;
	}
	
	public function setCountry ($country){
		$this -> country = $country;
	}

	public function getCountry (){
		return $this -> country;
    }	
	
	public function getDisambiguation (){
		return $this -> disambiguation;
    }
	
	public function setDisambiguation ($disambiguation){
		$this -> disambiguation = $disambiguation;
    }	
	
	public function setDatadate ($datadate){
		$this -> datadate = $datadate;
	}

	public function getDatadate (){
		return $this -> datadate;
	}
	
	public function setListeners ($listeners){
		$this -> listeners = $listeners;
	}

	public function getListeners (){
		return $this -> listeners;
	}	
	
	public function setPlaycount ($playcount){
		$this -> playcount = $playcount;
	}

	public function getPlaycount (){
		return $this -> playcount;
	}
		
}

$vol4 = new Blackalbum ('8c292627-3459-3852-8ebc-226c12db175d');
$ba = new Blackalbum ('de7de788-0f31-338a-9d82-8a09108e429f');

$bad = new Blackrelease ('0a3342f6-59a4-4ee0-a81c-6d5d4900f118', 'None');
$bagbdeluxe = new Blackrelease ('52c37691-e97e-3959-98c8-8b9a533eaeda', 'GB');
$vol4usa = new Blackrelease ('257c6df7-26b8-4283-908a-3e625e41cdbe', 'US');
$vol4xe = new Blackrelease ('41e41680-3652-432f-8225-fb033c4fdae0', 'XE');
$cog = new Blackrelease ('19772a1c-ea39-4104-bc99-ffc2203ea2ae', 'US');
	
$bagbdeluxe -> setDisambiguation ('Deluxe Edition');
$bad -> setDisambiguation ('');
$vol4usa -> setDisambiguation ('');
$vol4xe -> setDisambiguation ('');
$cog -> setDisambiguation ('');	

$vol4 -> addRecord ($cog);
$vol4 -> addRecord ($vol4xe);
$vol4 -> addRecord ($vol4usa);

$ba -> addRecord ($bagbdeluxe);
$ba -> addRecord ($bad);

$recordCollection = array ();

$x = ceil((count($filenames)));

function packAndShip ($foundRelease, $targetRelease) {
	$targetRelease->name = $foundRelease['name'];
	$targetRelease->listeners = $foundRelease['listeners'];
	$targetRelease->playcount = $foundRelease['playcount'];
}

function findRelease ($targetRelease, $releases) {
	
	$targetMBID = $targetRelease -> releasembid;
	$targetCountry = $targetRelease -> country;
	$targetDis = $targetRelease -> disambiguation;
	
	foreach ($releases as $release) {
		
		$releaseMBID = $release['mbid'];
		$releaseCountry = $release['country'];
		$releaseDis = $release['disambiguation'];
		
		if ($releaseMBID == $targetMBID) {
			
			if ($releaseCountry == $targetCountry) {
				
				if ($releaseDis == $targetDis) {
					packAndShip ($release, $targetRelease);
					break;
				} // end of Dis
			} // end of country
		} // end of MBID
	} // end of foreach
} // end of findRelease


function findAlbum ($targetAlbum, $albums) {

	$targetAlbumMBID = $targetAlbum -> albummbid;

	foreach ($albums as $album) {
		$releases = $album['releases'];

		if ($album['mbid'] == $targetAlbumMBID) {
			$targetReleases = $targetAlbum -> records;
			foreach($targetReleases as $targetRelease){
				findRelease ($targetRelease, $releases);
			} // end of foreach release
		} // end of mbid
	} // end of foreach album
} // end of findAlbum	

for ($i=0; $i<$x; ++$i) {

    $jsonFile = $filenames[$i];
    $fileContents = file_get_contents($jsonFile);
	
    $artistData = json_decode($fileContents,true);

    $artistMBID = $artistData['mbid'];
    $artistName = $artistData['name'];

    $dataDate = $artistData['date'];
	
	$vol4usa->datadate = $dataDate;
	$vol4xe->datadate = $dataDate;
	$cog->datadate = $dataDate;
	$bad->datadate = $dataDate;
	$bagbdeluxe->datadate = $dataDate;

    $albums = $artistData['albums'];
	
	findAlbum ($vol4, $albums);
	findAlbum ($ba, $albums);
	
	$recordCollection [] = $bad;
	$recordCollection [] = $bagbdeluxe;
	$recordCollection [] = $cog;
	$recordCollection [] = $vol4usa;
	$recordCollection [] = $vol4xe;

};

echo '<script> console.log(' . json_encode($recordCollection) . ')</script>;';

$connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

if(!$connekt){
	echo '<p>Fiddlesticks! Could not connect to database.</p>';
} else {
	
	$grails = $recordCollection;
	
	foreach ($grails as $grail) {

		$releaseName = $grail->name;
		$releaseMBID = $grail->releasembid;
		$albumListeners = $grail->listeners;
		$albumPlaycount = $grail->playcount;
		$dataDate = $grail->datadate;		

		$insertBSData = "INSERT INTO albumsLastFM (
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

		$rockin = $connekt->query($insertBSData);

		if(!$rockin){
			echo '<p>Rats! Could not insert ' . $releaseName . ' stats.</p>';
		} else {
			echo '<p>Inserted ' . $albumListeners . ' listeners and ' . $albumPlaycount . ' plays from ' . $dataDate . ' for ' . $releaseName . '.</p>';
		}
	}
}	

?>