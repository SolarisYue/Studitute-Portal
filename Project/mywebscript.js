document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.homecontent-image');
    let currentIndex = 0;

    function showNextImage() {
        images[currentIndex].classList.remove('active'); // Hide current image
        currentIndex = (currentIndex + 1) % images.length; // Move to next index
        images[currentIndex].classList.add('active'); // Show next image
    }

    // Initialize with the first image visible
    images[currentIndex].classList.add('active');

    // Set up the interval to change images every 200ms
    setInterval(showNextImage, 3000);
});
