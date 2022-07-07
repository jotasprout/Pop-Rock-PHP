# Pop Rock (PHP)
Creating dashboards and data visualizations using data gathered from multiple APIs. 

## Home Page: Artist List with some stats
<img src="https://roxorsoxor.com/imgs/pop-rock-php/all-Stats.jpg" alt="list of artists and their statistics from Spotify and Last F M">
User can:
    - Select an artist for comprehensive information 
    - Sort by Artist or rank using stats from Spotify and Last.FM

## Artist Dashboard
    - Images usually pulled from Spotify but sometimes manually uploaded (after downloading from fanart.tv)
    - Related artists (eg Related artists for Ronnie James Dio are Dio, Rainbow, Black Sabbath, etc.)
    - Current Spotify followers for Artist
    - Current LastFM listeners and playcount 
    - Line Graphs for stats over time
    - User can click Albums for discography stats
    
### Albums
### Albums List

Albums in list view can be sorted by album title, release date, and popularity.

<img src="https://jotascript.files.wordpress.com/2018/10/zombiesalbums2.png" alt="Top five albums by The Zombies on Spotify October 11, 2018.">

### Tracks


## Special Features

### How events affect artist/album/song popularity

![Line chart created with D3 showing Queen's popularity score over approximately six months.](https://jotascript.files.wordpress.com/2018/12/queen_01.png)

Above is a line graph showing **Queen**'s popularity increase due to the film *Bohemian Rhapsody*. 

Below is a line graph showing the increase in popularity of the song "Bohemian Rhapsody" due to the film *Bohemian Rhapsody*.

![Line chart created with D3 showing Bohemian Rhapsody's popularity score over approximately six months.](https://jotascript.files.wordpress.com/2018/12/bohemian_01.png)

<!--
Below is a multiline graph comparing this year's inductees into the **Rock and Roll Hall of Fame** showing the lack of influence their nominations and inductions had on their popularity.

<img src="https://github.com/jotasprout/Pop-Rock-PHP/blob/master/imgs/induct-2018-12-18.png">

For the line graphs similar to the one above, clicking an artist's image toggles the line's visibility.

-->

### Albums Bar Chart
![Column chart created with D3 displaying popularity score for Billy Idol albums. Album cover art appears beneath each column. Numerical score appears above each column.](https://jotascript.files.wordpress.com/2018/04/billyidol.png)

Data stored in MySQL (MariaDB) database. D3 gets data using PHP scripts containing SQL queries and builds the graphs and charts. 
I think album charts need to be vertical, rather than horizontal bar chart because some artists have tons of albums and it requires horizontal scrolling even on a desktop that overflows out of the Bootstrap elements, eventually getting cut off by SVG boundaries.



### Tracks List

At present, tracks are listed all together. Eventually, they'll be viewable by album. Tracks list view is sortable by album title, track title, and popularity.

<img src="https://jotascript.files.wordpress.com/2018/10/roxytracks.png" alt="Top ten Roxy Music tracks on Spotify October 11, 2018.">

## Back End
Cron jobs daily collect data using Spotify Web API and Last.fm 

### Spotify Web API
- Artists: Popularity and Followers 
- Albums: Popularity
- Tracks: Popularity
- Genres: **Future** For force layout relationship charts

### MusicBrainz API
- Gather MBIDs for artists, releases (oversimplification is "releases" are what they call albums), recordings ("tracks")
- [MusicBrainz.org](https://musicbrainz.org/)
- **Future** Gather "Relationships" (band members, personnel) from tracks

### FanArt.tv
- Artist, logos and album art

### Last.fm (perhaps being replaced by ListenBrainz)
- Listeners for artists, albums, tracks
- Playcount for artists, albums, tracks
- Tags (genres)

### ListenBrainz.org
[ListenBrainz.org](https://listenbrainz.org/) includes these helpful pages:
- [Main Documentation](https://listenbrainz.readthedocs.io/en/production/)
- [ListenBrainz API](https://listenbrainz.readthedocs.io/en/production/dev/api.html)
- [JSON Documentation](https://listenbrainz.readthedocs.io/en/production/dev/json.html)

### SeatGeek
**Future**
- Venues, cities of concerts
- Genres of concert artists

## Background
PHP-based version of [rockinJS](https://github.com/jotasprout/rockinJS) which replaced [myRockinApp](https://github.com/jotasprout/myRockinApp) (Python). Moved on to using PHP and MySQL with Pop-PHP because I couldn't get the objects to build as completely as I wanted in either Python to Javascript. 

## To Do
### Enhancements
- Timeline sliders to increase or decrease timespan

### ADA
- Add speech output, descriptions of charts, results
- Alternate input for those who can't see to drag & drop
