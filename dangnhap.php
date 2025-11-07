<?php
session_start();
@include 'config.php';

if (isset($_SESSION['iduser']) && isset($_SESSION['role']) && $_SESSION['role'] === 'thanhvien') {
    header("Location: index.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $matkhau = $_POST['matkhau'];

    $stmt = $conn->prepare("SELECT iduser, role FROM users WHERE email = ? AND matkhau = ?");
    $stmt->bind_param("ss", $email, $matkhau);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $role = $row["role"];
        $iduser = $row["iduser"];

        $_SESSION['dangnhap'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['iduser'] = $iduser; 
        $_SESSION['role'] = $role; 

        if ($role === "admin") {
            $_SESSION['admin'] = true; // Set admin session variable
            header("Location: admin/admin.php");
            exit;
        } elseif ($role === "thanhvien") {
            header("Location: index.php");
            exit;
        }
    } else {
        echo 'Sai email hoặc mật khẩu';
    }

    $stmt->close();
}
?>



<?php include 'header.php'; ?>
    </div>
    <div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
        <h3>Đăng nhập tài khoản</h3>
        <ul class="breadcrumb&#x20;breadcrumb-arrow">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a class="564206" href="sanpham.php">Đăng nhập tài khoản</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <div id="signGF" class="text-center">
                    <h3>Đăng nhập tài khoản</h3>
                    <a rel="nofollow" href="/user/fbsignin?redirect=/" id="signFacebook"><i class="fa fa-facebook fb"></i><span>Facebook</span></a>
                    <a rel="nofollow" href="/user/ggsignin" id="signGoogle"><i class="fa fa-google-plus gp"></i><span>Google</span></a>
                </div>
                <form method="post" id="customer_login" action="dangnhap.php">
                    <form method="post" name="UserSignin" class="f" id="UserSignin">
                        <ul><input type="hidden" name="csrf" >
                            <li><input name="email" type="text" id="email" placeholder="Email" value=""></li>
                            <li><input name="matkhau" type="password"  id="matkhau" placeholder="Mật khẩu" value=""></li>
                            <li class="btns"><input name="submit" type="submit" id="btnSubmit" ></li>
                        </ul>
                    </form>
                </form>
                <p class="text-center" style="margin: 10px 0 20px 0; font-size: 13px;"><a href="getpass.php">Quên mật khẩu ?</a></p>
                <p class="text-center" style="font-size: 13px;"> Bạn chưa có tài khoản vui lòng đăng ký <a href="dangky.php" style="text-decoration: underline">tại đây</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card) => {
                const xemThemBtn = card.querySelector('.btn-xem-them');
                const cartIcon = card.querySelector('.card__cart');

                card.addEventListener('mouseenter', function() {
                    xemThemBtn.style.display = 'block';
                    cartIcon.style.display = 'block';
                });

                card.addEventListener('mouseleave', function() {
                    xemThemBtn.style.display = 'none';
                    cartIcon.style.display = 'none';
                });
            });
        });
    </script>




</body>

</html>