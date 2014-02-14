FHEM Presence tracker with Geofency webhook
===========================================

Receive JSON POST request from the [Geofency iOS app][1] and write the enter/exit event to a file.
A command line utility is also provided and can be called from FHEM to check the status.

System requirements
-------------------
* PHP 5.3 or better
* [Composer][2]

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
Since the webhook is open for everyone, you should [protect it with a .htaccess file][3] and enter the data in Geofency.

Ideas for future expansion
--------------------------
- Validate JSON
- Verify phone id(s) and iBeacon UUID 
- Differentiate between several beacon IDs for a more general use case of the webhook
- Store all events in database (for statistics/debugging)

[1]: http://www.geofency.com/
[2]: https://getcomposer.org/
[3]: http://lmgtfy.com/?q=password+protection+.htaccess
