<?php
$service_blob = json_decode($_ENV['VCAP_SERVICES'], true);

foreach($service_blob as $service_provider => $service_list) {
    // looks for 'cleardb' or 'p-mysql' service
    if ($service_provider === 'user-provided') {
        foreach($service_list as $mssql_service) {
            if ($mssql_service['instance_name'] === 'mssql-server-db') {
                $serverName = $mssql_service['credentials']['host'];
                $connectionOptions = array(
                    "database" => $mssql_service['credentials']['database'],
                    "uid" => $mssql_service['credentials']['user'],
                    "pwd" => $mssql_service['credentials']['password']
                );
            }
        }
        continue;
    }
}


// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if ($conn === false) {
    die(formatErrors(sqlsrv_errors()));
}

// Select Query
$tsql = "SELECT @@Version AS SQL_VERSION";

// Executes the query
$stmt = sqlsrv_query($conn, $tsql);

// Error handling
if ($stmt === false) {
    die(formatErrors(sqlsrv_errors()));
}
?>

<h1> Results : </h1>

<?php
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo $row['SQL_VERSION'] . PHP_EOL;
}

sqlsrv_free_stmt($stmt);

$tsql2="SELECT NAME,PRODUCTNUMBER FROM SalesLT.Product";
$getResults= sqlsrv_query($conn, $tsql2);

echo ("Reading data from table" . PHP_EOL);
if ($getResults === false) {
 die(formatErrors(sqlsrv_errors()));
}

while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
  echo ($row['NAME'] . " " . $row['PRODUCTNUMBER'] . PHP_EOL);
}
sqlsrv_free_stmt($getResults);

sqlsrv_close($conn);

function formatErrors($errors)
{
    // Display errors
    echo "Error information: <br/>";
    foreach ($errors as $error) {
        echo "SQLSTATE: ". $error['SQLSTATE'] . "<br/>";
        echo "Code: ". $error['code'] . "<br/>";
        echo "Message: ". $error['message'] . "<br/>";
    }
}
?>
