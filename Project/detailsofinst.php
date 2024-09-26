<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database.php';

$institution_id = isset($_GET['id']) ? $_GET['id'] : die('Error: Missing Institution ID.');
$user_id = $_SESSION['user_id']; // Ensure $user_id is defined by getting it from the session

$stmt = $pdo->prepare("SELECT institution_name, course_name, course_level, mode_of_study, locations, tution_fee, duration FROM database_institution WHERE institution_id = ?");
$stmt->execute([$institution_id]);
$institution = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$institution) {
    echo "No details found for this institution.";
    exit;
}

// Construct the title for the page
$page_title = $institution['institution_name'] . "'s<br>" . $institution['course_name'];

// Check if the institution is already a favorite
$fav_stmt = $pdo->prepare("SELECT * FROM favourites WHERE user_id = ? AND institution_id = ?");
$fav_stmt->execute([$user_id, $institution_id]);
$is_favorite = $fav_stmt->rowCount() > 0; // true if favorite, false otherwise
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="design.css">
    <script src="mywebscript.js"></script>
    <link rel="icon" type="image/png" href="Favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title><?php echo htmlspecialchars($page_title); ?> - Studitute Portal</title>
    <style>
        .institution-details {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .fav-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #f1f1ff;
            border: 1px solid #ccc;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 24px;
        }
        .fav-btn.active i {
            color: red; /* Color when favorited */
        }
        .fav-btn i {
            color: #ccc; /* Default color */
        }
        .course-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns */
            gap: 20px; /* Space between grid items */
            padding: 20px 0;
        }
        .course-info-item {
            background-color: #f1f1ff; /* Light background */
            padding: 15px;
            border-radius: 8px;
            box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }
        .course-info-item strong {
            display: block;
            color: #2C3E50; /* Dark blue for text */
            margin-bottom: 10px;
        }
        .program, .campus, .adminsreq {
            background-color: #f1f1ff; /* Light blue background for a subtle look */
            border: 1px solid #ddd; /* Maintaining a subtle border */
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="content institution-details">
    <h1><?php echo $page_title; ?>
        <span class="fav-btn <?php echo $is_favorite ? 'active' : ''; ?>" onclick="toggleFavorite(<?php echo $institution_id; ?>, this)">
            <i class="fa fa-heart"></i>
        </span>
    </h1>
    
    <div class="course-info-grid">
        <div class="course-info-item">
            <strong>Course Name:</strong>
            <?php echo htmlspecialchars($institution['course_name']); ?>
        </div>
        <div class="course-info-item">
            <strong>Tuition Fee:</strong>
            $<?php echo number_format($institution['tution_fee'], 2); ?>
        </div>
        <div class="course-info-item">
            <strong>Location:</strong>
            <?php echo htmlspecialchars($institution['locations']); ?>
        </div>
        <div class="course-info-item">
            <strong>Duration:</strong>
            <?php echo htmlspecialchars($institution['duration']); ?> year(s)
        </div>
        <div class="course-info-item">
            <strong>Mode of Study:</strong>
            <?php echo htmlspecialchars($institution['mode_of_study']); ?>
        </div>
        <div class="course-info-item">
            <strong>Level:</strong>
            <?php echo htmlspecialchars($institution['course_level']); ?>
        </div>
    </div>

    <div class="program">
        <h2>About the Program</h2>
        <p>This program provides students with a comprehensive understanding of the subject matter, preparing them for a successful career in the field. It focuses on practical skills and theoretical knowledge to ensure graduates are well-equipped to meet industry demands.</p>
    </div>
    
    <div class="campus">
        <h2>Campus Facilities</h2>
        <p>The campus boasts state-of-the-art facilities, including modern laboratories, libraries, and study spaces designed to enhance the learning experience and support student success.</p>
    </div>
    
    <div class="adminsreq">
        <h2>Admission Requirements</h2>
        <p>Applicants are expected to meet certain academic criteria and demonstrate a strong interest in the field. Specific requirements can vary, so prospective students should consult the university's admissions office for detailed information.</p>
    </div>
    
    <p><a href="resultofsearch.php" style="color: black; text-decoration:underline;">Back to <strong>Search Results</strong></a></p>
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
                element.classList.add('active');
            } else {
                element.classList.remove('active');
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
