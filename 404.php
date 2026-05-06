<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page Not Found</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary-color: #6366F1;
    --text-color: #333;
    --gray: #777;
    --background-color: #f9fafb;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Inter',sans-serif;
}

body{
    background: var(--background-color);
    display:flex;
    align-items:center;
    justify-content:center;
    height:100vh;
    text-align:center;
}

/* Error Card */
.error-container{
    background:#fff;
    padding:50px 40px;
    border-radius:14px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
    max-width:500px;
    animation: fadeIn 0.6s ease;
}

.error-code{
    font-size:80px;
    font-weight:700;
    color:var(--primary-color);
}

.error-title{
    font-size:24px;
    margin-top:10px;
    color:var(--text-color);
}

.error-text{
    margin-top:10px;
    color:var(--gray);
}

.btn-home{
    display:inline-block;
    margin-top:25px;
    padding:12px 26px;
    background:var(--primary-color);
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
    transition:0.3s;
}

.btn-home:hover{
    background:#4F46E5;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}
</style>
</head>

<body>

<div class="error-container">
    <div class="error-code">404</div>
    <div class="error-title">Page Not Found</div>
    <div class="error-text">
        The page you are looking for does not exist or the URL is incorrect.
    </div>
    <a href="index.php" class="btn-home">Go to Home</a>
</div>

</body>
</html>
