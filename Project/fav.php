<?php
// Ensure the session is started and the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection
include 'database.php';

$user_id = $_SESSION['user_id'];

// Query to fetch the user's favorites
$query = "
    SELECT f.institution_id, di.institution_name, di.tution_fee, di.locations, di.duration, di.course_name, di.course_level
    FROM favourites f
    JOIN database_institution di ON f.institution_id = di.institution_id
    WHERE f.user_id = :user_id
";
$stmt = $pdo->prepare($query);
$stmt->execute(['user_id' => $user_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <script src="mywebscript.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Favourites - Studitute Portal</title>
    <style>
        .unfav-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: red; /* Red when favorited */
        }
        .unfav-btn:hover {
            color: brown; /* Brown when hovered for unfavorite action */
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

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
            <th>Remove</th>
        </tr>
        <?php
        $i = 1;
        foreach ($favorites as $fav) {
            echo "<tr>
                <td>{$i}</td>
                <td><a href=\"detailsofinst.php?id={$fav['institution_id']}\" style=\"color:black\">{$fav['institution_name']}</a></td>
                <td>{$fav['tution_fee']}</td>
                <td>{$fav['locations']}</td>
                <td>{$fav['duration']} year(s)</td>
                <td>{$fav['course_name']}</td>
                <td>{$fav['course_level']}</td>
                <td class=\"fav-icon\">
                    <button class=\"unfav-btn\" data-id=\"{$fav['institution_id']}\" id=\"unfav-btn-{$fav['institution_id']}\">
                        <i class=\"fas fa-heart\"></i> <!-- Solid heart when favorited -->
                    </button>
                </td>
            </tr>";
            $i++;
        }
        if ($i == 1) {
            echo "<tr><td colspan=\"8\">No favorites added yet.</td></tr>";
        }
        ?>
    </table>
    <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
</div>

<?php include 'footer.php'; ?>

<script>
// JavaScript for unfavorite button
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.unfav-btn').forEach(button => {
        button.addEventListener('click', function() {
            const institutionId = this.getAttribute('data-id');
            removeFromFavorites(institutionId, this);  // Pass button id for icon toggle
        });
    });
});

function removeFromFavorites(institutionId, button) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'removefromfavorites.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                button.closest('tr').remove(); // Remove row from table
            } else {
                alert(response.message);
            }
        }
    };
    
    xhr.send('institution_id=' + institutionId);
}
</script>

</body>
</html>
