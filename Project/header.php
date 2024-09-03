<?php
// Start the session if it hasn't been started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Function to extract initials
function getInitials($name) {
    $initials = '';
    foreach (explode(' ', $name) as $word) {
        $initials .= strtoupper($word[0]);
    }
    return $initials;
}
?>

<div class="header">
    <a href="homepage.php" class="logo-container">
        <img src="Logo.jpg" alt="Logo" class="logo">
    </a>
    <div class="title-container">
        <div class="title">Studitute Portal</div>
        <p class="subtitle">Empowering your Educational Journey</p>
    </div>
    <div class="profile">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-info">
                <span class="user-initials"><?php echo getInitials($_SESSION['user_name']); ?></span><br>
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <div class="dropdown-button">&#9662;</div>
                <div class="dropdown-content">
                    <a href="userprofile.php">Profile</a>
                    <a href="logout.php">Log Out</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php">
                <img class="guest" src="Guest.jpg" alt="Guest Profile Picture"><br>
                <h3>Log In</h3>
            </a>
        <?php endif; ?>
    </div>
</div>

<nav>
    <ul class="nav-list">
        <li class="nav-item"><a href="searchpage.php">Search</a></li>
        <li class="nav-item"><a href="crosscredit.php">Cross Credit</a></li>
        <li class="nav-item"><a href="fav.php">Favourites</a></li>
        <li class="nav-item"><a href="contactus.php">Contact Us</a></li>
    </ul>
</nav>

<style>
.user-info {
    position: relative;
    display: inline-block;
    cursor: pointer;
    align-items: center;
    line-height: 40px;
}

.user-initials {
    width: 40px;
    height: 40px;
    background-color: #777;
    color: white;
    text-align: center;
    line-height: 40px;
    border-radius: 50%;
    border: 2px solid #666;
    display: inline-block;
    margin-right: 5px;
}

.user-name {
    margin-right: 10px;
    vertical-align: middle;
}

.dropdown-button {
    display: inline-block;
    cursor: pointer;
    color: white;
    font-size: 20px;
    vertical-align: middle;
}

.user-info .dropdown-content {
    display: none;
    position: absolute;
    right: 0; /* Adjusted for better alignment */
    background-color: #9AC1F9;
    border: 1px solid #727272;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.user-info .dropdown-content a {
    color: black;
    padding: 12px 16px;
    border:0.5px solid #727272;
    text-decoration: none;
    display: block;
}

.user-info .dropdown-content a:hover {background-color: #535357;
color: white;}

.dropdown-button:hover + .dropdown-content, .dropdown-content:hover {
    display: block;
}


</style>
