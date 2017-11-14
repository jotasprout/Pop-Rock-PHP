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
                                    echo "<option value='" . $BonJovi->get_artistID() . "'>" . $BonJovi->get_artistName() . "</option>";
									echo "<option value='" . $KateBush->get_artistID() . "'>" . $KateBush->get_artistName() . "</option>";
                                    echo "<option value='" . $Cars->get_artistID() . "'>" . $Cars->get_artistName() . "</option>";
                                    echo "<option value='" . $DepecheMode->get_artistID() . "'>" . $DepecheMode->get_artistName() . "</option>";
                                    echo "<option value='" . $DireStraits->get_artistID() . "'>" . $DireStraits->get_artistName() . "</option>";
                                    echo "<option value='" . $Eurythmics->get_artistID() . "'>" . $Eurythmics->get_artistName() . "</option>";
                                    echo "<option value='" . $JGeilsBand->get_artistID() . "'>" . $JGeilsBand->get_artistName() . "</option>";
                                    echo "<option value='" . $JudasPriest->get_artistID() . "'>" . $JudasPriest->get_artistName() . "</option>";
                                    echo "<option value='" . $LLCoolJ->get_artistID() . "'>" . $LLCoolJ->get_artistName() . "</option>";
                                    echo "<option value='" . $MC5->get_artistID() . "'>" . $MC5->get_artistName() . "</option>";
                                    echo "<option value='" . $TheMeters->get_artistID() . "'>" . $TheMeters->get_artistName() . "</option>";
                                    echo "<option value='" . $MoodyBlues->get_artistID() . "'>" . $MoodyBlues->get_artistName() . "</option>";
                                    echo "<option value='" . $Radiohead->get_artistID() . "'>" . $Radiohead->get_artistName() . "</option>";
                                    echo "<option value='" . $RageAgainstTheMachine->get_artistID() . "'>" . $RageAgainstTheMachine->get_artistName() . "</option>";
                                    echo "<option value='" . $RufusFeatChakaKhan->get_artistID() . "'>" . $RufusFeatChakaKhan->get_artistName() . "</option>";
                                    echo "<option value='" . $NinaSimone->get_artistID() . "'>" . $NinaSimone->get_artistName() . "</option>";
                                    echo "<option value='" . $SisterRosettaTharpe->get_artistID() . "'>" . $SisterRosettaTharpe->get_artistName() . "</option>";
                                    echo "<option value='" . $LinkWray->get_artistID() . "'>" . $LinkWray->get_artistName() . "</option>";
                                    echo "<option value='" . $Zombies->get_artistID() . "'>" . $Zombies->get_artistName() . "</option>";
                                    echo "<option value='" . $RageAgainstTheMachine->get_artistID() . "'>" . $RageAgainstTheMachine->get_artistName() . "</option>";
                                    echo "<option value='" . $ChakaKhan->get_artistID() . "'>" . $ChakaKhan->get_artistName() . "</option>";									
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