<?php
session_start();
include 'database.php'; // This file should contain your database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['Name']);
    $email = htmlspecialchars($_POST['Email']);
    $mobile = htmlspecialchars($_POST['mobilenum']);
    $message = htmlspecialchars($_POST['Message']);

    // Prepare and bind
    $stmt = $pdo->prepare("INSERT INTO contact_us (name, email, mobile_number, message) VALUES (?, ?, ?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $mobile);
    $stmt->bindParam(4, $message);

    if ($stmt->execute()) {
        $success_message = "Thank you for contacting us, $name. We will get back to you shortly.";
    } else {
        $success_message = "There was a problem submitting your form. Please try again.";
    }
}

include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <script src="mywebscript.js"></script>
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Contact Us - Studitute Portal</title>
</head>
<body>
<div class="content">
    <div class="form-container" style="text-align: center;">
        <?php if (!empty($success_message)): ?>
            <p><?php echo $success_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="contactus.php" class="form-grid">
            <div class="form-group">
                <label for="Name">Full Name:</label>
                <input type="text" id="Name" name="Name" required>
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="mobilenum">Mobile Number</label>
                <input type="number" id="mobilenum" name="mobilenum" required>
            </div>
            <div class="form-group">
                <label for="Message">Message:</label>
                <textarea id="Message" name="Message" required></textarea>
            </div>
            <button type="submit">Contact Us</button>
        </form>
        <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
