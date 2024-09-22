<?php
session_start(); // Start the session.


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['login_message'] = 'Please log in to access further';
    header('Location: login.php');
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
<title>Result of Cross Credits - Studitute Portal</title>
</head>
<body>


<?php include 'header.php'; ?>


<div class="content credit">
    <h1>Result for Cross Credit check:</h1>
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
    </table><br>
    <button onclick="goBack()">Go Back</button>
</div>


<?php include 'footer.php'; ?>


<!-- Place result.js at the bottom, after the DOM has loaded -->
<script src="result.js"></script>


</body>
</html>





