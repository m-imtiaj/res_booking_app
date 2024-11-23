<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Insert the new slot into the database
    $stmt = $pdo->prepare("INSERT INTO available_slots (date, time) VALUES (?, ?)");
    $stmt->execute([$date, $time]);

    // Redirect back to the admin slots page
    header('Location: admin_slots.html');
}
?>
