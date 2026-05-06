<?php
include "Rconfig.php";

// ================= AJAX CHECK =================
if(isset($_POST['ajax_check'])){
    $type = $_POST['type'];
    $value = mysqli_real_escape_string($conn, $_POST['value']);

    if($type == "username"){
        $q = mysqli_query($conn,"SELECT * FROM login WHERE username='$value'");
    } else {
        $q = mysqli_query($conn,"SELECT * FROM login WHERE email='$value'");
    }

    if(mysqli_num_rows($q) > 0){
        echo "exists";
    } else {
        echo "available";
    }
    exit();
}

// ================= REGISTER =================
if (isset($_POST['register'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $checkUser = mysqli_query(
        $conn,
        "SELECT * FROM login WHERE username='$username' OR email='$email'"
    );

    if (mysqli_num_rows($checkUser) > 0) {
        echo "<script>alert('Username or Email already exists!'); window.history.back();</script>";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert = mysqli_query(
        $conn,
        "INSERT INTO login (username, email, password)
         VALUES ('$username', '$email', '$hashed_password')"
    );

    if ($insert) {
        echo "<script>alert('Registration successful'); window.location.href='login.php';</script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Arial',sans-serif;}
body{background:#f4f4f9;display:flex;justify-content:center;align-items:center;height:100vh;}
.register-container{background:#fff;padding:30px 40px;border-radius:12px;box-shadow:0 8px 25px rgba(0,0,0,0.15);width:100%;max-width:650px;display:flex;gap:40px;flex-wrap:wrap;}
.register-form{flex:2;min-width:300px;}
.register-form h2{text-align:center;margin-bottom:25px;color:#4CAF50;font-size:28px;}
.register-form label{display:block;margin-bottom:5px;font-weight:bold;font-size:14px;}
.register-form input{width:100%;padding:12px;margin-bottom:15px;border-radius:6px;border:1px solid #ccc;font-size:14px;}
.register-form button{width:100%;padding:12px;background:#4CAF50;color:#fff;font-weight:bold;border:none;border-radius:6px;cursor:pointer;transition:0.3s;font-size:16px;}
.register-form button:hover{background:#45a049;}
.note-panel{flex:1;background:#f9fff9;border-left:3px solid #4CAF50;padding:20px 15px;border-radius:8px;height:fit-content;margin-top:0;position:sticky;top:20px;}
.note-panel h3{color:#4CAF50;margin-bottom:15px;text-align:center;font-size:16px;}
.note-panel ul{list-style:none;padding-left:0;font-size:14px;line-height:1.8;}
.note-panel li{margin-bottom:10px;color:#000;transition:0.3s;}
.note-valid{color:green;font-weight:bold;}
.note-invalid{color:red;font-weight:bold;}
.availability-msg{font-size:0.85rem;margin-top:-10px;margin-bottom:10px;height:18px;}
.login-link {
    display: block;
    text-align: center;
    margin-top: 12px;
    font-size: 14px;
    color: #4CAF50;
    text-decoration: none;
    transition: 0.3s;
}

.login-link:hover {
    text-decoration: underline;
    color: #45a049;
}

@media(max-width:900px){.register-container{flex-direction:column;}.note-panel{border-left:none;border-top:3px solid #4CAF50;margin-top:20px;position:relative;top:auto;}}
</style>
</head>
<body>

<div class="register-container">
    <form action="register.php" method="post" class="register-form" id="regForm">
        <h2>Create Account</h2>

        <!-- Username -->
        <label>Username</label>
        <input type="text" id="username" name="username" required>
        <div id="userMsg" class="availability-msg"></div>

        <!-- Email -->
        <label>Email</label>
        <input type="email" id="email" name="email" required>
        <div id="emailMsg" class="availability-msg"></div>

        <!-- Password -->
        <label>Password</label>
        <input type="password" id="password" name="password" required>

        <!-- Confirm Password -->
        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="register">Register</button>
        
       <a href="login.php" class="login-link">Already have an account? Login here</a>

    </form>
    

    <!-- Note Panel -->
    <div class="note-panel">
        <h3>Note</h3>
        <ul>
            <li id="note-username-length">Username: min 4 characters</li>
            <li id="note-username-char">Username: letters & numbers</li>
            <li id="note-password-length">Password: min 6 characters</li>
            <li id="note-password-cap">Password: at least 1 capital letter</li>
            <li id="note-password-num">Password: at least 1 number</li>
            <li id="note-password-special">Password: at least 1 special symbol (!@#$...)</li>
        </ul>
    </div>
</div>

<script>
const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

// ===== AJAX CHECK =====
function checkData(type,value,msgId){
    let msg=document.getElementById(msgId);
    if(value.trim()===""){ msg.innerHTML=""; return; }

    fetch("register.php",{
        method:"POST",
        headers:{"Content-Type":"application/x-www-form-urlencoded"},
        body:"ajax_check=1&type="+type+"&value="+encodeURIComponent(value)
    })
    .then(res=>res.text())
    .then(data=>{
        if(data=="exists"){
            msg.innerHTML = type.charAt(0).toUpperCase()+type.slice(1) + " already exists";
            msg.style.color = "red";
        } else {
            msg.innerHTML = type.charAt(0).toUpperCase()+type.slice(1) + " available";
            msg.style.color = "green";
        }
    });
}
usernameInput.addEventListener("input",()=>{checkData("username",usernameInput.value,"userMsg");});
emailInput.addEventListener("input",()=>{checkData("email",emailInput.value,"emailMsg");});

// ===== DYNAMIC NOTE COLOR =====
function updateNote(noteId,condition,value){
    const noteEl = document.getElementById(noteId);
    if(value===""){ noteEl.style.color="#000"; noteEl.style.fontWeight="normal"; return; }
    if(condition){ noteEl.style.color="green"; noteEl.style.fontWeight="bold"; }
    else{ noteEl.style.color="red"; noteEl.style.fontWeight="bold"; }
}

usernameInput.addEventListener('input', function () {
    const val = this.value;
    updateNote('note-username-length', val.length>=4, val);
    updateNote('note-username-char', (/[a-zA-Z]/.test(val) && /\d/.test(val)), val);
});

passwordInput.addEventListener('input', function () {
    const val = this.value;
    updateNote('note-password-length', val.length>=6, val);
    updateNote('note-password-cap', /[A-Z]/.test(val), val);
    updateNote('note-password-num', /\d/.test(val), val);
    updateNote('note-password-special', /[!@#$%^&*(),.?":{}|<>]/.test(val), val);
});

// ===== FORM SUBMIT CHECK =====
document.getElementById('regForm').addEventListener('submit', function(e) {
    if(document.querySelectorAll('.note-panel li').length > 0){
        const invalid = Array.from(document.querySelectorAll('.note-panel li')).some(el=>el.style.color=="red");
        if(invalid){
            alert("Please fulfill all requirements in Note panel.");
            e.preventDefault();
        }
    }
});
</script>

</body>
</html>
