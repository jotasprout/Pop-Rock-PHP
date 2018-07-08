# Pop-PHP
Gets popularity data via Spotify API for artists, albums, and songs to store in a MySQL database and track popularity over time as well as comparing popularity data across artists, albums, songs. Building interactive data visualization using **D3.js** and **jQuery**.

## Recent Examples
### Column Chart
![Column chart created with D3 displaying popularity score for Billy Idol albums. Album cover art appears beneath each column. Numerical score appears above each column.](https://jotascript.files.wordpress.com/2018/04/billyidol.png)

At present, user selects an artist from a menu. Menu fetches data stored in my MySQL database and uses D3 to generate a column graph. 

![Line chart created with D3 showing Alice Cooper's popularity score over approximately six months.](https://jotascript.files.wordpress.com/2018/07/alicegraph.png)

At present, this is my only line graph. Purpose is to compare artists' popularity scores using album release dates as "years."

## Back End
* Eventually, all PHP will be strictly back-end
* Cron jobs collect Spotify Web API data regularly and store it in my database

## Status
Active.

## Background
PHP-based version of [rockinJS](https://github.com/jotasprout/rockinJS) which replaced [myRockinApp](https://github.com/jotasprout/myRockinApp) (Python). Moved on to using PHP and MySQL with Pop-PHP because I couldn't get the objects to build as completely as I wanted in either Python to Javascript. 
