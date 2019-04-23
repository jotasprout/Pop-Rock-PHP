<?php

$albumID = $_GET['albumID'];

require_once 'rockdb.php';
require_once 'page_pieces/navbar_rock.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$gatherTrackInfo = "SELECT t.trackID, t.trackName, a.albumName, a.albumID, p1.pop, p1.date, f1.dataDate, f1.trackListeners, f1.trackPlaycount
						FROM tracks t
						INNER JOIN albums a ON a.albumID = t.albumID
						JOIN (SELECT p.* FROM popTracks p
								INNER JOIN (SELECT trackID, pop, max(date) AS MaxDate
											FROM popTracks  
											GROUP BY trackID) groupedp
								ON p.trackID = groupedp.trackID
								AND p.date = groupedp.MaxDate) p1 
						ON t.trackID = p1.trackID
						LEFT JOIN (SELECT f.*
								FROM tracksLastFM f
								INNER JOIN (SELECT trackMBID, trackListeners, trackPlaycount, max(dataDate) AS MaxDataDate
											FROM tracksLastFM  
											GROUP BY trackMBID) groupedf
								ON f.trackMBID = groupedf.trackMBID
								AND f.dataDate = groupedf.MaxDataDate) f1
						ON t.trackMBID = f1.trackMBID
						WHERE a.albumID = '$albumID'
						ORDER BY p1.pop DESC";

$getit = $connekt->query( $gatherTrackInfo );

if ( !$getit ) {
	echo 'Cursed-Crap. Did not run the query.';
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>This Album's Tracks Popularity On Spotify</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>

	<div class="container-fluid">

		<?php echo $navbar ?>

		<!-- main -->
		<p>Please be patient while data loads.</p>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">This Album's Tracks Popularity On Spotify</h3>
			</div>
			<div class="panel-body">

				<?php if(!empty($getit)) { ?>
				
				<table class="table" id="tableotracks">
					<thead>
						<tr>
							<th onClick="sortColumn('albumName', 'ASC')"><div class="pointyHead">Album Name</div></th>
							<th>Spotify<br>trackID</th>
				<!--

				-->
			<th onClick="sortColumn('trackName', 'DESC')"><div class="pointyHead">Track Title</div></th>
			<th class="popStyle">Spotify<br>Data Date</th>
			<th class="popStyle" onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Track<br>Popularity</div></th>
			<th>LastFM<br>Data Date</th>
			<th class="rightNum pointyHead">LastFM<br>Listeners</th>
			<th class="rightNum pointyHead">LastFM<br>Playcount</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		while ( $row = mysqli_fetch_array( $getit ) ) {
			$albumName = $row[ "albumName" ];
			$trackName = $row[ "trackName" ];
			$trackID = $row[ "trackID" ];
			$trackPop = $row[ "pop" ];
			$popDate = $row[ "date" ];
			$lastFMDate = $row[ "dataDate" ];
			$trackListenersNum = $row[ "trackListeners"];
			$trackListeners = number_format ($trackListenersNum);
			if (!$trackListeners > 0) {
				$trackListeners = "n/a";
			};
			$trackPlaycountNum = $row[ "trackPlaycount"];
			$trackPlaycount = number_format ($trackPlaycountNum);
			if (!$trackPlaycount > 0) {
				$trackPlaycount = "n/a";
			};
	?>
<tr>
<td><?php echo $albumName ?></td>
<td><?php echo $trackID ?></td>
<!--

-->
<td><a href='https://www.roxorsoxor.com/poprock/track_Chart.php?trackID=<?php echo $trackID ?>'><?php echo $trackName ?></a></td>
<td class="popStyle"><?php echo $popDate ?></td>
<td class="popStyle"><?php echo $trackPop ?></td>
<td class="popStyle"><?php echo $lastFMDate ?></td>
<td class="rightNum"><?php echo $trackListeners ?></td>
<td class="rightNum"><?php echo $trackPlaycount ?></td>
</tr>
	<?php 
		} // end of while
	?>
	
	</tbody>
</table>
				<?php 
					} // end of if
				?>
			</div> <!-- panel body -->
		</div> <!-- panel panel-primary -->
	</div> <!-- closing container -->









<script>

var w = 740;
var h = 400;
var padding = 40;

var dataset, xScale, yScale, xAxis, yAxis, line;

d3.json("functions/create_album_popLine.php?albumID=<?php echo $albumID; ?>", function(data) {
    
    console.log(data);
    
    var dataset = data;

    const albumName = dataset[0].albumName;

    const topHeading = d3.select("#topHead")
            .text(albumName + " -- current stats on Spotify and LastFM"); 

    const albumTitle = d3.select("#albumPop")
            .text(albumName + " -- popularity on Spotify over time");   

    const currentPopAlbum = dataset[0].pop;

    const currentPop = d3.select("#forCurrentPopularity")
            .text(currentPopAlbum);               

    const dataFollowers = dataset[0].followers;
    let followers = String(dataFollowers).replace(/(.)(?=(\d{3})+$)/g,'$1,');

    const albumFollowers = d3.select("#forCurrentFollowers")
            .text(followers);  

    const albumArt = dataset[0].albumArt;

    d3.select("#forArt")
            .data(dataset)
            .attr("src", albumArt)
            .attr("height", 166);
            //.attr("width", auto)

    dataset.forEach(function(d) {
        d.date = new Date(d.date);
        d.pop = +d.pop;
    });

    xScale = d3.scaleTime()
                .domain([
                    d3.min(dataset, function(d) { return d.date; }),
                    d3.max(dataset, function(d) { return d.date; })
                ])
                .range([padding, w - padding]);

    yScale = d3.scaleLinear()
               .domain(d3.extent(data, function(d) { return d.pop; }))
               .range([h - padding, padding]);

    const xAxis = d3.axisBottom()
                    .scale(xScale)
                    .tickFormat(d3.timeFormat("%b"));

    const yAxis = d3.axisLeft()
                    .scale(yScale);

    var line = d3.line()
                .x(function(d) { return xScale(d.date); })
                .y(function(d) { return yScale(d.pop); });

    var svg = d3.select("#forAlbumChart")
                    .append("svg")
                    .attr("width", w)
                    .attr("height", h);

    svg.append("path")
        .datum(dataset)
        .attr("class", "line")
        .attr("d", line);

    svg.append("g")
       .call(xAxis)
       .attr("transform", "translate(0," + (h - padding) + ")")
       .attr("class", "axis");

    svg.append("g")
       .call(yAxis)
       .attr("transform", "translate(" + padding + ",0)")
       .attr("class", "axis");

});

</script>




<script>

    d3.json("functions/getAlbumLastFM.php?albumID=<?php echo $albumID; ?>", function(dataset) {
        
        console.log(dataset);
        
        var data = dataset;

        const dataListeners = data[0].albumListeners;
        let listeners = String(dataListeners).replace(/(.)(?=(\d{3})+$)/g,'$1,');
        const albumListeners = d3.select("#forCurrentListeners")
            .text(listeners);   

        const dataPlaycount = data[0].albumPlaycount;
        let playcount = String(dataPlaycount).replace(/(.)(?=(\d{3})+$)/g,'$1,');
        const albumPlaycount = d3.select("#forCurrentPlaycount")
            .text(playcount); 
    });   
     
</script>





<?php echo $scriptsAndSuch; ?>
<script src="https://www.roxorsoxor.com/poprock/functions/sortTheseTracks.js"></script>
</body>
	
</html>