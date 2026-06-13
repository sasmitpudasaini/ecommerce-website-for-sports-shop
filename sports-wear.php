<?php
// PHP Backend Logic
session_start();
include 'db.php'; // Include your database connection file

// Enable error reporting (for debugging, remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle POST requests (inserting products)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);

    // Check if JSON data is valid
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON data received.']);
        exit;
    }

    // Check if the action parameter is set
    if (!isset($data['action'])) {
        echo json_encode(['success' => false, 'message' => 'Missing action parameter.']);
        exit;
    }

    $action = $data['action'];

    // Handle the insert action
    if ($action == 'insert' && isset($data['products'])) {
        $products = $data['products'];

        // Validate and sanitize product data
        $validProducts = [];
        foreach ($products as $product) {
            if (isset($product['id'], $product['image'], $product['image_price'], $product['company'], $product['item_name'])) {
                $validProducts[] = [
                    'id' => htmlspecialchars($product['id']),
                    'image' => filter_var($product['image'], FILTER_SANITIZE_URL),
                    'image_price' => filter_var($product['image_price'], FILTER_SANITIZE_STRING),
                    'company' => htmlspecialchars($product['company']),
                    'item_name' => htmlspecialchars($product['item_name'])
                ];
            }
        }

        if (empty($validProducts)) {
            echo json_encode(['success' => false, 'message' => 'No valid products to insert.']);
            exit;
        }

        // Insert each product into the database
        try {
            $conn->beginTransaction(); // Start a transaction
            foreach ($validProducts as $product) {
                $sql = "INSERT INTO products (id, image, image_price, company, item_name) 
                        VALUES (:id, :image, :image_price, :company, :item_name)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':id' => $product['id'],
                    ':image' => $product['image'],
                    ':image_price' => $product['image_price'],
                    ':company' => $product['company'],
                    ':item_name' => $product['item_name']
                ]);
            }
            $conn->commit(); // Commit the transaction
            echo json_encode(['success' => true, 'message' => 'Products inserted successfully.']);
        } catch (PDOException $e) {
            $conn->rollBack(); // Rollback on error
            echo json_encode(['success' => false, 'message' => 'Failed to insert products: ' . $e->getMessage()]);
        }
        exit;
    }

    // If no valid action is found
    echo json_encode(['success' => false, 'message' => 'Invalid action or missing data.']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="utils.css" rel="stylesheet" type="text/css" />
    <title>Online Sports Store esportz</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                <input class="search" placeholder="Search" class="desktop-searchBar" value="">
                <div class="profile mx-2 clickable-item">
                    <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
                </div>
                <div class="wishlist mx-2 clickable-item">
                    <i class="bi bi-bag"></i>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                    </svg>
                </div>
            </div>
        </nav>
    </header>

    <section class="container section11">
        <a href="sports-wear.php"><img class="sale items1" src="photo/jersey.png" /></a>
    </section>

    <section class="container1 section3">
        <div class="newarrival productdetails">
            <h1><span class="shoescategory semibold">TOP PICKS FOR YOU</span></h1>
        </div>
        <div class="items-container newarrivals">
            <!-- Products will be dynamically added here -->
        </div>
    </section>

    <section class="container1 section2">
        <div class="items-container bestseller">
            <!-- Products will be dynamically added here -->
        </div>
    </section>

    <footer>
        <div class="footer_container">
            <div class="footer_column">
                <h3>PRODUCTS</h3>
                <a href="shoes.html">Shoes</a>
                <a href="sports-wear.php">Sports Wear</a>
                <a href="play-items.php">Play Items</a>
                <a href="#">Gift Card</a>
            </div>
            <div class="footer_column">
                <h3>SALE</h3>
                <a href="blackfridaysale.php">Black Friday Sale</a>
                <a href="wintersale.php">Winter Sale</a>
                <a href="limitededition.php">Limited Edition</a>
                <a href="#">Gift Card</a>
            </div>
            <div class="footer_column">
                <h3>OUR INFO</h3>
                <a href="about-us.html">About Us</a>
            </div>
        </div>
        <hr>
        <div class="copyright">
            © 2024 www.esportz.com. All rights reserved.
        </div>
    </footer>

    <script>
        // Data for New Arrivals
        const newArrivals = [
            {
                id: '009',
                image: 'photo/barcajersey.png',
                image_price: '$180',
                company: 'Nike',
                item_name: 'Nike Interact Run',
            },
            {
                id: '010',
                image: 'photo/mancityjersey.png',
                image_price: '$30',
                company: 'Puma',
                item_name: 'Nike Mercurial Vapor 16 Academy',
            },
            {
                id: '011',
                image: 'photo/realjersey.png',
                image_price: '$60',
                company: 'Adidas',
                item_name: 'Barca Jersey',
            },
            {
                id: '012',
                image: 'photo/manujersey.png',
                image_price: '$400',
                company: 'Adidas',
                item_name: 'Hockey Shoes',
            }
        ];

        // Data for Best Seller
        const bestSellerItems = [
            {
                id: '013',
                image: 'photo/arsenaljersey.png',
                image_price: '$109',
                company: 'Adidas',
                item_name: 'Arsenal Jersey',
            },
            {
                id: '014',
                image: 'photo/argentinajersey.png',
                image_price: '$222',
                company: 'Adidas',
                item_name: 'Adidas Lionel Messi 2024 Jersey',
            },
            {
                id: '015',
                image: 'photo/realjersey.png',
                image_price: '$105',
                company: 'Adidas',
                item_name: 'Man City jersey',
            },
            {
                id: '016',
                image: 'photo/portugaljersey.png',
                image_price: '$114',
                company: 'Nike',
                item_name: 'Cristiano Ronaldo 2022/23 Away jersey',
            }
        ];

        // Function to create HTML for items
        function generateItemsHTML(items) {
            return items.map(item => `
                <div class="product-card">
                    <img class="newarrival" src="${item.image}" />
                    <div class="newarrival productdetails">${item.image_price}</div>
                    <div class="newarrival productdetails productbrand">${item.company}</div>
                    <div class="newarrival productdetails">${item.item_name}</div>
                    <button class="buttons add-to-cart" onclick="addToCart('${item.id}')">Add to Cart</button>
                </div>
            `).join('');
        }

        // Insert New Arrivals and Best Seller products into their sections
        document.querySelector(".items-container.newarrivals").innerHTML = generateItemsHTML(newArrivals);
        document.querySelector(".items-container.bestseller").innerHTML = generateItemsHTML(bestSellerItems);

        // Function to send product data to the server
        function insertProducts(products) {
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'insert', products: products })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Products inserted successfully:', data.message);
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Insert New Arrivals and Best Seller products into the database
        insertProducts(newArrivals);
        insertProducts(bestSellerItems);

        // Function to handle adding items to the cart
        function addToCart(productId) {
            console.log(`Item ${productId} added to cart`);
            // Add logic to handle adding items to the cart (e.g., update session or database)
        }
    </script>
</body>

</html>