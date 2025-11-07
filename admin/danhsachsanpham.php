<?php
session_start();
@include 'config.php';

if (isset($_GET['iddanhmuc'])) {
	$dm = $_GET['iddanhmuc'];
	$danhmuc_filter = "WHERE iddanhmuc = $dm";
} else {
	$danhmuc_filter = "";
}

$conn =  mysqli_connect("localhost", "root", "", "cakeshop");
$kq = mysqli_query($conn, "SELECT count(id) as total FROM sanpham $danhmuc_filter");
$row = mysqli_fetch_assoc($kq);
$total_records = $row['total'];
$current_page = isset($_GET['page']) ? ($_GET['page']) : 1;
$limit = 8;

$total_page = ceil($total_records / $limit);

if ($current_page > $total_page) {
	$current_page = $total_page;
} else if ($current_page < 1) {
	$current_page = 1;
}


$start = ($current_page - 1) * $limit;

$rs = mysqli_query($conn, "SELECT * FROM sanpham $danhmuc_filter LIMIT $start, $limit");

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
	<link rel="stylesheet" href="style_qlsp.css">
	<link rel="stylesheet" href="style.css">

	<title>Quản lý bán bánh</title>
	<style>
		.card {
			margin: 15px;
		}

		a {
			color: #f3ca94;
		}

		a:hover {
			color: brown;
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
			<form id="search-form">
				<div class="form-input">
					<input type="text" id="key-search" name="key-search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>

			<div id="search-results">

			</div>

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
		<!-- NAVBAR -->

		<!-- MAIN -->
		<div class="container" style=" padding-top: 10px;">
			<div class="filter-bar">
				<div class="">
					<div class="box-header">
						<h2 style="text-align: center;font-weight: bold;">Danh sách sản phẩm</h2>
					</div>
				</div>
			</div>
			<div class="menu-main" style="text-align: center;">
				<div class="menu-main__btns">
					<div class="row">
						<div class="col-md-12">
							<li class="menu-mains__item">
								<?php
								$conn = mysqli_connect("localhost", "root", "", "cakeshop");
								$sql = "SELECT * FROM danhmuc ";
								$kq = mysqli_query($conn, $sql);

								echo '<a class="menu-mains__item-btn" href="danhsachsanpham.php">Tất cả</a>';
								while ($row = mysqli_fetch_array($kq)) {

									echo ' <a class="menu-mains__item-btn" href="danhsachsanpham.php?iddanhmuc=' . $row["id"] . '">' . $row["tendanhmuc"] . '</a>';
								}
								?>
							</li>
						</div>
					</div>
				</div>

				<p id="thongbao" style="display: none;">Không có thông tin tìm kiếm!</p>

				<div id="list-product" style="display: flex; flex-wrap: wrap">
					<?php
					while ($row = mysqli_fetch_assoc($rs)) {
						$id = $row['id'];
						$anh = $row['image'];
						$ten = $row['tensanpham'];
						$gia = number_format($row['gia'], 0, ',', '.');
						$giamgia = number_format($row['giamgia'], 0, ',', '.');
					?>
						<div class="card" style="position: relative; border: none;background-color: #ededed;">
							<div class="card__img">
								<?php echo '<img src="images/' . $row["image"] . '">' ?>
							</div>
							<?php if ($row["sale"] > 0) : ?>
								<div class="label_product"><span class="label_sale"><?php echo $row["sale"] ?></span></div>
							<?php endif; ?>
							<div class="card__title">
								<?php echo $row["tensanpham"] ?>
							</div>
							<div class="card__price">
								<?php
								if ($giamgia > 0) {
									echo '<del class="card__price_1">' . $gia . 'đ </del>';
									echo $giamgia . "đ";
								} else {
									echo $gia . "đ";
								}
								?>
							</div>
							<div class="card__action">
								<?php echo '<button class="btn-xem-them"><a href="chitietsanpham.php?id=' . $id . '">Xem Thêm</a></button>'; ?>
							</div>
						</div>
					<?php
					}
					?>
				</div>

			</div>

			<div class="pagination" style="font-size: 25px; text-align: center; display:flex;justify-content: center;">
				<?php

				if ($current_page > 1 && $total_page > 1) {
					echo '<a href="danhsachsanpham.php?page=' . ($current_page - 1) . '">Prev</a> | ';
				}

				for ($i = 1; $i <= $total_page; $i++) {
					if ($i == $current_page) {
						echo '<span>' . $i . '</span> | ';
					} else {
						echo ' <a href="danhsachsanpham.php?page=' . $i . '">' . $i . '</a> | ';
					}
				}


				if ($current_page < $total_page &&  $total_page > 1) {
					echo '<a href="danhsachsanpham.php?page=' . ($current_page + 1) . '">Next</a> | ';
				}
				?>
			</div>
			<!-- MAIN -->
		</div>
	</section>
	<!-- CONTENT -->
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
							var result_product = '<div class="card" style="position: relative; border: none;background-color: #ededed;">' +
								'<div class="card__img"><img src="images/' + result.image + '"></div>' +
								'<div class="card__title">' + result.name + '</div>' +
								'<div class="card__price">' + result.price + '</div>' +
								'<div class="card__action">' +
								'<button class="btn-xem-them"><a href="chitietsanpham.php?id=' + result.id + '">Xem Thêm</a></button>' +
								'</div></div>';

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


	<script src="script.js"></script>

</body>

</html>