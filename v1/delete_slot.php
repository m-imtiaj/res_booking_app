<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Delete the slot from the database
    $stmt = $pdo->prepare("DELETE FROM available_slots WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect back to the admin slots page
    header('Location: admin_slots.html');
}
?>
