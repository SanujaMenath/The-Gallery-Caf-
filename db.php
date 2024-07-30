<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "the_gallery_cafe";

//Create Connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check Connection
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

?>