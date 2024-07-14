<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Ragpicker</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Register as Ragpicker</h2>
    <form action="register_action.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required><br><br>
        <input type="hidden" name="role" value="ragpicker">
        <button type="submit">Register</button>
    </form>
</body>
</html>
