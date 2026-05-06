<?php
session_start();
include "Rconfig.php";

/* ===== ADMIN AUTH ===== */
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

/* ===== DELETE USER ===== */
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM login WHERE id=$id");
    echo "<script>alert('User deleted successfully');location='user_details_form.php';</script>";
    exit();
}

/* ===== DELETE MESSAGE ===== */
if (isset($_GET['delete_msg'])) {
    $id = (int)$_GET['delete_msg'];
    mysqli_query($conn, "DELETE FROM contact WHERE id=$id");
    echo "<script>alert('Message deleted successfully');location='user_details_form.php';</script>";
    exit();
}

/* ===== USER PAGINATION ===== */
$limit = 6;
$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$offset = ($page-1)*$limit;

$totalQ = mysqli_query($conn,"SELECT COUNT(*) total FROM login");
$total = mysqli_fetch_assoc($totalQ)['total'];
$pages = ceil($total/$limit);

/* ===== FETCH USERS ===== */
$users = mysqli_query($conn,"
    SELECT id, username, email 
    FROM login
    ORDER BY id DESC
    LIMIT $limit OFFSET $offset
");

/* ===== FETCH MESSAGES ===== */
$messages = mysqli_query($conn,"
    SELECT id, name, email, message 
    FROM contact
    ORDER BY id DESC
");


/* ===== MESSAGE PAGINATION ===== */
$msg_limit = 6;
$msg_page = isset($_GET['msg_page']) ? max(1,(int)$_GET['msg_page']) : 1;
$msg_offset = ($msg_page - 1) * $msg_limit;

$msgTotalQ = mysqli_query($conn, "SELECT COUNT(*) total FROM contact");
$msgTotal = mysqli_fetch_assoc($msgTotalQ)['total'];
$msgPages = ceil($msgTotal / $msg_limit);

/* ===== FETCH PAGINATED MESSAGES ===== */
$messages = mysqli_query($conn,"
    SELECT id, name, email, message
    FROM contact
    ORDER BY id DESC
    LIMIT $msg_limit OFFSET $msg_offset
");

?>


<!DOCTYPE html>
<html>
<head>
<title>User & Message Details</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --primary:#6366F1;
    --nav:#718096;
    --danger:#ef4444;
}
*{font-family:'Inter',sans-serif;box-sizing:border-box}
body{background:#f5f7fb;margin:0}

/* HEADER */
header{
    background:#fff;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:1px solid #ddd;
}
.header-left{
    display:flex;
    align-items:center;
    gap:40px;
}
header h2{color:var(--primary)}
.admin_nav{
    display:flex;
    gap:24px;
    padding-left:15rem;
}
.admin_nav a{
    text-decoration:none;
    color:var(--nav);
    font-weight:600;
}
.admin_nav a:hover{color:var(--primary)}
.logout{
    background:var(--primary);
    color:#fff;
    padding:10px 18px;
    border:none;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
}

/* CONTAINER */
.container{
    max-width:1200px;
    margin:30px auto;
    padding:0 20px;
}

/* TABLE */
table{
    width:100%;
    background:#fff;
    border-collapse:collapse;
    border-radius:12px;
    text-align:center;
    margin-bottom:40px;
}
th,td{
    padding:14px;
    text-align:center;
    vertical-align:middle;
}
th{background:#e5e7eb}
tr:hover{background:#f9fafb}

/* BUTTONS */
button{
    padding:6px 14px;
    border:none;
    border-radius:6px;
    font-weight:600;
    cursor:pointer;
}
.delete{
    background:var(--danger);
    color:#fff;
}
.action-btns{
    display:flex;
    justify-content:center;
    gap:8px;
}

/* PAGINATION */
.pagination{
    display:flex;
    justify-content:center;
    gap:6px;
    margin:20px 0 40px;
}
.pagination a{
    padding:8px 14px;
    border:1px solid var(--primary);
    text-decoration:none;
    border-radius:6px;
}
.pagination a.active,
.pagination a:hover{
    background:var(--primary);
    color:#fff;
}

</style>
</head>

<body>
<?php include "loader.php"; ?>

<header>
    <div class="header-left">
        <h2>Admin Dashboard</h2>
        <nav class="admin_nav" >
            <a href="admin.php">Blogs Data</a>
            <a href="user_details_form.php">User Login</a>
            <a href="user_details_form.php#messages">Message</a>
        </nav>
    </div>
    <form action="logout.php" method="post">
    <button class="logout">Logout</button>
    </form>
</header>

<div class="container">

<!-- ================= USERS TABLE ================= -->
        <h3 style="margin-bottom:15px;">Registered Users</h3>

        <table>
        <tr>
            <th>Sr No</th>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>

        <?php 
        $sr = $offset + 1;
        if(mysqli_num_rows($users)>0){
            while($u=mysqli_fetch_assoc($users)){ ?>
        <tr>
            <td><?= $sr++ ?></td>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td>
                <div class="action-btns">
                    <a href="?delete_id=<?= $u['id'] ?>" 
                    onclick="return confirm('Delete this user?')">
                        <button class="delete">Delete</button>
                    </a>
                </div>
            </td>
        </tr>
        <?php } } else { ?>
        <tr>
            <td colspan="5" style="font-weight:600;">No users found</td>
        </tr>
        <?php } ?>
        </table>

        <div class="pagination">
            <?php for($i=1;$i<=$pages;$i++){ ?>
                <a class="<?= ($i==$page)?'active':'' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
            <?php } ?>
        </div>

<!-- ================= MESSAGES TABLE ================= -->
        <div id="messages"></div>
        <h3 style="margin-bottom:15px;">User Messages</h3>

        <table>
        <tr>
            <th>Sr No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>

        <?php 
        $sr = 1;
        if(mysqli_num_rows($messages)>0){
            while($m=mysqli_fetch_assoc($messages)){ ?>
        <tr>
            <td><?= $sr++ ?></td>
            <td><?= htmlspecialchars($m['name']) ?></td>
            <td><?= htmlspecialchars($m['email']) ?></td>
            <td><?= htmlspecialchars($m['message']) ?></td>
            <td>
                <div class="action-btns">
                    <a href="?delete_msg=<?= $m['id'] ?>" 
                    onclick="return confirm('Delete this message?')">
                        <button class="delete">Delete</button>
                    </a>
                </div>
            </td>
        </tr>
        <?php } } else { ?>
        <tr>
            <td colspan="5" style="font-weight:600;">No messages found</td>
        </tr>
        <?php } ?>
        </table>
        <div class="pagination">
        <?php for($i=1;$i<=$msgPages;$i++){ ?>
            <a class="<?= ($i==$msg_page)?'active':'' ?>"
            href="?msg_page=<?= $i ?>&page=<?= $page ?>#messages">
                <?= $i ?>
            </a>
        <?php } ?>
        </div>



</div>

</body>
</html>
