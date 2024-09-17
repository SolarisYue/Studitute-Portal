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
    <script src="mammoth.browser.min.js"></script> <!-- Mammoth.js for .docx handling -->
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Check Cross Credits - Studitute Portal</title>
</head>
<body>
  
<?php include 'header.php'; ?>

<div class="content">
    <div class="form-container" style="text-align: center;">
        <form id="crossCreditForm" method="POST" enctype="multipart/form-data" class="form-grid">
            <div class="form-group" id="SourceInstitution">
                <label for="SourceInstitution">Source Institution:</label>
                <input type="text" id="SourceInstitution" name="SourceInstitution">
            </div>
            <div class="form-group" id="SourceUnitOutlines">
                <label for="SourceUnitOutlines">Unit Outlines from Source Institution<span style="color: red;">*</span></label>
                <input type="file" id="fileGroup1" name="SourceUnitOutlines[]" accept=".docx" multiple required>
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
                <label for="DestinationUnitOutlines">Unit Outlines from Destination Institution<span style="color: red;">*</span></label>
                <input type="file" id="fileGroup2" name="DestinationUnitOutlines[]" accept=".docx" multiple required>
                <small>Please make sure to rename each unit outline to their respective unit names.</small>
            </div>
            <button type="button" id="compareButton" style="color: black;">Check Cross-Credit</button>
        </form>
        <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Link to crosscredit.js -->
<script src="crosscredit.js"></script>

</body>
</html>