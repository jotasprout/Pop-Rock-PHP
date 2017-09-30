<?php
  include ("class.artist.php");
  
  $aliceCooper = new artist("3EhbVgyfGd7HkpsagwL9GS","Alice Cooper");
  $davidBowie = new artist("0oSGxfWSnnOXhD2fKuz2Gy","David Bowie");
  $bobDylan = new artist("74ASZWbe4lXaubB36ztrGX","Bob Dylan");
  $meatLoaf = new artist("7dnB1wSxbYa8CejeVg98hz","Meat Loaf");
  $johnMellencamp = new artist("3lPQ2Fk5JOwGWAF3ORFCqH","John Mellencamp");
  $stooges = new artist("4BFMTELQyWJU1SwqcXMBm3","The Stooges");
  $bruceSpringsteen = new artist("3eqjTLE0HfPfh78zjh6TqT","Bruce Springsteen");
  $kiss = new artist("07XSN3sPlIlB2L2XNcTwJw","Kiss");
  $iggyPop = new artist("33EUXrFKGjpUSGacqEHhU4","Iggy Pop");
  $popWilliamson = new artist("1l8grPt6eiOS4YlzjIs0LF","Iggy Pop and James Williamson");
  $rollingStones = new artist("22bE4uQ6baNwSHPVcDxLCe","Rolling Stones");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>My Rocking Software Application</title>
    <script src='https://www.roxorsoxor.com/js/jquery-214.js'></script>
</head>

<body>
	<p>Home page for myRockinApp: PHP version.</p>
	<div class="container">
    
            <form class="form-horizontal" id="rockinForm">
                <fieldset>
                    <legend>My Rockin JS App</legend>
    
                    <div class="form-group"> <!-- Row 1 -->
                        <label class="col-lg-2 control-label" for="artist">Ye Olde Select An Artist Menu</label>
                        <div class="col-lg-4">
                            <select class="form-control" id="artist" name="artist">
                                <option value="">- Choose -</option>

                                <?php
                                    echo
                                        "<option value='" . $aliceCooper->get_artistID . "'>" . $aliceCooper->get_artistName . "</option>" .
                                        "<option value='" . $davidBowie->get_artistID . "'>" . $davidBowie->get_artistName . "</option>" .
                                        "<option value='" . $bobDylan->get_artistID . "'>" . $bobDylan->get_artistName . "</option>" .
                                        "<option value='" . $meatLoaf->get_artistID . "'>" . $meatLoaf->get_artistName . "</option>" .
                                        "<option value='" . $johnMellencamp->get_artistID . "'>" . $johnMellencamp->get_artistName . "</option>" .
                                        "<option value='" . $stooges->get_artistID . "'>" . $$stooges->get_artistName . "</option>" .
                                        "<option value='" . $bruceSpringsteen->get_artistID . "'>" . $bruceSpringsteen->get_artistName . "</option>" .
                                        "<option value='" . $kiss->get_artistID . "'>" . $kiss->get_artistName . "</option>" .
                                        "<option value='" . $iggyPop->get_artistID . "'>" . $iggyPop->get_artistName . "</option>" .
                                        "<option value='" . $popWilliamson->get_artistID . "'>" . $popWilliamson->get_artistName . "</option>" .
                                        "<option value='" . $rollingStones->get_artistID . "'>" . $rollingStones->get_artistName . "</option>"
                                    ;
                                ?>

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
    
        <footer class="footer"><p>&copy; Sprout Means Grow 2016</p></footer>
    
    <script src="createArtistObject5.js"></script>
    </body>
    
    </html>
    