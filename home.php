<?php
session_start();
include("class/DB.php"); // هنا الاتصال بقاعدة البيانات

$db = new DB();

// Get product count
$db->query("SELECT COUNT(*) as count FROM prod");
$db->execute();
$product_count = $db->stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Get cart count
$db->query("SELECT SUM(quantity) as cart_count FROM cart WHERE session_id = ?");
$db->execute([session_id()]);
$cart_count = $db->stmt->fetch(PDO::FETCH_ASSOC)['cart_count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> Rafiqa</title>
 <link rel="icon" href="images/logo1.png" type="image/png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <link rel="stylesheet" href="style.css">

 </head>
 <body>

  <header class="header">
   <div class="container">
    <div class="header-flex">
     <div class="logo-section">
      <div class="logo"><a href="home.php"> <img src="images\logo1.png" alt="رفيقة"> </a>
      </div>
     </div>
<!-- Navigation Bar -->
<nav class="nav-desktop">
  <a href="#home" class="nav-link" id="navHome">الرئيسية</a>
  <a href="#cats" class="nav-link" id="navCats">القطط المتاحة</a>
  <a href="#about" class="nav-link" id="navAbout">من نحن</a>
  <a href="#contact" class="nav-link" id="navContact">تواصل معنا</a>

  <!-- زر سلة المشتريات -->
  <button onclick="window.location.href='cart.php'" class="cart-button" name="add">
 <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"/>

    </svg>
   <span class="cart-badge"><?php echo $cart_count; ?></span>
  </button>

  <!-- زر تسجيل الدخول -->
  <a href="#loginModal" class="login-icon">
    <svg class="login-svg" viewBox="0 0 24 24">
      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
    </svg>
  </a>
</nav>

  </header><!-- مودال تسجيل الدخول -->
  <div id="loginModal" class="modal">
   <div class="modal-content"><a href="#" class="close">×</a>
    <div class="modal-header-new">
     <div class="modal-icon-container-new">
      <svg class="modal-icon-new" fill="currentColor" viewbox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
      </svg>
     </div>
     <h2 class="modal-title">تسجيل الدخول</h2>
     <p class="modal-subtitle">اختر الوسيلة المناسبة</p>
    </div>
    <div class="login-buttons"><button class="login-button">
      <svg class="login-button-icon email-icon" fill="currentColor" viewbox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
      </svg> البريد الإلكتروني </button> <button class="login-button">
      <svg class="login-button-icon sms-icon" fill="currentColor" viewbox="0 0 24 24"><path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.35-.11-.74-.03-1.02.24l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.59l2.2-2.2c.27-.27.35-.67.24-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z" />
      </svg> رسالة نصية </button>
    </div>
   </div>
  </div><!-- Hero Section -->
  
<section id="home" class="hero-section">
   <div class="hero-container">
    <!-- الصورة على اليسار -->
      <div class="cat-img">
        <img src="images/cat-home.png" alt="قطة لطيفة ">
    </div>
    
    <!-- الكلام على اليمين -->
    <div class="hero-content">
        <h2 class="hero-title">مرحبا بك في رفيقة لتبني</h2>
        <p class="hero-subtitle">نساعدك في العثور على الرفيق المثالي من القطط اللطيفة التي تحتاج إلى بيت دافئ ومحب</p>
        <a href="#catsContainer"> 
            <button onclick="scrollToSection('cats')" class="hero-button"> تصفح القطط المتاحة </button> 
        </a>
    </div>
   </div>
</section>
<!-- Products Section -->
  <section class="products-section">
   <div class="products-container">
    <div class="products-header">
     <h2 class="products-title">منتجات القطط</h2>
     <p class="products-subtitle">كل ما تحتاجه لرعاية رفيقك الجديد</p>
    </div>
    <div class="products-grid"><!-- Cat Clothes Card -->
     <div class="product-card">
      <div class="product-content">
       <div class="product-icon">
        <svg class="product-svg" fill="currentColor" viewbox="0 0 100 100"><circle cx="50" cy="35" r="15" fill="#8B5CF6" /> <ellipse cx="50" cy="60" rx="18" ry="25" fill="#A78BFA" /> <circle cx="45" cy="32" r="2" fill="white" /> <circle cx="55" cy="32" r="2" fill="white" /> <path d="M45 38 Q50 42 55 38" stroke="white" stroke-width="2" fill="none" /> <polygon points="42,25 38,20 45,28" fill="#8B5CF6" /> <polygon points="58,25 62,20 55,28" fill="#8B5CF6" /> <rect x="35" y="50" width="30" height="3" fill="#EC4899" rx="1" /> <rect x="35" y="58" width="30" height="3" fill="#EC4899" rx="1" /> <circle cx="42" cy="65" r="2" fill="#F59E0B" /> <circle cx="50" cy="65" r="2" fill="#F59E0B" /> <circle cx="58" cy="65" r="2" fill="#F59E0B" />
        </svg>
       </div>
       <h3 class="product-name">ملابس للقطط</h3>
       <p class="product-description">ملابس دافئة وأنيقة لحماية قطتك في الشتاء</p><a href="prod_cat/clothes.php"> <button class="product-button"> تصفح الملابس </button> </a>
      </div>
     </div><!-- Cat Food Card -->
     <div class="product-card">
      <div class="product-content">
       <div class="product-icon">
        <svg class="product-svg" fill="currentColor" viewbox="0 0 100 100"><ellipse cx="50" cy="75" rx="25" ry="8" fill="#6B7280" /> <ellipse cx="50" cy="72" rx="23" ry="6" fill="#F59E0B" /> <path d="M30 72 Q35 65 40 72 Q45 65 50 72 Q55 65 60 72 Q65 65 70 72" stroke="#D97706" stroke-width="2" fill="none" /> <circle cx="50" cy="45" r="12" fill="#8B5CF6" /> <circle cx="46" cy="42" r="1.5" fill="white" /> <circle cx="54" cy="42" r="1.5" fill="white" /> <polygon points="45,35 41,30 48,38" fill="#8B5CF6" /> <polygon points="55,35 59,30 52,38" fill="#8B5CF6" /> <path d="M47 48 Q50 52 53 48" stroke="white" stroke-width="1.5" fill="none" /> <circle cx="35" cy="68" r="1.5" fill="#DC2626" /> <circle cx="42" cy="70" r="1" fill="#16A34A" /> <circle cx="58" cy="69" r="1" fill="#DC2626" /> <circle cx="65" cy="67" r="1.5" fill="#16A34A" />
        </svg>
       </div>
       <h3 class="product-name">طعام القطط</h3>
       <p class="product-description">طعام صحي ومغذي لجميع أعمار القطط</p><a href="prod_cat/food.php"> <button class="product-button"> تصفح الطعام </button> </a>
      </div>
     </div><!-- Cat Toys Card -->
     <div class="product-card">
      <div class="product-content">
       <div class="product-icon">
        <svg class="product-svg" fill="currentColor" viewbox="0 0 100 100"><circle cx="45" cy="45" r="15" fill="#EC4899" /> <path d="M35 35 Q45 30 55 35 Q50 45 40 40 Q35 50 45 55 Q55 50 50 40" stroke="#BE185D" stroke-width="2" fill="none" /> <path d="M30 45 Q40 40 50 45 Q45 55 35 50" stroke="#BE185D" stroke-width="1.5" fill="none" /> <path d="M60 45 Q70 35 75 45 Q80 55 70 60 Q60 65 55 55" stroke="#EC4899" stroke-width="3" fill="none" /> <ellipse cx="25" cy="25" rx="8" ry="6" fill="#8B5CF6" /> <circle cx="22" cy="22" r="2" fill="#8B5CF6" /> <circle cx="25" cy="20" r="2" fill="#8B5CF6" /> <circle cx="28" cy="22" r="2" fill="#8B5CF6" /> <circle cx="25" cy="24" r="1.5" fill="#8B5CF6" /> <ellipse cx="75" cy="75" rx="8" ry="5" fill="#6B7280" /> <circle cx="82" cy="73" r="2" fill="#6B7280" /> <path d="M83 71 L87 68 M83 75 L87 78" stroke="#6B7280" stroke-width="1.5" /> <circle cx="78" cy="74" r="1" fill="white" />
        </svg>
       </div>
       <h3 class="product-name">ألعاب القطط</h3>
       <p class="product-description">ألعاب ممتعة ومحفزة لنشاط قطتك</p><a href="prod_cat/toys.php"> <button class="product-button"> تصفح الألعاب </button> </a>
      </div>
     </div>
    </div>
   </div>
  </section>
  
<!-- Available Cats Section -->
<section id="cats">
  <div class="container">
    <div class="section-header">
      <h2>القطط المتاحة للتبني</h2>
      <p>اختر رفيقك الجديد من بين هذه القطط الرائعة</p>
    </div>
  </div>
<section class="cats-grid" id="catsContainer">
    <?php
    $db->query("SELECT * FROM prod ORDER BY id DESC");
    $db->execute();

    if ($db->stmt->rowCount() > 0) {
        while ($cat = $db->stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "
            <div class='cat-card'>
                <div class='cat-image-container'>
                    <img src='{$cat['image']}' alt='{$cat['name']}' class='cat-image'>
                    <h1 class='cat-name'>{$cat['name']}</h1>
                </div>
                <div class='cat-content'>
                                    <p class='cat-description'>{$cat['description']}</p>
                    <h3 class='cat-location'>
                        <svg class='location-icon' width='16' height='16' viewBox='0 0 24 24' fill='#9810b0'>
                            <path d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z'/>
                        </svg>
                        {$cat['location']}
                    </h3>
                    <a href='informaitoncat/cat-details.php?id={$cat['id']}' class='adopt-button'>
                        تبنَّ الآن
                    </a>
                </div>
            </div>";
        }
    } else {
        echo "<p class='no-cats'>لا توجد قطط متاحة حالياً</p>";
    }
    ?>
</section>
</section>
     
  </section><!-- About Section -->
  <section id="about" class="py-16 bg-white">
   <div class="container mx-auto px-4">
    <div class="max-w-4xl mx-auto text-center">
     <h2 class="text-4xl font-bold text-gray-800 mb-8">من نحن</h2>
     <div class="text-6xl mb-6">
      🐱💕
     </div>
     <p class="text-lg text-gray-600 mb-8 leading-relaxed">رفيقة هي منصه تهدف إلى إيجاد بيوت محبة للقطط المشردة والمهجورة. نؤمن بأن كل قطة تستحق الحب والرعاية، ونعمل بجد لضمان وصول كل قطة إلى العائلة المناسبة لها.</p>
     <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
      <div class="p-6 bg-purple-50 rounded-lg">
       <div class="text-3xl mb-4">
        🎯
       </div>
       <h3 class="text-xl font-bold mb-3">مهمتنا</h3>
       <p class="text-gray-600">إنقاذ القطط المشردة وإيجاد بيوت محبة لها مع توفير الرعاية الطبية اللازمة</p>
      </div>
      <div class="p-6 bg-purple-50 rounded-lg">
       <div class="text-3xl mb-4">
        👥
       </div>
       <h3 class="text-xl font-bold mb-3">فريقنا</h3>
       <p class="text-gray-600">مجموعة من المتطوعين المحبين للحيوانات والمختصين في الطب البيطري</p>
      </div>
     </div>
    </div>
   </div>
  </section><!-- Cat Details Modal -->
  <div id="catDetailsModal" class="modal">
   <div class="modal-content"><a href="#" class="close">×</a>
    <div class="modal-header">
     <div class="modal-icon-container">
      <svg class="modal-icon" fill="currentColor" viewbox="0 0 24 24"><path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 7.5V9M15 11.5L21 12V14L15 13.5V15.5L21 16V18L15 17.5V19.5L12 19L9 19.5V17.5L3 18V16L9 15.5V13.5L3 14V12L9 11.5V9L3 9.5V7.5L9 7V5L12 5L15 7V9" />
      </svg>
     </div>
     <h2 class="modal-title" id="catName">اسم القط</h2>
     <p class="modal-subtitle" id="catLocation">الموقع</p>
    </div>
    <div style="text-align: center; margin-bottom: 1.5rem;">
     <p id="catDescription" style="color: #6b7280; margin-bottom: 1.5rem;">وصف القط</p>
     <div style="display: flex; gap: 1rem; justify-content: center;"><button class="login-button" style="background-color: #7c3aed; color: white; border-color: #7c3aed;"> تبني الآن </button> <button class="login-button" onclick="window.location.href='#'"> معلومات أكثر </button>
     </div>
    </div>
   </div>
  </div><!-- Contact Section -->
  <section id="contact" class="py-16 bg-gray-50">
   <div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto text-center">
     <h2 class="text-4xl font-bold text-gray-800 mb-8">تواصل معنا</h2>
     <div class="bg-white p-8 rounded-lg shadow-lg">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
       <div class="text-center p-4">
        <div class="text-3xl text-purple-600 mb-3">
         📱
        </div>
        <h3 class="font-bold mb-2">الهاتف</h3>
        <p class="text-gray-600">+966 50 123 4567</p>
       </div>
       <div class="text-center p-4">
        <div class="text-3xl text-purple-600 mb-3">
         ✉️
        </div>
        <h3 class="font-bold mb-2">البريد الإلكتروني</h3>
        <p class="text-gray-600">info@rafeqa.com</p>
       </div>
      </div>
      <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
       <p class="text-yellow-800 text-sm"><strong>ملاحظة:</strong> سنرد على رسالتك خلال 24 ساعة. نحن هنا لمساعدتك في العثور على الرفيق المثالي!</p>
      </div>
      <form class="space-y-4" onsubmit="handleContactForm(event)">
       <div><input type="text" placeholder="الاسم الكامل" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
       </div>
       <div><input type="email" placeholder="البريد الإلكتروني" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
       </div>
       <div><textarea placeholder="رسالتك" rows="4" required class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
       </div><button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg font-bold hover:bg-purple-700 transition-colors"> إرسال الرسالة </button>
      </form><!-- Success Message -->
      <div id="successMessage" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
       <p class="text-green-800 text-center">✅ تم إرسال رسالتك بنجاح! سنتواصل معك قريباً</p>
      </div>
     </div>
    </div>
   </div>
  </section><!-- Footer -->
  <footer class="bg-gray-800 text-white py-8">
   <div class="container mx-auto px-4 text-center">
    <div class="flex items-center justify-center space-x-3 space-x-reverse mb-4">
     <div class="logo"><a href="#home"> <img src="images/logo1.png" alt="رفيقة" style="height: 40px; width: auto;"> </a>
     </div>
     <h3 class="text-xl font-bold">رفيقة</h3>
    </div>
    <p class="text-gray-400 mb-4">نساعد القطط في العثور على بيوت محبة</p>
    <div class="flex justify-center space-x-6 space-x-reverse mb-4"><a href="#home" class="text-gray-400 hover:text-white transition-colors">الرئيسية</a> <a href="#cats" class="text-gray-400 hover:text-white transition-colors">القطط المتاحة</a> <a href="#about" class="text-gray-400 hover:text-white transition-colors">من نحن</a> <a href="#contact" class="text-gray-400 hover:text-white transition-colors">تواصل معنا</a>
    </div>
    <p class="text-gray-500 text-sm">© 2025 رفيقة. جميع الحقوق محفوظة.</p>
   </div>
  </footer>
 
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'995a8f25d5bdf536',t:'MTc2MTY1NTgyOS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>