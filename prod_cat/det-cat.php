<?php
include("../class/DB.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db = new DB();
    $db->query("SELECT * FROM clothes WHERE id = ?");
    $db->execute([$id]);
    $item = $db->stmt->fetch(PDO::FETCH_ASSOC);

    // لو فيه مقاسات نحولها لمصفوفة
    if ($item && !empty($item['size'])) {
        $sizes = explode(",", $item['size']);
    } else {
        $sizes = [];
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تفاصيل القطعة</title>
  <style>
    body { font-family: Arial; background: #f0f0f0; padding: 20px; direction: rtl; }
    .details { background: #fff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0 0 10px #ccc; }
    img { width: 100%; height: 300px; object-fit: cover; border-radius: 8px; }
    h2 { margin-top: 10px; }
    p { margin: 8px 0; }
    input[type="number"] { width: 60px; padding: 5px; }
    button { padding: 10px; background: #4CAF50; color: white; border: none; cursor: pointer; margin-top: 10px; }
  </style>
</head>
<body>

<?php if ($item): ?>
  <div class="details">
    <img src="../admin/product/uploads/<?= htmlspecialchars($item['image']) ?>" alt="صورة القطعة">
    <h2><?= htmlspecialchars($item['name']) ?></h2>
    <p><strong>السعر:</strong> <?= htmlspecialchars($item['price']) ?> ريال</p>
    <p><strong>الوصف:</strong> <?= htmlspecialchars($item['description']) ?></p>
<form method="POST" action="../add_to_cart.php">
  <label>اختر المقاس:</label>
  <select name="selected_size" required>
    <?php foreach ($sizes as $s): ?>
      <option value="<?= htmlspecialchars($s) ?>"><?= htmlspecialchars($s) ?></option>
    <?php endforeach; ?>
  </select>
  <br><br>

  <label>الكمية:</label>
  <input type="number" name="quantity" value="1" min="1">
  <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
  <input type="hidden" name="product_type" value="clothes">
  <br>
  <button type="submit">🛒 أضف إلى السلة</button>
</form>

  </div>
<?php else: ?>
  <p style="text-align:center;">❌ لم يتم العثور على القطعة المطلوبة.</p>
<?php endif; ?>

</body>
</html>