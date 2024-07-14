<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'user') {
    header('Location: login.php');
    exit;
}

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

$user_id = $_SESSION['user_id'];
$sql = "SELECT bookings.id, users.name, users.email, users.location, bookings.booking_date 
        FROM bookings 
        JOIN users ON bookings.ragpicker_id = users.id 
        WHERE bookings.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add some styles for the bookings table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #f5f5f5;
        }
        tr {
            background-color: #f8f8f8;
        }

    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
    <a href="logout.php" class="logout-btn">Logout</a>
    <h2>Search for Ragpickers by Location</h2>
    <form action="search.php" method="get">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>
        <button type="submit">Search</button>
    </form>
    <h2 style="color:white">Your Bookings</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Ragpicker Name</th>
                <th>Email</th>
                <th>Location</th>
                <th>Booking Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>
    <?php
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
