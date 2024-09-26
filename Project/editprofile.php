<?php
session_start();
include 'database.php'; // Ensure this file contains your PDO database connection setup

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect if not logged in
    exit();
}

$message = '';

// Handle form submission for profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update data
    $name = $_POST['Name'];
    $email = $_POST['EmailAddress'];
    $mobile = $_POST['Mobilenumber'];
    $info = $_POST['detailinformation'];

    $updateStmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ?, mobile_number = ?, profile_information = ? WHERE user_id = ?");
    if ($updateStmt->execute([$name, $email, $mobile, $info, $_SESSION['user_id']])) {
        $message = "Profile updated successfully.";
    } else {
        $message = "Failed to update profile.";
    }
}

// Fetch updated data from database regardless of POST or GET
$stmt = $pdo->prepare("SELECT full_name, email, mobile_number, profile_information FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    // Additional error handling if no user is found
    $message = "No user data found.";
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
    <title>Edit Profile - Studitute Portal</title>
</head>
<body>

    <?php include 'header.php'; ?>

   
    <div class="edit-profile-container">
        <div class="edit-profile-card">
            <h2>Edit Profile</h2>
            <?php if (!empty($message)): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form id="editprofile" action="editprofile.php" method="POST">
                <div class="form-group">
                    <label for="Name">Full Name:</label>
                    <input type="text" id="Name" name="Name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="EmailAddress">Email Address:</label>
                    <input type="email" id="EmailAddress" name="EmailAddress" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="Mobilenumber">Mobile Number:</label>
                    <input type="text" id="Mobilenumber" name="Mobilenumber" value="<?php echo htmlspecialchars($user['mobile_number']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="detailinformation">Short Information:</label>
                    <textarea id="detailinformation" name="detailinformation"><?php echo htmlspecialchars($user[ 'profile_information']); ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Save Changes</button>
                </div>
                <div class="form-group">
                    <a href="changepass.php"><button type="button">Change Password</button></a>
                </div>
            </form>
            <p><a href="userprofile.php" style="color: black; text-decoration:underline;">Back to <strong>User Profile</strong></a></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>
