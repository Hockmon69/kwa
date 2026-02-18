<?php
session_start();
include('Database.php'); // Connects to the database

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Search for the user in the database
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username; // Start a session for the admin
        header("Location: admin.php"); // Redirect to the admin dashboard
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Specific styling for the login box */
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background: #222;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            background: #333;
            border: 1px solid #444;
            color: white;
        }
        .error { color: #ff4757; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if(isset($error)) { echo '<p class="error">'.$error.'</p>'; } ?>
        
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <br>
        <a href="index.php" style="color: gray; text-decoration: none;">← Back to Site</a>
    </div>

</body>
</html>