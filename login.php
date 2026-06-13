<?php
session_start(); // Start the session
$db = mysqli_connect('localhost', 'root', '', 'registration'); // Database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs and sanitize them
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Hash the password using md5 (as per your original code)
    $hashed_password = md5($password);

    // Debugging: Log the received email and hashed password
    error_log("Login attempt - Email: $email, Hashed Password: $hashed_password");

    // Query to check if the user exists
    $sql = "SELECT id, password FROM users WHERE email = '$email' AND password = '$hashed_password'";
    $result = mysqli_query($db, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if the user exists
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result); // Fetch user data

            // Login successful
            $_SESSION['login_user'] = $email; // Store user email in the session
            $_SESSION['user_id'] = $user['id']; // Store user ID in the session
            header("Location: home.php"); // Redirect to home page
            exit();
        } else {
            // User not found or password incorrect
            $error = "Invalid email or password";
            echo $error;
        }
    } else {
        // Query error
        $error = "Database query failed: " . mysqli_error($db);
        echo $error;
    }
}
?>