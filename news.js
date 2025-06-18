document.addEventListener("DOMContentLoaded", function () {
  const newsContainer = document.querySelector(".news-container");
  const newsItems = document.querySelectorAll(".news-item");
  const prevBtn = document.querySelector(".prev-btn");
  const nextBtn = document.querySelector(".next-btn");

  let index = 0;
  const totalItems = newsItems.length;
  let autoSlideInterval;

  function showNews(n) {
    if (n >= totalItems) {
      index = 0;
    } else if (n < 0) {
      index = totalItems - 1;
    } else {
      index = n;
    }

    newsContainer.style.transform = `translateX(${-index * 100}%)`;
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      showNews(index + 1);
    }, 5000);
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  // Event Listeners
  nextBtn.addEventListener("click", () => {
    showNews(index + 1);
    stopAutoSlide();
    startAutoSlide();
  });

  prevBtn.addEventListener("click", () => {
    showNews(index - 1);
    stopAutoSlide();
    startAutoSlide();
  });

  // Touch Events for mobile
  let touchStartX = 0;
  let touchEndX = 0;

  newsContainer.addEventListener("touchstart", (e) => {
    touchStartX = e.changedTouches[0].screenX;
    stopAutoSlide();
  });

  newsContainer.addEventListener("touchend", (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
    startAutoSlide();
  });

  function handleSwipe() {
    const swipeThreshold = 50;
    const difference = touchStartX - touchEndX;

    if (Math.abs(difference) > swipeThreshold) {
      if (difference > 0) {
        showNews(index + 1);
      } else {
        showNews(index - 1);
      }
    }
  }

  // Start auto slide
  startAutoSlide();
});
