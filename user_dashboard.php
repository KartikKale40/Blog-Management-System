<?php
session_start();
include "Rconfig.php";

/* ================= LOGIN CHECK ================= */
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id  = $_SESSION['id'];
$username = $_SESSION['username'];

/* ================= DELETE BLOG ================= */
if (isset($_GET['del_id'])) {
    $del_id = $_GET['del_id'];

    mysqli_query(
        $conn,
        "DELETE FROM blogs WHERE blog_id='$del_id' AND user_id='$user_id'"
    );

    echo "<script>
        alert('Blog Deleted Successfully');
        window.location.href='user_dashboard.php';
    </script>";
}

/* ================= FETCH SINGLE BLOG FOR EDIT ================= */
$editData = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $res = mysqli_query(
        $conn,
        "SELECT * FROM blogs WHERE blog_id='$edit_id' AND user_id='$user_id'"
    );
    $editData = mysqli_fetch_assoc($res);
}

/* ================= ADD BLOG ================= */
if (isset($_POST['btn_add'])) {
    $title       = $_POST['title'];
    $description = $_POST['description'];

    $image = "";
    if (!empty($_FILES['image']['name'])) {
        if (!is_dir("uploads")) {
            mkdir("uploads", 0777, true);
        }
        $image = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
    }

    mysqli_query($conn,
        "INSERT INTO blogs (user_id,title,description,image,status)
         VALUES ('$user_id','$title','$description','$image','Pending')"
    );

    echo "<script>
        alert('Blog Submitted');
        window.location.href='user_dashboard.php';
    </script>";
}

/* ================= UPDATE BLOG ================= */
if (isset($_POST['btn_update'])) {

    mysqli_query($conn,
        "UPDATE blogs SET 
            title='".mysqli_real_escape_string($conn,$_POST['title'])."',
            description='".mysqli_real_escape_string($conn,$_POST['description'])."',
            status='Pending'
         WHERE blog_id='".(int)$_POST['blog_id']."' 
         AND user_id='$user_id'"
    );

    echo "<script>
        alert('Blog updated and sent for admin approval again');
        window.location.href='user_dashboard.php';
    </script>";
}
/* ================= FETCH BLOGS ================= */
$data = mysqli_query(
    $conn,
    "SELECT * FROM blogs WHERE user_id='$user_id' ORDER BY blog_id DESC"
);
?>


<!-- **********************************HTML CODE ************************** -->
<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/user_dashboard.css">
</head>

<body>
<?php include "loader.php"; ?>

    <header>
        <h2>Welcome, <?php echo $username; ?></h2>
        
        <form action="logout.php" method="post">
            <button class="logout">Logout</button>
        </form>
    </header>

    <div class="container">

        <div class="form-card">
            <h3><?php echo $editData ? 'Update Blog' : 'Add Blog'; ?></h3>

            <form method="post" enctype="multipart/form-data" class="blog-form">
            <input type="hidden" name="blog_id" value="<?php echo $editData['blog_id'] ?? ''; ?>">

            <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required value="<?php echo $editData['title'] ?? ''; ?>">
        </div>

        <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="4" required><?php echo $editData['description'] ?? ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image">
            </div>

            <button name="<?php echo $editData ? 'btn_update' : 'btn_add'; ?>" class="add">
            <?php echo $editData ? 'Update' : 'Submit'; ?>
            </button>
            </form>
        </div>

        <div class="blog-header">
            <h3>Your Blogs</h3>

                <div class="search-box">
                    <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search by ID or Title">
                </div>
        </div>

        <table id="blogTable">
            <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Remark</th>
            <th>Action</th>

            </tr>

            <?php while($row = mysqli_fetch_assoc($data)) { ?>
            <tr>
            <td><?php echo $row['blog_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo substr($row['description'],0,80); ?>...</td>
            <td><?php if($row['image']){ ?><img src="uploads/<?php echo $row['image']; ?>"><?php } ?></td>
            <td>
                <?php if($row['status']=='Approved'){ ?>
                    <span style="color:green;font-weight:600;">Approved</span>
                <?php } elseif($row['status']=='Pending'){ ?>
                    <span style="color:orange;font-weight:600;">Pending Approval</span>
                <?php } else { ?>
                    <span style="color:red;font-weight:600;">Rejected</span>
                <?php } ?>

                <td>
                <?php if($row['status']=='Rejected'){ ?>
                    <span style="color:#ef4444;">
                        <?= htmlspecialchars($row['remark'] ?: '—') ?>
                    </span>
                <?php } else { ?>
                    —
                <?php } ?>
                </td>

            </td>

            <td>
            <a href="?edit_id=<?php echo $row['blog_id']; ?>"><button class="update">Update</button></a>
            <a href="?del_id=<?php echo $row['blog_id']; ?>" onclick="return confirm('Are you sure?')">
            <button class="delete">Delete</button></a>
            </td>
            </tr>
            <?php } ?>

        </table>
    </div>


    <!--******************************** JS********************** -->
<script>
        document.getElementById("searchInput").addEventListener("keyup", function(){
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll("#blogTable tr");

            rows.forEach((row, index) => {
                if(index === 0) return;
                let id = row.cells[0].innerText.toLowerCase();
                let title = row.cells[1].innerText.toLowerCase();
                row.style.display = (id.includes(value) || title.includes(value)) ? "" : "none";
            });
        });
</script>

</body>
</html>
