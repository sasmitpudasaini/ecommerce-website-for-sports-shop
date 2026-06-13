<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="utils.css" rel="stylesheet" type="text/css" />
    <title>Online Sports Store esportz</title>
</head>

<body>
    <header class="container">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
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

                <div class="wishlist mx-2 clickable-item"><i class="bi bi-bag"></i> <svg
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                    </svg></i></div>
            </div>
        </nav>




    </header>


    <section class="container1 section3">
        <div class="newarrival productdetails">
            <h1><span class="shoescategory semibold">BLACK FRIDAY</span></h1>
        </div>
        <div class="items-container newarrivals">
            <!-- Products will be dynamically added here -->
        </div>
    </section>





    <footer>
        <div class="footer_container">
            <div class="footer_column">
                <h3>PRODUCTS</h3>

                <a href="shoes.php">Shoes</a>
                <a href="sports-wear.php">sports wear</a>
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

                <a href="about-us.html">
                    <div class="">About US</div>
                </a>

            </div>
        </div>
        <hr>

        <div class="copyright">
            © 2024 www.esportz.com. All rights reserved.
        </div>
    </footer>


    <script>
        // Targeting containers for both New Arrivals and Best Seller
        let itemContainerElementNewArrivals = document.querySelector(".items-container.newarrivals");
        let itemContainerElementBestSeller = document.querySelector(".items-container.bestseller");

        // Data for New Arrivals (same as before)
        const newArrivals = [
            {
                id: '003',
                image: 'photo/barcajersey.png',
                image_price: '$60',
                company: 'Nike',
                item_name: 'Barca Jersey',
            },
            {
                id: '002',
                image: 'photo/nike footballboot.png',
                image_price: '$30',
                company: 'Nike',
                item_name: 'Nike Mercurial Vapor 16 Academy',
            },
            {
                id: '001',
                image: 'photo/nike running shoes.png',
                image_price: '$180',
                company: 'Nike',
                item_name: 'Nike Interact Run',

            },
            {
                id: '004',
                image: 'photo/manujersey.png',
                image_price: '$400',
                company: 'Adidas',
                item_name: 'Hockey Shoes',
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

        // Insert New Arrivals into their section
        itemContainerElementNewArrivals.innerHTML = generateItemsHTML(newArrivals);


        function addToCart() {
            console.log("Item added to cart");
        }
    </script>

</body>

</html>