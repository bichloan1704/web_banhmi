<?php
session_start();
@include 'config.php';


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="logo1.png" rel="icon" type="image&#x2F;vnd.microsoft.icon">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
    <link rel="stylesheet" href="../css/card.css" type="text/css">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_qlsp.css">
    <title>Quản lý bán bánh</title>
    <style>

    </style>
</head>

<body>

    <?php include('sidebar.php') ?>


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>

            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="logo1.png">
            </a>
        </nav>


        <style>
            /* .overlay {
                /* display: none; 
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                justify-content: center;
                align-items: center;
            } */

            .order-details {
                /* display: none; */
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                font-size: 15px;
                /* width: 700px; */
                /* position: fixed; */
                /* top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); */
            }

            .scrollable-td {
                height: 670px;
                overflow-y: auto;
            }
        </style>

        <div class="overlay" id="overlay">
            <div class="scrollable-td">
                <div class="order-details" id="orderDetails">
                    <?php
                    $iddh = isset($_GET['iddh']) ? $_GET['iddh'] : null;
                    echo '<h2 style="text-align: center; font-weight: bold;">Chi tiết đơn hàng ' . $iddh . '</h2>';
                    echo '<h3>Thông tin giao hàng</h3>';

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
                    ?>

                        <div style="padding-left: 10px;">
                            Họ tên: <?php echo $ten; ?><br>
                            Email: <?php echo $email; ?><br>
                            Sdt: <?php echo $sdt; ?><br>
                            Địa chỉ: <?php echo $diachi; ?><br>
                            Ngày đặt hàng: <?php echo $ngaydathang; ?><br>
                            Phương thức thanh toán: <?php echo $phuongthucthanhtoan; ?><br>
                            <strong><?php echo $trangthai; ?></strong><br><br>
                        </div>
                    <?php
                        // }
                    }
                    ?>

                    <h3>Sản phẩm</h3>
                    <table class="table table-striped">
                        <?php
                        $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                        $sql = "SELECT ctdh.*, sp.tensanpham, sp.image
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
                            $gia = $row["gia"];

                        ?>
                            <tr>
                                <td><img style="width:70px; height:70px" src="images/<?php echo $image; ?>" alt=""></td>
                                <td><?php echo $tensanpham; ?></td>
                                <td><?php echo $soluong; ?></td>
                                <td><?php echo $gia; ?></td>
                            </tr>
                        <?php } ?>
                    </table>

                    <button id="closeOrderDetails" style="border: none;height: 30px;padding: revert;border-radius: 10px;background-color: wheat;margin-left: 45%;"><a href="donhang.php">Đóng</a></button>
                </div>
            </div>
        </div>



</body>

</html>