<?php
session_start(); // Start the session
include 'database.php'; // Ensure this file contains your database connection setup

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = ''; // To store messages to display to the user

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword']; // Corrected the array key to match form field name

    // First, check if the old password is correct
    $stmt = $pdo->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    if ($user && password_verify($oldPassword, $user['password'])) {
        // Check if new password and confirm password match
        if ($newPassword === $confirmPassword) {
            // Update the password in the database
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            if ($updateStmt->execute([$newHash, $_SESSION['user_id']])) {
                $message = "Your password has been successfully updated.";
            } else {
                $message = "Failed to update the password.";
            }
        } else {
            $message = "The new passwords do not match.";
        }
    } else {
        $message = "The old password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="design.css">
<script src="mywebscript.js"></script>
<link rel="icon" type="image/png" href="Favicon.png">
<title>Change Password - Studitute Portal</title>
</head>
<body>

<?php include 'header.php'; // Include the header ?>

<div class="content">
    <div class="form-container" style="text-align: center;">
        <?php if (!empty($message)): ?>
            <p style="color: red;"><?php echo $message; ?></p>
        <?php endif; ?>
        <form id="changepassword" action="changepass.php" method="POST">
            <div class="form-group" id="old-password-group">
                <label for="oldPassword">
                    Old Password <span style="color: red;">*</span>
                </label>
                <div class="password-container">
                    <input type="password" id="oldPassword" name="oldPassword" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('oldPassword', this)">
                        <img src="ceye-icon.png" alt="Show Password">
                    </span>
                </div>
            </div>
            <br>

            <div class="form-group" id="password-group">
                <label for="newPassword">
                   New Password <span style="color: red;">*</span>
                </label>
                <div class="password-container">
                    <input type="password" id="newPassword" name="newPassword" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('newPassword', this)">
                        <img src="ceye-icon.png" alt="Show Password">
                    </span>
                </div>
            </div>
            <div class="form-group" id="confirm-password-group">
                <label for="confirmPassword">
                   Confirm Password <span style="color: red;">*</span>
                </label>
                <div class="password-container">
                    <input type="password" id="ConfirmPassword" name="confirmPassword" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('confirmPassword', this)">
                        <img src="ceye-icon.png" alt="Show Password">
                    </span>
                </div>
                <p id="password-match-message" style="color: red;"></p>
            </div>
            <br>

            <button type="submit">Change Password</button>
        </form>
        <p><a href="editprofile.php" style="color: black; text-decoration:underline;">Back to Edit Profile</a></p>
    </div>
</div>

<?php include 'footer.php'; // Include the footer ?>

</body>
</html>
