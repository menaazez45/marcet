<!DOCTYPE html>
<html>
<head>
    <title>عرض المنتجات</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        img {
            max-width: 100px;
            max-height: 100px;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        
        }
        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">تسجيل الخروج</a>
    <a href="help.php">لعمل دعايه</a>
</div>

<div class="container">
    <?php
    include("connect.php");

    // استعلام SQL لاختيار الحقول المطلوبة من جدول المنتجات
    $sql = "SELECT title, price, image, descrip FROM products";
    $result = $conn->query($sql);

    // إذا كان هناك بيانات متاحة
    if ($result->num_rows > 0) {
        // عرض البيانات في جدول HTML
        echo "<table><tr><th>Title</th><th>Price</th><th>Image</th><th>Description</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["title"]. "</td><td>" . $row["price"]. "</td><td><img src='" . $row["image"]. "' alt='Product Image'></td><td>" . $row["descrip"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "لا توجد بيانات متاحة";
    }
    $conn->close();
    ?>
</div>

</body>
</html>
