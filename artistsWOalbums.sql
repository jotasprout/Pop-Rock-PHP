SELECT * FROM artists
LEFT JOIN albums
ON artists.artistID = albums.artistID
WHERE albums.artistID IS NULL