<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make a Reservation - Redb Restaurant</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="container">
            <!-- Logo -->
            <div class="logo">
                <h1>Redb Restaurant</h1>
            </div>

            <!-- Navigation Menu -->
            <nav class="nav-menu">
                <ul>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="reservation.html">Reservation</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="cart.html">Cart</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content Section -->
    <main>
        <section class="intro-section">
            <div class="container" style="text-align: center;">
                <h1>Make a Reservation</h1>
                <p>Book a table at our restaurant and enjoy a memorable dining experience.</p>
            </div>
        </section>

        <!-- Reservation Form Section -->
        <section class="reservation-section">
            <div class="form-container">
                <h2>Reserve Your Table</h2>
                <form action="submit_reservation.php" method="POST">
                    <!-- Name Field -->
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your Full Name" required>

                    <!-- Email Field -->
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Your Email Address" required>

                    <!-- Slot Selection -->
                    <label for="slot">Choose a Slot:</label>
                    <select id="slot" name="slot" required>
                        <option value="">Select a slot</option>
                        <?php
                        include 'db.php';

                        try {
                            $query = $pdo->query("SELECT * FROM available_slots ORDER BY date, time");
                            if ($query) {
                                while ($slot = $query->fetch()) {
                                    echo "<option value='{$slot['id']}'>{$slot['date']} at {$slot['time']}</option>";
                                }
                            } else {
                                echo "<option value=''>No slots available</option>";
                            }
                        } catch (Exception $e) {
                            echo "<option value=''>Error fetching slots: {$e->getMessage()}</option>";
                        }
                        ?>

                    </select>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">  Book Now</button>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-container">
            <!-- Contact Information -->
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>123 Restaurant St, Food City</p>
                <p>Email: admin@restaurant.com</p>
                <p>Phone: (0)123 456-789</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="reservation.html">Reservation</a></li>
                    <li><a href="login.html">Login</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>

            <!-- Social Media Links -->
            <div class="footer-section">
                <h3>Follow Us</h3>
                <p>
                    <a href="#">Facebook</a> | 
                    <a href="#">Twitter</a> | 
                    <a href="#">Instagram</a>
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Redb Restaurant. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
