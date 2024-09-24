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
    $oldPassword = $_POST['Password'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['ConfirmPassword'];

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
        <form id="changepassword" action="changepassword.php" method="POST">
            <div class="form-group">
                <label for="Password">Old Password:</label>
                <input type="password" id="Password" name="Password" required>
            </div><br>

            <div class="form-group">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div><br>

            <div class="form-group">
                <label for="ConfirmPassword">Confirm Password:</label>
                <input type="password" id="ConfirmPassword" name="ConfirmPassword" required>
            </div><br>

            <button type="submit">Change Password</button>
        </form>
        <p><a href="editprofile.php" style="color: black; text-decoration:underline;">Back to Edit Profile</a></p>
    </div>
</div>

<?php include 'footer.php'; // Include the footer ?>

</body>
</html>
