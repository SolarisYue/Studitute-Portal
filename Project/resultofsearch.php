<?php
// Ensure the session is started and the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection
include 'database.php';

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
    <script src="mywebscript.js"></script>
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Result of Searching Institution - Studitute Portal</title>
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
        if ($results && count($results) > 0) {
            $i = 1;
            foreach ($results as $result) {
                // Ensure 'institution_id' is accessed correctly from the $result array
                $institution_id = htmlspecialchars($result['institution_id']);
                $institution_name = htmlspecialchars($result['institution_name']);
                $tution_fee = htmlspecialchars($result['tution_fee']);
                $locations = htmlspecialchars($result['locations']);
                $duration = htmlspecialchars($result['duration']);
                $course_name = htmlspecialchars($result['course_name']);
                $course_level = htmlspecialchars($result['course_level']);
                
                echo "<tr>
                    <td>{$i}</td>
                    <td><a href=\"detailsofinst.php?id={$institution_id}\" style=\"color:black\">{$institution_name}</a></td>
                    <td>{$tution_fee}</td>
                    <td>{$locations}</td>
                    <td>{$duration}</td>
                    <td>{$course_name}</td>
                    <td>{$course_level}</td>
                    <td class=\"fav-icon\">
                        <button class=\"fav-btn\" data-id=\"{$institution_id}\" id=\"fav-btn-{$institution_id}\">
                            <img class=\"fav-image\" src=\"FavD.png\" alt=\"Favorite\">
                        </button>
                    </td>
                </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan=\"8\">No results found.</td></tr>";
        }
        ?>
    </table>
    <p><a href="searchpage.php" style="color: black; text-decoration:underline;">Back to <strong>Search</strong></a></p>
</div>

<?php include 'footer.php'; // Include the footer file ?>

</body>
</html>
