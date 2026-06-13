<?php
session_start(); // Start the session to manage user login

// Enable error reporting (for debugging, remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db.php'; // Include your database connection file

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
                id: '001',
                image: 'photo/nike running shoes.png',
                image_price: '$180',
                company: 'Nike',
                item_name: 'Nike Interact Run',
            },
            {
                id: '002',
                image: 'photo/nike footballboot.png',
                image_price: '$30',
                company: 'Nike',
                item_name: 'Nike Mercurial Vapor 16 Academy',
            },
            {
                id: '003',
                image: 'photo/basketballshoes.ng.png',
                image_price: '$60',
                company: 'Nike',
                item_name: 'Nike G.T. Cut 3 "Jordan Poole',
            },
            {
                id: '004',
                image: 'photo/nike football1.png',
                image_price: '$400',
                company: 'XLP',
                item_name: 'Nike Mercurial Superfly 10 Elite Blueprint',
            }
        ];

        // Data for Best Seller
        const bestSellerItems = [
            {
                id: '005',
                image: 'photo/baseballshoes.png',
                image_price: '$250',
                company: 'Nike',
                item_name: 'Nike football ',
            },
            {
                id: '006',
                image: 'photo/hockeyboot.png',
                image_price: '$120',
                company: 'Nike',
                item_name: 'Nike Mercurial Superfly 10 Elite Blueprint',
            },
            {
                id: '007',
                image: 'photo/futsalboot.png',
                image_price: '$199',
                company: 'Nike',
                item_name: 'Nike Jr. Tiempo Legend 10 Academy',
            },
            {
                id: '008',
                image: 'photo/footballnikegrey.png',
                image_price: '$320',
                company: 'Nike',
                item_name: 'Nike Phantom Luna 2 Elite',
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
                    <button class="buttons add-to-cart" onclick="addToCart(${JSON.stringify(item)})">Add to Cart</button>
                </div>
            `).join('');
        }

        // Insert New Arrivals and Best Seller products into their sections
        document.querySelector(".items-container.newarrivals").innerHTML = generateItemsHTML(newArrivals);
        document.querySelector(".items-container.bestseller").innerHTML = generateItemsHTML(bestSellerItems);

        // Function to add an item to the cart
        function addToCart(item) {
            fetch('addtocart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'add', item: item })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Item added to cart');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>