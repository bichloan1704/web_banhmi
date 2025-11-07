<?php

$conn = mysqli_connect("localhost", "root", "", "cakeshop");


if (isset($_SESSION['iduser']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $iduser = $_SESSION['iduser'];


    $sql = "SELECT hoten FROM users WHERE iduser = $iduser";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $adminName = $row['hoten'];
    } else {
        $adminName = 'Admin'; 
    }
} else {

    $adminName = 'Admin';
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="style.css">
<!-- SIDEBAR -->
<section id="sidebar">
	<a href="#" class="brand">
		<i class='bx bxs-smile'></i>
		<span class="text">
		<?php echo $adminName; ?>
		</span>
	</a>
	<ul class="side-menu top">
		<li>
			<a href="admin.php">
				<i class='bx bxs-dashboard'></i>
				<span class="text">Chung</span>
			</a>
		</li>
		<li>
			<a href="quanlydanhmuc.php">
				<i class='bx bxs-shopping-bag-alt'></i>
				<span class="text">Quản lý danh mục</span>
			</a>
		</li>
		<li>
			<a href="danhsachsanpham.php">
				<i class='bx bxs-shopping-bag-alt'></i>
				<span class="text"> Danh sách sản phẩm</span>
			</a>
		</li>
		<li>
			<a href="quanlysanpham.php">
				<i class='bx bxs-shopping-bag-alt'></i>
				<span class="text">Quản lý sản phẩm</span>
			</a>
		</li>
		<li>
			<a href="donhang.php">
				<i class='bx bxs-doughnut-chart'></i>
				<span class="text">Đơn hàng</span>
			</a>
		</li>
		<li>
			<a href="lienhe.php">
				<i class='bx bxs-message-dots'></i>
				<span class="text">Phản hồi</span>
			</a>
		</li>
		<li>
			<a href="binhluan.php">
				<i class='bx bxs-group'></i>
				<span class="text">Bình luận</span>
			</a>
		</li>
		<li>
			<a href="tintuc.php">
				<i class='bx bxs-shopping-bag-alt'></i>
				<span class="text">Tin tức</span>
			</a>
		</li>
		<li>
			<a href="doanhthu.php">
				<i class='bx bxs-group'></i>
				<span class="text">Doanh thu</span>
			</a>
		</li>
		<li>
			<a href="quanlytaikhoan.php">
				<i class='bx bxs-shopping-bag-alt'></i>
				<span class="text"> Tài khoản</span>
			</a>
		</li>
	</ul>
	<ul class="side-menu">
		<li>
			<a href="#">
				<i class='bx bxs-cog'></i>
				<span class="text">Cài đặt</span>
			</a>
		</li>
		<li>
			<a href="dangxuat.php" class="logout">
				<i class='bx bxs-log-out-circle'></i>
				<span class="text">Đăng xuất</span>
			</a>
		</li>
	</ul>
</section>
<script>
	$(document).ready(function() {
		// Lấy địa chỉ URL hiện tại
		var currentUrl = window.location.href;

		// Duyệt qua tất cả các thẻ li
		$(".side-menu li").each(function() {
			// Lấy href của thẻ a trong li
			var menuUrl = $(this).find("a").attr("href");

			// So sánh địa chỉ URL với href của thẻ a
			if (currentUrl.includes(menuUrl)) {
				// Nếu trùng khớp, thêm class "active"
				$(this).addClass("active");
			}
		});
	});
</script>