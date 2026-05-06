<?php
session_start();
include "Rconfig.php";

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Get admin by username only
   $stmt = mysqli_prepare($conn, "SELECT * FROM admin WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

    $admin = mysqli_fetch_assoc($result);

    if (password_verify($password, $admin['password'])) {

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid Password";
    }

} else {
    $error = "Invalid Username";
}

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial,sans-serif;
}

body{
    background:#f4f4f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.login-container{
    background:#fff;
    padding:40px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    width:100%;
    max-width:400px;
}

.login-container h2{
    text-align:center;
    margin-bottom:25px;
    color:#4CAF50;
}

label{
    font-weight:bold;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0 20px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    width:100%;
    padding:12px;
    background:#4CAF50;
    color:#fff;
    border:none;
    border-radius:5px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#45a049;
}

.error{
    background:#fdecea;
    color:#d32f2f;
    padding:10px;
    margin-bottom:15px;
    border-radius:5px;
    text-align:center;
}
</style>
</head>

<body>
<?php include "loader.php"; ?>

<div class="login-container">
<h2>Admin Login</h2>

<?php if (!empty($error)) { ?>
    <div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="post">
<label>Username</label>
<input type="text" name="username" required>

<label>Password</label>
<input type="password" name="password"  required>

<button type="submit" name="submit">Login</button>
</form>
</div>

</body>
</html>
