<?php
session_start();
if (!isset($_SESSION['username'])) {
header("Location: index.html");
exit();
}
// Retrieve the IP address and username from the cookie if it exists
if (isset($_COOKIE['user_info'])) {
$user_info = json_decode($_COOKIE['user_info'], true);
// Convert IPv6 loopback (::1) to IPv4 loopback (127.0.0.1)
if ($user_info['ip'] === '::1') {
$user_info['ip'] = '127.0.0.1';
}
} 
else {
    $user_info = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="container">
        
        <h2 style="color: #ddd";>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <p>Your IP address: <?php echo $user_info ? $user_info['ip'] : 'N/A'; ?></p>
        
        <h2><a href="logout.php" style="color: #ddd";>Log Out</a></h2>

        </div>
    </header>

    <!-- Add Menu Item Form -->
    <section class="admin-section">
        <h2>Add New Menu Item</h2>
        <form action="add_item.php" method="POST" enctype="multipart/form-data">

            <label for="name">Item Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="image">Image:</label><
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Add Item</button>
        </form>
    </section>

    <!-- Menu Items List -->
    <section class="admin-section">
        <h2>Current Menu Items</h2>
        <div id="menu-items">
            <!-- Display items fetched from the database -->
            <?php
            include 'db.php';
            $query = $pdo->query("SELECT * FROM menu_items");
            while ($item = $query->fetch()) {
                echo "
                    <div class='menu-item'>
                        <h3>{$item['name']}</h3>
                        <p>{$item['description']}</p>
                        <p>Price: \${$item['price']}</p>
                        <img src='uploads/{$item['image']}' alt='{$item['name']}' class='menu-image'>
                        <form action='delete_item.php' method='POST'>
                            <input type='hidden' name='id' value='{$item['id']}'>
                            <button type='submit' class='remove-btn'>Remove</button>
                        </form>
                    </div>
                ";
            }
            ?>
        </div>
    </section>
    <!-- Add Slot Form -->
    <section class="admin-section">
        <div class="form-container">
            <h2>Add Available Slot</h2>
            <form action="add_slot.php" method="POST">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>

                <button type="submit" class="btn-submit">Add Slot</button>
            </form>
        </div>
    </section>

    <!-- View Slots Section -->
    <section class="admin-section">
        <h2>Available Slots</h2>
        <div class="slot-list">
            <?php
            include 'db.php';
            $query = $pdo->query("SELECT * FROM available_slots ORDER BY date, time");
            while ($slot = $query->fetch()) {
                echo "
                    <div class='slot-item'>
                        <p>{$slot['date']} at {$slot['time']}</p>
                        <form action='delete_slot.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$slot['id']}'>
                            <button type='submit' class='remove-btn'>Remove</button>
                        </form>
                    </div>
                ";
            }
            ?>
        </div>
    </section>

</body>
</html>

