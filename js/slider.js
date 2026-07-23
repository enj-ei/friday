document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".slide");
    let currentSlide = 0;

    function nextSlide() {
        if (slides.length <= 1) return;

        // Hide current
        slides[currentSlide].classList.remove("active");

        // Move to next slide
        currentSlide = (currentSlide + 1) % slides.length;

        // Show next
        slides[currentSlide].classList.add("active");
    }

    // Change slide every 4 seconds
    if (slides.length > 0) {
        setInterval(nextSlide, 4000);
    }
});