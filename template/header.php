<?php
session_start();
include_once("../class/DB.php");
$db = new DB();
$db->query("SELECT SUM(quantity) as cart_count FROM cart WHERE session_id = ?");
$db->execute([session_id()]);
$cart_count = $db->stmt->fetch(PDO::FETCH_ASSOC)['cart_count'] ?? 0;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رفيقة</title>
    <link rel="icon" href="../images/logo1.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Tajawal', sans-serif; 
            margin: 0; 
            padding: 0; 
        }
        .header-full { 
            width: 100vw; 
            position: relative; 
            left: 50%; 
            right: 50%; 
            margin-left: -50vw; 
            margin-right: -50vw; 
            background: white; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.1); 
            position: fixed; 
            top: 0; 
            z-index: 1000; 
        }
        .modal { 
            display: none; 
            position: fixed; 
            z-index: 2000; 
            left: 0; top: 0; 
            width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); 
        }
        .modal:target { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .modal-content { 
            background: white; 
            padding: 30px; 
            width: 400px; 
            max-width: 90%; 
            border-radius: 15px; 
            position: relative; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
        }
        .close { 
            position: absolute; 
            top: 15px; 
            right: 20px; 
            font-size: 28px; 
            color: #aaa; 
            text-decoration: none; 
        }
        .close:hover { 
            color: #8B5CF6; 
        }
        .login-button { 
            flex: 1; 
            padding: 15px; 
            border: 2px solid #e5e7eb; 
            border-radius: 10px; 
            background: #fff; 
            cursor: pointer; 
            transition: all 0.3s ease; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 8px; 
            font-weight: 500; 
        }
        .login-button:hover { 
            border-color: #8B5CF6; 
            background: #f3f4f6; 
            transform: translateY(-2px); 
        }
        .logo img { 
            height: 45px; 
            width: auto; 
        }
        .cart-badge { 
            position: absolute; 
            top: -8px; 
            left: -8px; 
            background: #ef4444; 
            color: white; 
            border-radius: 50%; 
            width: 20px; 
            height: 20px; 
            font-size: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
    </style>
</head>
<body class="bg-gray-50" style="padding-top: 80px;"><!-- مسافة علشان الهيدر الفيكسد -->

<!-- الهيدر -->
<header class="header-full">
    <div class="max-w-7xl mx-auto px-4 py-3"><!-- خففت البادنج -->
        <div class="flex justify-between items-center">
            <!-- الشعار -->
            <div class="flex items-center">
                <a href="home.php" class="logo">
                    <img src="../images/logo1.png" alt="رفيقة">
                </a>
            </div>

            <!-- التنقل -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="../home.php" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">الرئيسية</a>
                <a href="../home.php#cats" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">القطط المتاحة</a>
                
                <!-- سلة المشتريات -->
                <button onclick="window.location.href='cart.php'" class="relative p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"/>
                    </svg>
                    <span class="cart-badge"><?php echo $cart_count; ?></span>
                </button>

                <!-- تسجيل الدخول -->
                <a href="#loginModal" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </a>
            </nav>

            <!-- زر الموبايل -->
            <button class="md:hidden text-gray-700 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- مودال تسجيل الدخول -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <a href="#" class="close">&times;</a>
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-purple-600 mb-2">تسجيل الدخول</h2>
            <p class="text-gray-600 text-sm">اختر الوسيلة المناسبة</p>
        </div>
        <div class="flex gap-3">
            <button class="login-button">
                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
                البريد الإلكتروني
            </button>
            <button class="login-button">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.35-.11-.74-.03-1.02.24l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.59l2.2-2.2c.27-.27.35-.67.24-1.02C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z"/>
                </svg>
                رسالة نصية
            </button>
        </div>
    </div>
</div>