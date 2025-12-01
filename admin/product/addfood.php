<?php
include("../../class/DB.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $age_group = $_POST['age_group'];
    $flavor = $_POST['flavor'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];

    // التعامل مع الصورة
    $imageName = basename($_FILES['image']['name']);
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadPath = "uploads/" . $imageName;

    if (move_uploaded_file($imageTmp, $uploadPath)) {
        $db = new DB();
        $db->query("INSERT INTO food (name, price, type, age_group, flavor, weight, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $db->execute([$name, $price, $type, $age_group, $flavor, $weight, $description, $imageName]);

        // كود تلقائي للطعام
        $lastId = $db->lastInsertId();
        $code = "fd-" . str_pad($lastId, 3, "0", STR_PAD_LEFT);
        $db->query("UPDATE food SET code = ? WHERE id = ?");
        $db->execute([$code, $lastId]);

        echo "<p style='color:green;'>✅ تمت إضافة المنتج بنجاح برقم: $code</p>";
    } else {
        echo "<p style='color:red;'>❌ فشل رفع الصورة.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إضافة طعام للقطط</title>
  <style>
    body { font-family: 'Tahoma'; direction: rtl; background-color: #f9f9f9; padding: 20px; }
    form { background: #fff; padding: 20px; border-radius: 8px; width: 450px; margin: auto; box-shadow: 0 0 10px #ccc; }
    label { display: block; margin-top: 10px; }
    input, textarea, select { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 15px; padding: 10px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    button:hover { background-color: #45a049; }
  </style>
</head>
<body>

<h2 style="text-align:center;">🍽️ إضافة منتج طعام للقطط</h2>

<form action="" method="POST" enctype="multipart/form-data">
  <label>اسم المنتج:</label>
  <input type="text" name="name" required>

  <label>السعر (ر.س):</label>
  <input type="number" name="price" required>
<label>نوع الطعام:</label>
<select name="type" required>
  <option value="dry">جاف</option>
  <option value="wet">رطب</option>
  <option value="treat">مكافآت</option>
</select>

<label>الفئة العمرية:</label>
<select name="age_group" required>
  <option value="kitten">صغير</option>
  <option value="adult">بالغ</option>
  <option value="senior">كبير</option>
  <label>الفئة العمرية:</label>
<select name="age_group" required>
  <option value="kitten">صغير</option>
  <option value="adult">بالغ</option>
  <option value="senior">كبير</option>
  <option value="all">كل المراحل العمرية</option>
</select>
</select>

  <label>النكهة / المكونات:</label>
  <input type="text" name="flavor" placeholder="مثل: دجاج، سلمون، تونة">

  <label>الوزن / الحجم:</label>
  <input type="text" name="weight" placeholder="مثل: 1 كجم، 400 جم">

  <label>الوصف:</label>
  <textarea name="description" required></textarea>

  <label>الصورة:</label>
  <input type="file" name="image" accept="image/*" required>

  <button type="submit">إضافة المنتج</button>
</form>

</body>
</html>