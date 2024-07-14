<?php
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

$name = $_POST['name'];
$email = $_POST['email'];
$location = $_POST['location'];
$phone = $_POST['phone'];
$description = $_POST['description'];

$sql = "INSERT INTO ragpickers (name, email, location, phone, description) VALUES ('$name', '$email', '$location', '$phone', '$description')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
