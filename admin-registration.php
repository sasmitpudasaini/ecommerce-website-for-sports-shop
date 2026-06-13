<?php
session_start();
$username = "";
$email = "";
$errors = array();

// DB CONNECTION
$db = mysqli_connect('localhost', 'root', '', 'registration');

// Register The Admin
if (isset($_POST['regis'])) {
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password2']);

    // Validation
    if ($password_1 != $password_2) {
        array_push($errors, "The passwords do not match");
    }

    // Check if admin already exists
    $check = "SELECT * FROM admin WHERE username='$username' OR email='$email' LIMIT 1";
    $run_check = mysqli_query($db, $check);
    $fetch_result = mysqli_fetch_assoc($run_check);

    if ($fetch_result) {
        if ($fetch_result['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($fetch_result['email'] === $email) {
            array_push($errors, "Email is already registered");
        }
    }

    // If no errors, register the admin
    if (count($errors) == 0) {
        $password = md5($password_1); // Hash the password (use password_hash() for better security)
        $query = "INSERT INTO admin (username, email, password) VALUES ('$username', '$email', '$password')";
        mysqli_query($db, $query);

        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now registered and logged in";
        header('location: admin-login-form.php'); // Redirect to login page
    }
}
?>