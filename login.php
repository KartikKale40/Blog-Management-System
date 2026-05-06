
<?php
session_start();
include "Rconfig.php";

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // DO NOT escape password

    // Fetch user by username
    $query = mysqli_query(
        $conn,
        "SELECT * FROM login WHERE username='$username'"
    );

    if (mysqli_num_rows($query) == 1) {

        $user = mysqli_fetch_assoc($query);

        // Verify hashed password
        if (password_verify($password, $user['password'])) {

            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: user_dashboard.php");
            exit();

        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }

    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login - Daily Blogs</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #4CAF50;
        }

        .login-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-container button:hover {
            background-color: #45a049;
        }

        .login-container .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #4CAF50;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .login-container .register-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <?php include "loader.php"; ?>

    <div class="login-container">
        <h2>User Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit" name="submit">Login</button>
        </form>
        <a href="register.php" class="register-link">Don't have an account? Register here</a>
    </div>

</body>
</html>
