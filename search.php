<?php
session_start();

// Initialize $result to avoid undefined variable notice
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['location'])) {
    $location = $_GET['location'];

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $dbname = "ragpicker_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $location = $conn->real_escape_string($location);
    $sql = "SELECT * FROM users WHERE role = 'ragpicker' AND location LIKE '%$location%'";
    $result = $conn->query($sql);

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Ragpickers</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        /* Container styles */
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Heading styles */
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Search form styles */
        .search-form {
            margin-bottom: 20px;
            text-align: center;
        }

        .search-form label {
            font-weight: bold;
        }

        .search-form input[type="text"] {
            width: 300px;
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-form button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        /* Results table styles */
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .results-table th, .results-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .results-table th {
            background-color: #f8f8f8;
        }

        .results-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .book-button {
            padding: 5px 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .book-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Search Ragpickers</h1>
        <form class="search-form" action="search.php" method="get">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            <button type="submit">Search</button>
        </form>

        <?php if ($result && $result->num_rows > 0): ?>
            <h2>Search Results</h2>
            <table class="results-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td>
                            <form action="book.php" method="post" style="display:inline;">
                                <input type="hidden" name="ragpicker_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="book-button">Book</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['location'])): ?>
            <p>No ragpickers found for the specified location.</p>
        <?php endif; ?>
    </div>
</body>
</html>
