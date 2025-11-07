<?php
session_start();
@include 'config.php';

if (isset($_GET['remove']) && isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = '$remove_id' AND iduser = $iduser");
    header('location:cart.php');
}
if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE cart SET soluong = '$update_value' WHERE id = '$update_id'");
    if ($update_quantity_query) {
        header('location:cart.php');
    }
}
if (isset($_GET['delete_all']) && isset($_SESSION['iduser'])) {
    $iduser = $_SESSION['iduser'];
    mysqli_query($conn, "DELETE FROM cart WHERE iduser = $iduser");
    header('location:cart.php');
}

?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/cart.css" type="text/css">
<link rel="stylesheet" href="https://theme.hstatic.net/200000696635/1001034053/14/cartpage.css?v=394">
<style>
    .btn-main {
        border: 1px solid #080808;
        color: #080808;
        border-radius: 5px;
    }

    .btn-main:hover {
        color: #fff;
        background: #080808;
    }
</style>
<?php
if ($row_count == 0) { ?>
    <section class="main-cart-page main-container col1-layout mobile-tab active" id="cart-tab" data-title="Giỏ hàng" style="height: 450px;">
        <div class="wrap_background_aside padding-top-15 margin-bottom-40 padding-left-0 padding-right-0 cartmbstyle">
            <div class="cart-empty container card border-0 py-2 ">
                <div class="alert green-alert section" role="alert">
                    <div class="title-cart text-center">
                        <h1 class="d-none">Giỏ hàng</h1>
                        <div>
                            <img src="//theme.hstatic.net/200000696635/1001034053/14/cart_empty_background.png?v=394" class="img-fluid" width="298" height="152">
                        </div>
                        <h3>
                            “Hổng” có gì trong giỏ hết
                        </h3>
                        <p style="font-size: 18px;"> Về trang cửa hàng để chọn mua sản phẩm bạn nhé!!</p>
                        <a href="index.php" title="Mua sắm ngay" class="btn btn-main">Mua sắm ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <div class="wrapper-mainCart" style="margin: 8px 0;">
        <div class="content-bodyCart">
            <div class="container" style="background: #ffffff; padding:8px;border-radius: 8px;">
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-12 contentCart-detail">
                        <div class="mainCart-detail">
                            <div class="heading-cart heading-row">
                                <h1>Giỏ hàng của bạn</h1>
                                <p class="title-number-cart">Bạn đang có <strong class="count-cart"><?php echo $row_count ?></strong> sản phẩm trong giỏ hàng</p>
                                <div class="cart-shipping ">
                                </div>
                            </div>
                            <a href="cart.php?delete_all" style="float: right;padding-bottom: 10px;color: #a59c9c" onclick="return confirm('Xóa tất cả sản phẩm?');"> Xóa tất cả </a>
                            <?php 
                            if (isset($_SESSION['iduser'])) {
                                $iduser = $_SESSION['iduser']; ?>
                            <div class="list-pageform-cart  mb-3" style="margin-bottom: 0 !important;">
                                <form action="" method="post" id="cartformpage" style="margin-bottom: 0 !important;">
                                    <?php
                                    $conn = mysqli_connect("localhost", "root", "", "cakeshop");
                                    $sql = "SELECT * FROM cart where iduser= $iduser";
                                    $kq = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($kq)) {
                                        $idsp = $row['idsp'];
                                        $id = $row['id'];
                                        $anh = $row['image'];
                                        $ten = $row['tensanpham'];
                                        $gia = number_format($row['gia'], 3, ',', '.');
                                        $giamgia = number_format($row['giamgia'], 3, ',', '.');
                                        $soluong = $row["soluong"];
                                    ?>
                                        <div class="cart-row">
                                            <div class="table-cart">
                                                <div class="media-line-item line-item" data-line="1" data-variant-id="73" data-product-id="73">
                                                    <div class="media-left">
                                                        <div class="item-img">
                                                            <a href="chitietsanpham.php?id='" . $id>
                                                                <img src="images/<?php echo $anh ?>" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="item-remove">
                                                            <a style="padding: 0 !important;" href="cart.php?remove=<?php echo $row['id']; ?>" onclick="return confirm('Xóa sản phẩm này?')" class="cart">Xóa</a>
                                                        </div>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="item-info">
                                                            <h3 class="item--title"><a href="chitietsanpham.php?id=<?php echo $idsp; ?>"><?php echo $ten; ?></a></h3>
                                                        </div>
                                                        <div class="item-price">
                                                            <p>
                                                                <?php

                                                                if ($row['giamgia'] > 0) {
                                                                    echo '<span">' . $giamgia . 'đ   </span>';
                                                                } else {
                                                                    echo '<span">' . $gia . 'đ   </span>';
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="media-total">
                                                        <div class="item-total-price">
                                                            <div class="price">
                                                                <span class="line-item-total">
                                                                    <?php
                                                                    $total_price = $row['giamgia'] > 0 ? $row['giamgia'] * $soluong : $row['gia'] * $soluong;
                                                                    $thanhtien = number_format($total_price, 3, ',', '.');
                                                                    $update_query = "UPDATE cart SET thanhtien = '$thanhtien' WHERE idsp = '{$row['idsp']}'";
                                                                    $update_result = mysqli_query($conn, $update_query);

                                                                    if ($update_result) {
                                                                        echo $thanhtien . 'đ';
                                                                    } else {
                                                                        echo 'Error updating database: ' . mysqli_error($conn);
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="item-qty">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="update_quantity_id" value="<?php echo $row['id']; ?>">
                                                                <input type="number" name="update_quantity" min="1" style="width: 30px;border-radius: 7px;background-color: #cecfcf;border: none;text-align: end;" value="<?php echo $row['soluong']; ?>">
                                                                <input type="submit" value="Cập nhật" style="    border: none;border-radius: 6px;padding: 3px;" name="update_update_btn">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                            <?php } ?>
                            <div class="pageCart-hrvpmo  hrvpmo-grids">
                                <div class="hrv-pmo-discount" data-hrvpmo-layout="grids"></div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-4 col-md-12 col-12 sidebarCart-sticky ">
                        <div class="wrap-order-summary">
                            <div class="order-summary-block">
                                <style>
                                    .wrapper-mainCart .order-summary-block .summary-action div {
                                        position: relative;
                                        font-size: 14px;
                                        margin-bottom: 4px;
                                        padding-left: 15px;
                                        font-weight: 400;
                                        text-align: left;
                                    }

                                    .wrapper-mainCart .order-summary-block .summary-action div:before {
                                        content: "";
                                        width: 4px;
                                        height: 4px;
                                        background: #999999;
                                        left: 0;
                                        opacity: 1;
                                        position: absolute;
                                        top: 8px;
                                        border-radius: 50%;
                                    }
                                </style>
                                <div class="summary-total" style="border-top: none;">
                                    <?php
                                    $grand_total = 0;
                                    $kq = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($kq)) {
                                        $total_price = $row['giamgia'] > 0 ? $row['giamgia'] * $row['soluong'] : $row['gia'] * $row['soluong'];
                                        $grand_total += $total_price;
                                    }

                                    $formatted_grand_total = number_format($grand_total, 3, ',', '.');
                                    ?>
                                    <p>Tổng tiền: <span><?php echo $formatted_grand_total ?></span></p>
                                </div>
                                <div class="summary-action">
                                    <div class="">
                                        ĐỔI HÀNG MIỄN PHÍ - Tại tất cả cửa hàng trong 15 ngày</div>
                                    <div class="">
                                        Bạn cũng có thể nhập mã giảm giá ở trang thanh toán.</div>

                                </div>
                                <div class="summary-button">
                                    <a id="btnCart-checkout" class="checkout-btn btnred " data-price-min="400000" data-price-total="1200000" href="thanhtoan.php">THANH TOÁN </a>
                                </div>
                            </div>
                            <div class="order-summary-hrvpmo">
                                <div class="hrv-pmo-coupon" data-hrvpmo-layout="minimum"></div>
                            </div>
                            <div class="order-summary-block order-summary-notify ">
                                <div class="summary-warning alert-order">
                                    <div class="textmr ">
                                        <strong>Chính sách mua hàng</strong>:
                                    </div>
                                    <div class="">
                                        Hiện chúng tôi đang áp dụng giao hàng trên toàn quốc</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include 'footer.php'; ?>
</body>

</html>