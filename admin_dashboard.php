<?php
session_start();

// Redirect to login if the user is not an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login-form.php'); // Redirect to login page
    exit();
}

include 'db.php'; // Include your database connection file

// Handle product deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $delete_id]);
    header('Location: admin_dashboard.php'); // Refresh the page
    exit();
}

// Handle product acceptance
if (isset($_GET['accept_id'])) {
    $accept_id = $_GET['accept_id'];
    $sql = "UPDATE products SET status = 'accepted' WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':product_id' => $accept_id]);
    header('Location: admin_dashboard.php'); // Refresh the page
    exit();
}

// Fetch all products from the database
$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            font-size: 16px;
        }

        .navbar a:hover {
            color: #28a745;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1