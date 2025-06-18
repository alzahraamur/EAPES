<?php

$logoPath = (strpos($_SERVER['PHP_SELF'], 'admin/') !== false) ? '../images/Black_White_Bold_Modern_Studio_Logo-removebg-preview.png' : 'images/Black_White_Bold_Modern_Studio_Logo-removebg-preview.png';
?>

<header class="header">
    <a href="index.php" class="logo">
        <img src="<?= $logoPath ?>" alt="EAT-PES Logo" style="height:50px;">
    </a>

    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <nav class="navigation">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="index.php" <?= ($currentPage == 'home') ? 'class="active"' : ''; ?>>Home</a>
            <a href="news.php" <?= ($currentPage == 'news') ? 'class="active"' : ''; ?>>News</a>
            <a href="about.php" <?= ($currentPage == 'about') ? 'class="active"' : ''; ?>>About</a>
            <a href="contact.php" <?= ($currentPage == 'contact') ? 'class="active"' : ''; ?>>Contact Us</a>
            <a href="login.php" <?= ($currentPage == 'login') ? 'class="active"' : ''; ?>>Login</a>
            <a href="register.php" <?= ($currentPage == 'register') ? 'class="active"' : ''; ?>>Register</a>
        <?php endif; ?>
    </nav>
</header>

<style>
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.95);
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.logo img {
    height: 50px;
    width: auto;
}

.navigation {
    display: flex;
    gap: 2rem;
}

.navigation a {
    color: #333;
    text-decoration: none;
    font-weight: 500;
    font-size: 1.1rem;
    transition: color 0.3s ease;
    position: relative;
}

.navigation a:hover {
    color: #007bff;
}

.navigation a.active {
    color: #007bff;
}

.navigation a.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: #007bff;
}

.nav-toggle {
    display: none;
}

.nav-toggle-label {
    display: none;
    cursor: pointer;
}

.nav-toggle-label span {
    display: block;
    width: 25px;
    height: 2px;
    background-color: #333;
    margin: 5px 0;
    transition: 0.4s;
}

@media (max-width: 768px) {
    .nav-toggle-label {
        display: block;
    }

    .navigation {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        padding: 1rem;
        flex-direction: column;
        gap: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .nav-toggle:checked ~ .navigation {
        display: flex;
    }

    .nav-toggle:checked + .nav-toggle-label span:nth-child(1) {
        transform: rotate(-45deg) translate(-5px, 6px);
    }

    .nav-toggle:checked + .nav-toggle-label span:nth-child(2) {
        opacity: 0;
    }

    .nav-toggle:checked + .nav-toggle-label span:nth-child(3) {
        transform: rotate(45deg) translate(-5px, -6px);
    }
}
</style>
<?php
if (!isset($currentPage)) $currentPage = ''; 
$inAdmin = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$basePath = $inAdmin ? '../' : '';
?>

<header class="header">
    <a href="<?= $basePath ?>index.php" class="logo">
        <img src="<?= $basePath ?>images/Black_White_Bold_Modern_Studio_Logo-removebg-preview.png" alt="EAT-PES Logo">
    </a>

    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <label for="nav-toggle" class="nav-toggle-label">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <nav class="navigation">
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="<?= $basePath ?>index.php" <?= $currentPage == 'home' ? 'class="active"' : '' ?>>Home</a>
            <a href="<?= $basePath ?>news.php" <?= $currentPage == 'news' ? 'class="active"' : '' ?>>News</a>
            <a href="<?= $basePath ?>about.php" <?= $currentPage == 'about' ? 'class="active"' : '' ?>>About</a>
            <a href="<?= $basePath ?>contact.php" <?= $currentPage == 'contact' ? 'class="active"' : '' ?>>Contact Us</a>
            <a href="<?= $basePath ?>login.php" <?= $currentPage == 'login' ? 'class="active"' : '' ?>>Login</a>
            <a href="<?= $basePath ?>register.php" <?= $currentPage == 'register' ? 'class="active"' : '' ?>>Register</a>
        <?php else: ?>
            <a href="<?= $basePath ?>logout.php">Logout</a>
        <?php endif; ?>
    </nav>
</header>
