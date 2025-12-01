<?php
include("../class/DB.php");
include("../template/header.php");
$db = new DB(); // إنشاء اتصال

// البحث
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM food WHERE name LIKE :search OR description LIKE :search OR flavor LIKE :search";
$db->query($sql);
$db->execute(['search' => "%$search%"]);
$results = $db->stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>عرض منتجات الطعام</title>
      <link rel="stylesheet" href="style.css" />

</head>
<body>

 <div class="page-header">
    <h1 class="page-title">🍽️ عرض منتجات طعام القطط</h1>
  </div>

 <div class="search-box">
    <form method="GET">
      <input type="text" name="search" placeholder="🔍 ابحث عن طعام القطط..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">بحث</button>
    </form>
  </div>

  <div class="container">
  <?php foreach($results as $row): ?>
    <?php
      // تحديد مسار الصورة
      $imagePath = "../admin/product/uploads/" . $row['image'];
      if (!file_exists($imagePath) || empty($row['image'])) {
          $imagePath = "../admin/product/uploads/default.png"; // صورة افتراضية
      }
    ?>
    <div class="card">
    <!-- زر القلب -->
    <button class="favorite-btn">❤️</button>            
    <a href="det-food.php?id=<?= $row['id'] ?>" style="text-decoration:none; color:inherit;">
        <img src="<?= $imagePath ?>" alt="صورة المنتج">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>السعر: <?= htmlspecialchars($row['price']) ?> ريال</p>
        <p>النوع: <?= htmlspecialchars($row['type']) ?></p>
        <p>الفئة العمرية: <?= htmlspecialchars($row['age_group']) ?></p>
        <p>النكهة: <?= htmlspecialchars($row['flavor']) ?></p>
        <p>الوزن: <?= htmlspecialchars($row['weight']) ?></p>
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