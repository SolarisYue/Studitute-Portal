<?php
session_start(); // Start the session.

// Check if the user is logged in, using a session variable we've set at login.
if (!isset($_SESSION['user_id'])) {
  $_SESSION['login_message'] = 'Please log in to access further';
  header('Location: login.php');
  exit();

}

// If the user is logged in, continue with the rest of the code for the page.
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="design.css">
<script src="mywebscript.js"></script>
<link rel="icon" type="image/png" href="Favicon.png">
<title>Check Cross Credits - Studitute Portal</title>
</head>
<body>

<?php include 'header.php'; // Include the header ?>

<div class="content">
    <div class="form-container" style="text-align: center;">
      <form method="POST" action="resultofcrosscredit.php" enctype="multipart/form-data" class="form-grid">
      <div class="form-group" id="SourceInstitution">
        <label for="SourceInstitution">Source Institution:</label>
        <input type="text" id="SourceInstitution" name="SourceInstitution">
      </div>
      <div class="form-group" id="SourceUnitOutlines">
        <label for="SourceUnitOutlines">
          Unit Outlines from Source Institution<span style="color: red;">*</span>
          <span style="color: rgba(255, 0, 0, 0.620);">Required</span>
        </label>
        <input type="file" id="SourceUnitOutlines" name="SourceUnitOutlines[]" accept="application/pdf" multiple required>
        <small>Please make sure to rename each unit outline to their respective unit names.</small>
      </div>
      <div class="form-group" id="Level">
        <label for="Level">Level of Education:</label>
        <input list="levels" name="level">
        <datalist id="levels">
          <option value="Short Course/Diploma"></option>
          <option value="Undergraduate"></option>
          <option value="Post Graduate"></option>
        </datalist>
      </div>
      <div class="form-group" id="DestinationInstitution">
        <label for="DestinationInstitution">Destination Institution:</label>
        <input type="text" id="DestinationInstitution" name="DestinationInstitution">
      </div>
      <div class="form-group" id="DestinationUnitOutlines">
        <label for="DestinationUnitOutlines">
          Unit Outlines from Destination Institution<span style="color: red;">*</span>
          <span style="color: rgba(255, 0, 0, 0.620);">Required</span>
        </label>
        <input type="file" id="DestinationUnitOutlines" name="DestinationUnitOutlines[]" accept="application/pdf" multiple required>
        <small>Please make sure to rename each unit outline to their respective unit names.</small>
      </div>
      <button type="submit" id="searchinstitution-button" style="color: black;">Check Cross-Credit</button>
      </form>
      <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
    </div>
</div>

<?php include 'footer.php'; // Include the footer ?>

</body>
</html>