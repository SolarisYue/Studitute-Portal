<?php
session_start(); // Starts the session to ensure user is logged in, otherwise redirect

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="design.css">
<script src="mywebscript.js"></script>
<link rel="icon" type="image/png" href="Favicon.png">
<title>Search Institution - Studitute Portal</title>
</head>
<body>

<?php include 'header.php'; // Includes the header file ?>

<div class="content">
    <div class="form-container" style="text-align: center;">
        <form method="GET" action="resultofsearch.php" class="form-grid"> <!-- Make sure action is set to a PHP file -->
            <div class="form-group" id="Institutionname">
                <label for="Institutionname">Institution Name:</label>
                <input type="text" id="Institutionname" name="Institutionname">
            </div>
            <div class="form-group" id="Location">
                <label for="Location">Location:</label>
                <input type="text" id="Location" name="Location">
            </div>
            <div class="form-group" id="Course">
                <label for="Course">Course:</label>
                <input type="text" id="Course" name="Course">
            </div>
            <div class="form-group" id="Level">
                <label for="Level">Level of Education:</label>
                <input list="levels" name="level">
                <datalist id="levels">
                    <option value="Short Course/Diploma/ Pre-Bachelor"></option>
                    <option value="Undergraduate/ Bachelor"></option>
                    <option value="Post Graduate/ Masters"></option>
                </datalist>
            </div>
            <div class="form-group" id="Duration">
                <label for="Duration">Duration:</label>
                <input type="text" id="Duration" name="Duration">
            </div>
            <div class="form-group" id="feerange">
                <label for="feerange">Tuition Fee Range:</label>
                <div class="fee-range">
                    <span>Min</span>
                    <input type="number" class="input-min">
                    <span>Max</span>
                    <input type="number" class="input-max">
                </div>
            </div>
            <button type="submit" id="searchinstitution-button" style="color: black;">Search Institution</button>
        </form>
        <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
    </div>
</div>

<?php include 'footer.php'; // Includes the footer file ?>

</body>
</html>
