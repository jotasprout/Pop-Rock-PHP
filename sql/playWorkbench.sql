SELECT p.*, t.trackName, a.albumName
FROM roxorsox_poprock.popTracks p
JOIN tracks t ON t.trackSpotID = p.trackSpotID
JOIN roxorsox_poprock.albums a 
ON a.albumSpotID = t.albumSpotID
AND a.artistSpotID = '5M52tdBnJaKSvOpJGz8mfZ'
WHERE p.date = max(p.date);