<?php
$serverName = "";
$connectionOptions = array(
    "database" => "xx",
    "uid" => "xxx",
    "pwd" => "xxx"
);

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


$tsql2="SELECT TOP 20  ARTIST, TITLE FROM  album";
$getResults= sqlsrv_query($conn, $tsql2);

echo ("Reading data from table" . PHP_EOL);
if ($getResults === false) {
 die(formatErrors(sqlsrv_errors()));
}

while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
  echo ($row['ARTIST'] . " " . $row['TITLE'] . PHP_EOL);
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
