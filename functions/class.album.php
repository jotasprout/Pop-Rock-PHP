<?php

    class album {

        public function insert_album($albumID,$albumName,$albumReleased,$thisArtistID) {

            

            try {
                $stmt = $rock->conn->prepare("INSERT INTO albums (albumID,albumName,albumReleased,thisArtistID) VALUES(:albumID, :albumName, :albumReleased, :thisArtistID)");
                $stmt->bindparam(":albumID",$albumID);
                $stmt->bindparam(":albumName",$albumName);
                $stmt->bindparam(":albumReleased",$albumReleased);
                $stmt->bindparam(":thisArtistID",$thisArtistID);
                $stmt->execute();
                return $stmt;
            }
    
            // should not ex be exception like it is in user class? Make all of this consistent
            catch(PDOException $ex) {
                echo $ex->getMessage();
            }
        }
        
        // Do these variables need to be declared here? Or are below functions enough? What about variables in albums file? And that file should be combined with this, correct?
        var $albumID;
		var $albumArtist;
        var $albumName;
		var $albumReleased;
		var $albumPop;

        public function __construct () {
        }

//        public function __construct ($thisAlbumID) {
//            $this -> albumID = $thisAlbumID;
//        }

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