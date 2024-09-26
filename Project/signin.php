<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $profile_information = $_POST['profile_information'];
    $mobile_number = $_POST['mobile_number'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, profile_information, mobile_number) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$full_name, $email, $hashed_password, $profile_information, $mobile_number])) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error creating account. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <script src="mywebscript.js"></script>
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Sign Up - Studitute Portal</title>
</head>
<body>
<div class="header">
    <a href="homepage.php" class="logo-container"><img src="Logo.jpg" alt="Logo" class="logo"></a>
    <div class="title-container">
      <div class="title">Studitute Portal</div>
      <p class="subtitle">Empowering your Educational Journey</p>
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

    <div class="content">
        <div class="form-container">
            <form method="POST" action="signin.php" class="form-grid">
                <?php if (isset($error)): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <div class="form-group" id="name-group">
                    <label for="full_name">
                        Full Name <span style="color: red;">*</span>
                    </label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="form-group" id="email-group">
                    <label for="email">
                        Email Address <span style="color: red;">*</span>
                    </label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group" id="password-group">
                    <label for="password">
                        Password <span style="color: red;">*</span>
                    </label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                            <img src="ceye-icon.png" alt="Show Password">
                        </span>
                    </div>
                </div>
                <div class="form-group" id="confirm-password-group">
                    <label for="confirm_password">
                       Confirm Password <span style="color: red;">*</span>
                    </label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password', this)">
                            <img src="ceye-icon.png" alt="Show Password">
                        </span>
                    </div>
                    <p id="password-match-message" style="color: red;"></p>
                </div>
                <div class="form-group" id="profileinformation-group">
                    <label for="profile_information">Short Information for profile:</label>
                    <textarea id="profile_information" name="profile_information"></textarea>
                </div>

                <div class="form-group" id="mobilenumber-group">
                    <label for="mobile_number">
                        Mobile Number <span style="color: red;">*</span>
                    </label>
                    <input type="text" id="mobile_number" name="mobile_number" required>
                </div>

                <div class="form-group share-info">
                    <input type="checkbox" id="termsConditions" name="termsConditions" required>
                    <label for="termsConditions">
                        I agree to the <a href="T&C.pdf" target="_blank" style="color: black; text-decoration:underline;">Terms and Conditions</a> and <a href="Privacy.pdf" target="_blank" style="color: black; text-decoration:underline;">Privacy Policies</a>.
                    </label>
                </div>

                <div class="form-group" id="register-group">
                    <button type="submit" id="Button">Register</button>
                </div>
            </form>
            <p>Already a User? <a href="login.php" style="color: black; text-decoration:underline;">Log In</a> Now!!</p>
            <p><a href="index.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
