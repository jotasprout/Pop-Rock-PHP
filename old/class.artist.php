<?php

// this needs to access a database by requiring a config file of some sort

    class artist {

        var $artistID;
        var $artistName;

        function __construct ($artists_id, $artists_name) {
            $this -> artistID = $artists_id;
            $this -> artistName = $artists_name;
        }

        function set_artistID ($new_artistID) {
            $this -> artistID = $new_artistID;
        }

        function get_artistID () {
            return $this -> artistID;
        }

        function set_artistName ($new_artistName) {
            $this -> artistName = $new_artistName;
        }

        function get_artistName () {
            return $this -> artistName;
        }


    }

?>