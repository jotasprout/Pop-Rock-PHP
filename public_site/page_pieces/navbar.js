const navbar = "<nav class='navbar navbar-default'><div id='header' class='container-fluid'><ul class='nav navbar-nav'><li><a href='https://roxorsoxor.com/poprock/index.php'>Artists<br>Spotify</a></li><li><a href='https://roxorsoxor.com/poprock/indexLastFM.php'>Artists<br>LastFM</a></li><li><a href='https://roxorsoxor.com/poprock/artist_AlbumsListSpot2.php?artistSpotID=" + artistSpotID + "&artistMBID=" + artistMBID + "&source=spotify'>Albums<br>Spotify</a></li><li><a href='https://roxorsoxor.com/poprock/artist_AlbumsListLastFM.php?artistSpotID=" + artistSpotID + "&artistMBID=" + artistMBID + "&source=musicbrainz'>Albums<br>LastFM</a></li><li><a href='https://roxorsoxor.com/poprock/artist_TracksListSpot.php?artistSpotID=" + artistSpotID + "&artistMBID=" + artistMBID + "&source=spotify'>Tracks<br>Spotify</a></li><li><a href='https://roxorsoxor.com/poprock/artist_TracksListLastFM.php?artistSpotID=" + artistSpotID + "&artistMBID=" + artistMBID + "&source=musicbrainz'>Tracks<br>LastFM</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_albumsChart.php'>Related<br>Artists</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_popTimeLines.php'>Over Time<br>Popularity</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_popCurrentColumns.php'>Current<br>Popularity</a></li><li><a href='https://roxorsoxor.com/poprock/multiArtists_followersCurrentColumns.php'>Current<br>Followers</a></li><li><a href='https://roxorsoxor.com/poprock/genresSpot.php'>Genres<br>Spotify</a></li><li><a href='https://roxorsoxor.com/poprock/genresMBLFM.php'>Genres<br>LastFM</a></li><li><a href='https://roxorsoxor.com/poprock/dragdrop/dragdropArtists9.php'>Drag Drop</a></li></ul></div> <!-- /container-fluid --></nav> <!-- /navbar -->";

const fluidCon = document.getElementById('fluidCon');

$(document).ready(function(){
    fluidCon.innerHTML = navbar;
});

