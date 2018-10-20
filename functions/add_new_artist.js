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
    }).then((response) => (console.log(response)))
  .catch((err) => console.log (err));

}; // end of sendartistToServer











// Try this
/*
$.ajax({
        type: 'POST',
        url: 'functions/add_new_artist.php',
        data: 'artist=' + artist,
        success: function (response) {
           console.log(response);
        }
    });
*/
// In your PHP Service read out data of the database:

// connect to your database first
/*
$username = $_POST["var"];  
$sql="SELECT * FROM users WHERE anything = '$var'";
$result = mysql_query($sql);

if($result === FALSE) {
    die(mysql_error());
}

while($row = mysql_fetch_array($result)){ 
    return $row["variable"];
}

// ANOTHER THING I FOUND

function createNode(element) {
    return document.createElement(element);
}

function append(parent, el) {
  return parent.appendChild(el);
}

const ul = document.getElementById('authors');
const url = 'https://randomuser.me/api/?results=10';
fetch(url)
.then((resp) => resp.json())
.then(function(data) {
  let authors = data.results;
  return authors.map(function(author) {
    let li = createNode('li'),
        img = createNode('img'),
        span = createNode('span');
    img.src = author.picture.medium;
    span.innerHTML = `${author.name.first} ${author.name.last}`;
    append(li, img);
    append(li, span);
    append(ul, li);
  })
})
.catch(function(error) {
  console.log(JSON.stringify(error));
}); 

// AND ALSO THIS

var poutput = $('.listHolder');

$.ajax({
url: 'https://domain.com/page.php',
    dataType: 'jsonp',
    jsonp: 'jsoncallback',
    timeout: 5000,
    success: function(data, status){	
        $.each(data, function(pi,item){ 
        str = item.name;	
            var products = '<div id="'+item.id+'" class="items">'+
                            '<p class="names">'+item.name+'</p>'+
                            '</div>';
            
            poutput.append(products);
                
        })
    }
});
*/