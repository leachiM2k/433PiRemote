433PiRemote
===========
This is web interface for remote switch sockets working on 433 MHz band.
It has two parts: an user interface with simple buttons and an administration part
with fancy forms and dip switches that enables everyone to add new remote switches.

Please use composer to install all dependencies as it needs the twig emplate engine.

    composer install
    
**You don't need any databases!**
Everything is stored in json-files. Take a look at data/example.*.json files.
For a quick start rename them by removing "example." from their names.

Furthermore you'll have to set some directories and files to be writable by your
web server user (usually www-data on linux systems). These directories are:
* twig/cache (I suggest chmod 777)
* data/config.json (I suggest chmod 666)
* data/groups.json (I suggest chmod 666)
    
You will also need the 433-sender-server. I will upload it to github in few days.
