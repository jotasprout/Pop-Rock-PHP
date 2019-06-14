<?php

// this needs methods for storing:
//     artistPop
//     artistListeners
//     artistPlaycount

    class artist {

        var $artistSpotID;
        var $artistName;
        var $artistPop;

        function __construct ($artists_id, $artists_name) {
            $this -> artistSpotID = $artists_id;
            $this -> artistName = $artists_name;
        }

        function set_artistSpotID ($new_artistSpotID) {
            $this -> artistSpotID = $new_artistSpotID;
        }

        function get_artistSpotID () {
            return $this -> artistSpotID;
        }

        function set_artistName ($new_artistName) {
            $this -> artistName = $new_artistName;
        }

        function get_artistName () {
            return $this -> artistName;
        }
		
		function set_artistPop ($new_artistPop) {
            $this -> artistPop = $new_artistPop;
        }

        function get_artistPop () {
            return $this -> artistPop;
        }

    }

?>