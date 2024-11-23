<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];

    $sql = "INSERT INTO reservations (name, email, date, time, people) VALUES (:name, :email, :date, :time, :people)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':date' => $date,
        ':time' => $time,
        ':people' => $people
    ]);

    echo "Reservation confirmed for $name on $date at $time for $people people.";
}
?>
