<?php

// this needs to access a database by requiring a config file of some sort

    class album {

        var $albumID;
		var $albumArtist;
        var $albumName;
		var $albumReleased;
		var $albumPop;

        function __construct ($album_id) {
            $this -> albumID = $album_id;
        }

        function set_albumID ($new_albumID) {
            $this -> albumID = $new_albumID;
        }

        function get_albumID () {
            return $this -> albumID;
        }

        function set_albumName ($new_albumName) {
            $this -> albumName = $new_albumName;
        }

        function get_albumName () {
            return $this -> albumName;
        }
		
		function set_albumPop ($new_albumPop) {
            $this -> albumPop = $new_albumPop;
        }

        function get_albumPop () {
            return $this -> albumPop;
        }
		
		function set_albumPop ($new_albumPop) {
            $this -> albumPop = $new_albumPop;
        }

        function get_albumPop () {
            return $this -> albumPop;
        }
		
		function set_albumArtist ($new_albumArtist) {
            $this -> albumArtist = $new_albumArtist;
        }

        function get_albumArtist () {
            return $this -> albumArtist;
        }
		
		function set_albumReleased ($new_albumReleased) {
            $this -> albumalbumReleased = $new_albumReleased;
        }

        function get_albumReleased () {
            return $this -> albumReleased;
        }


    }

?>