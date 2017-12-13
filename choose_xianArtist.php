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
    <title>Choose an Artist</title>
    <?php echo $stylesAndSuch; ?>
</head>

<body>
	<div class="container">
    
    <form class="form-horizontal" id="rockinForm" action="handle_albums8.php" method="post">
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
echo "<option value='" . $oneBadPig->get_artistID() . "'>" . $oneBadPig->get_artistName() . "</option>";
echo "<option value='" . $stryper->get_artistID() . "'>" . $stryper->get_artistName() . "</option>";
echo "<option value='" . $bloodgood->get_artistID() . "'>" . $bloodgood->get_artistName() . "</option>";
echo "<option value='" . $bride->get_artistID() . "'>" . $bride->get_artistName() . "</option>";
echo "<option value='" . $steveTaylor->get_artistID() . "'>" . $steveTaylor->get_artistName() . "</option>";
echo "<option value='" . $stPerfectFoil->get_artistID() . "'>" . $stPerfectFoil->get_artistName() . "</option>";
echo "<option value='" . $stDanielsonFoil->get_artistID() . "'>" . $stDanielsonFoil->get_artistName() . "</option>";
echo "<option value='" . $chagallGuevara->get_artistID() . "'>" . $chagallGuevara->get_artistName() . "</option>";
echo "<option value='" . $vengeanceRising->get_artistID() . "'>" . $vengeanceRising->get_artistName() . "</option>";
echo "<option value='" . $freedomSoul->get_artistID() . "'>" . $freedomSoul->get_artistName() . "</option>";
echo "<option value='" . $pid->get_artistID() . "'>" . $pid->get_artistName() . "</option>";
echo "<option value='" . $sfc->get_artistID() . "'>" . $sfc->get_artistName() . "</option>";
echo "<option value='" . $dcTalk->get_artistID() . "'>" . $dcTalk->get_artistName() . "</option>";
echo "<option value='" . $dynamicTwins->get_artistID() . "'>" . $dynamicTwins->get_artistName() . "</option>";
echo "<option value='" . $eRoc->get_artistID() . "'>" . $eRoc->get_artistName() . "</option>";
echo "<option value='" . $resurrectionBand->get_artistID() . "'>" . $resurrectionBand->get_artistName() . "</option>";
echo "<option value='" . $xlDBD->get_artistID() . "'>" . $xlDBD->get_artistName() . "</option>";
echo "<option value='" . $crucified->get_artistID() . "'>" . $crucified->get_artistName() . "</option>";
echo "<option value='" . $playdough->get_artistID() . "'>" . $playdough->get_artistName() . "</option>";
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