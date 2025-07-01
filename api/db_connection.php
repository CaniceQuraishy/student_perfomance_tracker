<?php
// This is our central database connection file.

// --- Database Credentials ---
// These are the default settings for a local XAMPP server.
$servername = "localhost";
$username = "root";
$password = ""; // The default password for the 'root' user is empty.
$dbname = "spt_db"; // The name of the database we created.

// --- Create the Connection ---
// We use 'mysqli' for a modern and secure connection.
$conn = new mysqli($servername, $username, $password, $dbname);

// --- Check the Connection ---
// If the connection fails, we stop everything and show an error.
// This is important for debugging.
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>