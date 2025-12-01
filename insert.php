<?php
include("class/DB.php");
if (!$con) {
    die("فشل الاتصال: " . mysqli_connect_error());
}

// اذا ضغطت على زر إضافة
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $age = $_POST['age'];
    $gender =$_POST['gender'];
    $description = $_POST['description'];

    // التعامل مع الصورة
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_path = "ublo/" . $image_name;

        // رفع الصورة أولًا
        if (move_uploaded_file($image_tmp, $image_path)) {
            // استخدام Prepared Statement لإدخال البيانات
            $stmt = $con->prepare("INSERT INTO prod (name, location, age ,gender,description, image) VALUES (?, ?, ?, ?,?,?)");
            $stmt->bind_param("ssssss", $name, $location,$age,$gender, $description, $image_path);

            if ($stmt->execute()) {
                echo "<script>
                        alert('تم رفع الصورة وحفظ البيانات بنجاح');
                        window.location='admin/addcat.php';
                      </script>";
            } else {
                echo "خطأ في إدخال البيانات: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "<script>alert('خطأ في رفع الصورة')</script>";
        }
    } else {
        echo "<script>alert('لم يتم اختيار صورة أو حدث خطأ أثناء رفعها')</script>";
    }
}

$con->close();

?>
