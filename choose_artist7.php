<?php
    session_start();
    
    require 'artists.php';
    require 'vendor/autoload.php';
    require_once 'stylesAndScripts.php';

    // Fetch saved access token
    $accessToken = $_SESSION['accessToken'];
    
    $GLOBALS['api'] = new SpotifyWebAPI\SpotifyWebAPI();
    $GLOBALS['api']->setAccessToken($accessToken);
    
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>My Rocking Software Application</title>
    <?php echo $stylesAndSuch; ?>
</head>

<body>
	<div class="container">
    
            <form class="form-horizontal" id="rockinForm" action="handle_albums7.php" method="post">
                <fieldset>
                    <legend>Ye Olde Select An Artist Menu</legend>
    
                    <div class="form-group"> <!-- Row 1 -->
<!--                        
                    <label class="col-lg-2 control-label" for="artist">Ye Olde Select An Artist Menu</label>
-->
                        <div class="col-lg-4">
                            <select class="form-control" id="artist" name="artist">
                                <option value="">- Choose -</option>

                                <?php
                                    // I really need to make an artist array ... the following is just stupid
                                    echo "<option value='" . $aliceCooper->get_artistID() . "'>" . $aliceCooper->get_artistName() . "</option>";
                                    echo "<option value='" . $davidBowie->get_artistID() . "'>" . $davidBowie->get_artistName() . "</option>";
                                    echo "<option value='" . $bobDylan->get_artistID() . "'>" . $bobDylan->get_artistName() . "</option>";
                                    echo "<option value='" . $meatLoaf->get_artistID() . "'>" . $meatLoaf->get_artistName() . "</option>";
                                    echo "<option value='" . $johnMellencamp->get_artistID() . "'>" . $johnMellencamp->get_artistName() . "</option>";
                                    echo "<option value='" . $stooges->get_artistID() . "'>" . $stooges->get_artistName() . "</option>";
                                    echo "<option value='" . $bruceSpringsteen->get_artistID() . "'>" . $bruceSpringsteen->get_artistName() . "</option>";
                                    echo "<option value='" . $kiss->get_artistID() . "'>" . $kiss->get_artistName() . "</option>";
                                    echo "<option value='" . $iggyPop->get_artistID() . "'>" . $iggyPop->get_artistName() . "</option>";
                                    echo "<option value='" . $popWilliamson->get_artistID() . "'>" . $popWilliamson->get_artistName() . "</option>";
                                    echo "<option value='" . $rollingStones->get_artistID() . "'>" . $rollingStones->get_artistName() . "</option>";
                                    echo "<option value='" . $tomPetty->get_artistID() . "'>" . $tomPetty->get_artistName() . "</option>";
                                    echo "<option value='" . $tpHeartbreakers->get_artistID() . "'>" . $tpHeartbreakers->get_artistName() . "</option>";
                                ?>

                            </select>
                        </div>
                    </div><!-- /Row 1 -->
    
                    <div class="form-group"> <!-- Row 2 -->
                        <div class="col-lg-4 col-lg-offset-2">
                            <button class="btn btn-primary" type="submit" name="submit">Get Artist Shizzle</button>
                        </div>
                    </div><!-- /Row 2 -->
                </fieldset>
            </form>
    
      </div> <!-- /container -->
    
        <footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>
        <?php echo $scriptsAndSuch; ?>
    </body>
    
    </html>