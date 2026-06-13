<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_POST['image'];
    $image_price = $_POST['image_price'];
    $company = $_POST['company'];
    $item_name = $_POST['item_name'];

    $sql = "INSERT INTO products (image, image_price, company, item_name)
            VALUES ('$image', '$image_price', '$company', '$item_name')";

    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<form method="post">
    <label>Image URL:</label>
    <input type="text" name="image" required><br>

    <label>Price:</label>
    <input type="text" name="image_price" required><br>

    <label>Company:</label>
    <input type="text" name="company" required><br>

    <label>Item Name:</label>
    <input type="text" name="item_name" required><br>

    <button type="submit">Add Product</button>
</form>