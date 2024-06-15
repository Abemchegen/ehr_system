<?php

    $database= new mysqli("localhost","root","","ehr");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>