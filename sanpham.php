<?php
session_start();
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $idsp = isset($_POST['idsp']) ? $_POST['idsp'] : '';
    $tensanpham = isset($_POST['tensanpham']) ? $_POST['tensanpham'] : '';
    $gia = isset($_POST['gia']) ? $_POST['gia'] : '';
    $giamgia = isset($_POST['giamgia']) ? $_POST['giamgia'] : '';
    $image = isset($_POST['image']) ? $_POST['image'] : '';
    $product_quantity = 1;

    $total_price = $giamgia > 0 ? $giamgia * $product_quantity : $gia * $product_quantity;
    $thanhtien = number_format($total_price, 3, ',', '.');
    if (isset($_SESSION['iduser'])) {
        $iduser = $_SESSION['iduser'];
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE tensanpham = '$tensanpham' AND iduser = '$iduser'");
        if (mysqli_num_rows($select_cart) > 0) {
            echo '<script>alert("Sản phẩm đã tồn tại trong giỏ hàng");</script>';
        } else {
            $insert_product = mysqli_query($conn, "INSERT INTO cart(tensanpham, gia, giamgia, soluong, thanhtien, image, idsp, iduser) VALUES('$tensanpham', '$gia', '$giamgia', '$product_quantity','$thanhtien', '$image', '$idsp', '$iduser')");
            if ($insert_product) {
                echo '<script>alert("Thêm sản phẩm vào giỏ hàng thành công");</script>';
            } else {
                echo '<script>alert("Error: ' . mysqli_error($conn) . '");</script>';
            }
        }
    } else {
        echo '<script>alert("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng");</script>';
    }
}
if (isset($_GET['iddanhmuc'])) {
	$dm = $_GET['iddanhmuc'];
	$danhmuc_filter = "WHERE iddanhmuc = $dm";
} else {
	$danhmuc_filter = "";
}

// $conn =  mysqli_connect("localhost", "root", "", "cakeshop");
$kq = mysqli_query($conn, "SELECT count(id) as total FROM sanpham $danhmuc_filter");
$row = mysqli_fetch_assoc($kq);
$total_records = $row['total'];
$current_page = isset($_GET['page']) ? ($_GET['page']) : 1;
$limit = 12;

$total_page = ceil($total_records / $limit);

if ($current_page > $total_page) {
	$current_page = $total_page;
} else if ($current_page < 1) {
	$current_page = 1;
}


$start = ($current_page - 1) * $limit;

$rs = mysqli_query($conn, "SELECT * FROM sanpham $danhmuc_filter LIMIT $start, $limit");

?>
<?php include 'header.php'; ?>
<div class="bread-crumb text-center bread-crumb_background" style=" background-image: url('https://pos.nvncdn.net/16a837-71503/bn/20220325_5UxI8S76E0NIJxh0znPFxEOw.png');">
    <h3> <a href="sanpham.php">Sản phẩm</a></h3>
    <ul class="breadcrumb&#x20;breadcrumb-arrow">
        <li><a href="index.php">Trang chủ</a></li>
        <li>
            <a class="564206" href="sanpham.php">
                <?php
                if (isset($_GET['iddanhmuc']) && !empty($_GET['iddanhmuc'])) {
                    $iddanhmuc = $_GET['iddanhmuc'];
                    $sql = "SELECT  DISTINCT danhmuc.tendanhmuc FROM sanpham
                            INNER JOIN danhmuc ON sanpham.iddanhmuc = danhmuc.id  
                            WHERE iddanhmuc = " . $iddanhmuc;
                    $kq = mysqli_query($conn, $sql);
                    if ($kq) {
                        while ($row = mysqli_fetch_assoc($kq)) {
                            echo $row["tendanhmuc"];
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($conn);
                    }
                } else {
                    echo "Sản phẩm";
                }
                ?>
            </a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="filter-bar">
        <div class="col-lg-3">
            <div class="box-header">
                <h4>Tất cả sản phẩm</h4>
            </div>
        </div>
    </div>
    <div class="row" id="list-product">
        <?php
        $conn = mysqli_connect("localhost", "root", "", "cakeshop");

        if (isset($_GET['iddanhmuc'])) {
            $sql = "SELECT * FROM sanpham WHERE iddanhmuc = " . $_GET['iddanhmuc'];
        } else {

            $sql = "SELECT * FROM sanpham";
        }

        // $kq = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($rs)) {
            $id = $row['id'];
            $anh = $row['image'];
            $ten = $row['tensanpham'];
            $gia = number_format($row['gia'], 0, ',', '.');
            $giamgia = number_format($row['giamgia'], 0, ',', '.');

        ?>
            <div class="col-md-3">
                <div class="card" style="position: relative;">
                    <div class="card__img">
                        <?php echo '<img src="admin/images/' . $row["image"] . '">' ?>
                        <?php if ($row["sale"] > 0) : ?>
                            <div class="label_product"><span class="label_sale"><?php echo $row["sale"] ?></span></div>
                        <?php endif; ?>
                    </div>
                    <div class="card__title">
                        <?php echo $row["tensanpham"] ?>
                    </div>
                    <div class="card__price">
                        <?php
                        if ($row['giamgia'] > 0) {
                            echo '<del class="card__price_1">' . $gia . 'đ </del>';
                            echo $giamgia . "đ";
                        } else {
                            echo $gia . "đ";
                        }
                        ?>
                    </div>
                    <div class="card__action">
                        <form action="" method="post">
                            <input type="hidden" name="idsp" value="<?php echo $id; ?>">
                            <input type="hidden" name="tensanpham" value="<?php echo $ten; ?>">
                            <input type="hidden" name="gia" value="<?php echo $gia; ?>">
                            <input type="hidden" name="giamgia" value="<?php echo $giamgia; ?>">
                            <input type="hidden" name="image" value="<?php echo $anh; ?>">
                            <?php
                            echo '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' . $id . '">Xem Thêm</a></button>';
                            ?>
                            <button type="submit" class="card__cart" name="add_to_cart">
                                <i class='bx bxs-cart-alt'></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        <?php
        }
        ?>
    </div>
    <div class="pagination" style="font-size: 25px; text-align: center; display:flex;justify-content: center;">
				<?php

				if ($current_page > 1 && $total_page > 1) {
					echo '<a href="sanpham.php?page=' . ($current_page - 1) . '">Prev</a> | ';
				}

				for ($i = 1; $i <= $total_page; $i++) {
					if ($i == $current_page) {
						echo '<span>' . $i . '</span> | ';
					} else {
						echo ' <a href="sanpham.php?page=' . $i . '">' . $i . '</a> | ';
					}
				}


				if ($current_page < $total_page &&  $total_page > 1) {
					echo '<a href="sanpham.php?page=' . ($current_page + 1) . '">Next</a> | ';
				}
				?>
			</div>
</div>
</div>
<?php include 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const $keySearch = $('#key-search');
        const $listProduct = $('#list-product');
        const $thongbao = $('#thongbao');

        $keySearch.on('input', function() {
            const searchTerm = $(this).val();

            if (searchTerm == "") {
                $listProduct.empty();
                $thongbao.hide();
            }

            $.post('xulitimkiem.php', {
                'key-search': searchTerm
            }, function(data) {
                $listProduct.empty();

                if (data.length > 0) {
                    const results = JSON.parse(data);

                    results.forEach(function(result) {
                        var result_product = '<div class="col-md-3">' +
                            '<div class="card" style="position: relative;">' +
                            '<div class="card__img"><img src="images/' + result.image + '"></div>' +
                            '<div class="card__title">' + result.name + '</div>' +
                            '<div class="card__price">' + result.price + '</div>' +
                            '<div class="card__action">' +
                            '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' + result.id + '">Xem Thêm</a></button>' +
                            '<div class="card__cart"><i class="bx bxs-cart-alt"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';


                        $listProduct.append(result_product);
                    });

                    $thongbao.hide();
                } else {
                    $listProduct.empty();
                    $thongbao.show();
                }
            });
        });
    });
</script>

</body>

</html>