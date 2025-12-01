<?php
include("../class/DB.php");

?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>اضافة قطه لتبني</title>
<link rel="stylesheet" href="style.css?v=<?php echo filemtime('style.css'); ?>">
  
</head>

<body>
  <h1>لوحة التحكم - إضافة قطة</h1>

  <form id="addCatForm" action="../insert.php" method="post" enctype="multipart/form-data">
    <label>اسم القطة:</label>
    <input type="text" id="catName" required name="name"><br><br>

    <label>الموقع:</label>
    <input type="text" id="catLocation" required name="location"><br><br>
    
 <label>العمر:</label>
    <input type="text" id="catage" required name="age"><br><br>
<label>الجنس:</label><br>
<input type="radio" id="male" name="gender" value="male" required>
<label for="male">ذكر</label>
<input type="radio" id="female" name="gender" value="female">
<label for="female">أنثى</label><br><br>
    
    <label>الوصف:</label>
    <textarea id="catDesc" required name="description"></textarea><br><br>

    <label>إضافة صورة القطة:</label>
    <input type="file" id="catImage" accept="image/*" required name="image"><br><br>

       <a href="viewall.php">
      عرض جميع القطط
    </a> <br>

    <button type="submit" name="add">إضافة</button>

 
</form>


</body>
</html>
