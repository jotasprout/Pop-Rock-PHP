<?php

// this needs to access a database by requiring a config file of some sort

    class track {

        var $trackID;
		var $trackAlbum;
        var $trackName;
		var $trackPop;

        function __construct ($track_id) {
            $this -> trackID = $track_id;
        }

        function set_trackID ($new_trackID) {
            $this -> trackID = $new_trackID;
        }

        function get_trackID () {
            return $this -> trackID;
        }
		
        function set_trackAlbum ($new_trackAlbum) {
            $this -> trackAlbum = $new_trackAlbum;
        }

        function get_trackAlbum () {
            return $this -> trackAlbum;
        }		

        function set_trackName ($new_trackName) {
            $this -> trackName = $new_trackName;
        }

        function get_trackName () {
            return $this -> trackName;
        }
		
		function set_trackPop ($new_trackPop) {
            $this -> trackPop = $new_trackPop;
        }

        function get_trackPop () {
            return $this -> trackPop;
        }


    }

?>