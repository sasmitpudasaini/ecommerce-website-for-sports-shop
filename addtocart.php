<?php
session_start(); // Start the session
include 'db.php'; // Include the database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle POST requests (cart actions)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the raw POST data
  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  // Debugging: Log the received data
  error_log("Received data: " . print_r($data, true));

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

  // Handle the add action
  if ($action == 'add' && isset($data['item'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
      echo json_encode(['success' => false, 'message' => 'User not logged in.']);
      exit;
    }

    $item = $data['item'];
    $user_id = $_SESSION['user_id'];

    // Debugging: Log the item and user ID
    error_log("User ID: $user_id, Item: " . print_r($item, true));

    try {
      // Check if the item is already in the user's cart
      $sql = "SELECT * FROM carts WHERE user_id = :user_id AND product_id = :product_id";
      $stmt = $db->prepare($sql);
      $stmt->execute([':user_id' => $user_id, ':product_id' => $item['id']]);
      $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($existingItem) {
        echo json_encode(['success' => false, 'message' => 'Item already in cart']);
      } else {
        // Add the item to the cart
        $sql = "INSERT INTO carts (user_id, product_id, quantity, added_at) 
                        VALUES (:user_id, :product_id, :quantity, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([
          ':user_id' => $user_id,
          ':product_id' => $item['id'],
          ':quantity' => 1 // Default quantity is 1
        ]);

        // Debugging: Log success
        error_log("Item added to cart: " . print_r($item, true));

        echo json_encode(['success' => true, 'message' => 'Item added to cart']);
      }
    } catch (PDOException $e) {
      // Log the error
      error_log('Database error: ' . $e->getMessage());

      // Return a JSON response with the error message
      echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
  }

  // Handle the remove action
  if ($action == 'remove' && isset($data['cart_id'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
      echo json_encode(['success' => false, 'message' => 'User not logged in.']);
      exit;
    }

    $cart_id = $data['cart_id'];
    $user_id = $_SESSION['user_id'];

    try {
      // Remove the item from the cart
      $sql = "DELETE FROM carts WHERE cart_id = :cart_id AND user_id = :user_id";
      $stmt = $db->prepare($sql);
      $stmt->execute([':cart_id' => $cart_id, ':user_id' => $user_id]);

      // Debugging: Log success
      error_log("Item removed from cart: Cart ID $cart_id");

      echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
    } catch (PDOException $e) {
      // Log the error
      error_log('Database error: ' . $e->getMessage());

      // Return a JSON response with the error message
      echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
  }

  // Handle the buy action
  if ($action == 'buy') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
      echo json_encode(['success' => false, 'message' => 'User not logged in.']);
      exit;
    }

    $user_id = $_SESSION['user_id'];

    try {
      // Clear the user's cart
      $sql = "DELETE FROM carts WHERE user_id = :user_id";
      $stmt = $db->prepare($sql);
      $stmt->execute([':user_id' => $user_id]);

      // Debugging: Log success
      error_log("Cart cleared for user: User ID $user_id");

      echo json_encode(['success' => true, 'message' => 'Your purchase is on the way!']);
    } catch (PDOException $e) {
      // Log the error
      error_log('Database error: ' . $e->getMessage());

      // Return a JSON response with the error message
      echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
  }

  // If no valid action is found
  echo json_encode(['success' => false, 'message' => 'Invalid action or missing data.']);
  exit;
}

// Fetch cart items for the logged-in user
$cartItems = [];
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  // Join the carts table with the products table to fetch product details
  $sql = "SELECT carts.*, products.image, products.image_price, products.company, products.item_name 
            FROM carts 
            INNER JOIN products ON carts.product_id = products.product_id 
            WHERE carts.user_id = :user_id";
  $stmt = $db->prepare($sql);
  $stmt->execute([':user_id' => $user_id]);
  $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link href="utils.css" rel="stylesheet" type="text/css" />
  <title>Your Shopping Cart</title>
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
          <?php if (!isset($_SESSION['login_user'])): ?>
            <a href="login-form.php"><i class="fa-solid fa-user"></i> Login</a>
          <?php else: ?>
            <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
          <?php endif; ?>
        </div>
        <div class="wishlist mx-2 clickable-item">
          <a href="addtocart.php">
            <i class="bi bi-bag"></i>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag"
              viewBox="0 0 16 16">
              <path
                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
            </svg>
          </a>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container section items-container bestseller">
      <div class="cart-container">
        <h1>Your Shopping Cart <img class="newarrival sc" src="photo/shopping-cart.png"></h1>

        <?php if (!empty($cartItems)): ?>
          <table>
            <thead>
              <tr>
                <th></th>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalPrice = 0;
              foreach ($cartItems as $item):
                $price = (float) str_replace('$', '', $item['image_price']);
                $totalPrice += $price * $item['quantity'];
                ?>
                <tr id="cart-item-<?php echo $item['cart_id']; ?>">
                  <td>
                    <?php if (!empty($item['image'])): ?>
                      <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" width="50">
                    <?php else: ?>
                      <span>No Image</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                  <td><?php echo htmlspecialchars($item['company']); ?></td>
                  <td>$<?php echo number_format($price, 2); ?></td>
                  <td><button onclick="removeFromCart('<?php echo $item['cart_id']; ?>')">Remove</button></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <h3>Total Price: $<?php echo number_format($totalPrice, 2); ?></h3>
          <button onclick="buyNow()">Buy Now</button>
        <?php else: ?>
          <p>Your cart is empty.</p>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <script>
    // Function to remove an item from the cart
    function removeFromCart(cartId) {
      fetch('addtocart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'remove', cart_id: cartId })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Item removed from cart');
            location.reload(); // Refresh the page to update the cart
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }

    // Function to handle the buy now action
    function buyNow() {
      fetch('addtocart.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ action: 'buy' })
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert(data.message);
            location.reload(); // Refresh the page to clear the cart
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