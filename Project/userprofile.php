<?php
session_start();
include 'database.php'; // Ensure this file contains your PDO database connection setup

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from the database
$stmt = $pdo->prepare("SELECT full_name, email, mobile_number, profile_information FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Redirect if no user found (optional)
if (!$user) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <link rel="icon" type="image/png" href="Favicon.png">
    <script src="mywebscript.js"></script>
    <title>User Profile - Studitute Portal</title>
</head>
<body>

<?php include 'header.php'; // Include the header ?>


    <div class="profile-container">
        <div class="profile-card">
            <h2>User Profile</h2>
            <div class="profile-info">
                <label>Full Name:</label>
                <p><?php echo htmlspecialchars($user['full_name']); ?></p>
            </div>
            <div class="profile-info">
                <label>Email Address:</label>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="profile-info">
                <label>Mobile Number:</label>
                <p><?php echo htmlspecialchars($user['mobile_number']); ?></p>
            </div>
            <div class="profile-info">
                <label>Short Information:</label>
                <p><?php echo htmlspecialchars($user['profile_information']); ?></p>
            </div>
            <div class="edit-profile-link">
                <a href="editprofile.php">Edit Profile</a>
            </div>
            <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; Studitute Portal: Empowering your Educational Journey</p>
    </div>

</body>
</html>
