<?php
include("../class/DB.php");
include("../template/header.php");

$db = new DB(); // إنشاء اتصال

// البحث
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM games WHERE name LIKE :search OR description LIKE :search";
$db->query($sql);
$db->execute(['search' => "%$search%"]);
$results = $db->stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>عرض ألعاب القطط</title>
  <link rel="stylesheet" href="style.css" />

    
</head>
<body>

 <div class="page-header">
    <h1 class="page-title">🎮 عرض ألعاب القطط الممتعة</h1>
  </div>

  <div class="search-box">
    <form method="GET">
      <input type="text" name="search" placeholder="🔍 ابحث عن لعبة القطط..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">بحث</button>
    </form>
  </div>
  <div class="container">
  <?php foreach($results as $row): ?>
    <?php
      // تحديد مسار الصورة
      $imagePath = "../admin/product/uploads/" . $row['image'];
      if (!file_exists($imagePath) || empty($row['image'])) {
          $imagePath = "../admin/product/uploads/default-game.png"; // صورة افتراضية
      }
    ?>
      <div class="card">
    <!-- زر القلب -->
    <button class="favorite-btn">❤️</button>    
      <a href="det-play.php?id=<?= $row['id'] ?>" style="text-decoration:none; color:inherit;">
        <img src="<?= $imagePath ?>" alt="صورة اللعبة">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>السعر: <?= htmlspecialchars($row['price']) ?> ريال</p>
        <p>الكود: <?= htmlspecialchars($row['code']) ?></p>
        <p><?= htmlspecialchars($row['description']) ?></p>
      </a>
       <!-- زر إضافة للسلة - خارج الـ a -->
    <button class="add-to-cart-btn" onclick="addToCart(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', <?= $row['price'] ?>, '<?= $imagePath ?>')">
        أضف إلى السلة
    </button>
    </div>
  <?php endforeach; ?>
  </div>
</body>
</html>