<?php
$artistMBID = $_GET['artistMBID'];
$artistSpotID = $_GET['artistSpotID'];
$albumMBID = $_GET['albumMBID'];

require_once 'rockdb.php';
require_once 'page_pieces/stylesAndScripts.php';

$connekt = new mysqli( $GLOBALS[ 'host' ], $GLOBALS[ 'un' ], $GLOBALS[ 'magicword' ], $GLOBALS[ 'db' ] );

if ( !$connekt ) {
	echo 'Darn. Did not connect. Screwed up like this: ' . mysqli_connect_error() . '</p>';
};

// check if the form has been submitted.
if (isset($_POST['submit'])){
	// If form is being submitted, process the form
	// get form data, making sure it is valid
	$albumMBID = $_POST['albumMBID'];
	$albumName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['albumName']));
	$artistName = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistName']));
	$artistMBID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistMBID']));
	$artistSpotID = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['artistSpotID']));
	$albumArtMB = mysqli_real_escape_string($connekt, htmlspecialchars($_POST['albumArtMB']));

	// check that artistMBID field is filled in
	if ($artistMBID == ''){
		// if form is NOT filled in
		// generate error message
		$error = 'ERROR: Boy, you sure are stupid! Fill in all required fields like you were told!';
		// and display form
		renderForm($albumMBID, $albumName, $artistName, $artistMBID, $artistSpotID, $albumArtMB, $error);
	}
	else // if form is filled in
	{
		// save data to database
		$updateAlbum = "UPDATE albumsMB SET albumName='$albumName', artistName='$artistName', artistMBID='$artistMBID', artistSpotID='$artistSpotID', albumArtMB='$albumArtMB' WHERE albumMBID='$albumMBID'";
		$retval = $connekt->query($updateAlbum);
		// Feedback of whether UPDATE worked or not
		if(!$retval){
			// if insert did NOT work
			die('Crap. Could not update this album because: ' . mysqli_error());
		}
		else
		{
			// if update worked, go to list of albums
			// do I want to change that to something AJAXy?
			header("Location: artist_AlbumsListLastFM.php?artistSpotID=" . $artistSpotID . "&artistMBID=" . $artistMBID . "&source=musicbrainz");
		}
	}

}
else // if the form isn't being submitted, get the data from the db and display the form
{
	// confirm id is valid and is numeric/larger than 0)
	if (isset($_GET['albumMBID'])){
		// query db
		$albumMBID = $_GET['albumMBID'];
		$result = mysqli_query($connekt, "SELECT * FROM albumsMB WHERE albumMBID=$albumMBID")
		or die(mysqli_error($result));
		$row = mysqli_fetch_array($result);
		// check that the 'albumMBID' matches up with a row in the databse
		if($row){
			// if there's a match
			// get data from db
			$albumMBID = $row['albumMBID'];
			$albumName = $row['albumName'];
			$artistName = $row['artistName'];
			$artistMBID = $row['artistMBID'];
			$artistSpotID = $row['artistSpotID'];
			if($row["albumArtMB"] == "") {
				$albumArtMB = "nope.png";
			}
			else {
				$albumArtMB = $row["albumArtMB"];
			}				
		}
		else // if no match, display error
		{
			echo "No results!";
		}
	}
	else // if the 'albumMBID' in the URL isn't valid, or if there is no 'albumMBID' value, display an error
	{
		echo $error;
	}
} // end of what to do if form isn't being submitted
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Edit <?php echo $albumName; ?> by <?php echo $artistName; ?></title>
<?php echo $stylesAndSuch; ?>
</head>
<body>
<div class="container-fluid">	
		
	<div id="fluidCon">
	</div> <!-- end of fluidCon -->
	
	  

	
	<!-- main -->
	<div class="panel panel-primary">
		<div class="panel-heading"><h3 class="panel-title">Edit <?php echo $albumName; ?> by <?php echo $artistName; ?></h3></div>
			<div class="panel-body">
				<!-- Panel Content -->
	
	<!-- This form displays user profile info from the database -->
	
	<form class="form-horizontal" action="" method="post">
		<input type="hidden" name="id" value="<?php echo $albumMBID; ?>"/>
		<fieldset>
            
			<div class="form-group"> <!-- Row 1 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="albumName">Album Name</label>				
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="albumName" value="<?php echo $albumName; ?>" />
				</div>
			</div>
			<!-- /Row 1 -->		
            	
			<div class="form-group"> <!-- Row 2 --> 
				<!-- Column 1 -->				
				<label class="col-lg-2 control-label" for="artistName">Artist Name</label>
				<!-- Column 2 -->				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="artistName" value="<?php echo $artistName; ?>" />
				</div>
			</div>
			<!-- /Row 2 -->
			
			<div class="form-group"> <!-- Row 3 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="artistMBID">artistMBID</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="artistMBID" value="<?php echo $artistMBID; ?>" readonly/>
				</div>
			</div>
			<!-- /Row 3 -->
			
			<div class="form-group"> <!-- Row 4 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="artistSpotID">artistSpotID</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="artistSpotID" name="artistSpotID"  value="<?php echo $artistSpotID; ?>" readonly/>
				</div>
			</div>
			<!-- /Row 4 --> 					
			
			<div class="form-group"> <!-- Row 4 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="assocArtistSpotID">Associated Artist SpotID</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="assocArtistSpotID" name="assocArtistSpotID"  value="<?php echo $assocArtistSpotID; ?>" />
				</div>
			</div>
					
			<!-- Last Row -->
			<div class="form-group"> <!-- Last Row -->	
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Update</button>
				</div>
			</div>
			<!-- /Last Row -->
		</fieldset>
	</form>
    
<div class="well">	
	
	<?php
	// this lists the cases assigned to this user
	// PHP code in a more secure location
	include("../../secret_php/xxxxxxx.php");
	// Start creating an HTML table for Assigned Cases and create header row
    echo "<table class='table table-striped table-hover '><thead><tr><th>Other Albums by " . $artistName . "</th></tr></thead>";
	echo "<tbody>";
	//Uses PHP code to connect to database
	$connekt = new mysqli($db_hostname, $db_artistMBID, $db_password, $db_database);
	// Connection test and feedback
	if (!$connekt) {
		die('Rats! Could not connect: ' . mysqli_error());
	}
	// Create variable for query
	$query0 = "
	SELECT b.albumName, b.albumMBID, z.artistName, x.albumArtMB
					FROM (SELECT mb.albumName, mb.albumMBID, mb.artistMBID
						FROM albumsMB mb 
						WHERE mb.artistMBID='$artistMBID') b 
					JOIN artists z ON z.artistMBID = b.artistMBID
					LEFT JOIN albumsMB x ON b.albumMBID = x.albumMBID
					ORDER BY b.albumName ASC;";
	// Use variable with MySQL command to grab info from database
	$result0 = $connekt->query($query0);
	// Create a row in HTML table for each row from database
    while ($row = mysqli_fetch_array($result0)) {
		echo "<tr><td><img src='" . $row['albumArtMB'] . "' height='64' width='64'></td><td>" . $row['albumName'] . "</td></tr>";
    }
	// Finish table of Assigned Cases
    echo "</tbody></table>";
	// When attempt is complete, connection closes
    mysqli_close($connekt);
?>

</div> <!-- /well -->

	</div> <!-- /panel-body -->
</div> <!-- /panel -->
	

	</div> <!-- /container-fluid --> 

<script src="https://www.roxorsoxor.com/poprock/page_pieces/navbar.js"></script>
</body>
</html>