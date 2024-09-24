<?php
session_start(); // Start the session at the top of the file
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit();
}

include 'database.php'; // Include the database connection

$user_id = $_SESSION['user_id'];

// Query to fetch favorites
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
        <?php
        if ($favorites && count($favorites) > 0) {
            $i = 1;
            foreach ($favorites as $fav) {
                echo "<tr>
                    <td>{$i}</td>
                    <td><a href=\"detailsofinst.php?id={$fav['institution_id']}\" style=\"color:black\">{$fav['institution_name']}</a></td>
                    <td>{$fav['tution_fee']}</td>
                    <td>{$fav['locations']}</td>
                    <td>{$fav['duration']}</td>
                    <td>{$fav['course_name']}</td>
                    <td>{$fav['course_level']}</td>
                    <td class=\"fav-icon\"><img class=\"fav-image\" src=\"FavC.png\" alt=\"Unfavorite\"></td>
                </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan=\"8\">No favorites added yet.</td></tr>";
        }
        ?>
    </table>
    <p><a href="homepage.php" style="color: black; text-decoration:underline;">Back to Homepage</a></p>
</div>

<?php include 'footer.php'; // Include the footer file ?>

<script>
    // JavaScript for unfavorite button
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.unfav-btn').forEach(button => {
            button.addEventListener('click', function() {
                const institutionId = this.getAttribute('data-id');
                removeFromFavorites(institutionId, this.id);  // Pass button id for icon toggle
            });
        });
    });

    function removeFromFavorites(institutionId, buttonId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'removefromfavorites.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById(buttonId).closest('tr').remove(); // Remove row from table
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
