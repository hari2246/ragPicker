<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("Please log in to book a ragpicker."); // Die or redirect to login page
    }

    // Sanitize input
    $user_id = $_SESSION['user_id'];
    $ragpicker_id = $_POST['ragpicker_id'];

    // Database credentials
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

    // Prepare SQL statement with placeholders
    $sql = "INSERT INTO bookings (user_id, ragpicker_id, booking_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    // Bind parameters with types
    $stmt->bind_param("ii", $user_id, $ragpicker_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Close statement and connection
        $stmt->close();
        $conn->close();

        // Display success message using JavaScript alert
        echo '<script>alert("Booking successful!"); window.location.href = "user_dashboard.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Handle GET requests or other methods
    echo "Invalid request method.";
}
?>
