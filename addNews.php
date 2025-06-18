<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$conn = mysqli_connect("127.0.0.1", "root", "", "eatpe");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


if (!file_exists('images')) {
    mkdir('images', 0777, true);
}


if (isset($_POST['add_news'])) {
   $title = mysqli_real_escape_string($conn, $_POST['title']);
$desc = mysqli_real_escape_string($conn, $_POST['content']);

    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = "images/" . $imageName;

    if (!empty($imageName)) {
        if (move_uploaded_file($imageTmp, $imagePath)) {
            $sql = "INSERT INTO news (title, content, image) VALUES ('$title', '$desc', '$imageName')";
            if (mysqli_query($conn, $sql)) {
                header("Location: news.php");
                exit();
            } else {
                die("Insert Error: " . mysqli_error($conn));
            }
        } else {
            die("❌ Failed to move uploaded file.");
        }
    } else {
        die("❌ No image uploaded.");
    }
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM news WHERE id = $id";
    mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add News - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php
$currentPage = 'news';
include 'include/navbar.php';
?>

<main class="main-section">
    <div class="container">
        <section class="contact-hero">
            <h1 class="page-title">Add News</h1>
            <p class="hero-text">Submit a new announcement or update to display on the homepage.</p>
        </section>

        <section class="contact-section">
            <div class="contact-container">
                <div class="contact-form-box">
                    <h2>News Details</h2>
                    <form class="contact-form" method="POST" enctype="multipart/form-data">
                        <div class="input-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" required>
                        </div>
                        <div class="input-group">
                            <label for="content">Description</label>
                            <textarea id="content" name="content" rows="5" required></textarea>
                        </div>
                        <div class="input-group">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" accept="image/*" required>
                        </div>
                        <button type="submit" name="add_news" class="submit-btn">
                            <i class="fas fa-plus-circle"></i> Submit
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
