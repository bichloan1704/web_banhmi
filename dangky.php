<?php
session_start();
@include 'config.php';

?>

<?php include 'header.php'; ?>
    </div>
    <div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
        <h3>Đăng ký tài khoản</h3>
        <ul class="breadcrumb&#x20;breadcrumb-arrow">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a class="564206" href="sanpham.php">Đăng ký tài khoản</a></li>
        </ul>
    </div>
    <div class="container content-web">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <div id="signGF" class="text-center">
                    <h3>Đăng ký tài khoản</h3>
                    <a rel="nofollow" href="/user/fbsignin?redirect=/" id="signFacebook"><i class="fa fa-facebook fb"></i><span>Facebook</span></a>
                    <a rel="nofollow" href="/user/ggsignin" id="signGoogle"><i class="fa fa-google-plus gp"></i><span>Google</span></a>
                </div>
                <form id="registerForm" action="xulidangky.php" method="post">
                    <ul>
                        <li><input name="hoten" id="hoten" placeholder="Họ và tên" type="text" class="txtFullName validate[required]"></li>
                        <li><input name="email" id="email" placeholder="Địa chỉ Email" type="text" class="txtEmail validate[required]"></li>
                        <li><input name="matkhau" id="matkhau" placeholder="Mật khẩu" type="password" class="pwdPass validate[required]"></li>
                        <li><input name="sdt" id="sdt" placeholder="Số điện thoại" type="text" class="txtPhone validate[required,custom[phone]] field-input"></li>
                        <li><input id="btn-register" type="submit" value="Đăng ký"></li>
                    </ul>
                </form>
                <p class="text-center" style="font-size: 13px;"> Bạn có tài khoản rồi vui lòng đăng nhập <a href="dangnhap.php" style="text-decoration: underline">tại đây</a></p>
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