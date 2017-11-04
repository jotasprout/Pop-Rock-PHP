<?php

require_once 'rockdb.php';

class rockstar {

    public function __construct () {
        $slider = new Slideitin();
        $slide = $slider->dbConnection();
        $this->conn = $slide;
    }

    public function insert_album($albumID,$albumName,$albumReleased,$thisArtistID) {

        try {
            $stmt = $this->conn->prepare("INSERT INTO albums (albumID,albumName,albumReleased,thisArtistID) VALUES(:albumID, :albumName, :albumReleased, :thisArtistID)");
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

}

?>