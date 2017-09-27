$(function(){

	var $theArtistName, $albumsTable, $rockinForm, $getArtistButt;

  $theArtistName = $('h2');                      // Cache the header
  $albumsTable = $('#albums');              		// Cache table to add new items
  $rockinForm = $('#rockinForm');          		// Cache form to show and hide
  $getArtistButt = $('#getArtistButt');          // Cache button

  $getArtistButt.on('click', function() {    	// When click on Get Artist button
    // $rockinForm.hide();                         // Hide the form
    var theArtistID = $('select').val();           // Get value of menu choice

  var artistName;
  var artistPop;
  var artistAlbumsURL;
  var artistAlbums = [];
  var artistAlbumsStr;
  var albumArray;
  var albumsArrays = [];
  var severalAlbumsURL;

  var albumID;
  var albumName;
  var albumReleased;
  var albumPop;
  var albumTracks = [];
  var trackID;
  var trackName;
  var trackPop;

  var albumTracksURL;
  var albumTracksIDs = [];

  function Artist (artistID, artistName, artistPop, artistAlbums) {
    this.artistID = artistID;
    this.artistName = artistName;
    this.artistPop = artistPop;
    this.artistAlbums = artistAlbums;
  }

  function Album (albumID, albumName, albumPop, albumReleased, albumTracks) {
    this.albumID = albumID;
    this.albumName = albumName;
    this.albumPop = albumPop;
    this.albumReleased = albumReleased;
    this.albumTracks = albumTracks;
  }

  // base of request URL
  var apiurl = "https://api.spotify.com";

  // artistID used as argument to get artistPop and artistAlbums
  var artistID;
  artistID = theArtistID;

  // do I have to declare this outside build_artistURL? Same with other so-called global variables at top.
  var artistURL;

  function build_artistURL (artistID) {
    artistURL = apiurl + "/v1/artists/" + artistID;
  }

  var rockstar = new Artist (artistID);
  rockstar.artistAlbums = [];

  function requestArtistInfo(artistURL){
    $.getJSON(artistURL, function(json){
      artistName = json.name;
      artistPop = json.popularity;
      rockstar.artistName = artistName;
      rockstar.artistPop = artistPop;
      console.log(rockstar);
    });
  }

  function build_artistAlbumsURL (artistID) {
    artistAlbumsURL = apiurl + "/v1/artists/" + artistID + "/albums?offset=0&limit=50&album_type=album&market=US";
  }

  function getArtistAlbums (artistAlbumsURL){
    $.getJSON(artistAlbumsURL, function(json){
      $.each(json.items, function (key, val){
        albumID = val.id;
        artistAlbums.push(albumID);
      });
  	  divideCombineAlbums (artistAlbums);
    	getAllAlbums(albumsArrays);
    });
  }

  function getAllAlbums(albumsArrays){
	  for (i=0; i<(albumsArrays.length); i++){
      var artistAlbumsStr = albumsArrays[i].join();
      build_severalAlbumsURL (artistAlbumsStr);
      getSeveralAlbums (severalAlbumsURL);
    };
  }

	function build_severalAlbumsURL (albumsString) {
	  severalAlbumsURL = apiurl + "/v1/albums?ids=" + albumsString + "&market=US";
	}

  var albumsTracksArrays = [];

  function Track (trackID, trackName, trackPop) {
    this.trackID = trackID;
    this.trackName = trackName;
    this.trackPop = trackPop;
  }

	function getSeveralAlbums (severalAlbumsURL) {
    // var artistAlbumsObjects = [];
  	$.getJSON(severalAlbumsURL, function(json){
  		$.each(json.albums, function (albumIndex, album){
        	albumID = album.id;
  			albumName = album.name;
  			albumPop = album.popularity;
  			albumReleased = album.release_date;
  			// console.log(albumName + ' = ' + albumPop + ' = ' + albumReleased);
			$albumsTable.append('<tr><td>' + albumID + '</td><td>' + albumName + '</td><td>' + albumReleased + '</td><td>' + albumPop + '</td></tr>');
  			albumX = new Album (albumID, albumName, albumPop, albumReleased);
  			albumX.albumTracks = [];
  			$.each(album.tracks.items, function (trackIndex, track){
  				trackID = track.id;
  				albumTracksIDs.push(trackID);
  			});
			getAlbumTracks();
  		});
		rockstar.artistAlbums.push (albumX);
  	});
  }

  function getAlbumTracks(){
    build_albumTracksURL ();
    getSeveralTracks (albumTracksURL);
    emptyTracks();
  }

  function getSeveralTracks (albumTracksURL) {
    var albumTracks = [];
    $.getJSON(albumTracksURL, function(json){
      $.each(json.tracks, function (trackIndex, track){
        trackID = track.id;
        trackName = track.name;
        trackPop = track.popularity;
        // var trackAlbumName = track.album.name;
        trackX = new Track (trackID, trackName, trackPop);
        albumTracks.push(trackX);
      }); 
		albumX.albumTracks = albumTracks;
    });
  }

  function build_albumTracksURL () {
    var albumToGet = albumTracksIDs.join();
    albumTracksIDs = [];
    albumTracksURL = apiurl + "/v1/tracks?ids=" + albumToGet + "&market=US";
  }

  function divideCombineAlbums(artistAlbums){
    var artistAlbumsChunk;
    var x = Math.ceil((artistAlbums.length)/20);
    var firstAlbum = 0;
    for (i=0; i<x; i++){
      var lastAlbum = firstAlbum + 19;
      artistAlbumsChunk = artistAlbums.slice(firstAlbum, lastAlbum);
      albumsArrays.push(artistAlbumsChunk);
      firstAlbum += 19;
    };
  }

  function emptyTracks (){
	  albumTracks = [];
    albumsTracksArrays = [];
	}

  build_artistURL (artistID)
  requestArtistInfo(artistURL);
  build_artistAlbumsURL(artistID);
  getArtistAlbums (artistAlbumsURL);

  });

});
