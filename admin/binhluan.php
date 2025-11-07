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
        .card {
            margin: 15px;
        }
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
        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Bình luận từ khách hàng</h2>
        <section class="display-product-table">

            <table class="table table-striped">

                <thead>
                    <th>Họ tên</th>
                    <th>Nội dung </th>
                    <th>Thời gian</th>
                    <th>Sản phẩm</th>
                    <th>Trạng thái</th>
                </thead>

                <tbody>
                    <?php
                    $select_products = mysqli_query($conn, "SELECT binhluan.*, users.hoten, sanpham.tensanpham
                    FROM binhluan
                    INNER JOIN users ON binhluan.iduser = users.iduser
                    INNER JOIN sanpham ON binhluan.idsp = sanpham.id
                    ORDER BY binhluan.thoigian DESC;
                    ");


                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                    ?>

                            <tr>

                                <td style="width:100px"><?php echo $row['hoten']; ?></td>
                                <td style=""><?php echo $row['noidung']; ?></td>
                                <td style=""><?php echo $row['thoigian']; ?></td>
                                <td><?php echo $row['tensanpham']; ?></td>
                                <td><a href="" class="option-btn" style="padding: 0px;background-color: cornsilk;"> <i class="fas fa-edit"></i> Trả lời </a></td>
                            </tr>

                    <?php
                        };
                    }
                    ?>
                </tbody>
            </table>

        </section>

</body>

</html>