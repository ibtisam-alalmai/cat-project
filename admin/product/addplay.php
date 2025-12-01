<?php
include("../../class/DB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // التعامل مع الصورة
    $imageName = basename($_FILES['image']['name']);
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadPath = "uploads/" . $imageName;

    if (move_uploaded_file($imageTmp, $uploadPath)) {
        $db = new DB();
        $db->query("INSERT INTO games (name, price, description, image) VALUES (?, ?, ?, ?)");
        $db->execute([$name, $price, $description, $imageName]);

        // كود تلقائي للعبة
        $lastId = $db->lastInsertId();
        $code = "gm-" . str_pad($lastId, 3, "0", STR_PAD_LEFT);
        $db->query("UPDATE games SET code = ? WHERE id = ?");
        $db->execute([$code, $lastId]);

        echo "<p style='color:green;'>✅ تمت إضافة اللعبة بنجاح برقم: $code</p>";
    } else {
        echo "<p style='color:red;'>❌ فشل رفع الصورة.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة لعبة للقطط</title>
  <style>
    body { font-family: 'Tahoma'; direction: rtl; background-color: #f9f9f9; padding: 20px; }
    form { background: #fff; padding: 20px; border-radius: 8px; width: 450px; margin: auto; box-shadow: 0 0 10px #ccc; }
    label { display: block; margin-top: 10px; }
    input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 15px; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    button:hover { background-color: #45a049; }
  </style>
</head>
<body>

<h2 style="text-align:center;">🎮 إضافة لعبة جديدة للقطط</h2>

<form action="" method="POST" enctype="multipart/form-data">
  <label>اسم اللعبة:</label>
  <input type="text" name="name" required>

  <label>السعر (ر.س):</label>
  <input type="number" name="price" required>

  <label>الوصف:</label>
  <textarea name="description" required></textarea>

  <label>الصورة:</label>
  <input type="file" name="image" accept="image/*" required>

  <button type="submit">إضافة اللعبة</button>
</form>

</body>
</html>