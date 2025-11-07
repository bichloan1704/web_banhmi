<?php
    session_start();
?>
<?php

@include 'config.php';
?>


    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $matkhau = $_POST['matkhau'];
    
        // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
        $stmt = $conn->prepare("SELECT iduser, role FROM users WHERE email = ? AND matkhau = ?");
        $stmt->bind_param("ss", $email, $matkhau);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            // Người dùng tồn tại trong cơ sở dữ liệu
            $row = $result->fetch_assoc();
            $role = $row["role"];
            $iduser = $row["iduser"];
    
            // Đặt session variables
            $_SESSION['dangnhap'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['iduser'] = $iduser; 
    
            if ($role === "admin") {
                // Đăng nhập thành công với tài khoản admin
                header("Location: admin/danhsachsanpham.php");
                exit;
            } elseif ($role === "thanhvien") {
                // Đăng nhập thành công với tài khoản thành viên
                header("Location: index.php");
                exit;
            }
        } else {
            // Trường hợp sai tên đăng nhập hoặc mật khẩu
            $error = "Sai email hoặc mật khẩu";
        }
    
        $stmt->close();
    }
?>
