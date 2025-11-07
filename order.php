<?php
session_start();
@include 'config.php';
$sql = "SELECT * FROM donhang WHERE iduser = '{$_SESSION['iduser']}'";
$kq = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($kq)) {
    $ten = $row["ten"];
}
if (isset($_POST['edit-pass'])) {
    $update_iduser = $_POST['update_iduser'];
    $edit_matkhau = $_POST['newpassword'];
    $update_password = mysqli_query($conn, "UPDATE users SET matkhau = '$edit_matkhau' WHERE iduser = '$update_iduser'");
    if ($update_password) {
        header('Location: profile.php');
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['huydonhang'])) {
    $iddh = isset($_POST['iddh']) ? $_POST['iddh'] : '';
    $trangthai = 'Đang chờ xác nhận hủy đơn hàng';

    $query = mysqli_query($conn, "UPDATE donhang SET trangthai = '$trangthai' WHERE iddh = '$iddh'");
}

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
        <li><a href="order.php">Đơn hàng</a></li>
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



        <div class="col-12 col-lg-9 col-md-9 col-sm-8 profileRight" style="display: block;">
            <div id="profileContent" class="profile-edit">
                <p class="change-title">Danh sách đơn hàng đã đặt mua</p>
                <p><strong>Xin chào, <a href="javascript:void(0)" rel="nofollow" class="e32124"> <?php echo $ten; ?></a>&nbsp;!</strong></p>
                <div class="col-xs-12 col-sm-12 col-lg-12 no-padding">
                    <div class="my-account">
                        <div class="dashboard">
                            <div class="recent-orders">
                                <div class="table-responsive tab-all" style="overflow-x:auto;">

                                    <table class="table table-cart" id="my-orders-table">
                                        <thead class="thead-default a-center">
                                            <tr style="text-align: center;">
                                                <th>Mã số đơn</th>
                                                <th>Ngày đặt hàng</th>
                                                <th>Tổng tiền</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th>Chi tiết đơn hàng</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                        $sql = "SELECT * FROM donhang WHERE iduser = '{$_SESSION['iduser']}' AND (trangthai != 'Đã hủy đơn hàng' )";;
                                        $kq = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_array($kq)) {
                                            $iduser = $row["iduser"];
                                            $ten = $row["ten"];
                                            $ngaydathang = $row["ngaydathang"];
                                            $iddh = $row["iddh"];
                                            // $sanpham = $row["sanpham"];
                                            $tongtien = $row["tongtien"];
                                            $trangthai = $row["trangthai"];
                                        ?>
                                            <tbody>
                                                <tr>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="iddh" value="<?php echo $iddh; ?>">
                                                        <input type="hidden" name="iduser" value="<?php echo $iduser; ?>">
                                                        <td><?php echo $iddh; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                                        <td><?php echo $tongtien; ?></td>
                                                        <td><?php echo $trangthai; ?></td>
                                                        <td style="text-align: center;"><a class="showOrderDetails" href="order.php?iddh=<?php echo $iddh; ?>">Hiển thị</a></td>

                                                        <?php
                                                        if ($trangthai == 'Đang chờ xác nhận') {
                                                            echo '<td><button type="submit" name="huydonhang" style="border:none;">Hủy</button></td>';
                                                        } else {
                                                            echo '<td></td>';
                                                        }
                                                        ?>
                                                    </form>
                                                    <!-- <td colspan="">
                                                        <div class="alert alert-warning">
                                                            <p>Không có đơn hàng nào.</p>
                                                        </div>
                                                    </td> -->
                                                </tr>
                                            </tbody>
                                        <?php
                                        }
                                        ?>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="change-title">Đơn hàng đã hủy</p>
            <div class="col-xs-12 col-sm-12 col-lg-12 no-padding">
                <div class="my-account">
                    <div class="dashboard">
                        <div class="recent-orders">
                            <div class="table-responsive tab-all" style="overflow-x:auto;">

                                <table class="table table-cart" id="my-orders-table">
                                    <thead class="thead-default a-center">
                                        <tr style="text-align: center;">
                                            <th>Mã số đơn</th>
                                            <th>Ngày đặt hàng</th>
                                            <th>Tổng tiền</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Chi tiết đơn hàng</th>
                                            <!-- <th class="text-center">Action</th> -->
                                        </tr>
                                    </thead>
                                    <?php
                                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                    $sql = "SELECT * FROM donhang WHERE iduser = '{$_SESSION['iduser']}' AND trangthai = 'Đã hủy đơn hàng'";
                                    $kq = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($kq)) {
                                        $iduser = $row["iduser"];
                                        $ten = $row["ten"];
                                        $ngaydathang = $row["ngaydathang"];
                                        $iddh = $row["iddh"];
                                        $tongtien = $row["tongtien"];
                                        $trangthai = $row["trangthai"];

                                    ?>
                                        <tbody>
                                            <tr>
                                                <form action="" method="post">
                                                    <input type="hidden" name="iddh" value="<?php echo $iddh; ?>">
                                                    <input type="hidden" name="iduser" value="<?php echo $iduser; ?>">
                                                    <td><?php echo $iddh; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                                    <td><?php echo $tongtien; ?></td>
                                                    <td><?php echo $trangthai; ?></td>
                                                    <td style="text-align: center;"><a class="showOrderDetails" href="order.php?iddh=<?php echo $iddh; ?>">Hiển thị</a></td>
                                                </form>
                                            </tr>
                                        </tbody>
                                    <?php
                                    }
                                    ?>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                justify-content: center;
                align-items: center;
            }

            .order-details {
                display: none;
                background-color: #fff;
                padding: 20px;

                border-radius: 5px;
                width: 700px;
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .scrollable-td {
                height: 670px;
                overflow-y: auto;
            }
        </style>

        <div class="overlay" id="overlay">
            <div class="order-details" id="orderDetails">
                <div class="scrollable-td">
                    <h2 style="text-align: center;">Chi tiết đơn hàng</h2>
                    <h3>Thông tin giao hàng</h3>
                    <?php

                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                    $sql = "SELECT * FROM donhang WHERE iddh = " . $_GET['iddh'];
                    $kq = mysqli_query($conn, $sql);
                    $grand_total = 0;

                    while ($row = mysqli_fetch_assoc($kq)) {
                        $iddh = $row['iddh'];
                        $ten = $row['ten'];
                        $email = $row['email'];
                        $sdt = $row["sdt"];
                        $diachi = $row["diachi"];
                        $ngaydathang = $row["ngaydathang"];
                        $phuongthucthanhtoan = $row["phuongthucthanhtoan"];
                        $trangthai = $row["trangthai"];
                        $tongtien = $row['tongtien'];
                    ?>


                        Họ tên: <?php echo $ten; ?><br>
                        Email: <?php echo $email; ?><br>
                        Sdt: <?php echo $sdt; ?><br>
                        Địa chỉ: <?php echo $diachi; ?><br>
                        Ngày đặt hàng: <?php echo date('d/m/Y', strtotime($ngaydathang)); ?><br>
                        Phương thức thanh toán:<?php echo $phuongthucthanhtoan; ?><br>
                        <strong><?php echo $trangthai; ?></strong><br><br>
                    <?php
                        // }
                    }
                    ?>
                    <h3>Sản phẩm</h3>
                    <table class="table table-striped">
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                        $sql = "SELECT ctdh.*, sp.tensanpham, sp.image, sp.gia, sp.giamgia
             FROM chitietdonhang ctdh
             INNER JOIN sanpham sp ON ctdh.idsp = sp.id
             WHERE iddh = $iddh";
                        $kq = mysqli_query($conn, $sql);
                        $grand_total = 0;

                        while ($row = mysqli_fetch_assoc($kq)) {
                            $idsp = $row['idsp'];
                            $tensanpham = $row["tensanpham"];
                            $image = $row["image"];
                            $soluong = $row["soluong"];
                            $gia = number_format($row['gia'], 0, ',', '.');
                            $giamgia = number_format($row['giamgia'], 0, ',', '.');

                            $total_price = $soluong * ($giamgia ? $giamgia : $gia);
                            $thanhtien = number_format($total_price, 3, '.', '.');
                            $grand_total += $total_price;
                        ?>
                            <tr>
                                <td><img style="width:70px; height:70px" src="admin/images/<?php echo $image; ?>" alt=""></td>
                                <td><?php echo $tensanpham; ?></td>
                                <td><?php echo $giamgia ? $giamgia : $gia; ?>  x <?php echo $soluong; ?></td>
                              
                                <td><?php echo $thanhtien; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3">Tổng tiền</td>
                            <td><?php echo number_format($grand_total, 3, '.', '.'); ?></td>
                        </tr>
                    </table>


                    <button id="closeOrderDetails" style="border: none;height: 30px;padding: revert;border-radius: 10px;background-color: wheat;margin-left: 45%;">Đóng</button>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function() {
                $(".showOrderDetails").click(function(e) {
                    e.preventDefault();
                    $("#overlay").show();
                    $("#orderDetails").show();
                });
                $("#overlay").show();
                    $("#orderDetails").show();

                $("#closeOrderDetails").click(function() {
                    $("#overlay").hide();
                    $("#orderDetails").hide();
                    window.location.href = "order.php";
                });
            });
        </script>




    </div>
</div>