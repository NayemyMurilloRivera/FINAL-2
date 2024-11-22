let currentIndex = 0;

function nextSlide() {
    const slides = document.querySelectorAll('.banner-slider img');
    if (currentIndex < slides.length - 1) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateSlider();
}

function prevSlide() {
    const slides = document.querySelectorAll('.banner-slider img');
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = slides.length - 1;
    }
    updateSlider();
}

function updateSlider() {
    const slider = document.getElementById('bannerSlider');
    const slideWidth = document.querySelector('.banner-slider img').clientWidth;
    slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
}