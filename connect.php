<?php
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $dbname = "iotdata";

    $conn = mysqli_connect ($serverName, $userName, $password, $dbname);

    mysqli_query($conn, "SET NAMEs 'utf8'");
?>