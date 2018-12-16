# Sample PHP/SQLServer application for PCF

Currently SQL server drivers are not included as part of PHP buildpack and trusty cells
To make it work 
- include SQL Driver, unixODBC and PHP extension for SQL libraries along with the application
  Refer to `php/lib` directory - copy all files 
- Set `LD_LIBRARY_PATH` in manifest.yml to the directory containing driver libs
- Set `ODBCSYSINI` in manifest to point to location of `odbcinst.ini` file required by driver
- Activate sqlserver php extensions by adding definintions to `php.ini`. It is done byusing buildpack extensibility and adding `.extensions\sqlsrv` code that copies requeried definitions to php configuration

http://appurl/testsql.php

Enjoy!



