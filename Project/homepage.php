<?php
session_start();
include 'database.php'; // Include the database connection
include 'header.php'; // Include the header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <script src="mywebscript.js" defer></script>
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Studitute Portal: Empowering your Education Journey</title>
</head>
<body>

<div class="homecontent">
    <div class="content-container">
        <img class="homecontent-image active" src="homepage1.png" alt="Homepage Image 1">
        <img class="homecontent-image active" src="homepage2.png" alt="Homepage Image 2"> 
    </div>
</div>

<?php include 'footer.php'; // Include the footer ?>
</body>
</html>
