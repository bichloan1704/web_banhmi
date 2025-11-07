
<?php
session_start();
@include 'config.php';

if (isset($_POST['themdm'])) {
	$tendanhmuc = $_POST['tendanhmuc'];
	$p_image_tmp_name = $_FILES['image']['tmp_name'];
	$p_image_folder = 'images/' . $image;

	$insert_query = mysqli_query($conn, "INSERT INTO `danhmuc` (tendanhmuc, image) VALUES ('$tendanhmuc', '$image')") or die('Query failed');

	if ($insert_query) {
		move_uploaded_file($p_image_tmp_name, $p_image_folder);
		$message[] = 'Thêm danh mục thành công';
		header('location: quanlydanhmuc.php');
	} else {
		$message[] = 'Thêm danh mục không thành công';
	}
}

if (isset($_GET['xoadm'])) {
	$delete_id = $_GET['xoadm'];
	$delete_query = mysqli_query($conn, "DELETE FROM danhmuc WHERE id = $delete_id") or die('Query failed');
	if ($delete_query) {
		header('location: quanlydanhmuc.php');
		$message[] = 'danh mục đã được xóa ';
	} else {
		header('location: quanlydanhmuc.php');
		$message[] = 'Xóa danh mục không thành công';
	}
}

if (isset($_POST['update_product'])) {
	$id = $_POST['id'];
	$tendanhmuc = $_POST['tendanhmuc'];
	

	if ($_FILES['update_p_image']['name']) {
		$file_name = $_FILES['update_p_image']['name'];
		$file_tmp = $_FILES['update_p_image']['tmp_name'];
		$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		$allowed_extensions = array("jpeg", "jpg", "png");

		if (in_array($file_ext, $allowed_extensions)) {
			$target = "images/" . basename($file_name);

			if (move_uploaded_file($file_tmp, $target)) {
				$sql_update_image = "UPDATE danhmuc SET image = '$file_name' WHERE id = $id";
				mysqli_query($conn, $sql_update_image);
			} else {
				echo "Error while moving the image file.";
			}
		} else {
			echo "Only JPEG or PNG image files are supported.";
		}
	}



	$update_query = mysqli_query($conn, "UPDATE danhmuc SET tendanhmuc = '$tendanhmuc' WHERE id = '$id'");

	if ($update_query) {
		$message[] = 'Sửa danh mục thành công';
		header('location: quanlydanhmuc.php');
	} else {
		$message[] = 'Sửa danh mục không thành công';
		header('location: quanlydanhmuc.php');
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
	<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<!-- My CSS -->
	<link rel="stylesheet" href="style_qlsp.css">
	<link rel="stylesheet" href="style.css">
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
	<section id="content" >
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
		<!-- NAVBAR -->
		<button onclick="myFunction()" style="background-color: #ae9886;border: none;height: 36px;padding: 5px 10px; margin: 10px;font-size: large;border-radius: 10px;color: white;">Thêm danh mục</button>
		<div class="container" id="add-product" style="display: none;">
			<section>

				<form action="" method="post" class="add-product-form" enctype="multipart/form-data" style=" border: 1px solid royalblue; margin-bottom: 10px;">

					<input type="text" name="tendanhmuc" placeholder="Tên danh mục" class="box" required>
					<label for="image" style="font-size: 15px; color: #9f9191;">Hình ảnh</label>
					<input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="box" required>				
					<br>
					<input type="submit" value="Thêm danh mục" name="themdm" class="btn">
				</form>

			</section>
		</div>
		<!-- MAIN -->


	</section>
	<script>
		function myFunction() {
			var x = document.getElementById("add-product");
			if (x.style.display === "none") {
				x.style.display = "block";
			} else {
				x.style.display = "none";
			}
		}
	</script>
	<!-- CONTENT -->
	<section class="display-product-table" style=" padding-left: 260px;">

		<table class="table table-striped" style="width: 560px">

			<thead style="text-align: center;">
				<th>Hình ảnh</th>
				<th>Tên danh mục</th>
				<th>Hành động</th>
			</thead>

			<tbody>
				<?php

				$select_products = mysqli_query($conn, "SELECT * FROM danhmuc");
				if (mysqli_num_rows($select_products) > 0) {
					while ($row = mysqli_fetch_assoc($select_products)) {
				?>

						<tr>
							<td><img src="images/<?php echo $row['image']; ?>" style="height: 160px; width: 180px" alt=""></td>
							<td style="width: 140px"><?php echo $row['tendanhmuc']; ?></td>
							<td>
								<a href="quanlydanhmuc.php?xoadm=<?php echo $row['id']; ?>"  onclick="return confirm('Bạn muốn xóa danh mục này');"> <i class="fas fa-trash"></i> Xóa </a>
								<a href="quanlydanhmuc.php?suadm=<?php echo $row['id']; ?>" > <i class="fas fa-edit"></i> Sửa </a>
							</td>
						</tr>

				<?php
					};
				} else {
					echo "<div class='empty'>Thêm danh mục không thành công</div>";
				};
				?>
			</tbody>
		</table>

	</section>

	<section class="edit-form-container">

		<?php

		if (isset($_GET['suadm'])) {
			$edit_id = $_GET['suadm'];
			$edit_query = mysqli_query($conn, "SELECT * FROM danhmuc WHERE id = $edit_id");
			if (mysqli_num_rows($edit_query) > 0) {
				while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
		?>

					<form action="" method="post" enctype="multipart/form-data" class="edit-product" style="    margin-left: 776px;border: 1px solid royalblue;padding: 10px;">
						<img src="photo/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
						<input type="hidden" name="id" value="<?php echo $fetch_edit['id']; ?>">
						<table>

						</table>
						Tên danh mục:
						<input type="text" class="box" required name="tendanhmuc" value="<?php echo $fetch_edit['tendanhmuc']; ?>">
						<input type="file" class="box" name="update_p_image" accept="image/png, image/jpg, image/jpeg">
						

						<input type="submit" value="Sửa danh mục" name="update_product" class="btn">
						<input type="reset" value="Thoát" id="close-edit" class="option-btn">
					</form>

		<?php
				};
			};
			echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
		};
		?>

	</section>


	<script src="script.js"></script>
	<script>
		var closeButton = document.getElementById('close-edit');
		closeButton.addEventListener('click', function() {
			var editFormContainer = document.querySelector('.edit-form-container');
			editFormContainer.style.display = 'none';
			window.location.href = 'quanlydanhmuc.php';		
		});
		
	</script>


</body>

</html>