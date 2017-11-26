<?php

    // why do I need this next line for this file? Do I?
    require 'vendor/autoload.php';
    require_once 'navbar_rock.php';
    require_once 'stylesAndScripts.php';

?>

<!DOCTYPE html>

<html>
    <head><meta charset="UTF-8"><title>Comparing Artists Current Popularity</title><?php echo $stylesAndSuch; ?></head>

    <body>

        <div class="container">
            <?php echo $navbar ?>

            <!-- D3 chart goes here -->
            <script>
            d3.json("compare_artists_recent.php".function(error, data) {
                data.forEach(function(d) {
                    console.log (json);
                });
            })
            </script>

        </div> <!-- close container -->

        <?php echo $scriptsAndSuch; ?>
        <footer class="footer"><p>&copy; Sprout Means Grow and RoxorSoxor 2017</p></footer>

    </body>
</html>