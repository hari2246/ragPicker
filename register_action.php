<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ragpicker_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize input data
$name = $conn->real_escape_string($_POST['name']);
$email = $conn->real_escape_string($_POST['email']);
$password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
$role = $conn->real_escape_string($_POST['role']);

if ($role == 'ragpicker') {
    $location = $conn->real_escape_string($_POST['location']);
    $sql = "INSERT INTO users (name, email, password, role, location) VALUES ('$name', '$email', '$password', '$role', '$location')";
} else {
    $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
}

if ($conn->query($sql) === TRUE) {
    // Redirect to login page after successful registration
    header("Location: login.php");
    exit; // Ensure script termination after the header redirection
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
