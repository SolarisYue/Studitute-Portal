<?php
session_start(); // Start the session to ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit();
}

include 'database.php'; // Include the database connection

// Get search parameters from the form submission
$institution_name = $_GET['Institutionname'] ?? '';
$location = $_GET['Location'] ?? '';
$course = $_GET['Course'] ?? '';
$level = $_GET['level'] ?? '';
$duration = $_GET['Duration'] ?? '';
$min_fee = $_GET['feerange_min'] ?? '';
$max_fee = $_GET['feerange_max'] ?? '';

// Build the query dynamically based on user input
$query = "SELECT institution_id, institution_name, tution_fee, locations, duration, course_name, course_level 
          FROM database_institution 
          WHERE 1=1";

// Add search filters if they exist
if (!empty($institution_name)) {
    $query .= " AND institution_name LIKE :institution_name";
}
if (!empty($location)) {
    $query .= " AND locations LIKE :location";
}
if (!empty($course)) {
    $query .= " AND course_name LIKE :course";
}
if (!empty($level)) {
    $query .= " AND course_level = :level";
}
if (!empty($duration)) {
    $query .= " AND duration = :duration";
}
if (!empty($min_fee) && !empty($max_fee)) {
    $query .= " AND tution_fee BETWEEN :min_fee AND :max_fee";
}

// Prepare the query
$stmt = $pdo->prepare($query);

// Bind the parameters
if (!empty($institution_name)) {
    $stmt->bindValue(':institution_name', '%' . $institution_name . '%');
}
if (!empty($location)) {
    $stmt->bindValue(':location', '%' . $location . '%');
}
if (!empty($course)) {
    $stmt->bindValue(':course', '%' . $course . '%');
}
if (!empty($level)) {
    $stmt->bindValue(':level', $level);
}
if (!empty($duration)) {
    $stmt->bindValue(':duration', $duration);
}
if (!empty($min_fee) && !empty($max_fee)) {
    $stmt->bindValue(':min_fee', $min_fee);
    $stmt->bindValue(':max_fee', $max_fee);
}

// Execute the query
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Result of Searching Institution - Studitute Portal</title>
    <style>
        .fav-btn {
            background: none;
            
            cursor: pointer;
            color: brown; /* Initial color of the heart */
        }
        .fav-btn.active {
            color: red; /* Color when favorited */
        }
    </style>
</head>
<body>

<?php include 'header.php'; // Include the header file ?>

<div class="content result">
    <h1>Search Results</h1>
    <table style="background-color: aliceblue;">
        <tr>
            <th>S.N</th>
            <th>Institution Name</th>
            <th>Tuition Fee</th>
            <th>Location</th>
            <th>Duration</th>
            <th>Course</th>
            <th>Level of Education</th>
            <th>Favorite</th>
        </tr>
        <?php
        $i = 1;
        foreach ($results as $result) {
            echo "<tr>
                <td>{$i}</td>
                <td><a href=\"detailsofinst.php?id={$result['institution_id']}\" style=\"color:black\">{$result['institution_name']}</a></td>
                <td>{$result['tution_fee']}</td>
                <td>{$result['locations']}</td>
                <td>{$result['duration']}</td>
                <td>{$result['course_name']}</td>
                <td>{$result['course_level']}</td>
                <td class=\"fav-icon\">
                    <button class=\"fav-btn\" data-id=\"{$result['institution_id']}\" id=\"fav-btn-{$result['institution_id']}\">
                        <i class=\"far fa-heart\"></i> <!-- Empty heart -->
                    </button>
                </td>
            </tr>";
            $i++;
        }
        ?>
    </table>
    <p><a href="searchpage.php" style="color: black; text-decoration:underline;">Back to <strong>Search</strong></a></p>
</div>

<?php include 'footer.php'; // Include the footer ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fav-btn').forEach(button => {
        button.addEventListener('click', function() {
            const institutionId = this.getAttribute('data-id');
            addToFavorites(institutionId, this);
        });
    });
});

function addToFavorites(institutionId, button) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'addtofavourites.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                const icon = button.querySelector('i');
                icon.classList.remove('far');
                icon.classList.add('fas');
                button.classList.add('active'); // Turn the heart red
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
