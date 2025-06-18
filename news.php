<?php
include 'include/db_config.php';
$currentPage = 'news';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - EAT-PES</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/news.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .full-content { display: none; }
        .read-more-btn {
            cursor: pointer;
            color: #3A6CF4;
            background: none;
            border: none;
            font-weight: bold;
            padding: 0;
        }
    </style>
</head>

<body>
    
    <?php include 'include/navbar.php'; ?>

    <main class="main-section">
        <div class="container">

            
            <div style="text-align: right; margin-bottom: 20px;">
                <a href="addNews.php" class="btn" style="background-color: #3A6CF4; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                    <i class="fas fa-plus-circle"></i> Add News
                </a>
            </div>

            <h1 class="page-title">Latest News</h1>

            <section class="news-slider">
                <button class="slider-btn prev-btn" aria-label="Previous slide">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="news-container">
                    <?php
                    $stmt = $pdo->query("SELECT * FROM news ORDER BY created_at DESC");
                    $news = $stmt->fetchAll();
                    if (count($news) > 0) {
                        $latest = $news[0];
                        echo '
                        <div class="news-item">
                            <div class="news-image">
                                <img src="images/' . htmlspecialchars($latest["image"]) . '" alt="Latest News">
                                <div class="news-date">
                                    <span class="date">' . date("d", strtotime($latest["created_at"])) . '</span>
                                    <span class="month">' . strtoupper(date("M", strtotime($latest["created_at"]))) . '</span>
                                </div>
                            </div>
                            <div class="news-content">
                                <h3>' . htmlspecialchars($latest["title"]) . '</h3>
                                <p class="short-content">' . substr(htmlspecialchars($latest["content"]), 0, 100) . '...</p>
                                <p class="full-content">' . nl2br(htmlspecialchars($latest["content"])) . '</p>
                                <button class="read-more-btn" onclick="toggleContent(this)">Read More</button>
                            </div>
                        </div>';
                    }
                    ?>
                </div>

                <button class="slider-btn next-btn" aria-label="Next slide">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </section>

            <section class="news-grid">
                <h2 class="section-title">All News</h2>
                <div class="grid-container">
                    <?php
                    for ($i = 1; $i < count($news); $i++) {
                        $row = $news[$i];
                        echo '
                        <div class="news-item">
                            <div class="news-image">
                                <img src="images/' . htmlspecialchars($row["image"]) . '" alt="News Image">
                                <div class="news-date">
                                    <span class="date">' . date("d", strtotime($row["created_at"])) . '</span>
                                    <span class="month">' . strtoupper(date("M", strtotime($row["created_at"]))) . '</span>
                                </div>
                            </div>
                            <div class="news-content">
                                <h3>' . htmlspecialchars($row["title"]) . '</h3>
                                <p class="short-content">' . substr(htmlspecialchars($row["content"]), 0, 100) . '...</p>
                                <p class="full-content">' . nl2br(htmlspecialchars($row["content"])) . '</p>
                                <button class="read-more-btn" onclick="toggleContent(this)">Read More</button>
                            </div>
                        </div>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>

    <script>
        function toggleContent(button) {
            const shortContent = button.parentElement.querySelector(".short-content");
            const fullContent = button.parentElement.querySelector(".full-content");

            if (fullContent.style.display === "none" || fullContent.style.display === "") {
                fullContent.style.display = "block";
                shortContent.style.display = "none";
                button.textContent = "Show Less";
            } else {
                fullContent.style.display = "none";
                shortContent.style.display = "block";
                button.textContent = "Read More";
            }
        }
    </script>
</body>

</html>

