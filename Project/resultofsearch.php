<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

$institution_name = $_GET['Institutionname'] ?? '';
$location = $_GET['Location'] ?? '';
$course = $_GET['Course'] ?? '';
$level = $_GET['level'] ?? '';
$duration = $_GET['Duration'] ?? '';
$min_fee = $_GET['feerange_min'] ?? '';
$max_fee = $_GET['feerange_max'] ?? '';

$query = "SELECT institution_id, institution_name, tution_fee, locations, duration, course_name, course_level 
          FROM database_institution 
          WHERE 1=1";

$params = [];

if (!empty($institution_name)) {
    $query .= " AND institution_name LIKE :institution_name";
    $params[':institution_name'] = '%' . $institution_name . '%';
}
if (!empty($location)) {
    $query .= " AND locations LIKE :location";
    $params[':location'] = '%' . $location . '%';
}
if (!empty($course)) {
    $query .= " AND course_name LIKE :course";
    $params[':course'] = '%' . $course . '%';
}
if (!empty($level)) {
    $query .= " AND course_level = :level";
    $params[':level'] = $level;
}
if (!empty($duration)) {
    $query .= " AND duration = :duration";
    $params[':duration'] = $duration;
}
if (!empty($min_fee) && !empty($max_fee)) {
    $query .= " AND tution_fee BETWEEN :min_fee AND :max_fee";
    $params[':min_fee'] = $min_fee;
    $params[':max_fee'] = $max_fee;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check favorites for the logged-in user
$fav_stmt = $pdo->prepare("SELECT institution_id FROM favourites WHERE user_id = ?");
$fav_stmt->execute([$_SESSION['user_id']]);
$favorites = $fav_stmt->fetchAll(PDO::FETCH_COLUMN, 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" type="image/png" href="Favicon.png">
    <title>Result of Searching Institution - Studitute Portal</title>
</head>
<body>

<?php include 'header.php'; ?>

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
            $fav_class = in_array($result['institution_id'], $favorites) ? 'fas' : 'far'; // Check if it's a favorite
                echo "<tr>
                    <td>{$i}</td>
                    <td><a href=\"detailsofinst.php?id={$result['institution_id']}\" style=\"color:black\">{$result['institution_name']}</a></td>
                    <td>{$result['tution_fee']}</td>
                    <td>{$result['locations']}</td>
                    <td>{$result['duration']} year(s)</td>
                    <td>{$result['course_name']}</td>
                    <td>{$result['course_level']}</td>
                    <td class=\"fav-icon\">
                        <i class=\"{$fav_class} fa-heart\" onclick=\"toggleFavorite({$result['institution_id']}, this)\"></i> <!-- Heart icon -->
                    </td>
            </tr>";
            $i++;
        }
        ?>
    </table>
    <p><a href="searchpage.php" style="color: black; text-decoration:underline;">Back to <strong>Search</strong></a></p>
</div>

<?php include 'footer.php'; ?>

<script>
function toggleFavorite(institutionId, element) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'toggle_favorite.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.favorited) {
                element.classList.remove('far');
                element.classList.add('fas');
            } else {
                element.classList.add('far');
                element.classList.remove('fas');
            }
        } else {
            alert('Request failed. Returned status of ' + xhr.status);
        }
    };
    xhr.send('institution_id=' + institutionId);
}
</script>

</body>
</html>
