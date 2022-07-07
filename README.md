# Pop Rock (PHP)
Creating dashboards and data visualizations using data gathered from multiple APIs. 

## Featured Special Features: Why I created this app

### How events affect artist/album/song popularity
I often wondered not only how much does an artist's death affect the popularity of their music but events such as:

**Queen**'s popularity increase due to the film *Bohemian Rhapsody*. 

![Line chart created with D3 showing Queen's popularity score over approximately six months.](https://jotascript.files.wordpress.com/2018/12/queen_01.png)

The increase in popularity of the song *"Bohemian Rhapsody"* due to the film *Bohemian Rhapsody*.

![Line chart created with D3 showing Bohemian Rhapsody's popularity score over approximately six months.](https://jotascript.files.wordpress.com/2018/12/bohemian_01.png)

**Motley Crue**'s popularity increase due to the film *The Dirt*. 
<img src="https://roxorsoxor.com/imgs/pop-rock-php/MotelyCrueMovie.jpg" alt="list of artists and their statistics from Spotify and Last F M">

Increase in popularity of **Motley Crue**'s albums due to the film *The Dirt*. 
<img src="https://roxorsoxor.com/imgs/pop-rock-php/MotleyCrue-Dirt-Release.jpg" alt="list of artists and their statistics from Spotify and Last F M">

<!--
Below is a multiline graph comparing this year's inductees into the **Rock and Roll Hall of Fame** showing the lack of influence their nominations and inductions had on their popularity.

<img src="https://github.com/jotasprout/Pop-Rock-PHP/blob/master/imgs/induct-2018-12-18.png">

For the line graphs similar to the one above, clicking an artist's image toggles the line's visibility.

-->

## Home Page: Artist List with some stats
<img src="https://roxorsoxor.com/imgs/pop-rock-php/all-Stats.jpg" alt="list of artists and their statistics from Spotify and Last F M">
<img src="https://roxorsoxor.com/imgs/pop-rock-php/all-artist-Stats.jpg" alt="list of artists and their statistics from Spotify and Last F M">

User can:

- Select an artist for comprehensive information 

- Sort by Artist or rank using stats from Spotify and Last.FM

- Last.FM "ratio" column accounts for inflated playcounts I assume are due to fans playing the same albums and songs endlessly

## Artist Dashboard
<img src="https://roxorsoxor.com/imgs/pop-rock-php/popRock-Artist-Thumb.jpg" alt="Dashboard for artist Ozzy Osbourne including many of the features listed below">

The above, older, screenshot shows the main menu (dynamic, adapting to type of page you're viewing) along the top (built with **Bootstrap**) for quick navigation anywhere. All buttons apply to the artist currently displayed. As features such as data visualizations were added to the artists dashboards, those buttons were removed.

- Images usually pulled from Spotify but sometimes manually uploaded (after downloading from fanart.tv)

- Related artists (eg Related artists for Ronnie James Dio are Dio, Rainbow, Black Sabbath, etc.) - data gathered via algorithms used with MusicBrainz.com

- Current Spotify followers for Artist

- Current LastFM listeners and playcount 

- Line Graphs for stats over time - data visualization created using D3.js

- User can click Albums for discography stats

**Associated Artists Force Graph**

This interactive graph displays how artists are related to each other. Users can move nodes around to focuse on a particular band or band member.

<img src="https://roxorsoxor.com/imgs/pop-rock-php/MusicBrainzForceRelation.jpg" alt="">

As such, one can also consider this a graph for Black Sabbath, Rainbow, Deep Purple, etc.

Another interactive feature is dragging and dropping the artist(s) of the user's choice to create their own custom bar graph.

<img src="https://roxorsoxor.com/imgs/pop-rock-php/drag-drop.jpg" alt="">

### Albums
### Albums List
Albums in list view can be sorted by album title, release date, and popularity.

Discrography pages used to be separated by Spotify and Last.FM stats but now contain all columns on one page.

<img src="https://roxorsoxor.com/imgs/pop-rock-php/Nugent-Spotify.jpg" alt="list of albums by Ted Nugent with current Spotify popularity score">
<img src="https://roxorsoxor.com/imgs/pop-rock-php/Nugent-LastFM.jpg" alt="list of albums by Ted Nugent with current Last.FM stats">


Even older screenshot showing album list displaying only year and current Spotify popularity:

<img src="https://jotascript.files.wordpress.com/2018/10/zombiesalbums2.png" alt="Top five albums by The Zombies on Spotify October 11, 2018.">

**Some artists have scatterplots (powered by D3)**

<img src="https://roxorsoxor.com/imgs/pop-rock-php/Dio.jpeg" alt="Scatterplot of albums featuring Ronnie James Dio with current Spotify popularity score">

This scatterplot displaying Spotify popularity uses the "Associated Artists" feature/table (powered by data gathered through the MusicBrainz API to include every album on which Ronnie James Dio was lead singer from Elf to Heaven & Hell.

Hovering over an album cover gives additional information.

<img src="https://roxorsoxor.com/imgs/pop-rock-php/DioLastFM.jpeg" alt="Scatterplot of albums featuring Ronnie James Dio with current LastFM stats">

This scatterplot displaying LastFM playcounts uses the "Associated Artists" feature/table as well but since there are, in some cases, more releases available in personal collections, you'll notice this image displays releases from the 50s even before he joined Elf.

Hovering over an album cover gives additional information.

### Albums Bar Chart
![Column chart created with D3 displaying popularity score for Billy Idol albums. Album cover art appears beneath each column. Numerical score appears above each column.](https://jotascript.files.wordpress.com/2018/04/billyidol.png)

Data stored in MySQL (MariaDB) database. D3 gets data using PHP scripts containing SQL queries and builds the graphs and charts. 
I think album charts need to be vertical, rather than horizontal bar chart because some artists have tons of albums and it requires horizontal scrolling even on a desktop that overflows out of the Bootstrap elements, eventually getting cut off by SVG boundaries.

**Associated Artists Albums Bar Graph**

Much like the above scatterplots included all albums feature Ronnie James Dio as lead singer, the bar graphs below aggregate all groups Steve Taylor sang for with his solo work.

<img src="https://roxorsoxor.com/imgs/pop-rock-php/steveTaylor.png" alt="">

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
