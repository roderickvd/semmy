Semmy
=====

Personal Solar Energy Monitor

Supported inverters
-------------------

Out-of-the-box support is provided for StecaGrid inverters that have an Ethernet interface and web portal with a "Measurements" page. If your inverter does have an Ethernet interface, but no such page, then you need to update the firmware.

Semmy is intended to be completely extensible. You can add support for other inverters by implementing the `Inverter` contract. Hook it up in the `InverterServiceProvider` and feel free to send a pull request.

Supported logging portals
-------------------------

Semmy currently supports logging to [PVOutput.org](http://pvoutput.org) and [Sonnenertrag.eu](https://www.sonnenertrag.eu/).

Support weather services
------------------------

Weather conditions can be retrieved from:
* [Weather Underground](https://www.wunderground.com/)
* [OpenWeatherMap](https://openweathermap.org)
* [KNMI](http://knmi.nl) (the Royal Netherlands Meteorological Institute)

You can add support for other weather services by implementing the `WeatherStationContract` contract. Hook it up in the `WeatherStationServiceProvider` and feel free to send a pull request.

Setup
-----

1. Copy `.env.example` to `.env`
2. Edit `.env` to suit your configuration
3. Add the following to your crontab:
```
* * * * * php /path/to/semmy/artisan schedule:run 1>> /dev/null 2>&1
```

Semmy also provides a real-time web dashboard that shows the current status of your solar generation and current weather conditions. In your web server, set the document root and index to `public/index.php` and be sure to enable rewrite support.

License
-------

This software by Roderick van Domburg is licensed under the terms of the MIT License.

Beautiful graphs are powered by Highcharts, which is licensed under a Creative Commons Attribution-NonCommercial 3.0 License. To view a copy of this license, visit http://creativecommons.org/licenses/by-nc/3.0/.

Free weather data from OpenWeatherMap is licensed under a Creative Commons Attribution-ShareAlike 2.0 License. To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/2.0/.

Weather Underground is a registered trademark of The Weather Channel, LLC both in the United States and internationally. The Weather Underground Logo is a trademark of Weather Underground, LLC.
