<?php
session_start();
include("class/DB.php");

$db = new DB();

// Fetch cart items for current session
$db->query("SELECT * FROM cart WHERE session_id = ?");
$db->execute([session_id()]);
$cart_items = $db->stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>سلة المشتريات</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Tahoma', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      direction: rtl;
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #6b21a8;
      margin-bottom: 30px;
      font-size: 28px;
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    li {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      position: relative;
    }

    li img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      margin-left: 15px;
    }

    .details {
      flex-grow: 1;
      margin-right: 10px;
    }

    .details h3 {
      margin: 0;
      font-size: 18px;
      color: #333;
    }

    .details p {
      margin: 5px 0;
      font-size: 16px;
      color: #666;
    }

    .delete-btn {
      position: absolute;
      top: 10px;
      left: 10px;
      background-color: #f87171;
      color: white;
      border: none;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      text-align: center;
      line-height: 28px;
      font-weight: bold;
      cursor: pointer;
      text-decoration: none;
    }

    p strong {
      font-size: 20px;
      color: #444;
      display: block;
      margin-top: 20px;
      text-align: center;
    }

    .btn {
      display: block;
      background-color: #e9d5ff;
      color: #4c1d95;
      padding: 12px 25px;
      border-radius: 25px;
      text-decoration: none;
      font-weight: bold;
      text-align: center;
      margin-top: 20px;
      transition: background-color 0.3s ease;
    }

    .btn:hover {
      background-color: #d8b4fe;
      color: #3b0764;
    }

    .empty {
      text-align: center;
      font-size: 18px;
      color: #777;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>🛒 سلة المشتريات</h1>

    <?php if (count($cart_items) > 0): ?>
      <ul>
        <?php foreach ($cart_items as $item): ?>
          <li>
            <?php if ($item['image']): ?>
              <img src="admin/product/uploads/<?= htmlspecialchars($item['image']) ?>" alt="صورة المنتج">
            <?php endif; ?>
            <div class="details">
              <h3><?= htmlspecialchars($item['name']) ?></h3>
              <p><?= $item['price'] ?> ريال × <?= $item['quantity'] ?></p>
              <?php if ($item['size']): ?>
                <p>المقاس: <?= htmlspecialchars($item['size']) ?></p>
              <?php endif; ?>
            </div>
            <a href="remove_from_cart.php?id=<?= $item['id'] ?>" class="delete-btn">✕</a>
          </li>
        <?php endforeach; ?>
      </ul>

      <p><strong>الإجمالي:</strong> <?= $total ?> ريال</p>
      <a href="checkout.php" class="btn">إتمام الطلب</a>
    <?php else: ?>
      <p class="empty">السلة فارغة حالياً.</p>
    <?php endif; ?>
  </div>
</body>
</html>