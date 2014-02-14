FHEM Presence tracker with Geofency webhook
===========================================

This code enables [FHEM][1] PRESENCE state through [Geofencing][5] with the [Geofency iOS app][2].

It consists of:
* A webhook (server script) that receives JSON POST requests from the Geofency app and writes the enter/exit events to a file.
* A command line utility that is called from FHEM to generate presence state (1 or 0) from the data.

System requirements
-------------------
* PHP 5.3 or better
* [Composer][3]

Installation
------------
- After extracting the sources in your web directory, run  
	``composer install``.
- Change the settings in ``settings.php`` if needed. 
- Make sure that the data directory for the data file is writable.
- Browse to your web directory. You should see the message "Not allowed." If you see the message "Filesystem error" check if the data directory for the data file is writable.
- *(optional)* Create a .htaccess file to protect your web directory (see "Security considerations").
- Install Geofency. Create a new location (either with a geofence or an iBeacon) and use its settings to set up a webhook for it, with the index.php as the endpoint.
- FHEM: Add the following line to your FHEM cfg:   
  ``define Geofency PRESENCE shellscript "php /path/to/your/webroot/checkpresence.php"``

Security considerations
-----------------------
Since the webhook is open for everyone, you should [protect it with a .htaccess file][4] and enter the data in Geofency.

Ideas for future expansion
--------------------------
- Validate JSON
- Verify phone id(s) and iBeacon UUID 
- Differentiate between several beacon IDs for a more general use case of the webhook
- Store all events in database (for statistics/debugging)

[1]: http://fhem.de/
[2]: http://www.geofency.com/
[3]: https://getcomposer.org/
[4]: http://lmgtfy.com/?q=password+protection+.htaccess
[5]: https://en.wikipedia.org/wiki/Geo-fence
