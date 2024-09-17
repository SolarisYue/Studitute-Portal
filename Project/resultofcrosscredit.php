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

<div class="container">
    <h1>Document Comparison Results</h1>
    <table id="resultsTable">
        <thead>
            <tr>
                <th id="headerGroup1">Group 1 File</th>
                <th id="headerGroup2">Group 2 File</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            <!-- Results will be inserted here by JavaScript -->
        </tbody>
    </table>
    <button onclick="goBack()">Go Back</button>
</div>


<?php include 'footer.php'; ?>

<!-- Link to result.js -->
<script src="result.js"></script>

</body>
</html>