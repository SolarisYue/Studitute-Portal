<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

// Include the database connection file
include 'database.php';

// Check if institution ID is provided
if (isset($_POST['institution_id'])) {
    $user_id = $_SESSION['user_id'];
    $institution_id = $_POST['institution_id'];

    // Check if already favorited
    $stmt = $pdo->prepare("SELECT * FROM favourites WHERE user_id = ? AND institution_id = ?");
    $stmt->execute([$user_id, $institution_id]);
    if ($stmt->rowCount() > 0) {
        // Already favorited, remove it
        $delete = $pdo->prepare("DELETE FROM favourites WHERE user_id = ? AND institution_id = ?");
        $delete->execute([$user_id, $institution_id]);
        echo json_encode(['success' => true, 'favorited' => false]);
    } else {
        // Not favorited, add it
        $insert = $pdo->prepare("INSERT INTO favourites (user_id, institution_id) VALUES (?, ?)");
        $insert->execute([$user_id, $institution_id]);
        echo json_encode(['success' => true, 'favorited' => true]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Institution ID not provided']);
}
?>
