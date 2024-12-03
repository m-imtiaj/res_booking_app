<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            try {

                // Insert user into the database
                $stmt = $pdo->prepare("INSERT INTO users ( email, password) VALUES ( ?, ?)");
                $stmt->execute([ $email, $confirm_password]);

                // Success Message
                echo "
                    <script>
                        alert('Account created successfully!');
                        window.location.href = 'login.html';
                    </script>
                ";
                exit(); // Stop further execution
            } catch (Exception $e) {
                if ($e->getCode() == 23000) { // Duplicate email error
                    echo "<p style='color: red;'>Email is already registered!</p>";
                } else {
                    echo "<p style='color: red;'>An error occurred: " . $e->getMessage() . "</p>";
                }
            }
        } else {
            echo "<p style='color: red;'>Passwords do not match!</p>";
        }
    } else {
        echo "<p style='color: red;'>All fields are required!</p>";
    }
}
?>