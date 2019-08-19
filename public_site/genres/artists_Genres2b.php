<?php

require_once '../page_pieces/stylesAndScripts.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Genres</title>
	<?php echo $stylesAndSuch; ?>
</head>
<body>
	<div class="container">
	<div id="fluidCon"></div> <!-- end of fluidCon -->
		<!-- main -->
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Click a genre to compare artists in that genre.</h3>
			</div>
			<div class="panel-body">
				<!-- Panel Content -->
				
                <table class="sortable table table-striped table-hover" id="tableoartists">
                <thead>
                    <tr>
                        <!--
                        <th>Table ID</th>					
                        <th onClick="sortColumn('artistName', 'unsorted')"><div class="pointyHead">Artist Name</div></th>
                        <th onClick="sortColumn('genre', 'ASC')"><div class="pointyHead">Genre</div></th>
                        <th><div>Source</div></th>
                        <th data-sort="name"><div class="pointyHead">Artist Name</div></th>
                        <th data-sort="genre"><div class="pointyHead">Genre</div></th>
                        -->
                        <th data-sort="name">Artist Name</th>
                        <th data-sort="genre">Genre</th>
                        
                    </tr>
                </thead>

				</table>
			</div>
			<!-- panel body -->
		</div>
		<!-- panel panel-primary -->
	</div>
	<!-- close container -->

<script>
/*
d3.json("artists_Genres2.php", function (genresData) {
    console.log("From json");
    console.log(genresData);
});
*/

$.getJSON("getGenresFromDB.php", function (genresData2) {
    console.log(genresData2);

    const dataset = genresData2;

    const everybody = [];

    dataset.forEach(function(ag){
        const myRow = {};
        if(ag.genreSource == "Spotify"){
            myRow.name = ag.artistNameSpot;
        } else {
            myRow.name = ag.artistNameMB;
        };
        myRow.genre = ag.genre;
        //myRow.genreSource = ag.genreSource;
        everybody.push(myRow);
    });

    /*
    const notThis = "musicbrainz";
    function filterSource (person) {
        return (person.genreSource == notThis);
    };
    let chosenPeeps = [];
    chosenPeeps = everybody.filter(filterSource);
    
    */
   
    const thesePeople = everybody;
    const $tableBody = $('<tbody></tbody>');

    for (let i = 0; i < thesePeople.length; i++) {
        const person = thesePeople[i];
        const $row = $('<tr></tr>');
        $row.append($('<td></td>').text(person.name));
        $row.append($('<td></td>').text(person.genre));
        //$row.append($('<td></td>').text(person.genreSource));
        $tableBody.append($row);
    };

    $('thead').after($tableBody);

});

</script>

<?php echo $scriptsAndSuch; ?>

<!--
    <script src="sort-table.js"></script>
<script src="https://www.roxorsoxor.com/poprock/functions/sort_genres.js"></script>
-->
<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbarIndex.js"></script>
</body>

</html>