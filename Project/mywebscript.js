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

document.addEventListener('DOMContentLoaded', function() {
    // Select all images with the class 'fav-image'
    const favImages = document.querySelectorAll('.fav-image');

    // Loop through each image and add a click event listener
    favImages.forEach(function(img) {
        img.addEventListener('click', function() {
            // Check if the current image is 'unfavorite' (FavD.png)
            if (img.getAttribute('src') === 'FavD.png') {
                // Change the image source to 'favorite' (FavC.png)
                img.setAttribute('src', 'FavC.png');
                img.setAttribute('alt', 'Favorites');
            } else {
                // Change the image source back to 'unfavorite' (FavD.png)
                img.setAttribute('src', 'FavD.png');
                img.setAttribute('alt', 'Unfavorite');
            }
        });
    });
});

function saveChanges() {
    // Simulate saving changes (e.g., form submission, AJAX call, etc.)
    alert("Changes saved successfully!");

}
function contactUs() {
    // Simulate contacting us (e.g., form submission, AJAX call, etc.)
    alert("Your message has been recieved!");

}

function logoutSuccess() {
    // Simulate contacting us (e.g., form submission, AJAX call, etc.)
    alert("Logout Successful!");

}

function togglePasswordVisibility(fieldId, iconElement) {
    var passwordField = document.getElementById(fieldId);
    var icon = iconElement.querySelector("img");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.src = "oeye-icon.png"; // Swap to eye-slash icon
        icon.alt = "Hide Password";
    } else {
        passwordField.type = "password";
        icon.src = "ceye-icon.png"; // Swap back to eye icon
        icon.alt = "Show Password";
    }
}




