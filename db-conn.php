<?php

// DB connect
$dbConn = @mysqli_connect($host, $user, $pwd, $sqlDb);

// Check connection
if ($dbConn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>