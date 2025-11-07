<?php
session_start();
@include 'config.php';

?>
<style>
    #profileMenu {
        padding: 0;
    }

    #profileMenu li,
    #profileContent ul li {
        list-style: none;
    }

    #profileMenu li a {
        display: block;
        padding: 5px 10px;
    }

    #profileMenu li a i {
        margin-right: 5px;
    }

    .sidebar {
        border: 1px solid #e0d8d8;
    }

    .sidebar .box-heading p {
        padding: 15px;
        background: #e8dac7;
        font-weight: bold;
    }

    .sidebar .box-heading p i {
        font-size: 19px;
        vertical-align: middle;
        margin-right: 10px;
    }

    #profileContent {
        padding: 0;
    }

    #profileContent .btn-use {
        background: -webkit-linear-gradient(35deg, #91ad41 0%, #ff8a6c 100%);
        color: #fff;
    }

    #profileContent .profile select {
        height: 36px;
        width: 100%;
        border-color: #91ad41;
    }

    #profileContent ul {
        padding: 0;
    }

    #profileContent form.f .btns {
        text-align: center;
        margin-top: 25px;
    }

    #profileContent form.f .btns input {
        border: none;
        padding: 7px 10px;
    }

    #profileContent form.f li {
        margin-bottom: 10px;
    }

    #profileContent form.f li label {
        margin: 0;
        width: 40%;
    }

    #profileContent form.f li:not(:last-child) input {
        width: 60%;
    }

    .change-title {
        font-size: 28px;
    }

    @media (max-width: 600px) {
        #profileContent {
            margin-top: 30px;
            text-align: center;
        }
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<?php include 'header.php'; ?>

<div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
    <h3> <a href="sanpham.php">Profile</a></h3>
    <ul class="breadcrumb&#x20;breadcrumb-arrow">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a class="564206" href="profile.php">Profile</a></li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-3 col-md-3 col-sm-4">
            <div class="sidebar">
                <div class="box-heading">
                    <p><i class="fa fa-bars" aria-hidden="true"></i>Quản lý tài khoản</p>
                </div>
                <div class="box-content">
                    <ul id="profileMenu">
                        <li class="active"><a rel="nofollow" href="profile.php"><i class="fa fa-fw fa-user" aria-hidden="true"></i> Trang cá nhân</a></li>
                        <li><a rel="nofollow" href="profile-changepassword.php"><i class="fa fa-fw fa-wrench" aria-hidden="true"></i> Thay đổi mật khẩu</a></li>
                        <li><a href="order.php"><i class="fa fa-fw fa-envelope" aria-hidden="true"></i> Quản trị đơn hàng</a></li>
                        <li><a rel="nofollow" href="dangxuat.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9 col-md-9 col-sm-8 profileRight">
            <div id="profileContent">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                $sql = "SELECT * FROM users WHERE iduser = '{$_SESSION['iduser']}'";
                $kq = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($kq)) {
                    $iduser = $row["iduser"];
                    $hoten = $row["hoten"];
                    $email = $row['email'];
                    $sdt = $row['sdt'];
                    $diachi = $row['diachi'];
                ?>
                    <h3><?php echo $hoten; ?></h3>
                    <p><b>Email:</b> <?php echo $email; ?></p>
                    <p><b>Điện thoại:</b> <?php echo $sdt; ?></p>
                    <p><b>Địa chỉ:</b> <?php echo $diachi; ?></p>
                    <a href="profile-edit.php" class="btn btn-use">Sửa</a>
                <?php
                }
                ?>
            </div>
        </div>
        
    </div>
</div>



<?php include 'footer.php'; ?>