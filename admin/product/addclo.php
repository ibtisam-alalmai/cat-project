<?php
include("../../class/DB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $description = $_POST['description'];

    // المقاسات (مصفوفة → نص مفصول بفواصل)
    $sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];

    // إذا اختار All، نخزن كل المقاسات
    if (in_array('All', $sizes)) {
        $sizes = ['XS','S','M','L','XL'];
    }

    $sizes = implode(",", $sizes); // نص مفصول بفواصل للتخزين

    // التعامل مع الصورة
    $imageName = basename($_FILES['image']['name']);
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadPath = "uploads/" . $imageName;

    if (move_uploaded_file($imageTmp, $uploadPath)) {
        $db = new DB();
        $db->query("INSERT INTO clothes (name, price, size, color, description, image) VALUES (?, ?, ?, ?, ?, ?)");
        $db->execute([$name, $price, $sizes, $color, $description, $imageName]);

        $lastId = $db->lastInsertId();
        $code = "C-" . str_pad($lastId, 3, "0", STR_PAD_LEFT);

        $db->query("UPDATE clothes SET code = ? WHERE id = ?");
        $db->execute([$code, $lastId]);

        echo "<p style='color:green;'>✅ تمت إضافة القطعة بنجاح برقم: $code</p>";
    } else {
        echo "<p style='color:red;'>❌ فشل رفع الصورة.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة ملابس القطط</title>
  <style>
    body { font-family: 'Tahoma'; direction: rtl; background-color: #f9f9f9; padding: 20px; }
    form { background: #fff; padding: 20px; border-radius: 8px; width: 400px; margin: auto; box-shadow: 0 0 10px #ccc; }
    label { display: block; margin-top: 10px; }
    input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 15px; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    button:hover { background-color: #45a049; }
  </style>
</head>
<body>

<h2 style="text-align:center;">🧺 إضافة قطعة ملابس للقطط</h2>

<form action="" method="POST" enctype="multipart/form-data">
  <label>اسم القطعة:</label>
  <input type="text" name="name" required>

  <label>السعر:</label>
  <input type="number" name="price" required>

  <label>المقاسات المتوفرة:</label>
  <div>
    <label><input type="checkbox" name="sizes[]" value="XS"> XS</label>
    <label><input type="checkbox" name="sizes[]" value="S"> S</label>
    <label><input type="checkbox" name="sizes[]" value="M"> M</label>
    <label><input type="checkbox" name="sizes[]" value="L"> L</label>
    <label><input type="checkbox" name="sizes[]" value="XL"> XL</label>
    <label><input type="checkbox" name="sizes[]" value="All"> جميع المقاسات</label>
  </div>

  <label>اللون:</label>
  <input type="text" name="color" required>

  <label>الوصف:</label>
  <textarea name="description" required></textarea>

  <label>الصورة:</label>
  <input type="file" name="image" accept="image/*" required>

  <button type="submit">إضافة</button>
</form>

</body>
</html>
