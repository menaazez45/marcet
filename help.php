<?php
// تحقق من زر الإرسال
if(isset($_POST['submit'])) {
    // بيانات قاعدة البيانات
    include("connect.php");

    // الحصول على بيانات المستخدم من نموذج الإدخال
    $username = $_POST['username'];
    $email = $_POST['email'];
    $send = $_POST['send'];

    // تحقق مما إذا كان الملف قد تم تحميله بنجاح
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_type = $_FILES['image']['type'];

        // حدد مجلد لحفظ الصور المرفوعة إليه
      //  $target_dir = "uploads/";

        // قم بتوليد اسم فريد للملف لتجنب التكرار
        $target_file = $target_dir . basename($image_name);

        // انقل الملف المرفوع إلى المجلد المستهدف
        if(move_uploaded_file($image_tmp_name, $target_file)) {
            // استعلام لإدخال بيانات المستخدم إلى قاعدة البيانات
            $sql = "INSERT INTO send (username, email, send, image) VALUES ('$username', '$email', '$send', '$target_file')";

            if(mysqli_query($conn, $sql)) {
                echo "تم الارسال بنجاح!";
                header("Location: home.php");
                exit();
            } else {
                echo "خطأ في تنفيذ الاستعلام: " . mysqli_error($conn);
            }
        } else {
            echo "حدث خطأ أثناء تحميل الصورة.";
        }
    } else {
        echo "يرجى تحميل صورة.";
    }

    // إغلاق الاتصال
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ارسال رسالة</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            text-align: right;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="file"] {
            margin-bottom: 20px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>ارسال رسالة</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <label for="username">اسم المستخدم:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="email">البريد الإلكتروني:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="send">الرسالة:</label>
        <input type="text" required name="send"><br>
        <label for="image">الصورة:</label>
        <input type="file" name="image" id="image" accept="image/*"><br>
        <input type="submit" name="submit" value="ارسال">
    </form>
</body>
</html>
