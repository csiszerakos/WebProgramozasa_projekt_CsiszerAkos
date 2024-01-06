<?php

namespace savemoneyapp;

class Connection
{
    function select_database($db, $user, $password)
    {
        global $con;
        $con = mysqli_connect("localhost", $user, $password, $db);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }

    function close()
    {
        global $con;
        mysqli_close($con);
    }
}
?>
