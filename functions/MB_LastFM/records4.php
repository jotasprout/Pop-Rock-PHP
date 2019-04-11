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

echo "<script>console.log(" . json_encode($ba) . ");</script>";
echo "<script>console.log(" . json_encode($vol4) . ");</script>";

echo "<script>console.log(" . json_encode($bad) . ");</script>";
echo "<script>console.log(" . json_encode($cog) . ");</script>";
echo "<script>console.log(" . json_encode($vol4usa) . ");</script>";
echo "<script>console.log(" . json_encode($vol4xe) . ");</script>";
echo "<script>console.log(" . json_encode($bagbdeluxe) . ");</script>";

$x = ceil((count($filenames)));

function findAlbum ($targetAlbum, $albums) {

	$targetAlbumMBID = $targetAlbum -> albummbid;

	foreach ($albums as $album) {

		if ($album['mbid'] == $targetAlbumMBID) {
			$targetReleases = $targetAlbum -> records;
			foreach($targetReleases as $targetRelease){
				//findRelease ($targetRelease);
				echo json_encode($targetRelease);
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
	
	findAlbum($vol4, $albums);
	


	foreach ($albums as $album){
		
		$releases = $album['releases'];
		
		$bad_mbid = $bad -> releasembid;
		$bagbdeluxe_mbid = $bagbdeluxe -> releasembid;
		$vol4usa_mbid = $vol4usa -> releasembid;
		$vol4xe_mbid = $vol4xe -> releasembid;
		$cog_mbid = $cog -> releasembid;
		
		$bad_Country = $bad -> country;
		$bagbdeluxe_Country = $bagbdeluxe -> country;
		$vol4usa_Country = $vol4usa -> country;
		$vol4xe_Country = $vol4xe -> country;
		$cog_Country = $cog -> country;
		
		$bagbdeluxe_Disambiguation = $bagbdeluxe -> disambiguation;
		
		if ($album['mbid'] == $vol4 -> albummbid) {
			
			foreach ($releases as $release) {
				
				$releaseMBID = $release['mbid'];
				$releaseCountry = $release['country'];
				
				switch ($releaseMBID) {
						
					case $cog_mbid:
						if ($releaseCountry == $cog_Country) {
							$cog->name = $release['name'];
							$cog->listeners = $release['listeners'];
							$cog->playcount = $release['playcount'];
							$recordCollection [] = $cog;					
						};
						break;						
						
					case $vol4usa_mbid:
						if ($releaseCountry == $vol4usa_Country) {
							$vol4usa->name = $release['name'];
							$vol4usa->listeners = $release['listeners'];
							$vol4usa->playcount = $release['playcount'];
							$recordCollection [] = $vol4usa;					
						};
						break;
						
					case $vol4xe_mbid:
						if ($releaseCountry == $vol4xe_Country) {
							$vol4xe->name = $release['name'];
							$vol4xe->listeners = $release['listeners'];
							$vol4xe->playcount = $release['playcount'];
							$recordCollection [] = $vol4xe;						
						};	
						break;
						

						
				};

			}

		};
		
		if ($album['mbid'] == $ba -> albummbid) {
			
			foreach ($releases as $release) {
				
				$releaseMBID = $release['mbid'];
				
				switch ($releaseMBID) {
						
					case $bagbdeluxe_mbid:
						$bagbdeluxe->name = $release['name'];
						$bagbdeluxe->listeners = $release['listeners'];
						$bagbdeluxe->playcount = $release['playcount'];
						$recordCollection [] = $bagbdeluxe;
						break;
						
					case $bad_mbid:
						$bad->name = $release['name'];
						$bad->listeners = $release['listeners'];
						$bad->playcount = $release['playcount'];
						$recordCollection [] = $bad;
						break;
						
				};				
			
			}

		};		
	};
    
};

$boogie = json_encode($recordCollection);

echo '<script> console.log(' . $boogie . ')</script>;';

    $connekt = new mysqli($GLOBALS['host'], $GLOBALS['un'], $GLOBALS['magicword'], $GLOBALS['db']);

    if(!$connekt){
        echo 'Fiddlesticks! Could not connect to database.<br>';
    } else {

        echo "whatevs";

    };

?>