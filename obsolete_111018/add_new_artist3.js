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
        // 'Content-Length': ArrayBuffer.byteLength(artistToSend),
        'Content-Type': 'application/json'
        }
    };

    fetch(url, artistOptions)
    .then(response => {
        return response;
        // return response.json();
    // }).then((res) => console.log(res()))
      }).then((response) => (console.log(response)))
    .catch((err) => console.log (err));

} // end of sendArtistToServer

function getArtistFromServer () {
    // something crafty
}