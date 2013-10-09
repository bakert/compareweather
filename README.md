compareweather
==============

Compare the weather in two locations. Minimalist web app.

Setup
=====

* Copy/move config.sample to config
* Run the SQL in /sql/compareweather.sql against your database, replacing PASSWORD with a suitable password
* Replace PASSWORD in config with the chosen password
* Register with developer.forecast.io
* Replace APIKEY in config with your forecast.io API key
* Optionally, schedule /server/scheduled.php to run daily or even hourly via cron so that weather data is not fetched on user time.
