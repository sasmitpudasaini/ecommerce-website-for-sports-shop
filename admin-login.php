<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'registration');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs and sanitize them
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password']; // Raw password input

    // Query to check if the admin exists
    $sql = "SELECT id, username, password FROM admin WHERE email='$email'";
    $result = mysqli_query($db, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Login successful
            $_SESSION['admin'] = true; // Set admin session flag
            $_SESSION['username'] = $admin['username']; // Store admin username in the session
            header("Location: admin_dashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            // Login failed
            $error = "Email or password is incorrect";
        }
    } else {
        // Login failed
        $error = "Email or password is incorrect";
    }
}
?>