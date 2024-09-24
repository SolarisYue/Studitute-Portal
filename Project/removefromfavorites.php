<?php
session_start();
include 'database.php'; // Ensure this points to your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$institution_id = $_POST['institution_id'] ?? null;

if ($institution_id) {
    // Delete from favourites where both user_id and institution_id match
    $stmt = $pdo->prepare("DELETE FROM favourites WHERE user_id = ? AND institution_id = ?");
    $stmt->execute([$user_id, $institution_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Removed from favorites.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to remove from favorites.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid institution ID.']);
}
?>
