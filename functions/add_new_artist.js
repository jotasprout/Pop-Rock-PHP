const artistForm = document.getElementById('addartist').addEventListener('submit', submitArtist);  

function submitArtist (event) {

    event.preventDefault();

    let artist_id = document.getElementById('artistid').value;

    const artistToSend = {
        artist_id
    };     

    const artistOptions = {
        method: 'POST',
        body: JSON.stringify(artistToSend),
        headers: {
        // 'Content-Type': 'application/json'
        }
    };

  const url = 'functions/add_new_artist.php';

  fetch(url, artistOptions)
  .then((res) => console.log(res.json()))
  .catch((err) => console.log (err));

}; // end of sendartistToServer