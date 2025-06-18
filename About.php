<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Employee Achievement Tracking System</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <?php
    $currentPage = 'about';
    include 'include/navbar.php';
    ?>

    <main class="main-section">
        <div class="container">
            <section class="about-hero">
                <h1 class="page-title">About Us</h1>
                <p class="hero-text">Empowering organizations through innovative performance tracking</p>
            </section>

            <section class="about-content">
                <div class="content-grid">
                    <div class="content-item">
                        <h2>Our Mission</h2>
                        <p>Our mission is to empower companies with the tools to evaluate employee contributions,
                            recognize achievements, and enhance productivity through data-driven decision-making.</p>
                    </div>

                    <div class="content-item">
                        <h2>About Our System</h2>
                        <p>The <strong>Employee Achievement Tracking and Performance Evaluation System</strong>
                            is designed to help organizations monitor, assess, and improve employee performance
                            efficiently.
                            Our system provides insightful analytics, goal tracking, and real-time progress monitoring.
                        </p>
                    </div>
                </div>

                <div class="features-section">
                    <h2>Why Choose Us?</h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <i class="fas fa-chart-line"></i>
                            <h3>Accurate Performance Insights</h3>
                            <p>Get detailed analytics and performance metrics</p>
                        </div>

                        <div class="feature-card">
                            <i class="fas fa-user-friendly"></i>
                            <h3>Easy-to-Use Interface</h3>
                            <p>Intuitive design for seamless user experience</p>
                        </div>

                        <div class="feature-card">
                            <i class="fas fa-shield-alt"></i>
                            <h3>Secure and Reliable</h3>
                            <p>Enterprise-grade security for your data</p>
                        </div>

                        <div class="feature-card">
                            <i class="fas fa-clock"></i>
                            <h3>Real-Time Progress Tracking</h3>
                            <p>Monitor achievements as they happen</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>
</body>

</html>