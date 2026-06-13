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

        // Insert each product into the database
        foreach ($products as $product) {
            try {
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
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => 'Failed to insert products: ' . $e->getMessage()]);
                exit;
            }
        }
        echo json_encode(['success' => true, 'message' => 'Products inserted successfully.']);
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
        <a href="play-items.php"><img class="sale items1" src="photo/playitems.png" /></a>
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
                id: '017',
                image: 'photo/basketball.png',
                image_price: '$20',
                company: 'Nike',
                item_name: 'Basketball',
            },
            {
                id: '018',
                image: 'photo/tt.png',
                image_price: '$30',
                company: 'Boliprinic',
                item_name: 'Table Tennis Bat Set',
            },
            {
                id: '019',
                image: 'photo/nike football.png',
                image_price: '$60',
                company: 'Nike',
                item_name: 'Football',
            },
            {
                id: '020',
                image: 'photo/cricket.png',
                image_price: '$1400',
                company: 'Gray-Nicolls',
                item_name: 'Cricket Bundel',
            }
        ];

        // Data for Best Seller
        const bestSellerItems = [
            {
                id: '021',
                image: 'photo/boxinggloves.png',
                image_price: '$109',
                company: 'Tap Out',
                item_name: 'Tap Out Boxing Gloves',
            },
            {
                id: '022',
                image: 'photo/longtennis.png',
                image_price: '$219',
                company: 'Babolat',
                item_name: 'Babolat Pure Drive Tennis Racquet Racket',
            },
            {
                id: '023',
                image: 'photo/rugbyball.png',
                image_price: '$25',
                company: 'Kinetica',
                item_name: 'Rugby Ball',
            },
            {
                id: '024',
                image: 'photo/baseballset.png',
                image_price: '$95',
                company: 'XLP',
                item_name: 'Baseball Set',
            }
        ];

        // Function to create HTML for items
        function generateItemsHTML(items) {
            let innerHTML = '';
            items.forEach(item => {
                innerHTML += `
                    <div class="product-card">
                        <img class="newarrival" src="${item.image}" />
                        <div class="newarrival productdetails">${item.image_price}</div>
                        <div class="newarrival productdetails productbrand">${item.company}</div>
                        <div class="newarrival productdetails">${item.item_name}</div>
                        <button class="buttons add-to-cart" onclick="addToCart()">Add to Cart</button>
                    </div>
                `;
            });
            return innerHTML;
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

        function addToCart() {
            console.log("Item added to cart");
        }
    </script>
</body>

</html>