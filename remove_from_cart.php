<?php
session_start();
include("class/DB.php");

$db = new DB();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->query("DELETE FROM cart WHERE id = ? AND session_id = ?");
    $db->execute([$id, session_id()]);
}

// Redirect to cart
header("Location: cart.php");
exit();
?>
