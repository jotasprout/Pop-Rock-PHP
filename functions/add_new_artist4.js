const artistForm = document.getElementById('addartist').addEventListener('submit', submitArtist);  


function submitArtist (event) {
    event.preventDefault();
    let artist = document.getElementById('artist').value;
    sendArtistToServer (artist);
}; // end of submitArtist

function sendArtistToServer (artist) {
    const url = 'functions/add_new_artist.php';
    const artistToSend = {
        artist
    };  
    const artistOptions = {
        method: 'POST',
        body: JSON.stringify(artistToSend),
        headers: {
        'Content-Type': 'application/json'
        }
    };
    fetch(url, artistOptions).then(response => response.json())
    .then(json => {
        console.log(json);
        console.log("this artist is " + json.name);
    }).catch(err => {
        console.log (err);
    });


/*
   fetch(url, artistOptions).then(response => {
      return response.json();
   }).then(data => {
       console.log(data);
       console.log("this artist is " + data.name);
   }).catch(err => {
       console.log (err);
   });
*/

}