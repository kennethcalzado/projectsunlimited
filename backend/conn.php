<?php

// Database credentials
$servername = "localhost"; // Change this to your database server name
$username = "projectsadmin"; // Change this to your database username
$password = "projectsunlimited1968"; // Change this to your database password
$database = "projectsunlimited"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}
