<?php

require_once '../secrets/auth.php';
require_once '../vendor/autoload.php';
require_once '../rockdb.php';
require_once '../data_text/artists_arrays.php';
require_once '../functions/tracks.php';

$session = new SpotifyWebAPI\Session($myClientID, $myClientSecret);
$session->requestCredentialsToken();
$accessToken = $session->getAccessToken();
$GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
$GLOBALS['api']->setAccessToken($accessToken);

# LastFM variables
$LastFM_baseURL = 'http://ws.audioscrobbler.com/2.0/?method=';

# Part of URL for getting LastFM artist info
$LastFM_artistInfo = 'artist.getinfo&mbid=';

# Part of URL for getting LastFM album info
$LastFM_albumInfo = 'album.getinfo&mbid=';

$LastFM_albumMBID = '' # item in list of MusicBrainz_releaseMBID 

# Part of URL for getting LastFM track info
$LastFM_trackInfo = 'track.getinfo&mbid=';

$LastFM_trackMBID = ''; # item in list of MusicBrainz_recordingMBID 

# LastFM API key
$LastFM_apiKey = '&api_key=333a292213e03c10f38269019b5f3985';

# LastFM response format
$LastFM_jsonFormat = '&format=json';

# Get artist stats from LastFM
function makeGetArtistInfoFromLastFM_URL($LastFM_artistMBID) {
    $get_artist_info_from_LastFM = $LastFM_baseURL . $LastFM_artistInfo . $LastFM_artistMBID . $LastFM_apiKey . $LastFM_jsonFormat;
    echo $get_artist_info_from_LastFM	;
}


function makeLastFM_albumCheckURL($LastFM_albumMBID) {
	    $LastFM_albumCheckURL = $LastFM_baseURL . $LastFM_albumInfo . $LastFM_albumMBID . $LastFM_apiKey . $LastFM_jsonFormat;
    echo $LastFM_albumCheckURL;
}


function getLastFM_trackURL ($LastFM_trackMBID) {
    $LastFM_trackURL = $LastFM_baseURL . $LastFM_trackInfo . $LastFM_trackMBID . $LastFM_apiKey . $LastFM_jsonFormat;
    echo $LastFM_trackURL;	
}

$MusicBrainz_artistMBID = '';

# MusicBrainz variables
$MusicBrainz_baseURL = 'https://www.musicbrainz.org/ws/2/';

# Part of URL for using artist MBID
$MusicBrainz_artistMethod = 'artist/';

# Part of URL for getting MusicBrainz Release Groups info
$MusicBrainz_getReleaseGroups = '?inc=release-groups';

# Part of URL for using Release Groups MBID to get Releases
$MusicBrainz_releasegroupMethod = 'release-group/';

# Part of URL for getting MusicBrainz Releases info
$MusicBrainz_releases = '?inc=releases';

# Part of URL for using Release MBID
$MusicBrainz_releaseMethod = 'release/';

# Part of URL for getting MusicBrainz Recordings info
$MusicBrainz_recordings = '?inc=recordings';

# MusicBrainz response format
$MusicBrainz_jsonFormat = '&fmt=json';

# Get artist info (inc Release-Groups) from MusicBrainz
function makeReleaseGroupsURL($MusicBrainz_artistMBID) {
    $getReleaseGroups_totalURL = $MusicBrainz_baseURL . $MusicBrainz_artistMethod . $MusicBrainz_artistMBID . $MusicBrainz_getReleaseGroups . $MusicBrainz_jsonFormat;
    echo $getReleaseGroups_totalURL;	
}

function makeGetReleases_totalURL($MusicBrainz_releasegroupMBID) {
    $getReleases_totalURL = $MusicBrainz_baseURL . $MusicBrainz_releasegroupMethod . $MusicBrainz_releasegroupMBID . $MusicBrainz_releases . $MusicBrainz_jsonFormat;
    echo $getReleases_totalURL;	
}

function makeGetRecordings_totalURL($MusicBrainz_releaseMBID) {
    $getRecordings_totalURL = $MusicBrainz_baseURL . $MusicBrainz_releaseMethod . $MusicBrainz_releaseMBID . $MusicBrainz_recordings . $MusicBrainz_jsonFormat;
    echo $getRecordings_totalURL;	
}

echo "Getting Artist info and RELEASE GROUPS from MusicBrainz";

?>