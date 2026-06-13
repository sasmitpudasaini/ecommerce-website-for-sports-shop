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
                    </svg></div>
            </div>
        </nav>




    </header>
    <section class="container section11">

        <h1> <span class="shoescategory semibold">About Us</span></h1>
        <p> Welcome to [Esportz - Online Sports Shop], your go-to destination for high-quality sports products! As a
            small online sports shop, we’re passionate about offering everything you need to stay active and perform at
            your best. From play items and sportswear to shoes, we carry a curated selection of items designed for
            athletes of all levels.

            Whether you're a beginner or a seasoned pro, our goal is to provide you with affordable, top-notch gear that
            helps you achieve your fitness goals. We take pride in offering excellent customer service and ensuring that
            each product meets our standards for quality and performance.

            Browse through our categories to find the right equipment, stylish sportswear, and shoes that suit your
            unique needs. Thank you for choosing [Esportz]—your journey to a more active and healthier lifestyle starts
            here!
        </p>

        <img class="logo" src="photo/logo.png">
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

                <a href="about-us.php">
                    <div class="">About US</div>
                </a>

            </div>
        </div>
        <hr>

        <div class="copyright">
            © 2024 www.esportz.com. All rights reserved.
        </div>
    </footer>

</body>

</html>