# Pop Rock (PHP)
Gets popularity data via Spotify API for artists, albums, and songs to store in a MySQL database and track popularity over time as well as comparing popularity data across artists, albums, songs. Building interactive data visualization using **D3.js** and **jQuery**.

## Recent Examples
### Albums List

Albums in list view can be sorted by album title, release date, and popularity.

<img src="https://jotascript.files.wordpress.com/2018/10/zombiesalbums2.png" alt="Top five albums by The Zombies on Spotify October 11, 2018.">

### Albums Bar Chart
![Column chart created with D3 displaying popularity score for Billy Idol albums. Album cover art appears beneath each column. Numerical score appears above each column.](https://jotascript.files.wordpress.com/2018/04/billyidol.png)

At present, user selects an artist from a menu. Menu fetches data stored in my MySQL database and uses D3 to generate a column graph. 

I think this needs to be a vertical, rather than horizontal, bar chart because some artists have tons of albums and it requires horizontal scrolling even on a desktop.

### Line Graphs for visualizing popularity over time

![Line chart created with D3 showing Alice Cooper's popularity score over approximately six months.](https://jotascript.files.wordpress.com/2018/07/alicegraph.png)

At present, this is the only type of line graph available. Purpose is to compare artists' popularity scores using album release dates as "years." Above is a line graph for **Alice Cooper** for an indeterminate amount of time. Below is popularity for **Rufus featuring Chaka Khan** approximately from their nomination for induction to the **Rock and Roll Hall of Fame** in 2017 to their nomination in 2018.

<img src="https://jotascript.files.wordpress.com/2018/10/rufusline.png">

In the near future, users can compare artists, albums and tracks with multiple lines in a single graph.

### Tracks List

At present, tracks are listed all together. Eventually, they'll be viewable by album. Tracks list view is sortable by album title, track title, and popularity.

<img src="https://jotascript.files.wordpress.com/2018/10/roxytracks.png" alt="Top ten Roxy Music tracks on Spotify October 11, 2018.">

## Front End
- Soon, the front end will be far less clunky and take advantage of AJAX
- Also, the UI will be more interactive

## Back End
* Eventually, all PHP will be strictly back-end
* Cron jobs collect Spotify Web API data regularly and store it in my database

## Status
Active.

## Background
PHP-based version of [rockinJS](https://github.com/jotasprout/rockinJS) which replaced [myRockinApp](https://github.com/jotasprout/myRockinApp) (Python). Moved on to using PHP and MySQL with Pop-PHP because I couldn't get the objects to build as completely as I wanted in either Python to Javascript. 

## ADA
### To Do
- Add speech output, descriptions of charts, results
- Alternate input for those who can't see to drag & drop