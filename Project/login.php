<?php
session_start();
include 'database.php'; // Ensures database connection is set up


$login_error = ''; // Initialize login error message

// Handle the POST request from the login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Make sure this name attribute matches the form below
    $password = $_POST['password']; // Make sure this name attribute matches the form below

    // Prepare and execute query to find user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables and redirect to homepage
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        header("Location: homepage.php"); // Make sure this file exists
        exit();
    } else {
        $login_error = "Invalid email or password.";
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
<title>Log In - Studitute Portal</title>
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
    <div class="form-container" style="text-align: center;">
      <form method="POST" action="login.php" class="form-grid">
        <?php if (!empty($login_error)): ?>
            <p class="error" style="color: red;"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <div class="form-group" id="email-group">
          <label for="email"> <span style="color: red; font-size: 1.2em; vertical-align: super;">*</span>
            Email Address&nbsp;<span style="color: rgba(255, 0, 0, 0.620); font-size: 0.7em; vertical-align: super;">Required</span>
          </label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group" id="password-group">
          <label for="password"> <span style="color: red; font-size: 1.2em; vertical-align: super;">*</span>
            Password&nbsp;<span style="color: rgba(255, 0, 0, 0.620); font-size: 0.7em; vertical-align: super;">Required</span>
          </label>
          <div class="password-container">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                <img src="ceye-icon.png" alt="Show Password">
            </span>
          </div>
        </div>
        <button type="submit" style="color: black;">Log In</button>
      </form>
      <p>New User?<br>
      <a href="signin.php" style="color: black; text-decoration:underline;">Sign Up</a> Now!!</p>
      <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
    </div>
  </div>

  <div class="footer">
    <p>@Copyright- Studitute Portal: Empowering your Educational Journey</p>
  </div>

</body>
</html>
