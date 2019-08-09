const artistForm = document.getElementById('addartist').addEventListener('submit', submitArtist);  

function submitArtist (event) {
    event.preventDefault();
    let artist = document.getElementById('artist').value;
    const artistToSend = {
        artist
    };   

/*
*/
    console.log(artist); 

    const artistOptions = {
        method: 'POST',
        body: JSON.stringify(artistToSend),
        headers: {
        // 'Content-Length': ArrayBuffer.byteLength(artistToSend),
        'Content-Type': 'application/json'
        }
    };

  const url = 'functions/add_new_artist.php';

  fetch(url, artistOptions)
  .then(response => {
      return response;
      // return response.json();
  // }).then((res) => console.log(res()))
    }).then((response) => (console.log(response))
    .then(function (){
        // grab new info from db
    })
  .catch((err) => console.log (err));

}; // end of submitArtist


// Try this
/*
*/