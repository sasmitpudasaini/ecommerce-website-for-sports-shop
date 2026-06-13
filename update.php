<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_POST['image'];
    $image_price = $_POST['image_price'];
    $company = $_POST['company'];
    $item_name = $_POST['item_name'];

    $sql = "UPDATE products SET image='$image', image_price='$image_price', company='$company', item_name='$item_name' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<form method="post">
    <label>Image URL:</label>
    <input type="text" name="image" value="<?php echo $row['image']; ?>" required><br>

    <label>Price:</label>
    <input type="text" name="image_price" value="<?php echo $row['image_price']; ?>" required><br>

    <label>Company:</label>
    <input type="text" name="company" value="<?php echo $row['company']; ?>" required><br>

    <label>Item Name:</label>
    <input type="text" name="item_name" value="<?php echo $row['item_name']; ?>" required><br>

    <button type="submit">Update Product</button>
</form>