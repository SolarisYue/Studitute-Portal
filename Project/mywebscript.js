document.addEventListener('DOMContentLoaded', function() {
    // Event listener for the homepage image slider
    const images = document.querySelectorAll('.homecontent-image');
    let currentIndex = 0;

    function showNextImage() {
        images[currentIndex].classList.remove('active'); // Hide current image
        currentIndex = (currentIndex + 1) % images.length; // Move to next index
        images[currentIndex].classList.add('active'); // Show next image
    }

    // Initialize with the first image visible
    images[currentIndex].classList.add('active');

    // Set up the interval to change images every 3.5 seconds
    setInterval(showNextImage, 3500);
});

// Function to simulate saving profile changes
function saveChanges() {
    alert("Changes saved successfully!");
}

// Function to simulate contacting the portal (e.g., for a contact form submission)
function contactUs() {
    alert("Your message has been received!");
}

// Function to simulate a successful logout
function logoutSuccess() {
    alert("Logout Successful!");
}

// Function to toggle password visibility in the form
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

// Function to check if new passwords match in the change password form
function checkPasswordMatch() {
    const password = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("ConfirmPassword").value;
    const messageElement = document.getElementById("password-match-message");

    if (password === confirmPassword) {
        messageElement.style.color = "green";
        messageElement.textContent = "Password match";
        return true; // Allow form submission
    } else {
        messageElement.style.color = "red";
        messageElement.textContent = "Passwords do not match";
        return false; // Prevent form submission
    }
}
