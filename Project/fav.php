<?php
session_start(); // Start the session at the top of the file
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit();
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
<title>Favourites - Studitute Portal</title>
</head>
<body>

<?php include 'header.php'; // Include the header file ?>

<div class="content fav">
    <h1>Your Favourites List</h1>
    <table style="background-color: aliceblue;">
      <tr>
        <th>S.N</th>
        <th>Institution Name</th>
        <th>Tuition Fee</th>
        <th>Location</th>
        <th>Duration</th>
        <th>Course</th>
        <th>Level of Education</th>
        <th></th>
      </tr>
      <!-- Example Row (repeat as needed based on dynamic data) -->
      <tr>
        <td>1</td>
        <td><a href="detailsofinst.html" style="color:black">Canberra Institute of Technology</a></td>
        <td>$11,500</td>
        <td>Canberra</td>
        <td>1.5 Years</td>
        <td>Diploma in Nursing</td>
        <td>Short Course/Diploma</td>
        <td class="fav-icon"><img class="fav-image" src="FavC.png" alt="Unfavorite"></td>
      </tr>
      <!-- More rows would be populated here -->
    </table>
    <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
</div>

<?php include 'footer.php'; // Include the footer file ?>

</body>
</html>
