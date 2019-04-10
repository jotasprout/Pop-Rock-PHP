<?php

require_once '../rockdb.php';

class Blackalbum {
	
	public $albummbid;
	
	public function setAlbummbid ($albummbid){
		$this -> albummbid = $albummbid;
	};
	public function getAlbummbid (){
		return $this -> albummbid;
	};
		
}

class Blackrelease {
	
	public $releasembid;
	public $datadate;
	public $listeners;
	public $playcount;
	
	public function setReleasembid ($releasembid){
		$this -> releasembid = $releasembid;
	};
	public function getReleasembid (){
		return $this -> releasembid;
	};
	
	public function setDatadate ($datadate){
		$this -> datadate = $datadate;
	};
	public function getDatadate (){
		return $this -> datadate;
	};
	
	public function setListeners ($listeners){
		$this -> listeners = $listeners;
	};
	public function getListeners (){
		return $this -> listeners;
	};	
	
	public function setPlaycount ($playcount){
		$this -> playcount = $playcount;
	};
	public function getPlaycount (){
		return $this -> playcount;
	};
		
}

$vol4 = new Blackalbum ();
$ba = new Blackalbum ();

$vol4 -> setAlbummbid ('8c292627-3459-3852-8ebc-226c12db175d');
$ba -> setAlbummbid ('de7de788-0f31-338a-9d82-8a09108e429f');

$bad = new Blackrelease ();
$bagbdeluxe = new Blackrelease ();
$vol4usa = new Blackrelease ();
$vol4xe = new Blackrelease ();
$cog = new Blackrelease ();

$bad -> setReleasembid ('0a3342f6-59a4-4ee0-a81c-6d5d4900f118');
$bagbdeluxe -> setReleasembid ('52c37691-e97e-3959-98c8-8b9a533eaeda');
$vol4usa -> setReleasembid ('257c6df7-26b8-4283-908a-3e625e41cdbe');
$vol4xe -> setReleasembid ('41e41680-3652-432f-8225-fb033c4fdae0');
$cog -> setReleasembid ('19772a1c-ea39-4104-bc99-ffc2203ea2ae');

$filenamesBS = array (
    '../data_text/jsonLastFM/BlackSabbath_Group_02-16-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_02-27-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_02-28-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-01-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-03-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-08-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-14-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-17-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-20-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-21-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-22-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-25-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-27-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-28-19.json', 
    '../data_text/jsonLastFM/BlackSabbath_Group_03-29-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_04-02-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_04-03-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_04-04-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_04-05-19.json',
    '../data_text/jsonLastFM/BlackSabbath_Group_04-06-19.json' 
);

$filenames = $filenamesBS;

$x = ceil((count($filenames)));

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

        $baAlbum = $albums['mbid']['de7de788-0f31-338a-9d82-8a09108e429f'];

        $baDemosRelease = $baAlbum['mbid']['0a3342f6-59a4-4ee0-a81c-6d5d4900f118'];
        $baDemosListeners = $baDemosRelease['listeners'];
        $baDemosPlaycount = $baDemosRelease['playcount'];
        $baDemosNameYucky = $baDemosRelease['name'];
        $baDemosName = mysqli_real_escape_string($connekt,$baDemosNameYucky);        

        $baRelease = $baAlbum['mbid']['52c37691-e97e-3959-98c8-8b9a533eaeda'];
        $baListeners = $baRelease['listeners'];
        $baPlaycount = $baRelease['playcount'];
        $baNameYucky = $baRelease['name'];
        $baName = mysqli_real_escape_string($connekt,$baNameYucky);         

        $v4Album = $albums['mbid']['8c292627-3459-3852-8ebc-226c12db175d'];

        $cogRelease = $v4Album['mbid']['19772a1c-ea39-4104-bc99-ffc2203ea2ae'];
        $cogListeners = $cogRelease['listeners'];
        $cogPlaycount = $cogRelease['playcount'];
        $cogNameYucky = $cogRelease['name'];
        $cogName = mysqli_real_escape_string($connekt,$cogNameYucky);         

        $v4Release = $v4Album['mbid']['257c6df7-26b8-4283-908a-3e625e41cdbe'];
        $v4Listeners = $v4Release['listeners'];
        $v4Playcount = $v4Release['playcount']; 
        $v4NameYucky = $v4Release['name'];
        $v4Name = mysqli_real_escape_string($connekt,$v4NameYucky);                 

        /* for ($j=0; $j<$albumsNum; ++$j) {
            $album = $albums[$j];
            $releases = $album['releases'];
            $releasesNum = ceil((count($releases)));
            if ($releasesNum > 0){
                $releaseMBID = $album['releases'][0]['mbid'];
                $releaseNameYucky = $album['releases'][0]['name'];
                $releaseName = mysqli_real_escape_string($connekt,$releaseNameYucky);
                $albumListeners = $album['releases'][0]['listeners'];
                $albumPlaycount = $album['releases'][0]['playcount'];
		*/		
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
       // };
    };
};

?>