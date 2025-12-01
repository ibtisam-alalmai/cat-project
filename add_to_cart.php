<?php
session_start();
include("class/DB.php");

$db = new DB();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $product_type = $_POST['product_type'];
    $size = isset($_POST['selected_size']) ? $_POST['selected_size'] : null;

    // Determine table
    $table = '';
    if ($product_type == 'food') {
        $table = 'food';
    } elseif ($product_type == 'games') {
        $table = 'games';
    } elseif ($product_type == 'clothes') {
        $table = 'clothes';
    } else {
        die("Invalid product type");
    }

    // Fetch product
    $db->query("SELECT name, price, image FROM $table WHERE id = ?");
    $db->execute([$product_id]);
    $product = $db->stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Insert into cart
        $db->query("INSERT INTO cart (session_id, product_id, product_type, name, price, quantity, size, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $db->execute([session_id(), $product_id, $product_type, $product['name'], $product['price'], $quantity, $size, $product['image']]);
    }
}

// Redirect to cart
header("Location: cart.php");
exit();
?>
