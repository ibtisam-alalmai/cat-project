<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>عرض جميع القطط</title>
  <style>
    body {
      font-family: 'Tahoma', sans-serif;
      background: #f9f9f9;
      padding: 20px;
    }
    h1 {
      text-align: center;
      color: #4B0E5A;
    }
    .cats-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .cat-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      text-align: center;
      padding: 15px;
    }
    .cat-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
    }
    .cat-card h2 {
      margin: 10px 0;
      font-size: 18px;
      color: #4B0E5A;
    }
    .cat-card h3 {
      margin: 5px 0;
      font-size: 16px;
      color: #666;
    }
    .cat-card p {
      font-size: 14px;
      padding: 0 10px;
      color: #333;
    }
    .cat-card form {
      margin-top: 10px;
    }
    .cat-card button {
      margin: 5px;
      padding: 8px 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      color: #fff;
      font-size: 14px;
    }
    .edit-btn {
      background-color: #f39c12;
    }
    .delete-btn {
      background-color: #e74c3c;
    }
    details {
      margin-top: 10px;
      text-align: left;
      padding: 0 10px;
    }
    details summary {
      cursor: pointer;
      color: #f39c12;
      font-weight: bold;
    }
    input, select, textarea {
      width: 90%;
      margin: 5px 0;
      padding: 6px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    textarea {
      resize: vertical;
    }
  </style>
</head>
<body>

<?php
include("../class/DB.php");

$db = new DB();


// حذف القطة
if (isset($_POST['delete_id'])) {
  $id = intval($_POST['delete_id']);
  $db->query("SELECT image FROM prod WHERE id = ?");
  $db->execute([$id]);
  if ($db->stmt->rowCount() > 0) {
    $img = $db->stmt->fetch(PDO::FETCH_ASSOC)['image'];
    if (file_exists("../" . $img)) {
      unlink("../" . $img);
    }
  }
  $db->query("DELETE FROM prod WHERE id = ?");
  $db->execute([$id]);
  echo "<script>window.location='viewall.php';</script>";
}

// تعديل القطة
if (isset($_POST['edit_id'])) {
  $id = intval($_POST['edit_id']);
  $name = $_POST['name'];
  $location = $_POST['location'];
  $age = intval($_POST['age']);
  $gender = $_POST['gender'];
  $description = $_POST['description'];

  // معالجة الصورة الجديدة إذا تم رفعها
  $newImagePath = null;
  if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
    $imageName = time() . '_' . basename($_FILES['new_image']['name']);
    $targetPath = "../ublo/" . $imageName;

    if (move_uploaded_file($_FILES['new_image']['tmp_name'], $targetPath)) {
      $db->query("SELECT image FROM prod WHERE id = ?");
      $db->execute([$id]);
      if ($db->stmt->rowCount() > 0) {
        $oldImage = $db->stmt->fetch(PDO::FETCH_ASSOC)['image'];
        if (file_exists("../" . $oldImage)) {
          unlink("../" . $oldImage);
        }
      }
      $newImagePath = "ublo/" . $imageName;
    }
  }

  // تحديث البيانات
  if ($newImagePath) {
    $db->query("UPDATE prod SET name=?, location=?, age=?, gender=?, description=?, image=? WHERE id=?");
    $db->execute([$name, $location, $age, $gender, $description, $newImagePath, $id]);
  } else {
    $db->query("UPDATE prod SET name=?, location=?, age=?, gender=?, description=? WHERE id=?");
    $db->execute([$name, $location, $age, $gender, $description, $id]);
  }

  echo "<script>window.location='viewall.php';</script>";
}
?>

<h1>جميع القطط المتاحة للتبني</h1>
<div class="cats-container">

<?php
$db->query("SELECT * FROM prod ORDER BY id DESC");
$db->execute();

if ($db->stmt->rowCount() > 0) {
  while ($cat = $db->stmt->fetch(PDO::FETCH_ASSOC)) {
?>

  <div class="cat-card">
    <img src="../<?php echo $cat['image']; ?>" alt="<?php echo $cat['name']; ?>">
    <h2><?php echo $cat['name']; ?></h2>
    <h3>📍 <?php echo $cat['location']; ?></h3>
    <h3>🎂 العمر: <?php echo $cat['age']; ?> سنوات</h3>
    <h3>⚧️ الجنس: <?php echo ($cat['gender'] == 'male') ? 'ذكر' : 'أنثى'; ?></h3>
    <p><strong>الوصف:</strong> <?php echo $cat['description']; ?></p>

    <!-- زر حذف -->
    <form method="post">
      <input type="hidden" name="delete_id" value="<?php echo $cat['id']; ?>">
      <button type="submit" class="delete-btn" onclick="return confirm('هل أنت متأكدة من حذف هذه القطة؟')">حذف</button>
    </form>

    <!-- نموذج تعديل -->
    <details>
      <summary>تعديل</summary>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" value="<?php echo $cat['id']; ?>">
        <input type="text" name="name" value="<?php echo $cat['name']; ?>" required>
        <input type="text" name="location" value="<?php echo $cat['location']; ?>" required>
        <input type="number" name="age" value="<?php echo $cat['age']; ?>" required>
        <select name="gender" required>
          <option value="male" <?php if ($cat['gender'] == 'male') echo 'selected'; ?>>ذكر</option>
          <option value="female" <?php if ($cat['gender'] == 'female') echo 'selected'; ?>>أنثى</option>
        </select>
        <textarea name="description" required><?php echo $cat['description']; ?></textarea>
        <label>تعديل الصورة:</label>
        <input type="file" name="new_image" accept="image/*">
        <button type="submit" class="edit-btn">حفظ التعديل</button>
      </form>
    </details>
  </div>

<?php
  }
} else {
  echo '<p style="text-align:center;">لا توجد قطط حالياً في قاعدة البيانات.</p>';
}
?>

</div>
</body>
</html>