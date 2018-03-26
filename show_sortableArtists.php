<?php

include 'sesh.php';
require_once 'rockdb.php';
require_once 'navbar_rock.php';
require_once 'stylesAndScripts.php';
// require_once 'artists.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect.';
};

$artistInfoRecent = "SELECT a.artistID AS artistID, a.artistName AS artistName, b.pop AS pop, b.date AS date
    FROM artists a
        INNER JOIN popArtists b ON a.artistID = b.artistID
            WHERE b.date = (select max(b2.date)
                            FROM popArtists b2)
    ORDER BY b.pop DESC";

$getit = $connekt->query( $artistInfoRecent );

?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<title>Artists Popularity</title>
	<?php echo $stylesAndSuch; ?>

	<script src='node_modules/idb/lib/idb.js'></script>
	<script>

		var dbPromise = idb.open('rockin-db2', 1, function(upgradeDb) {
			var keyValStore = upgradeDb.createObjectStore('keyval');
			keyValStore.put('Meat Loaf', 'artist01');
		});

		dbPromise.then(function(db) {
			var tx = db.transaction('keyval');
			var keyValStore = tx.objectStore('keyval');
			return keyValStore.get('artist01');
		}).then(function(val) {
			console.log ('The first artist is: ', val);
		});

		dbPromise.then(function(db) {
			var tx = db.transaction ('keyval', 'readwrite');
			var keyValStore = tx.objectStore('keyval');
			keyValStore.put ('Iggy Pop', 'artist02');
			return tx.complete; 
		}).then(function() {
			console.log ('Added Iggy');
		});

		/*

		*/
		

	</script>

</head>

<body>

	<div class="container">
		<?php echo $navbar ?>

		<!-- main -->

		<div class="panel panel-primary">

			<div class="panel-heading">
				<h3 class="panel-title">Most Recent Artist Popularity in My DB</h3>
			</div>

			<div class="panel-body">

				<!-- Panel Content -->
				<!-- D3 chart goes here -->
				<?php if (!empty($getit)) { ?>

				<table class="table" id="tableoartists">
					<thead>
						<tr>
							<th onClick="sortColumn('artistName', 'ASC')"><div class="pointyHead">Artist Name</div></th>
							<th onClick="sortColumn('pop', 'ASC')"><div class="pointyHead">Popularity</div></th>
							<th>Date</th>
							<!--
			
		--> 
						</tr>
					</thead>

					<tbody>

					<?php
					while ( $row = mysqli_fetch_array( $getit ) ) {
						$artistName = $row[ "artistName" ];
						$artistPop = $row[ "pop" ];
						$popDate = $row[ "date" ];
						?>

					<tr>
						<td><?php echo $artistName ?></td>
						<td><?php echo $artistPop ?></td>
						<td><?php echo $popDate ?></td>
						<!--
								
								-->
					</tr>

					<?php 
						} // end of while
					?>

					</tbody>
				</table>
				<?php 
					} // end of if
				?>

			</div>
			<!-- panel body -->

		</div>
		<!-- panel panel-primary -->

	</div>
	<!-- close container -->

	<?php echo $scriptsAndSuch; ?>
	<script src="https://www.roxorsoxor.com/poprock/sortTheseArtists.js"></script>

</body>

</html>