<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// الاتصال بقاعدة البيانات
$conn = mysqli_connect("127.0.0.1", "root", "", "eatpe");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);

    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        $successMessage = "✅ Send Successful!";
    } else {
        $successMessage = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php
$currentPage = 'contact';
include 'include/navbar.php';
?>

<main class="main-section">
    <div class="container">
        <section class="contact-hero">
            <h1 class="page-title">Contact Us</h1>
            <p class="hero-text">Get in touch with our team for any inquiries or support</p>
        </section>

        <section class="contact-section">
            <div class="contact-container">
                <div class="contact-info-box">
                    <h2>Contact Information</h2>
                    <div class="info-items">
                        <div class="contact-info">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info-content">
                                <h3>Address</h3>
                                <p>Muscat, Oman</p>
                            </div>
                        </div>
                        <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <div class="info-content">
                                <h3>Phone</h3>
                                <p>+968 1234 5678</p>
                            </div>
                        </div>
                        <div class="contact-info">
                            <i class="fas fa-envelope"></i>
                            <div class="info-content">
                                <h3>Email</h3>
                                <p>support@eatpes.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="contact-form-box">
                    <h2>Send us a Message</h2>
                    <?php if ($successMessage): ?>
                        <div style="color: green; font-weight: bold; margin-bottom: 10px;">
                            <?php echo $successMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form class="contact-form" method="POST">
                        <div class="input-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="input-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="input-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</main>

<?php include 'include/footer.php'; ?>
</body>
</html>
<?php mysqli_close($conn); ?>
