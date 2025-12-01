<?php
include("../class/DB.php");
include("../template/header.php");
$db = new DB();

// البحث
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM clothes WHERE name LIKE :search OR description LIKE :search";
$db->query($sql);
$db->execute(['search' => "%$search%"]);
$results = $db->stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="style.css" />

  <title>ملابس القطط - رفيقة</title>
  
</head>
<body>

  <!-- عنوان الصفحة -->
  <div class="page-header">
    <h1 class="page-title">ملابس القطط</h1>
  </div>

  <!-- شريط البحث -->
  <div class="search-box">
    <form method="GET">
      <input type="text" name="search" placeholder="🔍 ابحث عن ملابس القطط..." value="<?= htmlspecialchars($search) ?>">
      <button type="submit">بحث</button>
    </form>
  </div>



  <!-- عرض المنتجات -->
  <div class="container">
    <?php if(count($results) > 0): ?>
      <?php foreach($results as $row): ?>
        <?php
          $imagePath = "../admin/product/uploads/" . $row['image'];
          if (!file_exists($imagePath) || empty($row['image'])) {
              $imagePath = "../admin/product/uploads/default.png";
          }
        ?>
        <div class="card">
          <!-- زر القلب للمفضلة - الآن على اليمين -->
<button class="favorite-btn">❤️</button>          
          <a href="det-cat.php?id=<?= $row['id'] ?>" style="text-decoration:none; color:inherit;">
            <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="card-image">
            <div class="card-content">
              <h3 class="product-name"><?= htmlspecialchars($row['name']) ?></h3>
              <p class="product-price"><?= htmlspecialchars($row['price']) ?> ريال</p>
              
              <!-- زر إضافة للسلة -->
              <button class="add-to-cart-btn" onclick="addToCart(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', <?= $row['price'] ?>, '<?= $imagePath ?>')">
                أضف إلى السلة
              </button>
            </div>
          </a>
        </div>
        
      <?php endforeach; ?>
    <?php else: ?>
      <div class="no-results">
        <span class="no-results-icon">👕</span>
        <h3 class="no-results-title">لم نعثر على نتائج</h3>
        <p class="no-results-text">
          <?php if(!empty($search)): ?>
            لم نجد منتجات تطابق "<?= htmlspecialchars($search) ?>". جرب كلمات بحث أخرى.
          <?php else: ?>
            لا توجد منتجات متاحة حالياً.
          <?php endif; ?>
        </p>
      </div>
    <?php endif; ?>
  </div>
  <!-- معلومات النتائج -->
  <?php if(count($results) > 0): ?>
    <div class="results-info">
      عرض <span class="results-count"><?= count($results) ?></span> منتج
    </div>
  <?php endif; ?>
  <script>
    // دالة إضافة للسلة
    function addToCart(productId, productName, price, image) {
      alert(`تم إضافة ${productName} إلى السلة!`);
            console.log('إضافة للسلة:', {
        id: productId,
        name: productName,
        price: price,
        image: image
      });
    }
</body>
</html>