<?php

// this needs to access a database by requiring a config file of some sort

    class artist {

        var $artistID;

        function set_artistID ($new_artistID) {
            $this -> artistID = $new_artistID;
        }

        function get_artistID () {
            $this -> artistID;
        }

        var $artistName;

        function set_artistName ($new_artistName) {
            $this -> artistName = $new_artistName;
        }

        function get_artistName () {
            $this -> artistName;
        }


    }

?>