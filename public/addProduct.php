<?php
// Include the database connection class
require_once('../dbCon.php'); // Adjust the path if needed

// Create an instance of the Database class
$database = new Database();

// Get the database connection
$conn = $database->getConnection();

// Check if the form is submitted




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];
    $color = $_POST['color'];
    $size = $_POST['size'];
    $status = $_POST['status'];

    // Insert into database
    $query = "INSERT INTO products (name, description, price, image, category, brand, type, quantity, availability, color, size, status) 
              VALUES ('$name', '$description', '$price', '$image', '$category', '$brand', '$type', '$quantity', '$availability', '$color', '$size', '$status')";
    
    if ($conn->query($query) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>

    <form action="" method="POST">
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" required>

    <label for="description">Description:</label>
    <textarea name="description" id="description" required></textarea>

    <label for="price">Price:</label>
    <input type="number" name="price" id="price" step="0.01" required>

    <label for="image">Image URL:</label>
    <input type="text" name="image" id="image" required>

    <label for="category">Category:</label>
    <input type="text" name="category" id="category">

    <label for="brand">Brand:</label>
    <input type="text" name="brand" id="brand">

    <label for="type">Type:</label>
    <input type="text" name="type" id="type">

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" id="quantity">

    <label for="availability">Availability:</label>
    <select name="availability" id="availability">
        <option value="in_stock">In Stock</option>
        <option value="out_of_stock">Out of Stock</option>
    </select>

    <label for="color">Color:</label>
    <input type="text" name="color" id="color">

    <label for="size">Size:</label>
    <select name="size" id="size">
        <option value="xs">XS </option>
        <option value="s">S</option>
        <option value="m">M</option>
        <option value="l">L</option>
        <option value="xl">XL</option>
        <option value="xxl">XXL</option>
        <option value="xxl">XXXL</option>
    </select>

    <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="featured">Featured</option>
        <option value="bestseller">Best Seller</option>
        <option value="latest">Latest</option>
    </select>

    <button type="submit" name="submit">Add Product</button>
</form>


</body>
</html>
