<?php 
    session_start();
    
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xử lí đăng ký</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    <h1>Xử lí đăng ký</h1>
    
        <?php
            $hoten = $_POST['hoten'];
            $email = $_POST['email'];
            $matkhau = $_POST['matkhau'];
            $sdt = $_POST['sdt'];
            $role = 'thanhvien';
            $conn = mysqli_connect("localhost", "root","","cakeshop");

            $sql = "INSERT INTO users(hoten,email, matkhau, sdt, role) VALUES ('$hoten','$email', '$matkhau','$sdt', '$role')";
            $kq = mysqli_query($conn, $sql);
            if ($kq) {
                echo '<script>alert("Đăng ký tài khoản thành công");</script>';
                header("Location: index.php");
            } else {
             echo '<script>alert("Error: ' . mysqli_error($conn) . '")</script>';
            }
            
        ?>      
</body>
</html>