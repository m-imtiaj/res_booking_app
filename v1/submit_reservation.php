<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $slot_id = $_POST['slot'];

    // Insert reservation into the database
    $stmt = $pdo->prepare("INSERT INTO reservations (name, email, slot_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $slot_id]);

    echo 
    "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Reservation Completed</title>
            <link rel='stylesheet' href='style.css'>
        </head>
        <body>
            <div class='modal'>
                <div class='modal-content'>
                    <h2>Reservation Completed!</h2>
                    <p>Your reservation is completed. You will receive an email or text soon.</p>
                    <a href='menu.html' class='btn'>Go to Menu</a>
                </div>
            </div>
        </body>
        </html>
    ";
    exit();
}
?>
