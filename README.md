# Example Application for PHP/SQLServer on PCF

## Prerequisites

1. You need an SQL Server. It needs to be routable from your PCF environment. Include the example database tables with customer/product/sales info.

2. You need Internet access from your PCF environment. This is to a.) download the apt-buildpack which is not installed in most PCF environments and b.) because the apt-buildpack will use apt to install dependencies directly from Microsoft.

## Instructions

1. Create a user provided service with your DB info. Run `cf cups mssql-server-db -p "host, user, password, database"`. Supply your host, user and password.

2. Git clone this repo. Then run `cf push` from the root.

This will deploy the application to PCF. You can then go to the URL mapped to your application and you should see the `phpinfo()` output. This can be used to confirm that the `sqlsrv` and `pdo_sqlsrv` extensions are loaded. You can then go to `/testsql.php` URL and you should see data loaded from your database (this requires that the sample databases were loaded, if you have other SQL data you can modify the SQL query run by the `testsql.php` script prior to running `cf push`.

## Behind the Scenes

The PHP buildpack is going to install the `sqlsrv` and `pdo_sqlsrv` extensions for you. These extensions are bundled with most recent versions of the PHP buildpack.

In addition to that you need to have the Microsoft SQLServer ODBC driver for Ubuntu 18.04 Linux. This demo app is using the apt-buildpack to install these dependencies direct from Microsoft. See [these instructions](https://www.microsoft.com/en-us/sql-server/developer-get-started/php/ubuntu) and [these instructions](https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-2017) for more details. You can also see `apt.yml` to see which packages are installed.

## SQL Tools

We are also installing MSSQL Tools, so you can use `sqlcmd`. Run `cf ssh <app> -t -c "/tmp/lifecycle/launcher /home/vcap/app bash ''"` to enter container and source env variables. Then run `sqlcmd -S <db-host> -U <user>` to test connection.
