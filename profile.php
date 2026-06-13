<?php
session_start(); // Start the session
include 'db.php'; // Include the database connection file (using PDO)

// Check if the user is logged in
if (!isset($_SESSION['login_user'])) {
    header("Location: login-form.php"); // Redirect to login if not logged in
    exit();
}

// Fetch user details from the database using PDO
$email = $_SESSION['login_user'];
try {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data

    if (!$user) {
        die("User not found."); // Handle error if user not found
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage()); // Handle database errors
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="utils.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <header class="container">
        <nav class="flex space-between">
            <div class="left flex items-center">
                <a href="home.php"><img src="photo/storelogo.png"></a>
                <ul class="flex items-center justify-center uppercase semibold">
                    <li class="clickable-item"><a href="home.php">Home</a></li>
                    <li class="clickable-item"><a href="play-items.php">Play Items</a></li>
                    <li class="clickable-item"><a href="sports-wear.php">Sports Wear</a></li>
                    <li class="clickable-item"><a href="shoes.php">Shoes</a></li>
                </ul>
            </div>
            <div class="right flex items-center">
                <input class="search" placeholder="Search" class="desktop-searchBar" />
                <div class="profile mx-2 clickable-item">
                    <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
                </div>
                <div class="wishlist mx-2 clickable-item">
                    <a href="addtocart.php">
                        <i class="bi bi-bag"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-bag" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                        </svg>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <h1>User Profile</h1>
        <div class="profile-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?></p>
            <p><strong>Joined On:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
        </div>
        <div class="logout-button">
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </main>

    <footer>
        <div class="footer_container">
            <div class="footer_column">
                <h3>PRODUCTS</h3>
                <a href="shoes.php">Shoes</a>
                <a href="sports-wear.php">Sports Wear</a>
                <a href="play-items.php">Play Items</a>
            </div>
            <div class="footer_column">
                <h3>SALE</h3>
                <a href="blackfridaysale.php">Black Friday Sale</a>
                <a href="wintersale.php">Winter Sale</a>
                <a href="limitededition.php">Limited Edition</a>
            </div>
            <div class="footer_column">
                <h3>OUR INFO</h3>
                <a href="about-us.php">About Us</a>
            </div>
        </div>
        <hr>
        <div class="copyright">
            © 2024 www.esportz.com. All rights reserved.
        </div>
    </footer>
</body>

</html>