<?php

// Create connection
$conn = new mysqli($localhost, $vinothd, $vinoth2004, $vinothd);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// Close connection (optional)
// $conn->close();
?>
