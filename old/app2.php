<?php
session_start();

require 'artists.php';
require 'vendor/autoload.php';

// Fetch saved access token
$accessToken = $_SESSION['accessToken'];

$api = new SpotifyWebAPI\SpotifyWebAPI();
$api->setAccessToken($accessToken);

$artistID = $davidBowie;

// It's now possible to request data from the Spotify catalog
print_r(
    $api->getArtist($artistID)
);

$artistName = '';
$artistPop = '';
$artistAlbumsURL = '';
$artistAlbums = array ();
$artistAlbumsStr = '';
$albumArray = '';
$albumsArrays = array ();
$severalAlbumsURL = '';

$albumID = '';
$albumName = '';
$albumReleased = '';
$albumPop = '';
$albumTracks = array ();
$trackID = '';
$trackName = '';
$trackPop = '';

$albumTracksURL = '';
$albumTracksIDs = array ();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
    <title>Pop-PHP</title>
    <script src='https://www.roxorsoxor.com/js/jquery-214.js'></script>
</head>

<body>
	<div class="container">

        <form class="form-horizontal" id="rockinForm">
            <fieldset>
                <legend>PopRock</legend>

                <div class="form-group"> <!-- Row 1 -->
                    <label class="col-lg-2 control-label" for="artist">Ye Olde Select An Artist Menu</label>
                    <div class="col-lg-4">
                        <select class="form-control" id="artist" name="artist">
                            <option value="">- Choose -</option>
                            <option value="0oSGxfWSnnOXhD2fKuz2Gy">David Bowie</option>
                            <option value="74ASZWbe4lXaubB36ztrGX">Bob Dylan</option>
                            <option value="7dnB1wSxbYa8CejeVg98hz">Meat Loaf</option>
                            <option value="3EhbVgyfGd7HkpsagwL9GS">Alice Cooper</option>
                            <option value="3lPQ2Fk5JOwGWAF3ORFCqH">John Mellencamp</option>
                        </select>
                    </div>
                </div><!-- /Row 1 -->

                <div class="form-group"> <!-- Row 2 -->
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="button" id="getArtistButt">Get Artist Object</button>
                    </div>
                </div><!-- /Row 2 -->
            </fieldset>
        </form>

        <h2></h2>
        <table id="albums" class="table table-striped table-hover ">
            <tr>
              <th>Album ID</th>
              <th>Album Name</th>
              <th>Album Released</th>
              <th>Album Popularity</th>
            </tr>
        </table>

	</div> <!-- /container -->

    <footer class="footer"><p>&copy; Sprout Means Grow 2017</p></footer>

<script src="createArtistObject5.js"></script>

<div class="container">
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Music Thing</h3>
			</div>
			<div class="panel-body">

        <!-- nuthin -->
        <form class="form-horizontal" action="handle_choice.php" method="post">
            <fieldset>
				<?php
					// Create Investigator Menu
					echo "<div class='form-group'>";
						echo "<label class='col-lg-2 control-label' for='chosenArtist'>Artist</label>";
						echo "<div class='col-lg-4'>";
							echo "<select class='form-control' name='chosenArtist'>";
								echo "<option value=''>- Choose -</option>";
									echo "<option value='" . $someArtist . "'>ArtistName</option>";
							echo "</select>";
						echo "</div>";
					echo "</div>";
					// echo "<script>console.log('Case Number " . $assignedCase . " is assigned to " . $username . "')</script>";
					// When attempt is complete, connection closes
					mysqli_close($connekt);
				?>
                <div class="form-group"> <!-- Last Row -->
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Assign</button>
                    </div>
                </div><!-- /Last Row -->
            </fieldset>
        </form>

		</div> <!-- /panel-body -->
	</div> <!-- /panel-primary -->

	</div> <!-- /container -->
	<?php echo $scriptsAndSuch; ?>
</body>