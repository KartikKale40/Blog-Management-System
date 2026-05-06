<?php
include "Rconfig.php";

/* Approved blogs */
$blogQuery = mysqli_query($conn,
    "SELECT COUNT(*) AS totalBlogs FROM blogs WHERE status='Approved'"
);
$blogData = mysqli_fetch_assoc($blogQuery);

/* Active writers (users who submitted at least one blog) */
$userQuery = mysqli_query($conn,
    "SELECT COUNT(DISTINCT user_id) AS totalUsers FROM blogs"
);
$userData = mysqli_fetch_assoc($userQuery);

/* Page visit counter */
mysqli_query($conn,"UPDATE page_visits SET visits = visits + 1 WHERE id=1");
$visitQuery = mysqli_query($conn,"SELECT visits FROM page_visits WHERE id=1");
$visitData = mysqli_fetch_assoc($visitQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daily Blogs</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/index.css">
</head>
<body>
<?php include "loader.php"; ?>

<header>
    <div class="logo">DailyBlogs</div>
    <nav id="navLinks">
        <a href="#home">Home</a>
        <a href="blog.php">Blogs</a>
        <a href="#About">About Us</a>
        <a href="#contact">Contact</a>
    </nav>

       

    <!-- Hamburger menu button -->
    <div class="menu-btn" id="menuBtn">&#9776;</div>

</header>

<!-- HERO SECTION -->
<section class="main_content">
    <div class="main_content_heading"id="home">✨ Read • Write • Inspire</div>

    <h1>
        A modern platform to share ideas,
        stories and daily inspiration
    </h1>

    <p>
        Discover thoughtful blogs written by passionate authors.
        Learn, grow, and express your voice — every single day.
    </p>

    <div class="main_content_buttons">
        <a href="blog.php" class="btn-primary">Explore Blogs</a>
        <a href="login.php" class="btn-secondary">Start Writing</a>
    </div>

    <!-- STATS -->
    <div class="stats">
        <div class="stat">
            <h2 class="counter" data-target="<?php echo $visitData['visits']; ?>">0</h2>
            <span>Total Visitors</span>
        </div>
        <div class="stat">
            <h2 class="counter" data-target="<?php echo $blogData['totalBlogs']; ?>">0</h2>
            <span>Published Blogs</span>
        </div>
        <div class="stat">
            <h2 class="counter" data-target="<?php echo $userData['totalUsers']; ?>">0</h2>
            <span>Active Writers</span>
        </div>
    </div>
</section>

<!-- ABOUT US -->
<section  class="about_container" id="About">
    <div class="about_title" >About Us</div>

    <p class="about_text">
        Daily Blogs is a modern and community-driven blogging platform designed
        to inspire creativity, share knowledge, and encourage meaningful conversations.
        Our goal is to provide a safe and engaging space where writers and readers come together
        to explore ideas, experiences, and stories from around the world.
    </p>

    <p class="about_text" style="margin-top:15px;">
         We believe that every individual has a unique perspective worth sharing.
        Whether you are a passionate writer, a beginner looking to express your thoughts,
        or a reader seeking inspiration, Daily Blogs empowers you to connect through words.
        From technology and education to lifestyle, health, and personal growth — our platform
        supports diverse topics that matter in everyday life.
    </p>

    <p class="about_text" style="margin-top:15px;">
        To maintain quality and trust, all submitted blogs go through an admin approval process
        before being published. This ensures that readers receive authentic, relevant,
        and well-structured content. Writers can track their blog submission status directly
        from their dashboard, creating transparency and confidence in the system.
    </p>

       <p class="about_text" style="margin-top:15px;">
        At Daily Blogs, we are committed to continuous improvement. We focus on simplicity,
        clean design, and user-friendly experiences so that you can concentrate on what truly
        matters — reading, writing, and sharing ideas. Together, we are building a growing
        knowledge community, one blog at a time.
    </p>
</section>


<!-- CONTACT FORM -->
<section id="contact" class="contact_container">
    <div class="contact_title">Contact Us</div>
    <form class="contact_form" method="POST" action="index.php#contact">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
        <button type="submit" name="submit">Send Message</button>
    </form>
</section>

<!-- FOOTER -->
<footer>
    © 2026 Daily Blogs — Crafted with simplicity ✨
</footer>

<!-- JS COUNTER -->
<script>
const counters = document.querySelectorAll('.counter');

counters.forEach(counter => {
    const target = +counter.getAttribute('data-target');
    let count = 0;

    const updateCounter = () => {
        const increment = target / 80; // speed
        if(count < target){
            count += increment;
            counter.innerText = Math.ceil(count);
            requestAnimationFrame(updateCounter);
        } else {
            counter.innerText = target;
        }
    };
    updateCounter();
});
</script>

</body>
<script>
// Toggle menu on small screens
const menuBtn = document.getElementById('menuBtn');
const navLinks = document.getElementById('navLinks');

menuBtn.addEventListener('click', () => {
    navLinks.classList.toggle('show');
});
</script>
</html>
<?php
include "Rconfig.php";

if(isset($_POST['submit'])){

    extract($_POST);

    $add = mysqli_query(
        $conn,
        "INSERT INTO contact (name,email,message)
         VALUES ('$name','$email','$message')"
    ) or die(mysqli_error($conn));

    if($add){
        echo "<script>
                alert('Data inserted successfully!');
                window.location.href = 'index.php';
              </script>";
    }else{
        echo "<script>
                alert('Data error!');
              </script>";
    }
}
?>
