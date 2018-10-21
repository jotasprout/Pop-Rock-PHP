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
    .then(response => response.json())
    .then(json => (console.log(json)))
    .catch((err) => console.log (err));
    
    /*
    */

}
