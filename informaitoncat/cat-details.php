<?php
include("../class/DB.php");

$db = new DB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $db->query("SELECT * FROM prod WHERE id = ?");
    $db->execute([$id]);
    $cat = $db->stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تفاصيل القطة</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

<div class="container mx-auto px-4 py-16">
    <?php if ($cat): ?>
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto text-center">
<img src="../<?php echo $cat['image']; ?>" alt="<?php echo $cat['name']; ?>" class="w-full h-80 object-cover rounded-lg mb-6">

<h1 class="text-3xl font-bold text-purple-600 mb-4"><?php echo $cat['name']; ?></h1>

<h3 class="text-lg text-gray-600 mb-2">📍 <?php echo $cat['location']; ?></h3>

<h3 class="text-lg text-gray-600 mb-2">🎂 العمر: <?php echo $cat['age']; ?> </h3>

<h3 class="text-lg text-gray-600 mb-2">⚧️ الجنس: 
  <?php echo ($cat['gender'] == 'male') ? 'ذكر' : 'أنثى'; ?>
</h3>

<p class="text-gray-700 leading-relaxed mb-6">
  <span class="font-semibold text-purple-700">الوصف:</span>
  <?php echo $cat['description']; ?>
</p>
            <button class="bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-colors">تواصل للتبني</button>
        </div>
    <?php else: ?>
        <p class="text-center text-red-600">القطة غير موجودة</p>
    <?php endif; ?>
</div>

</body>
</html>
