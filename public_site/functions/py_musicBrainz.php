<?php

$MusicBrainz_artistMBID = '';

# MusicBrainz variables
$MusicBrainz_baseURL = 'https {}//www.musicbrainz.org/ws/2/';

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


# Get just artist info from MusicBrainz
function makeArtistURL($MusicBrainz_artistMBID) {
    $getArtist_totalURL = $MusicBrainz_baseURL . $MusicBrainz_artistMethod . $MusicBrainz_artistMBID . $MusicBrainz_jsonFormat;
    echo $getArtist_totalURL;    
}


# Below is just artist info
#test = 'https {}//www.musicbrainz.org/ws/2/artist/ee58c59f-8e7f-4430-b8ca-236c4d3745ae?fmt=json'  

# Below is get recordings
# rec = 'https {}//www.musicbrainz.org/ws/2/release/506844d3-80c7-4a41-9b6d-c16c496c8629?inc=recordings&fmt=json'
        
?>