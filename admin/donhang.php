<?php
session_start();
@include 'config.php';

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['xac_nhan_don_hang'])) {
//     $iddh = isset($_POST['iddh']) ? $_POST['iddh'] : '';
//     $trangthai = isset($_POST['trangthai']) ? $_POST['trangthai'] : '';

//     if ($trangthai == 'Đang chờ xác nhận') {
//         $updateQuery = "UPDATE donhang SET trangthai = 'Đã xác nhận' WHERE iddh = $iddh";
//     } else if ($trangthai == 'Đang chờ xác nhận hủy đơn hàng') {
//         $updateQuery = "UPDATE donhang SET trangthai = 'Đã hủy đơn hàng' WHERE iddh = $iddh";
//     }

//     if (isset($updateQuery)) {
//         $result = mysqli_query($conn, $updateQuery);

//         if ($result) {
//             echo 'Cập nhật trạng thái thành công';

//         } else {
//             echo 'Error: ' . mysqli_error($conn);
//         }
//     }
// }


if (isset($_POST['save_status'])) {
    $iddh = $_POST['iddh'];
    $newStatus = $_POST['suatrangthai'];

    $updateQuery = "UPDATE donhang SET trangthai = '$newStatus' WHERE iddh = '$iddh'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo 'Cập nhật trạng thái thành công';
        header('Location: donhang.php');
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

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
        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng</h2>
        <section class="display-product-table">
            <table class="table table-striped">
                <thead>
                    <th>Mã đơn</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </thead>
                <tbody>
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM donhang ");

                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                            $iddh = $row['iddh'];
                            $trangthai = $row['trangthai'];
                            $ngaydathang = $row['ngaydathang'];
                    ?>
                            <tr>
                                <form class="orderForm" method="post" action="">
                                    <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                    <td><?php echo $row['tongtien']; ?></td>
                                    <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                    <td><?php echo $row['trangthai']; ?></td>
                                    <?php
                                    if ($trangthai != 'Đã hủy đơn hàng' && $trangthai != 'Đã giao') {
                                        echo '<input type="hidden" name="iddh" value="' . $iddh . '">';
                                        echo '<td><a href="donhang.php?suatrangthai=' . $row['iddh'] . '"> <i class="fas fa-edit"></i> Sửa trạng thái </a></td>';
                                    } else {
                                        echo '<td></td>';
                                    }
                                    ?>



                                </form>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <section style="font-size: 15px; border: none; width: 270px;border-radius: 10px;background-color: #d8d8d0;">
            <?php
            if (isset($_GET['suatrangthai'])) {
                $suatrangthai = $_GET['suatrangthai'];
                $edit_query = mysqli_query($conn, "SELECT * FROM donhang WHERE iddh = $suatrangthai");
                if (mysqli_num_rows($edit_query) > 0) {
                    while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
            ?>
                        <form action="" method="post" style= "padding: 10px;">
                            <input type="hidden" name="iddh" value="<?php echo $fetch_edit['iddh']; ?>">
                            <label for="suatrangthai">Chọn trạng thái mới - Đơn hàng <?php echo $suatrangthai ?></label> <br>
                            <select name="suatrangthai" id="suatrangthai" style= "border: none;border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
                                <option value="<?php echo $fetch_edit['trangthai']; ?>" selected><?php echo $fetch_edit['trangthai']; ?></option>
                                <option value="Đã hủy đơn hàng" <?php echo ($fetch_edit['trangthai'] == 'Đã hủy đơn hàng') ? 'selected' : ''; ?>>Đã hủy đơn hàng</option>
                                <option value="Đã xác nhận" <?php echo ($fetch_edit['trangthai'] == 'Đã xác nhận') ? 'selected' : ''; ?>>Đã xác nhận</option>
                                <option value="Đang chuẩn bị đơn hàng" <?php echo ($fetch_edit['trangthai'] == 'Đang chuẩn bị đơn hàng') ? 'selected' : ''; ?>>Đang chuẩn bị đơn hàng</option>
                                <option value="Đang giao hàng" <?php echo ($fetch_edit['trangthai'] == 'Đang giao hàng') ? 'selected' : ''; ?>>Đang giao hàng</option>
                                <option value="Đã giao" <?php echo ($fetch_edit['trangthai'] == 'Đã giao') ? 'selected' : ''; ?>>Đã giao</option>
                            </select>
                            <br>
                            <input type="submit" value="Lưu trạng thái" name="save_status" style= "border: none;border-radius: 5px;">
                        </form>
            <?php
                    }
                }
            } ?>
        </section>

        <h2 style="text-align: center;padding: 10px; font-weight: bold;">Đơn hàng đã hủy</h2>
        <section class="display-product-table">
            <table class="table table-striped">
                <thead>
                    <th>Mã đơn</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Trạng thái</th>
                </thead>
                <tbody>
                    <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM donhang WHERE trangthai = 'Đã hủy đơn hàng'");

                    if (mysqli_num_rows($select_products) > 0) {
                        while ($row = mysqli_fetch_assoc($select_products)) {
                            $iddh = $row['iddh'];
                            $ngaydathang = $row['ngaydathang'];
                    ?>
                            <tr>
                                <form action="" method="post">
                                    <td style="text-align: center;"><?php echo $row['iddh']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($ngaydathang)); ?></td>
                                    <td><?php echo $row['tongtien']; ?></td>
                                    <td><a href="chitietdonhang.php?iddh=<?php echo $row['iddh']; ?>">Hiển thị chi tiết</a></td>
                                    <td><?php echo $row['trangthai']; ?></td>
                                </form>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </section>





</body>

</html>