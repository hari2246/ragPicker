<?php
session_start();

// Check if ragpicker is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['role'] != 'ragpicker') {
    header('Location: login.php');
    exit;
}

$ragpicker_id = $_SESSION['user_id'];  // Assuming user_id is stored in session after login

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

// Fetch ragpicker details
$sql_ragpicker = "SELECT * FROM users WHERE id = ?";
$stmt_ragpicker = $conn->prepare($sql_ragpicker);
$stmt_ragpicker->bind_param("i", $ragpicker_id);
$stmt_ragpicker->execute();
$result_ragpicker = $stmt_ragpicker->get_result();
$ragpicker = $result_ragpicker->fetch_assoc();

// Prepare SQL statement to retrieve bookings in ascending order by booking ID
$sql_bookings = "SELECT b.*, u.name AS user_name 
                 FROM bookings b 
                 INNER JOIN users u ON b.user_id = u.id
                 WHERE b.ragpicker_id = ? 
                 ORDER BY b.id ASC";  // Ordering by b.id ASC for ascending order
$stmt_bookings = $conn->prepare($sql_bookings);
$stmt_bookings->bind_param("i", $ragpicker_id);
$stmt_bookings->execute();
$result_bookings = $stmt_bookings->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ragpicker Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .details, .bookings {
            margin-bottom: 20px;
        }
        .details p, .bookings table {
            margin: 10px 0;
        }
        .bookings table {
            width: 100%;
            border-collapse: collapse;
        }
        .bookings th, .bookings td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .bookings th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ragpicker Dashboard</h1>
        
        <div class="details">
            <h2>My Details</h2>
            <p>Name: <?php echo htmlspecialchars($ragpicker['name']); ?></p>
            <p>Email: <?php echo htmlspecialchars($ragpicker['email']); ?></p>
            <p>Location: <?php echo htmlspecialchars($ragpicker['location']); ?></p>
            <p>Role: <?php echo htmlspecialchars($ragpicker['role']); ?></p>
        </div>

        <div class="bookings">
        <h2>My Bookings</h2>
            <?php if ($result_bookings->num_rows > 0): ?>
                
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_bookings->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt_ragpicker->close();
$stmt_bookings->close();
$conn->close();
?>
