<footer class="main-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Connect With Us</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>

        <div class="footer-section">
            <h3>Contact Info</h3>
            <p><i class="fas fa-phone"></i> +968 92062824</p>
            <p><i class="fas fa-envelope"></i> EATPES@email.com</p>
            <p><i class="fas fa-map-marker-alt"></i> 123 Street, Muscat, Oman</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> EATPES. All rights reserved.</p>
    </div>
</footer>

<style>
    .main-footer {
        background-color: #333;
        color: #fff;
        padding: 40px 0 20px;
    }

    .footer-content {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-section {
        margin: 0 20px;
        min-width: 250px;
    }

    .footer-section h3 {
        color: #fff;
        margin-bottom: 20px;
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section ul li {
        margin-bottom: 10px;
    }

    .footer-section a {
        color: #fff;
        text-decoration: none;
    }

    .footer-section a:hover {
        color: #ddd;
    }

    .social-icons a {
        margin-right: 15px;
        font-size: 20px;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #555;
    }
</style>