<!DOCTYPE html>
<html lang="en">
<?php
include "include/base.php";
?>

<body>
    <?php
    $currentPage = "home";
    include "include/navbar.php";
    ?>

    <main class="main-section">
       
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Welcome to Your Website</h1>
                <p class="hero-text">Your compelling tagline goes here</p>
                <a href="login.php" class="btn">Get Started</a>
            </div>
        </section>

        
        <section class="cta-section">
            <div class="container">
                <h2>Ready to Get Started?</h2>
                <p>Join us today and experience the difference</p>
                <a href="register.php" class="cta-button">Sign Up Now</a>
            </div>
        </section>
    </main>

    <?php include "include/footer.php"; ?>
</body>
</html>
