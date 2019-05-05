/*
WHEN both tracks and tracksMB tables have albumMBID but latter has no albumSpotID
*/

UPDATE tracksMB a
JOIN tracks b
ON a.albumMBID = b.albumMBID
SET a.albumSpotID = b.albumSpotID
WHERE a.albumMBID = b.albumMBID

/*
Above = 637 rows affected
*/
/*
Below is for Finding similar stuff 
*/
SELECT d.albumName, c.trackName, c.tracksTrackSpotID, c.tracksMBTrackSpotID, c.tracksTrackMBID, c.tracksMBTrackMBID, c.tracksAlbumSpotID, c.tracksMBAlbumSpotID, c.tracksAlbumMBID, c.tracksMBAlbumMBID  
    FROM
        (SELECT a.trackSpotID AS tracksTrackSpotID, b.trackSpotID AS tracksMBTrackSpotID, a.trackMBID AS tracksTrackMBID, b.trackMBID AS tracksMBTrackMBID, b.trackName, a.albumSpotID AS tracksAlbumSpotID, b.albumSpotID AS tracksMBAlbumSpotID, a.albumMBID AS tracksAlbumMBID, b.albumMBID AS tracksMBAlbumMBID
            FROM tracksMB a
        JOIN tracks b
            ON a.albumMBID = b.albumMBID AND a.trackSpotID = b.trackSpotID
        WHERE a.albumSpotID = b.albumSpotID) c
    JOIN albums d 
        ON c.tracksAlbumSpotID = d.albumSpotID
        WHERE d.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
    ORDER BY d.albumName ASC, c.trackName ASC

/*
Below is also for Finding similar stuff 
*/
SELECT d.albumName, c.trackName, c.tracksTrackSpotID, c.tracksMBTrackSpotID, c.tracksTrackMBID, c.tracksMBTrackMBID, c.tracksAlbumSpotID, c.tracksMBAlbumSpotID, c.tracksAlbumMBID, c.tracksMBAlbumMBID  
    FROM
        (SELECT a.trackSpotID AS tracksTrackSpotID, b.trackSpotID AS tracksMBTrackSpotID, a.trackMBID AS tracksTrackMBID, b.trackMBID AS tracksMBTrackMBID, b.trackName, a.albumSpotID AS tracksAlbumSpotID, b.albumSpotID AS tracksMBAlbumSpotID, a.albumMBID AS tracksAlbumMBID, b.albumMBID AS tracksMBAlbumMBID
            FROM tracksMB a
        JOIN tracks b
            ON a.albumMBID = b.albumMBID AND a.trackSpotID = b.trackSpotID) c
    JOIN albums d 
        ON c.tracksAlbumSpotID = d.albumSpotID
        WHERE d.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
    ORDER BY d.albumName ASC, c.trackName ASC    

/*
Below is also for bigger picture 
*/

SELECT d.albumName, c.trackName, c.tracksTrackSpotID, c.tracksMBTrackSpotID, c.tracksTrackMBID, c.tracksMBTrackMBID, c.tracksAlbumSpotID, c.tracksMBAlbumSpotID, c.tracksAlbumMBID, c.tracksMBAlbumMBID  
    FROM
        (SELECT a.trackSpotID AS tracksTrackSpotID, b.trackSpotID AS tracksMBTrackSpotID, a.trackMBID AS tracksTrackMBID, b.trackMBID AS tracksMBTrackMBID, b.trackName, a.albumSpotID AS tracksAlbumSpotID, b.albumSpotID AS tracksMBAlbumSpotID, a.albumMBID AS tracksAlbumMBID, b.albumMBID AS tracksMBAlbumMBID
            FROM tracksMB a
        LEFT JOIN tracks b
            ON a.albumMBID = b.albumMBID AND a.trackSpotID = b.trackSpotID) c
    JOIN albums d 
        ON c.tracksAlbumSpotID = d.albumSpotID
        WHERE d.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
    ORDER BY d.albumName ASC, c.trackName ASC

/*
Below is also for even bigger picture 
*/

SELECT d.albumName, c.trackNameTracks, c.trackNameTracksMB, c.trackSpotIDTracks, c.trackSpotIDTracksMB, c.trackMBIDTracks, c.trackMBIDTracksMB, c.albumSpotIDTracks, c.albumSpotIDTracksMB, c.albumMBIDTracks, c.albumMBIDTracksMB  
    FROM
        (SELECT a.trackSpotID AS trackSpotIDTracks, b.trackSpotID AS trackSpotIDTracksMB, a.trackMBID AS trackMBIDTracks, b.trackMBID AS trackMBIDTracksMB, b.trackName AS trackNameTracks, a.trackName AS trackNameTracksMB, a.albumSpotID AS albumSpotIDTracks, b.albumSpotID AS albumSpotIDTracksMB, a.albumMBID AS albumMBIDTracks, b.albumMBID AS albumMBIDTracksMB
            FROM tracksMB a
        LEFT JOIN tracks b
            ON a.albumMBID = b.albumMBID AND a.trackSpotID = b.trackSpotID) c
    JOIN albums d 
        ON c.albumSpotIDTracks = d.albumSpotID
        WHERE d.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
    JOIN albumsMB e 
        ON c.albumMBIDTracks = e.albumMBID
        WHERE e.artistMBID = '5182c1d9-c7d2-4dad-afa0-ccfeada921a8'        
    ORDER BY d.albumName ASC, c.trackNameTracks ASC        

    /*
Below is also for even bigger picture 
*/

SELECT d.albumName, c.trackNameTracks, c.trackNameTracksMB, c.trackSpotIDTracks, c.trackSpotIDTracksMB, c.trackMBIDTracks, c.trackMBIDTracksMB, c.albumSpotIDTracks, c.albumSpotIDTracksMB, c.albumMBIDTracks, c.albumMBIDTracksMB  
    FROM
        (SELECT a.trackSpotID AS trackSpotIDTracks, b.trackSpotID AS trackSpotIDTracksMB, a.trackMBID AS trackMBIDTracks, b.trackMBID AS trackMBIDTracksMB, b.trackName AS trackNameTracks, a.trackName AS trackNameTracksMB, a.albumSpotID AS albumSpotIDTracks, b.albumSpotID AS albumSpotIDTracksMB, a.albumMBID AS albumMBIDTracks, b.albumMBID AS albumMBIDTracksMB
            FROM tracksMB a
        LEFT JOIN tracks b
            ON a.albumMBID = b.albumMBID AND a.trackSpotID = b.trackSpotID) c
    JOIN albums d 
        ON c.albumSpotIDTracks = d.albumSpotID
        WHERE d.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
    JOIN albumsMB e 
        ON c.albumMBIDTracks = e.albumMBID
        WHERE e.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'        
    ORDER BY d.albumName ASC, c.trackNameTracks ASC   