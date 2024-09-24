<?php
session_start(); // Start the session
include 'database.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to log in to add favorites']);
    exit();
}

// Check if institution_id is set in POST
if (isset($_POST['institution_id'])) {
    $user_id = $_SESSION['user_id']; // Get the logged-in user ID
    $institution_id = $_POST['institution_id']; // Get the institution ID from the request

    // Check if the institution is already in the favorites table for this user
    $stmt = $pdo->prepare("SELECT * FROM favourites WHERE user_id = ? AND institution_id = ?");
    $stmt->execute([$user_id, $institution_id]);

    if ($stmt->rowCount() == 0) {
        // Insert into the favorites table
        try {
            $insertStmt = $pdo->prepare("INSERT INTO favourites (user_id, institution_id) VALUES (?, ?)");
            $insertStmt->execute([$user_id, $institution_id]);
            echo json_encode(['success' => true, 'message' => 'Added to favorites!']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Already in your favorites!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request! Institution ID missing']);
}
?>
