/*
Compare popularity of artists albums and songs from different stages of their career.
Compare popularity of artists
Compare popularity of career stages between artists -- longevity and relevance, I guess.

Using artistID, get artist's popularity
Using artistID, get all of an artist's US albumIDs (for now, no compilations)
Using arrays of albumIDs, request several Full Album Objects at a time getting each album's popularity
Using arrays of albumIDs, get each album's trackIDs
Using arrays of trackIDs, request several Full Track Objects at a time getting each track's popularity
*/

$(document).ready(function(){

  // Declare all variables as global so I can assign and access anywhere
  // Figure out how and where to put these since, apparently, global vars are bad and didn't work this way anyway

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

  var albumTracks = [];
  var albumsTracksArrays = [];
  var albumTracksURL;

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

  function Track (trackID, trackName, trackPop) {
    this.trackID = trackID;
    this.trackName = trackName;
    this.trackPop = trackPop;
  }

  // base of request URL
  var apiurl = "https://api.spotify.com";

  // artistID used as argument to get artistPop and artistAlbums
  var artistID;

  // Alice Cooper artistID for dev and testing
  // Eventually, GUI will receive input
  artistID = "3EhbVgyfGd7HkpsagwL9GS";

  // do I have to declare this outside build_artistURL? Same with other so-called global variables at top.
  var artistURL;

  function build_artistURL (artistID) {
    artistURL = apiurl + "/v1/artists/" + artistID;
  }

  var rockstar = new Artist (artistID);
  rockstar.artistAlbums = [];

  // Get artist name and popularity for tracking pop over time and comparing to other artists
  function requestArtistInfo(artistURL){
    $.getJSON(artistURL, function(json){
      artistName = json.name;
      artistPop = json.popularity;
      // console.log(artistName + ' = ' + artistPop);
      rockstar.artistName = artistName;
      rockstar.artistPop = artistPop;
      console.log(rockstar);
    });

  }

  // Get list of artist's albums. 50 is maximum allowed. For now, no compilations. Never want outside US.

  function build_artistAlbumsURL (artistID) {
    artistAlbumsURL = apiurl + "/v1/artists/" + artistID + "/albums?offset=0&limit=50&album_type=album&market=US";
  }

  function getArtistAlbums (artistAlbumsURL){
    $.getJSON(artistAlbumsURL, function(json){
      $.each(json.items, function (key, val){
        // Get each albumID for requesting Full Album Object with popularity
        albumID = val.id;
        // Put albumIDs in array for requesting several at a time (far fewer requests)
        artistAlbums.push(albumID);
      });
      // Divide albumIDs array into smaller arrays. Limit is 20 for "get several albums" requests.
  	  divideCombineAlbums (artistAlbums);
	  // this function exists and is nested here because global variables don't mean what I think they mean. I think.
    	getAllAlbums(albumsArrays);
    });
  }

  // For each array of albums (20 at a time), "get several albums"
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

/*
For each album, get name, popularity, and release date to compare popularity of albums in different stages of artist's career and compare popularity of albums in those stages to similar stages in careers of other artists.

Retrieval and storage of tracks in getSeveralAlbums works just like albums in getArtistAlbums.
*/

	function getSeveralAlbums (severalAlbumsURL) {
    // temp array for storing album objects
    var artistAlbumsObjects = [];
		$.getJSON(severalAlbumsURL, function(json){
			$.each(json.albums, function (albumIndex, album){
        albumID = album.id;
				albumName = album.name;
				albumPop = album.popularity;
				albumReleased = album.release_date;
				// console.log(albumName + ' = ' + albumPop + ' = ' + albumReleased);
        albumX = new Album (albumID, albumName, albumPop, albumReleased);
        // put this album into temp array
        // artistAlbumsObjects.push (albumX);
        albumX.albumTracks = [];
				$.each(album.tracks.items, function (trackIndex, track){
					trackID = track.id;
					albumTracks.push(trackID);
				});
        // I think I need to make more requests and get tracks an album at a time to make my object easier
        albumX.albumTracks = albumTracks;
        rockstar.artistAlbums.push (albumX);
        albumTracks = [];
			});
			divideCombineAlbumTracks (albumTracks);
			getAllTracks();
      // Now empty the track arrays so getAllTracks (above) doesn't grab anything multiple times. getSeveralAlbums gets called for each array in albumsArrays.
      emptyTracks ();
      console.log(rockstar);
		});

    // rockstar.artistAlbums = artistAlbumsObjects;
	}

  function divideCombineAlbums(artistAlbums){
    var artistAlbumsChunk;
    // Round up so loop loops as much as needed
    var x = Math.ceil((artistAlbums.length)/20);
    var firstAlbum = 0;
    for (i=0; i<x; i++){
      var lastAlbum = firstAlbum + 19;
      artistAlbumsChunk = artistAlbums.slice(firstAlbum, lastAlbum);
      albumsArrays.push(artistAlbumsChunk);
      firstAlbum += 19;
    };
    // am I leaving any garbage behind? Yes. Where can I safely empty these?
    // console.log(artistAlbums);
    // console.log(artistAlbumsChunk);
  }

	function divideCombineAlbumTracks (albumTracks){
		var albumTracksChunk;
    // Round up so loop loops as much as needed
		var y = Math.ceil((albumTracks.length)/50);
		var firstTrack = 0;
		for (i=0; i<y; i++){
			var lastTrack = firstTrack + 49;
			albumTracksChunk = albumTracks.slice(firstTrack, lastTrack);
			albumsTracksArrays.push(albumTracksChunk);
			firstTrack += 49;
		};
	}

	function build_albumTracksURL () {
	  var albumToGet = albumsTracksArrays[i].join();
	  albumTracksURL = apiurl + "/v1/tracks?ids=" + albumToGet + "&market=US";
	}

	function getSeveralTracks (albumTracksURL) {
	  $.getJSON(albumTracksURL, function(json){
  		$.each(json.tracks, function (trackIndex, track){
        trackID = track.id;
  			trackName = track.name;
  			trackPop = track.popularity;
  			var trackAlbumName = track.album.name;
  			// console.log(trackAlbumName + ' = ' + trackName + ' = ' + trackPop);
  		});
	  });
	}

  function getAllTracks(){
    for (i=0; i < albumsTracksArrays.length; i++){
      build_albumTracksURL ();
      getSeveralTracks (albumTracksURL);
    };
  }

  // So loops can start from scratch and don't duplicate anything
  function emptyTracks (){
	  albumTracks = [];
    albumsTracksArrays = [];
	}

  // And now we begin
  // Soon, UI will ask for artistID or artist name for testing and dev.
  // Eventually, other function in other file will repeat all of this for list of artists

  build_artistURL (artistID)
  requestArtistInfo(artistURL);
  build_artistAlbumsURL(artistID);
  getArtistAlbums (artistAlbumsURL);


  // Ta da!

});
