<?php
include "Rconfig.php";

/* PAGINATION */
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

/* SEARCH LOGIC */
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$searchQuery = $search ? " AND (b.title LIKE '%$search%' OR u.username LIKE '%$search%')" : '';

/* BLOG DATA */
$blogs = mysqli_query($conn,"
    SELECT b.*, u.username 
    FROM blogs b 
    JOIN login u ON b.user_id = u.id
    WHERE b.status='Approved' $searchQuery
    ORDER BY b.created_at DESC
    LIMIT $limit OFFSET $offset
");

/* TOTAL */
$totalRes = mysqli_query($conn,"
    SELECT COUNT(*) total 
    FROM blogs b 
    JOIN login u ON b.user_id = u.id
    WHERE b.status='Approved' $searchQuery
");
$totalRow = mysqli_fetch_assoc($totalRes);
$totalPages = ceil($totalRow['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Daily Blogs</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="css/blog.css">
</head>

<body>
<?php include "loader.php"; ?>

<div class="header-wrapper">
<header>
    <div class="logo">DailyBlogs</div>

    <!-- CENTER SEARCH -->
    <div class="search-box header-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="search" placeholder="Search...">
    </div>

    <!-- TOGGLE BUTTON (VISIBLE ON MOBILE) -->
    <div class="menu-btn" id="menuBtn">&#9776;</div>

    <!-- NAVIGATION (DROPDOWN) -->
    <div class="nav" id="mobileNav">



        <a href="index.php">Home</a>
        <a href="index.php#About">About</a>
        <a href="index.php#contact">Contact</a>

                <!-- LOGIN FIRST -->
        <div class="login-wrapper">
            <button class="login-btn" onclick="toggleLogin()">Login ▾</button>
            <div class="dropdown" id="loginMenu">
                <a href="login.php">User Login</a>
                <a href="adminlogin.php">Admin Login</a>
            </div>
        </div>

    </div>
</header>

</div>

<div class="main_container1">
    <div class="main-wrapper">
        <div class="container" id="blogContainer">

            <?php while($row=mysqli_fetch_assoc($blogs)){ ?>
                <div class="blog-card"
                        data-title="<?= strtolower($row['title']) ?>"
                        data-user="<?= strtolower($row['username']) ?>"
                        data-fulltitle="<?= htmlspecialchars($row['title']) ?>"
                        data-image="<?= htmlspecialchars($row['image']) ?>"
                        data-desc="<?= nl2br(htmlspecialchars($row['description'])) ?>"
                        data-author="<?= htmlspecialchars($row['username']) ?>"
                        data-time="<?= date("M d, Y h:i A",strtotime($row['created_at'])) ?>">

                        <div class="blog-title"><?= htmlspecialchars($row['title']) ?></div>
                            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="blog-image">
                        <div class="blog-description"><?= htmlspecialchars($row['description']) ?></div>

                        <span class="read-more">Read more →</span>

                        <div class="blog-meta">
                            By <?= htmlspecialchars($row['username']) ?> | <?= date("M d, Y",strtotime($row['created_at'])) ?>
                        </div>
                </div>
                <?php } ?>

    </div>


            <!-- PAGINATION -->
            <div class="pagination">
                    <?php if($page>1){ ?>
                        <a href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">« Prev</a>
                    <?php } ?>

                    <?php for($i=1;$i<=$totalPages;$i++){ ?>
                        <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= ($i==$page)?'active':'' ?>"><?= $i ?></a>
                    <?php } ?>

                    <?php if($page<$totalPages){ ?>
                        <a href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next »</a>
                    <?php } ?>
            </div>

            </div>

            <!-- MODAL -->
            <div class="modal" id="blogModal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">×</span>
                    <h2 id="mTitle"></h2>
                    <img id="mImage">
                    <div id="mDesc"></div>
                    <div class="blog-meta" id="mMeta"></div>
                </div>
            </div>
</div>

<!-- FOOTER -->
<footer>
    © 2026 Daily Blogs — Crafted with simplicity ✨
</footer>
<script>

function toggleMenu(){
    document.getElementById("mobileNav").classList.toggle("active");
}


/* READ MORE MODAL */
document.querySelectorAll(".read-more").forEach(btn=>{
    btn.onclick=()=>{
        const c=btn.closest(".blog-card");
        mTitle.innerText=c.dataset.fulltitle;
        mImage.src="uploads/"+c.dataset.image;
        mDesc.innerHTML=c.dataset.desc;
        mMeta.innerText="By "+c.dataset.author+" | "+c.dataset.time;
        blogModal.style.display="flex";
        blogModal.scrollIntoView({behavior:"smooth"});
    }
});
function closeModal(){blogModal.style.display="none";}

/* SEARCH: TITLE + AUTHOR */
document.getElementById("search").addEventListener("keyup",function(){
    const value=this.value.toLowerCase();
    document.querySelectorAll(".blog-card").forEach(card=>{
        const title = card.dataset.title;
        const author = card.dataset.user;
        card.style.display = (title.includes(value) || author.includes(value)) ? "flex" : "none";
    });
});
</script>

</body>
<script>
const menuBtn = document.getElementById("menuBtn");
const mobileNav = document.getElementById("mobileNav");

menuBtn.addEventListener("click", () => {
    mobileNav.classList.toggle("active");
});

// 

/* LOGIN DROPDOWN */
function toggleLogin(){
    const menu = document.getElementById("loginMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

/* CLOSE DROPDOWNS ON OUTSIDE CLICK */
window.addEventListener("click", e => {
    if (!e.target.closest(".login-wrapper")) {
        document.getElementById("loginMenu").style.display = "none";
    }
});
</script>

</html>
