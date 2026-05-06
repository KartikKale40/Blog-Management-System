<?php
session_start();
include "Rconfig.php";

/* =================== ADMIN AUTH =================== */
if (!isset($_SESSION['admin_id'])) {
    header("Location: adminlogin.php");
    exit();
}

/* =================== CREATE ADMIN =================== */

if (isset($_POST['create_admin'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO admin (username, email,mobile,password) VALUES ('$username','$email','$mobile', '$password')");
    echo "<script>alert('Admin created successfully');location='admin.php';</script>";
    exit();
}

/* =================== UPDATE PROFILE =================== */

if (isset($_POST['update_profile'])) {
    $id = $_SESSION['admin_id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';

    $sql = "UPDATE admin SET username='$username', email='$email', mobile='$mobile'";
    if ($password !== '') $sql .= ", password='$password'";
    $sql .= " WHERE id=$id";
    mysqli_query($conn, $sql);

    // Update session variables
    $_SESSION['admin_username'] = $username;
    $_SESSION['admin_email'] = $email;
    $_SESSION['admin_mobile'] = $mobile;

    echo "<script>alert('Profile updated successfully');location='admin.php';</script>";
    exit();
}

/* =================== SAVE REMARK =================== */

if (isset($_POST['save_remark'])) {
    $id = (int)$_POST['blog_id'];
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);

    mysqli_query($conn, "
        UPDATE blogs 
        SET remark='$remark', status='Rejected' 
        WHERE blog_id=$id
    ");

    echo "<script>alert('Blog rejected with remark');location='admin.php';</script>";
    exit();
}


/* =================== BLOG ACTIONS =================== */

if (isset($_GET['approve_id'])) {
    $id = (int)$_GET['approve_id'];
    mysqli_query($conn, "UPDATE blogs SET status='Approved' WHERE blog_id=$id");
    echo "<script>alert('Blog approved');location='admin.php';</script>";
    exit();
}

if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM blogs WHERE blog_id=$id");
    echo "<script>alert('Blog deleted');location='admin.php';</script>";
    exit();
}

/* =================== SEARCH =================== */

$search = '';
$where  = '';
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where = "AND (
        b.blog_id LIKE '%$search%' OR
        b.title LIKE '%$search%' OR
        l.username LIKE '%$search%'
    )";
}

/* =================== PAGINATION =================== */

$limit = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$totalQ = mysqli_query($conn, "
    SELECT COUNT(*) total
    FROM blogs b
    JOIN login l ON b.user_id=l.id
    WHERE 1 $where
");
$total = mysqli_fetch_assoc($totalQ)['total'];
$pages = ceil($total / $limit);

/* =================== FETCH BLOGS =================== */
$blogs = mysqli_query($conn, "
    SELECT b.*, l.username
    FROM blogs b
    JOIN login l ON b.user_id=l.id
    WHERE 1 $where
    ORDER BY 
        CASE 
            WHEN b.status='Pending' THEN 1
            WHEN b.status='Rejected' THEN 2
            ELSE 3
        END
    LIMIT $limit OFFSET $offset
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include "loader.php"; ?>

<header>
        <div class="header-left">
            <h2>Admin Dashboard</h2>
            <nav class="admin_nav">
                <a href="admin.php">Blogs Data</a>
                <a href="user_details_form.php">User Login</a>
                <a href="user_details_form.php#messages">Message</a>
            </nav>
        </div>

        <form action="logout.php" method="post">
            <button type="button" class="logout" onclick="openProfile()">Profile</button>
            <button class="logout">Logout</button>
        </form>

</header>


<div class="container">

    <!-- =================== SEARCH BAR =================== -->
            <form method="get">
            <input type="text" name="search" class="search-bar" placeholder="Search by ID, Title, Author" value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="approve">Search</button>
            </form>

        <!-- =================== BLOGS TABLE =================== -->
            <table>
                        <tr>
                        <th>S.No</th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>Actions</th>
                        </tr>

                        <?php while($b = mysqli_fetch_assoc($blogs)){ ?>
                        <tr>
                        <td class="sn"></td>
                        <td><?= $b['blog_id'] ?></td>
                        <td><?= htmlspecialchars($b['title']) ?></td>
                        <td><?= htmlspecialchars($b['username']) ?></td>
                        <td class="<?= strtolower($b['status']) ?>"><?= $b['status'] ?></td>
                        <td><button class="view" onclick="openModal(<?= $b['blog_id'] ?>)">View</button></td>
                        <td>
                        <div class="action-btns">
                        <?php if($b['status']=='Approved'){ ?>
                        <a href="?delete_id=<?= $b['blog_id'] ?>"><button class="delete">Delete</button></a>
                        <?php } elseif($b['status']=='Rejected'){ ?>
                        <button class="reject" onclick="openRemark(<?= $b['blog_id'] ?>)">Remark</button>
                        <?php } else { ?>
                        <a href="?approve_id=<?= $b['blog_id'] ?>"><button class="approve">Approve</button></a>
                      <button class="reject" onclick="openRemark(<?= $b['blog_id'] ?>)">Reject</button>

                        <?php } ?>
                        </div>
                        </td>
                        </tr>

                <!-- VIEW MODAL -->
                    <div class="modal" id="m<?= $b['blog_id'] ?>">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal(<?= $b['blog_id'] ?>)">×</span>
                            <h2><?= htmlspecialchars($b['title']) ?></h2>
                            <?php if(!empty($b['image'])){ ?>
            <img src="uploads/<?= htmlspecialchars($b['image']) ?>" alt="Blog Image" style="width:100%; max-height:400px; object-fit:cover; margin-bottom:15px;">
        <?php } ?>
                            <p><?= nl2br(htmlspecialchars($b['description'])) ?></p>
                        </div>
                    </div>

                <!-- REMARK MODAL -->
                    <div class="modal" id="r<?= $b['blog_id'] ?>">
                        <div class="modal-content">
                            <span class="close" onclick="closeRemark(<?= $b['blog_id'] ?>)">×</span>
                            <form method="post">
                            <input type="hidden" name="blog_id" value="<?= $b['blog_id'] ?>">
                            <textarea name="remark" rows="5" style="width:100%;padding:12px" required></textarea><br><br>
                            <button type="submit" name="save_remark" class="approve">Save Remark</button>
                            </form>
                        </div>
                    </div>
                        <?php } ?>
            </table>

            <div class="pagination">
                <?php for($i=1;$i<=$pages;$i++){ ?>
                <a class="<?= ($i==$page)?'active':'' ?>" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                <?php } ?>
            </div>

        </div>

       
        

        <!-- =================== PROFILE MODAL =================== -->
        <div class="modal" id="profileModal">
        <div class="modal-content" style="max-width:400px">
        <span class="close" onclick="closeProfile()">×</span>

        <!-- VIEW PROFILE -->
        <div id="profileView">
        <p><strong>Username:</strong> <span id="viewUsername"><?= isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : '' ?></span></p>
        <!-- <p><strong>Email:</strong> <span id="viewEmail"><?= isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email']) : '' ?></span></p>
        <p><strong>Phone:</strong> <span id="viewMobile"><?= isset($_SESSION['admin_mobile']) ? htmlspecialchars($_SESSION['admin_mobile']) : '' ?></span></p> -->
        <button type="button" class="approve" onclick="showEditProfile()">Update Profile</button>
        <button type="button" class="reject" onclick="closeProfile()">Close</button>
        </div>

        <!-- EDIT PROFILE -->
        <div id="profileEdit" style="display:none">
        <form method="post">
        <input type="text" name="username" value="<?= isset($_SESSION['admin_username']) ? htmlspecialchars($_SESSION['admin_username']) : '' ?>" required style="width:100%;padding:10px;margin:6px 0">
        <input type="email" name="email" placeholder="email" value="<?= isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email']) : '' ?>" required style="width:100%;padding:10px;margin:6px 0">
        <input type="text" name="mobile" placeholder="mobile" value="<?= isset($_SESSION['admin_mobile']) ? htmlspecialchars($_SESSION['admin_mobile']) : '' ?>" required style="width:100%;padding:10px;margin:6px 0">
        <input type="password" name="password" placeholder="New Password (leave blank if no change)" style="width:100%;padding:10px;margin:6px 0">
        <button type="submit" name="update_profile" class="approve">Modify</button>
        <button type="button" class="reject" onclick="cancelEditProfile()">Cancel</button>
        </form>
        </div>

</div>

<script>
//  <!-- =================== DYNAMIC SERIAL NUMBERS =================== -->
const start = <?= $offset + 1 ?>;
        document.querySelectorAll(".sn").forEach((el, i) => {
            el.innerText = start + i;
        });
        function openModal(id){document.getElementById('m'+id).style.display='block'}
        function closeModal(id){document.getElementById('m'+id).style.display='none'}
        function openRemark(id){document.getElementById('r'+id).style.display='block'}
        function closeRemark(id){document.getElementById('r'+id).style.display='none'}

        
function openProfile(){document.getElementById('profileModal').style.display='block'}
function closeProfile(){document.getElementById('profileModal').style.display='none'}
function showEditProfile(){
    document.getElementById('profileView').style.display='none';
    document.getElementById('profileEdit').style.display='block';
}
function cancelEditProfile(){
    document.getElementById('profileEdit').style.display='none';
    document.getElementById('profileView').style.display='block';
}

</script>


</body>
</html>
