document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all favorite buttons
    document.querySelectorAll('.fav-btn').forEach(button => {
        button.addEventListener('click', function() {
            const institutionId = this.getAttribute('data-id');
            addToFavorites(institutionId, this.id);  // Pass button id for icon toggle
        });
    });
});


function addToFavorites(institutionId, buttonId) {
    // Make an AJAX request to add the item to favorites
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'addtofavorites.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle success - Change the button icon
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById(buttonId).innerHTML = '<img class="fav-image" src="FavC.png" alt="Added to Favorite">';
            } else {
                alert(response.message);
            }
        }
    };
    
    // Send the request with the institution ID
    xhr.send('institution_id=' + institutionId);
}
