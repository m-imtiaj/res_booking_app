<?php
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Upload image
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imagePath = 'uploads/' . $imageName;
    move_uploaded_file($imageTmp, $imagePath);

    // Insert item into the database
    $stmt = $pdo->prepare("INSERT INTO menu_items (name, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $description, $price, $imageName]);

    // Redirect back to the dashboard
    header('Location: admin-dashboard.php');
}
?>
