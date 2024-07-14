<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $servername = "localhost";
        $username = "root";
        $password_db = "";  // Changed variable name to avoid conflict with password field
        $dbname = "ragpicker_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['location'] = $row['location'];

                if ($row['role'] == 'user') {
                    header("Location: user_dashboard.php");
                } else {
                    header("Location: ragpicker_dashboard.php");
                }
                exit;
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill out both fields.";
    }
} else {
    echo "Invalid request method.";
}
?>
